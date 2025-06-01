<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    /**
     * Show the subscription page
     */
    public function index()
    {
        $user = Auth::user();
        
        return view('subscription', [
            'intent' => $user->createSetupIntent(),
            'hasSubscription' => $user->subscribed('default')
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
                    'success_url' => route('subscription.success') . '?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => route('subscription.cancel'),
                    'allow_promotion_codes' => true,
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
     * Handle successful subscription
     */
    public function success(Request $request)
    {
        return view('subscription-success');
    }
    
    /**
     * Handle cancelled subscription
     */
    public function cancel()
    {
        return redirect()->route('dashboard')
            ->with('info', 'Subscription cancelled. You can subscribe anytime.');
    }
    
    /**
     * Cancel subscription
     */
    public function cancelSubscription(Request $request)
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
                'message' => 'Your subscription has been cancelled.'
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
        
        if (!$user->subscription('default')->onGracePeriod()) {
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
} 