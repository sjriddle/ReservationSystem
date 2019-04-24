## Doctrine ORM Usage

### Requirements
- Install Composer
- Make sure you have php 7.2+
- `composer install`
- `composer require doctrine maker`
- Update `.env` file ‘DATABASE_URL’ variable

### Create DB
- This function will create a new database with the specification described in the .env file
- `php bin/console doctrine:database:create`

### Make Model
- This function will create a new model which we can write PHP code to get and set DB values
- `php bin/console make:entity {NameOfModel}`

### Migrate Model to DB
- This will create a migration which can be run to create new tables associated with PHP models
- `php bin/console doctrine:migrations:diff`

### Run Migration
- This runs the created migration in the previous step
- `php bin/console doctrine:migrations:migrate`

### Run Query
- If you need to run any query, this is the syntax
- `php bin/console doctrine:sql '{SQL STATEMENT}'`



Doctrine Documentation: https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/index.html
