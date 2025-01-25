# Blog Project

A simple blog application built with Laravel, featuring post management, comments, and user authentication.

## Requirements

- PHP 8.1 or higher
- Laravel 10.x
- Composer
- MySQL or PostgreSQL

## Setup Instructions

1. Clone the repository:
```
git clone https://github.com/yourusername/blog-project.git
cd blog-project
```

2. Install dependencies:
```
composer install
```

3. Copy the environment file:
```
cp .env.example .env
```

4. Configure your database in the .env file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. Generate application key:
```
php artisan key:generate
```

6. Run migrations:
```
php artisan migrate
```

7. Start the development server:
```
php artisan serve
```

## Development Tools

This project includes several development tools to improve the development experience:

- Laravel Debugbar: For debugging and performance monitoring
- Laravel IDE Helper: For better IDE integration and code completion
- Laravel Telescope: For request monitoring and debugging (when in debug mode)

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
