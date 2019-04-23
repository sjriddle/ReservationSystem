## Doctrine ORM Usage

### Requirements
- Install Composer
- Make sure you have php 7.2+
- `Composer require doctrine maker`
- `Update `.env` file ‘DATABASE_URL’ variable`

### Create DB
- `php bin/console doctrine:database:create`

### Make Model: 
- `php bin/console make:entity {NameOfModel}`

### Migrate Model to DB:
- `php bin/console doctrine:migrations:diff`

### Run Migration:
- `php bin/console doctrine:migrations:migrate`

### Run Query
- `php bin/console doctrine:sql '{SQL STATEMENT}'`

