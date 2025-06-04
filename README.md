# HandyPing

Never forget another licence renewal - Simple SMS + email reminder tool for sole traders and mobile tradies.

## Features

- 📱 Phone-based authentication (no passwords)
- 📧 SMS & Email reminders for expiring licenses
- 🌐 Simple web-based dashboard (no app installation)
- 🔧 Built for tradies - licenses, insurance, certifications
- 💳 Stripe-powered billing ($9/month, 30-day free trial)
- **Phone-based Authentication**: Simple SMS verification for login
- **Reminder Management**: Create, edit, and delete reminders
- **Notification Options**: Choose between SMS and email notifications
- **Dashboard**: View upcoming and expiring reminders at a glance
- **SQLite Database**: Simple, file-based database
- **Stripe Subscriptions**: $9/month subscription with Stripe Checkout
- **Test Email**: Built-in tool to test Mailgun configuration

## Tech Stack

- **Backend**: Laravel 10
- **Frontend**: Vue 3 with Vue Router
- **Styling**: Tailwind CSS
- **Build Tool**: Vite
- **SMS**: Twilio (configured but not implemented)
- **Email**: Mailgun (configured but not implemented)
- **Database**: MySQL

## Requirements

- PHP 8.1 or higher
- Composer
- Node.js 16 or higher
- npm or yarn
- MySQL database

## Installation

**Important:** See `SETUP.md` for detailed setup instructions.

1. Clone the repository and navigate to the project:
```bash
cd handyping
```

2. Create the `.env` file:
```bash
cp env.example .env
```

3. Install PHP dependencies:
```bash
composer install
```

4. Install Node.js dependencies:
```bash
npm install
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure your database in `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=handyping
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Run database migrations:
```bash
php artisan migrate
```

8. (Optional) Seed the database with demo data:
```bash
php artisan db:seed
```

9. Build frontend assets:
```bash
npm run build
```

10. **Set up Stripe (for subscriptions)**:
   - See [STRIPE_SETUP.md](STRIPE_SETUP.md) for detailed instructions
   - Add your Stripe keys to `.env`

11. **Start the development server**:
```bash
php artisan serve
```

12. In a separate terminal, run Vite for frontend development:
```bash
npm run dev
```

13. Visit `http://localhost:8000` in your browser

## Demo Login

If you ran the database seeder:
- Phone: 0412345678
- The verification code will be displayed in debug mode

## Project Structure

```
handyping/
├── app/
│   ├── Http/
│   │   ├── Controllers/      # Web controllers
│   │   └── Controllers/Api/  # API controllers
│   └── Models/              # Eloquent models
├── database/
│   └── migrations/          # Database migrations
├── resources/
│   ├── css/                # Tailwind CSS
│   ├── js/                 # Vue application
│   │   ├── pages/          # Vue page components
│   │   └── router/         # Vue Router configuration
│   └── views/              # Blade templates
├── routes/
│   ├── api.php            # API routes
│   └── web.php            # Web routes
└── public/                # Public assets
```

## API Endpoints

### Authentication
- `POST /api/verify-phone` - Send verification code
- `POST /api/verify-code` - Verify code and login

### Reminders (Protected)
- `GET /api/reminders` - List all reminders
- `POST /api/reminders` - Create new reminder
- `GET /api/reminders/{id}` - Get specific reminder
- `PUT /api/reminders/{id}` - Update reminder
- `DELETE /api/reminders/{id}` - Delete reminder
- `GET /api/reminders/expiring-soon` - Get expiring reminders

### Dashboard (Protected)
- `GET /api/dashboard` - Get dashboard data

## Features to Implement

1. **SMS Integration**: Connect Twilio for sending SMS reminders
2. **Email Integration**: Connect Mailgun for email reminders
3. **Cron Jobs**: Set up scheduled tasks for sending reminders
4. **Payment Integration**: Implement Stripe for subscriptions
5. **Document Storage**: Add file upload for receipts/policies
6. **Multi-user Access**: Support for small crews

## Security Notes

- Phone-based authentication with 6-digit verification codes
- API protected with Laravel Sanctum
- CSRF protection enabled
- All user input is validated

## License

MIT