# Laravel Job Board

## Installation

1. `git clone` this repo
2. Open this project with your code editor: `cd laravel-job-board && code .`
3. Install dependencies `composer install`
4. Copy .env.example file, rename it with .env and update environment variables: `cp .env.example .env`
5. Generate key for your app `php artisan key:generate`
6. Create two databases: `sudo mysql` one for project `create database laravel_job_board` and one for testing `create database testing`
7. Migrate database `php artisan migrate`
8. Run your project `php artisan serve` and visit `http://127.0.0.1:8000`
