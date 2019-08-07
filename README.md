## Requirements
- Ensure you have PHP, Apache, and MySQL Installed
- Clone this repository into your htdocs folder in the XAMPP application
- Install Composer
- Make sure you have php 7+
- `composer install`
- Update `.env` file ‘DATABASE_URL’ variable (currently, this is configured for a MySQL user named 'root', with a password 'test' and the hostname '127.0.0.1'. This will be changed in the future to a MySQL Database in cloud AWS.)
- All you need to run to create your Database and tables is `php bin/console doctrine:migrations:migrate` since the migrations have already been created.

## How to Access VM
- SSH into `student@info4430spro` using PuTTY or Ubuntu Subsystem for Windows. Use the terminal for Mac OS. If you don't have any SSH keys or don't know how to generate them, use https://confluence.atlassian.com/bitbucketserver/creating-ssh-keys-776639788.html 
- Once in the VM Command Line, run the following command `sudo service apache2 start`.
- After the webserver is started, open up a browser and go to `http://10.52.2.41`. This should direct you to the main page of the current reservation system.

## Setup on Local Environment on Mac/Windows using XAMPP
### Setup Virtual Host
- Go to `C:\xampp\apache\conf\httpd.conf` and uncomment out `#Include conf/extra/httpd-vhosts.conf` on Mac it will be in the `/Applications/XAMPP/xamppfiles/etc/httpd.conf` and the line will be `#Include etc/extra/httpd-vhosts.conf`
- Go to `Applications/XAMPP/etc/extra/httpd-vhosts.conf` (Mac) or `C:\XAMPP\apache\conf\extra\httpd-vhosts.conf` and add the following text to the file to create a Virtual Host: 
```
<VirtualHost *:80>
    DocumentRoot "/Applications/XAMPP/htdocs/ReservationSystem/public"
    <Directory "/Applications/XAMPP/htdocs/">
        Allow from all
        AllowOverride All
        Order Allow,Deny
          Require all granted
    </Directory>
    ServerName reservationsystem.tests
</VirtualHost>
```
- Then go to `/etc/hosts` (Mac) or `C:\Windows\System32\drivers\etc` (Windows) and put in the following entry:
```
127.0.0.1 reservationsystem.tests
```
- Restart Apache in XAMPP

## Setup on Linux Environment (LAMP)
- Ensure MySQL and PHP are installed on the linux environment
- Ensure Apache2 is install by running `sudo apt install apache2`
- Clone the ReservationSystem repo in the `/var/www/` folder location. 
- Alter the Apache2 sites-available file `/etc/apache2/sites-available/res-default.conf` and alter the directory structure to match the following:
 ```
 <Directory /var/www/ReservationSystem/public>
        AllowOverride All
        Order allow,deny
        Allow from all
</Directory>
```

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

### Run Fixture
- This is used to migrate the user data to the DB
- `php bin/console doctrine:fixtures:load`

### Run Query
- If you need to run any query, this is the syntax
- `php bin/console doctrine:query:sql '{SQL STATEMENT}'`

-----------------------------------
Doctrine Documentation: https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/index.html
