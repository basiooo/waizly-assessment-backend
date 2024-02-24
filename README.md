# Requirement
- PHP (8.1 or higher)
- Mysql
- Composer

# Installation Guide
- Clone Project
    ``` bash
    https://github.com/basiooo/waizly-assessment-backend.git
    ```
- Navigate to project dir
    ``` bash
    cd waizly-assessment-backend
    ```
- Start php and MySQL 
-  Install project dependencies:

    ```bash
    composer install
    ```
- Set Up the Environment

    ```bash
    cp .env.example .env
    ```
- Update the Laravel database configuration: 
    Open the .env file in project and update
    ``` ini
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=database_name
    DB_USERNAME=database_username
    DB_PASSWORD=database_password
    ```
- Generate application key
    ```bash
    php artisan key:generate
    ```
- Migrate Database:

    ```bash
    php artisan migrate
    ```

- Seeding Database
    ```bash
    php artisan db:seed
    ``` 
    
    
    6 users with 10 note records each

    email = test@test.com

    password = password

- Running App
    ```bash
    php artisan serve
    ```

## Testing

```bash
php artisan test
```