<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class StripeWebhookController extends CashierController
{
    /**
     * Handle customer subscription created.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleCustomerSubscriptionCreated($payload)
    {
        // Handle the subscription created event
        // You can add custom logic here, like sending a welcome email
        
        return $this->successMethod();
    }
    
    /**
     * Handle customer subscription updated.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleCustomerSubscriptionUpdated($payload)
    {
        // Handle the subscription updated event
        // You can add custom logic here
        
        return $this->successMethod();
    }
    
    /**
     * Handle customer subscription deleted.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleCustomerSubscriptionDeleted($payload)
    {
        // Handle the subscription deleted event
        // You can add custom logic here, like sending a cancellation email
        
        return $this->successMethod();
    }
} 