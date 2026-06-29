# WatchSense
WatchSense is a Laravel + Livewire movie discovery application that lets users browse films from TMDb, view details, save likes, and get recommendations based on genre, cast, director, ratings, and similar-user behavior.

## Features

- Landing page with trending movie data from TMDb

- User registration, login, and logout

- Movie gallery with search and browsing controls

- Movie detail pages with cast, crew, and language data

- Like and unlike support for authenticated users

- Weighted recommendation engine for related movies

- Database-backed users, films, genres, actors, reviews, and likes

## Tech Stack

- Laravel 12

- Livewire 4

- PHP 8.2+

- Vite

- Tailwind CSS 4

- MySQL or another Laravel-supported database

## Requirements

- PHP 8.2 or newer

- Composer

- Node.js and npm

- A database server

- TMDb API key

## Setup

1. Clone the repository and install dependencies.

```bash
composer install
npm install
```

2. Copy the environment file and configure your app.

```bash
copy .env.example .env
php artisan key:generate
```

3. Set the required values in .env.

```env
APP_KEY=base64:...
DB_CONNECTION=mysql
DB_DATABASE=watchsense
DB_USERNAME=root
DB_PASSWORD=
TMDB_API_KEY=your_tmdb_api_key
```

4. Run the database migrations.

```bash
php artisan migrate
```

5. Start the frontend and backend.

```bash
npm run dev
php artisan serve
```

You can also run the full local stack with:

```bash
composer run dev
```

## Useful Notes

- The application expects a valid TMDb API key in `TMDB_API_KEY`.

- If configuration changes do not appear immediately, clear the cache with `php artisan config:clear`.

- The default seeder creates a test user account for local testing.

## Project Structure

- `app/Http/Controllers` contains the gallery and authentication controllers.

- `app/Livewire` contains the movie detail and recommendation components.

- `app/Services/RecommendationService.php` handles weighted recommendation logic.

- `database/migrations` contains the schema for films, genres, actors, reviews, and likes.

- `resources/views` contains the Blade views for the UI.

## License

This project uses the MIT license.
