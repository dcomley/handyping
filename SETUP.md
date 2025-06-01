# HandyPing Setup Instructions

## Environment Configuration

Before running `composer install`, you need to create your `.env` file:

1. Copy the environment example file:
```bash
cp env.example .env
```

2. Generate an application key after installing dependencies:
```bash
php artisan key:generate
```

## Installation Steps

1. Install PHP dependencies:
```bash
composer install
```

2. Install Node.js dependencies:
```bash
npm install
```

3. Set up your database and update the `.env` file with your database credentials.

4. Run migrations:
```bash
php artisan migrate
```

5. (Optional) Seed the database with demo data:
```bash
php artisan db:seed
```

6. Build frontend assets:
```bash
npm run build
```

7. Start the development server:
```bash
php artisan serve
```

8. In a separate terminal, run Vite for frontend development:
```bash
npm run dev
```

Visit `http://localhost:8000` to see the application.

## Demo User

If you ran the seeder, you can log in with:
- Phone: 0412345678

The verification code will be displayed in debug mode. 