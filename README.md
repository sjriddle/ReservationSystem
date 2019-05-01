## Requirements
- Ensure you have PHP, XAMPP, MySQL Installed
- For this project, you will need to go to alter the hostname for the project. I will add documentation to make this process simple. Essentially, we want to hit the endpoint `reservationsystem.tests` and have that resolve to `127.0.0.1`
- Install Composer
- Make sure you have php 7.2+
- `composer install`
- `composer require doctrine maker`
- Update `.env` file ‘DATABASE_URL’ variable (currently, this is configured for a MySQL user named 'test' with the hostname '127.0.0.1'. To get this to work, you'll have to create this user in your MySQL workbench or MySQL CLI. This will be changed in the future to a MySQL Database in cloud AWS.)

## Doctrine ORM Usage

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
- `php bin/console doctrine:query:sql '{SQL STATEMENT}'`

-----------------------------------
Doctrine Documentation: https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/index.html
