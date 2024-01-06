# Parspack Coding Challenge

This is a product review system

## Table of Contents

- [Getting Started](#getting-started)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Code Style and Patterns](#code-style-and-patterns)
- [API Collection](#api-collection)
- [Testing](#testing)


## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing
purposes.

### Prerequisites

- PHP 8.1
- Composer
- MySQL

### Installation

1. Clone the repository:

    ```bash
    git clone https://hrgit.abrha.net/soraya.maleki/parspack.git
    ```

2. Navigate into the project directory:

    ```bash
    cd parspack
    ```

3. Install dependencies:

    ```bash
    composer install
    ```

4. Create a copy of the `.env.example` file and rename it to `.env`:

    ```bash
    cp .env.example .env
    ```

5. Generate the application key:

    ```bash
    php artisan key:generate
    ```

6. Set up your database configuration in the `.env` file:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```

7. Run the database migrations:

    ```bash
    php artisan migrate
    ```
8. Run the database seeders for add products (by default: A, B, C) and user(email: parspack@parspack.com, pass:
   random ):

    ```bash
    php artisan db:seed
    ```
9. You can run this command to insert new products:

    ```bash
    php artisan app:create-product
    ```

...

### Code Style and Patterns

- **PSR-12 for Code Style**: This project follows the PSR-12 (PHP Standard Recommendation) for code style, ensuring a consistent and readable codebase.


- **PSR-5 for DocBlocks**: PSR-5 is used for DocBlocks in this project, providing standardized documentation comments for classes, methods, and properties.


- **Observer Pattern**: The project utilizes the Observer pattern for handling events and state changes.

 
- **Repository Pattern**: The project utilizes the Repository pattern for data access.
- 
 
- **Service Pattern**: The project utilizes the Service pattern for business logic implementation. This promotes separation of concerns and maintainability.

...
### API Collection

- The API collection can be found in the root project directory. after import, set these environment variables in postman
    ```bash
    Domain=
    API=api
    Version=v1
    ```
  You must set Authorization BearerToken Header for call APIs
### Testing
I have added test cases at the end because it was optional. However, I know the importance of Test-Driven Development (TDD) and can adapt to writing tests first if the project requires it.
