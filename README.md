# WatchSense

WatchSense is a movie discovery app built with Laravel and Livewire. It pulls film data from TMDb, lets users explore trending titles, inspect movie details, save likes, and surface recommendations based on taste signals like genre, cast, director, and user activity.

## At A Glance

| What it does | Why it matters |
| --- | --- |
| Browse trending and searchable movies | Quickly find something worth watching |
| View rich movie details | See cast, crew, language, and ratings in one place |
| Like movies and build a profile | Make recommendations feel more personal |
| Use weighted recommendation logic | Blend multiple signals instead of relying on one factor |

## Highlights

- TMDb-powered landing page with trending content
- Auth flow for register, login, and logout
- Movie gallery for browsing and search
- Movie detail experience with cast, crew, and language metadata
- Like and unlike support for signed-in users
- Weighted recommendation engine for related titles
- Database-backed storage for users, films, genres, actors, reviews, and likes

## Tech Stack

- Laravel 12
- Livewire 4
- PHP 8.2+
- Vite
- Tailwind CSS 4
- MySQL or another Laravel-supported database

## What You Need

- PHP 8.2 or newer
- Composer
- Node.js and npm
- A database server
- TMDb API key

## Quick Start

1. Install dependencies.

```bash
composer install
npm install
```

2. Prepare the environment file.

```bash
copy .env.example .env
php artisan key:generate
```

3. Fill in the required values.

```env
APP_KEY=base64:...
DB_CONNECTION=mysql
DB_DATABASE=watchsense
DB_USERNAME=root
DB_PASSWORD=
TMDB_API_KEY=your_tmdb_api_key
```

4. Create the tables.

```bash
php artisan migrate
```

5. Run the app.

```bash
npm run dev
php artisan serve
```

If you prefer one command for local development, use:

```bash
composer run dev
```

## Notes

- The app expects `TMDB_API_KEY` to be set before movie features will work properly.
- If changes in `.env` do not seem to apply, run `php artisan config:clear`.
- The default seeder creates a test user account for local testing.

## Project Layout

- `app/Http/Controllers` contains the gallery and authentication controllers.
- `app/Livewire` contains the movie detail and recommendation components.
- `app/Services/RecommendationService.php` handles weighted recommendation logic.
- `database/migrations` contains the schema for films, genres, actors, reviews, and likes.
- `resources/views` contains the Blade views for the UI.

## License

This project uses the MIT license.
