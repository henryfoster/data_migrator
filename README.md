# Data Migration Tool

![Coverage](https://raw.githubusercontent.com/henryfoster/data_migrator/coverage/badge-coverage.svg)

## This task is part of a job application. 

### Task
The task was to create a commandline tool that can parse a xml file and push the data to a database.
Furthermore it should be easy to add new data sources and data sinks and the tool should be configurable to use those.
Errors should be written to a log file and the code should be tested.

### Setup
1. make sure you have php 8.2 and composer installed
2. clone the repo: `git clone ...`
3. `cd data_migrator`
4. install dependencies: `composer install`
5. create the (sqlite) database either with doctrine or use one of the sql files.
    If you want to use a different database then sqlite make sure to adjust the .env or create a .env.local with the correct database connection string.
    `bin/console do:da:cr` by default the sqlite database will be created in the ./var directory
    or run `createProstgresTable.sql` 
    or `createSqliteTable.sql`
6. if you created the database via doctrines migration system run `bin/console do:mi:mi`

7. now you can run the command to import the data: `bin/console app:migrate:data exampleConfig.json`
   exampleConfig.json is the configuration file to configure the data source and sink. It will by default use the feed.xml 
   file that was attached to the assignment.

### Extending Functionality
As requested the tool was build to work with multiple sources and destinations.
To add a new source or sink implement the SinkInterface or SourceInterface and configure them in their respective factories.
You can add additional configuration options as needed.
For other sources a Normalizer/Encoder might be needed.

### Design Considerations
The task was defined quite open-ended, so I wanted to share my design considerations.
I decided to go with Symfony and Doctrine as it was mentioned in the job position and 
I thought it would be a good opportunity to show some of my knowledge about the framework.
I looked at the task as if it was a part of a bigger web-application not as a standalone import script. 
