<?php

namespace App\Service;

use App\Entity\Item;
use App\Service\DataSink\DataSinkFactory;
use App\Service\DataSource\DataSourceFactory;
use App\Service\Transformer\DataTransformer;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DataMigrationPipeline implements LoggerAwareInterface
{
    use LoggerAwareTrait;
    public function __construct
    (
        private DataTransformer $transformer,
        private ValidatorInterface $validator,
        private DenormalizerInterface $denormalizer,
        private DataSourceFactory $dataSourceFactory,
        private DataSinkFactory $dataSinkFactory
    )
    {

    }

    public function migrate(array $config)
    {
        $source = $this->dataSourceFactory->create($config['source']);
        $sink = $this->dataSinkFactory->create($config['sink']);
        $normalizedData = $source->getData();
        $itemsBatch = [];
        $batchSize = 1000;
        $count = 0;
        foreach ($normalizedData as $itemArray) {
            $itemArray = $this->transformer->transform($itemArray, Item::class);
            $item = $this->denormalizer->denormalize($itemArray, Item::class, context: ['idPrefix' => $config['sink']['idPrefix']]);
            $errors = $this->validator->validate($item);
            foreach ($errors as $error) {
                $this->logger->error($error->getMessage(), ['class' => $this::class]);
            }
            if (0 === count($errors)) {
                $itemsBatch[] = $item;
            }

            $count++;
            if (0 === $count % $batchSize) {
                $sink->write($itemsBatch);
                $itemsBatch = [];
            }
        }
        $sink->write($itemsBatch);
    }
}