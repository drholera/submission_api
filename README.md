# Submission API

## Installation

- Download the repository
- Run `composer install` in the root folder
- Create the `.env` file from the `.env.example` and update values according to your local env (DB, Redis, etc) configuration
- Run `php artisan migrate` to execute migrations
- Run `php artisan serve` to start the application
- To execute tests run `php ./vendor/bin/phpunit --configuration ./phpunit.xml ./tests`
