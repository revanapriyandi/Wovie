# Wovie

Wovie is an anime and movie streaming Application

## Installation

```bash
composer install

cp .env.example .env

php artisan key generate

php artisan migrate

php artisan tinker
$user = new User;
$user->name = '...'
$user->email = '...'
$user->password = bcrypt('...');
$user->save();
```

```node modules
npm install

# build
npm run dev

```
