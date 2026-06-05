# Laravel Subscription API

## Installation

composer install

cp .env.example .env

php artisan key:generate

Update database credentials

php artisan migrate --seed

php artisan serve

## API Endpoints

GET /api/users

GET /api/users/{id}

GET /api/subscriptions

GET /api/users/{id}/subscriptions

POST /api/subscriptions/purchase

GET /api/dashboard/{user_id}