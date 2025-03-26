# Test Bursa Efek Project

## Project Overview

This is a Laravel-based web application with RESTful API endpoints for managing products and product categories.

## Prerequisites

-   PHP 8.1+
-   Composer
-   Laravel 10.x
-   MySQL or compatible database

## Installation Steps

### 1. Clone the Repository

```bash
git clone https://github.com/iqmalr/test-bursa-efek
cd test-bursa-efek
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Configuration

```bash
# Copy environment example file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup

Edit the `.env` file with your database credentials:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

### 5. Run Migrations

```bash
php artisan migrate
```

### 6. Start the Development Server

```bash
php artisan serve
```

## API Documentation

### Swagger Documentation

Since I can't log in to Swagger, I am unable to publish the Swagger documentation on Swagger UI. However, you can view it at the following link or run the project and access it at:

[http://127.0.0.1:8000/api/documentation#/](http://127.0.0.1:8000/api/documentation#/)

You can also check my Swagger file on GitHub:
[https://github.com/iqmalr/test-bursa-efek/blob/master/storage/api-docs/api-docs.json](https://github.com/iqmalr/test-bursa-efek/blob/master/storage/api-docs/api-docs.json)

### Postman Collection

[![Run in Postman](https://run.pstmn.io/button.svg)](https://documenter.getpostman.com/view/16586484/2sAYkKKJbB#intro)

## Additional Resources

-   [Laravel Documentation](https://laravel.com/docs)
-   [Swagger OpenAPI Documentation](https://swagger.io/docs/specification/about/)

## Troubleshooting

-   Ensure all dependencies are installed correctly
-   Check database connection in `.env` file
-   Run `php artisan config:clear` if experiencing configuration issues

## License

This project is open-source and available under the MIT License.
