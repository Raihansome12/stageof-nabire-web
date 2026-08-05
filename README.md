# Office Web

Office Web is a Laravel 13 application for managing institutional information, public services, and geophysical data. It combines a public-facing website with an administrative dashboard for content and data management.

## Overview

This project is designed for:
- presenting institutional profile and news content to the public
- publishing articles and bulletins
- displaying geophysical information such as sunrise/sunset, lightning, hilal, and earthquake data
- collecting community service requests and suggestions
- managing content and operational data from an admin panel

## Main features

### Public website
- Home page with latest updates, sunrise data, lightning updates, and earthquake highlights
- Profile page
- Publications and articles
- Public information pages
- Geophysics information pages for:
  - sunrise/sunset data
  - lightning maps and periods
  - hilal bulletin information
  - earthquake information and maps
- Community service / data request form
- Suggestion submission form

### Admin panel
- Dashboard
- Staff management
- Publication and article management
- Sunrise data management with CSV import support and template download
- Lightning data management
- Earthquake data management
- Hilal bulletin management
- Public information management
- Community data request management and request logs
- Suggestions management
- User account management
- API token management

## Tech stack
- PHP 8.3+
- Laravel 13
- Composer
- Node.js and npm
- Vite + Tailwind CSS
- Database support via Laravel for SQLite, MySQL, or PostgreSQL

## Requirements
Before running the project, make sure you have installed:
- PHP 8.3 or higher
- Composer
- Node.js and npm
- A database server (SQLite works out of the box using the provided example environment file)

## Installation

1. Clone the repository
   ```bash
   git clone <repository-url>
   cd office-web
   ```

2. Install PHP dependencies
   ```bash
   composer install
   ```

3. Install frontend dependencies
   ```bash
   npm install
   ```

4. Create the environment file
   ```bash
   copy .env.example .env
   ```
   On Linux/macOS:
   ```bash
   cp .env.example .env
   ```

5. Generate the application key
   ```bash
   php artisan key:generate
   ```

6. Configure the database in the `.env` file
   The repository includes a SQLite-based example configuration by default.

   Example:
   ```env
   DB_CONNECTION=sqlite
   ```

   If you prefer MySQL/PostgreSQL, update the corresponding values accordingly.

7. Run the database migrations
   ```bash
   php artisan migrate
   ```

8. Create the storage symlink
   ```bash
   php artisan storage:link
   ```

9. Build the frontend assets
   ```bash
   npm run build
   ```

## Configuration

The application uses Laravel's default environment configuration with database-backed sessions, cache, and queues. The example environment file already sets up SQLite plus database-backed queue/session/cache drivers.

Key environment values to confirm:
```env
APP_NAME=Office Web
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=sqlite

QUEUE_CONNECTION=database
SESSION_DRIVER=database
CACHE_STORE=database
```

## Running the project

### Development mode
```bash
composer run dev
```

This starts:
- the Laravel development server
- the queue worker
- the Vite development server

### Production-style run
```bash
npm run build
php artisan optimize
php artisan queue:work
```

## Testing
Run the test suite with:
```bash
php artisan test
```

You can also use:
```bash
composer test
```

## Project structure
- `app/` — controllers, models, middleware, and providers
- `bootstrap/` — Laravel bootstrap files
- `config/` — application configuration
- `database/` — migrations, seeders, and factories
- `public/` — public entry point and uploaded assets
- `resources/` — views, CSS, and JavaScript
- `routes/` — web and API routes
- `tests/` — Pest test suite

## Notes
- Uploaded files are stored through Laravel's public storage disk.
- The admin area is protected by authentication and the `admin` middleware.
- The public geophysics and community service modules rely on database-backed content and background queues.
- The API endpoint for earthquake ingestion is available under `routes/api.php` and requires a Sanctum token with the `earthquakes:write` ability.

## License
This project is intended for internal use unless otherwise specified by the repository owner.
