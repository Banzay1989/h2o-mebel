

## How to use

- Clone the repository with `git clone`
- Copy `.env.example` file to `.env` and edit database credentials there
- Run `composer install`
- Run `php artisan key:generate`

### To use photos in order:
- Run `composer require "spatie/laravel-medialibrary"` for upload photos

### Generate DB data:
- Run `php artisan migrate`
- Run `php artisan migrate --seed` (it has some seeded data for your testing)

### Frontend create
- Run `npm install`
- Run `npm run dev`
- That's it: launch the main [URL](http://localhosl:8080). 
