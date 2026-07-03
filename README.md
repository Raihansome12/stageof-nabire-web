# Office Web

Office Web is a Laravel-based website for presenting institutional information, public services, and geophysical data. The application includes a public-facing portal for visitors and an admin panel for managing content and data.

## Features

### Public website
- Home page with latest updates
- Profile page
- Publications and articles
- Earthquake information page
- Geophysics information pages for:
  - sunrise/sunset data
  - lightning information
- Public information page
- Community service / data request form

### Admin panel
- Dashboard
- Staff management
- Publication and article management
- Sunrise data management with CSV import support
- Lightning data management
- Earthquake data management
- Public information management
- Community data request management

## Tech stack
- PHP 8.3
- Laravel 13
- MySQL/PostgreSQL/SQLite-compatible Laravel database support
- Vite + Tailwind CSS
- Composer
- npm

## Requirements
Before running the project, make sure you have installed:
- PHP 8.3 or higher
- Composer
- Node.js and npm
- A database server (MySQL/PostgreSQL/SQLite)

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

4. Create environment file
   ```bash
   copy .env.example .env
   ```
   On Linux/macOS:
   ```bash
   cp .env.example .env
   ```

5. Generate application key
   ```bash
   php artisan key:generate
   ```

6. Configure your database in the `.env` file
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=office_web
   DB_USERNAME=root
   DB_PASSWORD=
   ```

7. Run database migrations
   ```bash
   php artisan migrate
   ```

8. Create the storage symlink
   ```bash
   php artisan storage:link
   ```

9. Build frontend assets
   ```bash
   npm run build
   ```

## Running the project

### Development mode
```bash
composer run dev
```

This starts:
- Laravel development server
- queue worker
- Vite dev server

### Production build
```bash
npm run build
php artisan optimize
php artisan queue:work
```

## Environment variables
The following variables are commonly required:

```env
APP_NAME=Office Web
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=office_web
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=no-reply@example.com
MAIL_FROM_NAME="Office Web"

OFFICE_WA_NUMBER=6281234567890
```

## Testing
Run the test suite with:
```bash
php artisan test
```

## Project structure
- `app/` — application logic, controllers, models, and services
- `database/` — migrations and seeders
- `public/` — public entry point and uploaded assets
- `resources/` — views, CSS, and JavaScript
- `routes/` — web routes
- `tests/` — automated tests

## Notes
- Uploaded files are stored in the public storage disk.
- The admin area is protected by authentication and role-based access.
- The geophysics sections and public service form rely on database-backed content and external notifications.

## License
This project is open for internal use unless otherwise specified by the repository owner.
