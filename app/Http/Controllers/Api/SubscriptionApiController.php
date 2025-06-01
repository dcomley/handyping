<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionApiController extends Controller
{
    /**
     * Get subscription status
     */
    public function status()
    {
        $user = Auth::user();
        
        return response()->json([
            'success' => true,
            'data' => [
                'has_subscription' => $user->subscribed('default'),
                'on_trial' => $user->onTrial(),
                'on_grace_period' => $user->subscription('default') ? $user->subscription('default')->onGracePeriod() : false,
                'ends_at' => $user->subscription('default') ? $user->subscription('default')->ends_at : null,
                'stripe_price_id' => env('STRIPE_PRICE_ID'),
                'price' => '$9/month'
            ]
        ]);
    }
    
    /**
     * Create a checkout session for the subscription
     */
    public function checkout(Request $request)
    {
        $user = Auth::user();
        
        // Check if user already has a subscription
        if ($user->subscribed('default')) {
            return response()->json([
                'success' => false,
                'message' => 'You already have an active subscription.'
            ], 400);
        }
        
        try {
            // Create a checkout session
            $checkout = $user->newSubscription('default', env('STRIPE_PRICE_ID'))
                ->checkout([
                    'success_url' => config('app.url') . '/subscription/success?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => config('app.url') . '/subscription',
                    'allow_promotion_codes' => true,
                    'billing_address_collection' => 'auto',
                    'customer_update' => [
                        'address' => 'auto',
                    ],
                ]);
            
            return response()->json([
                'success' => true,
                'checkout_url' => $checkout->url
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create checkout session: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Cancel subscription
     */
    public function cancel(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->subscribed('default')) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have an active subscription.'
            ], 400);
        }
        
        try {
            $user->subscription('default')->cancel();
            
            return response()->json([
                'success' => true,
                'message' => 'Your subscription has been cancelled. You will have access until the end of your billing period.'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel subscription: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Resume cancelled subscription
     */
    public function resume(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->subscription('default') || !$user->subscription('default')->onGracePeriod()) {
            return response()->json([
                'success' => false,
                'message' => 'Your subscription cannot be resumed.'
            ], 400);
        }
        
        try {
            $user->subscription('default')->resume();
            
            return response()->json([
                'success' => true,
                'message' => 'Your subscription has been resumed.'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to resume subscription: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get billing portal URL
     */
    public function billingPortal(Request $request)
    {
        $user = Auth::user();
        
        try {
            return response()->json([
                'success' => true,
                'url' => $user->billingPortalUrl(config('app.url') . '/subscription')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get billing portal URL: ' . $e->getMessage()
            ], 500);
        }
    }
} 