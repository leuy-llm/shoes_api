app/
├── Http/
│   ├── Controllers/
│   │   └── Api/
│   │       └── V1/
│   │           ├── AuthController.php      # Register/Login/Logout
│   │           ├── ProductController.php   # Products CRUD
│   │           ├── CategoryController.php  # Categories CRUD
│   │           ├── CartController.php      # Add/Remove/Update cart
│   │           ├── OrderController.php     # Place order, history
│   │           └── PaymentController.php   # Payment gateway integration
│   ├── Middleware/
│   └── Requests/                           # Validation requests
│
├── Models/
│   ├── User.php
│   ├── Product.php
│   ├── Category.php
│   ├── Cart.php
│   ├── Order.php
│   └── OrderItem.php
│
├── Services/                               # Business logic
│   ├── CartService.php
│   ├── OrderService.php
│   └── PaymentService.php
│
├── Repositories/                           # Data abstraction (optional)
│
database/
├── migrations/                             # Products, Orders, etc.
├── seeders/                                # Demo data (categories, products)


### Error 
thrown in F:\Tranee2\Laravel Project\laravel-api\artisan on line 10
PS F:\Tranee2\Laravel Project\laravel-api> php artisan serve
PHP Warning:  require(F:\Tranee2\Laravel Project\laravel-api/vendor/autoload.php): Failed to open stream: No such file or directory in F:\Tranee2\Laravel Project\laravel-api\artisan on line 10
PHP Fatal error:  Uncaught Error: Failed opening required 'F:\Tranee2\Laravel Project\laravel-api/vendor/autoload.php' (include_path='.;C:\php\pear') in F:\Tranee2\Laravel Project\laravel-api\artisan:10
Stack trace:

==== Fix Error =====
composer install

## Check Storage and catche permissions
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

## Check logs for the actual error 
storage/logs/laravel.log


Step by step to setup project laravel
1.Create new .env form .env example: php artisan key:generate
2.go to php.ini or php: ;extension=pdo_mysql remove ; to extension = pdo_mysql and extension=mysqli
3.Verify pdo_mysql is loaded: php

## Create DB
php artisan migrate

## Seed DB
php artisan db:seed

## Run tests
php artisan test

## Run server
php artisan serve

## Run queue
php artisan queue:listen

## If you want model + migration + controller + resource + seeder + factory (everything):
php artisan make:model Category -all

## If you want model + migration + controller:
php artisan make:model Product -mc

## If you want only migration + model:
php artisan make:model Product -m


##  Factory 
php artisan make:factory CategoryFactory : In Laravel, a Factory is used to quickly generate fake data for your models.

## Create seeder
php artisan make:seeder CategorySeeder

## Run seeder
php artisan db:seed --class=CategorySeeder

## Create factory for invoice
php artisan make:factory InvoiceFactory

## 
php artisan migrate:fresh --seed

## Show list route
php artisan route:list



| Endpoint | Return type                              |
| -------- | ---------------------------------------- |
| index    | `ProductCollection`                      |
| show     | `ProductResource`                        |
| edit     | `ProductResource`                        |
| store    | `ProductResource` (after creation)       |
| update   | `ProductResource` (after update)         |
| destroy  | JSON with message (`success` or `error`) |
