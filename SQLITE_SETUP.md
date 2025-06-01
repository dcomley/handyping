# SQLite Setup for HandyPing

Since MySQL is not installed, you can use SQLite for quick development setup.

## Update your .env file

Change the database configuration in your `.env` file:

```
DB_CONNECTION=sqlite
```

And comment out or remove these MySQL-specific lines:
```
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=handyping
# DB_USERNAME=root
# DB_PASSWORD=
```

## The SQLite database file has been created

The file `database/database.sqlite` has already been created for you.

## Run migrations

Now you can run the migrations:

```bash
php artisan migrate
```

## Optional: Seed the database

To add demo data:

```bash
php artisan db:seed
```

This will create a demo user with phone: 0412345678

## Continue with the setup

```bash
npm run build
php artisan serve
```

Then visit http://localhost:8000 