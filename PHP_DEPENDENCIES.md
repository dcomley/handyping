# PHP Dependencies for HandyPing

Your system has PHP 8.3 installed, but some required extensions are missing.

## Required PHP Extensions

Install the following PHP extensions for Laravel to work properly:

```bash
# For SQLite database support
sudo apt install php8.3-sqlite3

# Other commonly needed extensions for Laravel
sudo apt install php8.3-mbstring php8.3-xml php8.3-curl php8.3-zip

# For MySQL (if you want to use MySQL instead of SQLite)
sudo apt install php8.3-mysql
```

## Install all at once

```bash
sudo apt update
sudo apt install php8.3-sqlite3 php8.3-mbstring php8.3-xml php8.3-curl php8.3-zip
```

## After installation

Once the extensions are installed, you can continue with:

```bash
# Run migrations
php artisan migrate

# Seed the database (optional)
php artisan db:seed

# Build frontend assets
npm run build

# Start the development server
php artisan serve
```

Then visit http://localhost:8000 