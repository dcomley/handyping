# Stripe Setup for HandyPing

This guide will help you set up Stripe for accepting $9/month subscriptions in HandyPing.

## Prerequisites

- A Stripe account (sign up at https://stripe.com)
- Access to your Stripe Dashboard

## Setup Steps

### 1. Get Your API Keys

1. Log in to your [Stripe Dashboard](https://dashboard.stripe.com)
2. Navigate to **Developers** → **API keys**
3. Copy your **Publishable key** and **Secret key**
4. For testing, use the test mode keys (toggle "Test mode" on)

### 2. Create a Product and Price

1. In Stripe Dashboard, go to **Products**
2. Click **+ Add product**
3. Fill in the details:
   - **Name**: HandyPing Pro
   - **Description**: Monthly subscription for HandyPing reminder service
4. In the pricing section:
   - **Pricing model**: Standard pricing
   - **Price**: $9.00
   - **Billing period**: Monthly
5. Click **Add product**
6. Copy the **Price ID** (looks like `price_1ABC123...`)

### 3. Set Up Webhook (Optional but recommended)

1. In Stripe Dashboard, go to **Developers** → **Webhooks**
2. Click **Add endpoint**
3. Enter your webhook URL: `https://yourdomain.com/stripe/webhook`
4. Select events to listen for:
   - `checkout.session.completed`
   - `customer.subscription.created`
   - `customer.subscription.updated`
   - `customer.subscription.deleted`
5. Copy the **Signing secret**

### 4. Configure Your .env File

Add these values to your `.env` file:

```env
# Stripe Configuration
STRIPE_KEY=pk_test_YOUR_PUBLISHABLE_KEY
STRIPE_SECRET=sk_test_YOUR_SECRET_KEY
STRIPE_WEBHOOK_SECRET=whsec_YOUR_WEBHOOK_SECRET
STRIPE_PRICE_ID=price_YOUR_PRICE_ID

# App URL (needed for Stripe redirects)
APP_URL=http://localhost:8000
```

### 5. Configure Customer Portal (Optional)

1. In Stripe Dashboard, go to **Settings** → **Billing** → **Customer portal**
2. Configure the portal settings:
   - Enable customers to update payment methods
   - Enable customers to cancel subscriptions
   - Enable customers to view invoices
3. Save the configuration

## Testing

### Test Cards

Use these test card numbers in Stripe's test mode:

- **Success**: 4242 4242 4242 4242
- **Requires authentication**: 4000 0025 0000 3155
- **Declined**: 4000 0000 0000 9995

Use any future expiry date and any 3-digit CVC.

### Test the Integration

1. Start your Laravel server: `php artisan serve`
2. Log in to HandyPing
3. Navigate to **Subscription** in the header
4. Click **Subscribe Now**
5. You'll be redirected to Stripe Checkout
6. Use a test card to complete the payment
7. You'll be redirected back to HandyPing with an active subscription

## Production Checklist

Before going live:

- [ ] Switch to live API keys in your `.env` file
- [ ] Update `APP_URL` to your production domain
- [ ] Set up webhook endpoint for production
- [ ] Test with a real card (you can refund yourself)
- [ ] Enable Stripe Tax if needed
- [ ] Configure email receipts in Stripe

## Troubleshooting

### "Failed to create checkout session"

- Check that your Stripe API keys are correct
- Ensure the `STRIPE_PRICE_ID` is valid
- Check Laravel logs: `tail -f storage/logs/laravel.log`

### Webhook not working

- Ensure your webhook secret is correct
- Check that your app URL is publicly accessible
- Verify webhook events in Stripe Dashboard

### Customer portal not loading

- Ensure you've configured the Customer Portal in Stripe
- Check that the user has a valid Stripe customer ID

## Support

For Stripe-specific issues, refer to:
- [Stripe Documentation](https://stripe.com/docs)
- [Laravel Cashier Documentation](https://laravel.com/docs/10.x/cashier-stripe) 