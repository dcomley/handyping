<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class AuthApiController extends Controller
{
    /**
     * Send verification code to phone number
     */
    public function verifyPhone(Request $request)
    {
        $request->validate([
            'phone' => 'required|regex:/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/'
        ]);
        
        $phone = $request->phone;
        
        // Generate 6-digit verification code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Store code in cache for 10 minutes
        Cache::put('phone_verification_' . $phone, $code, now()->addMinutes(10));
        
        // TODO: Send SMS via Twilio
        // For now, we'll just log it or return it in development
        if (config('app.debug')) {
            return response()->json([
                'success' => true,
                'message' => 'Verification code sent',
                'debug_code' => $code // Remove in production
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Verification code sent to ' . $phone
        ]);
    }
    
    /**
     * Verify the code and create access token
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'code' => 'required|digits:6'
        ]);
        
        $phone = $request->phone;
        $code = $request->code;
        
        // Check if code matches
        $storedCode = Cache::get('phone_verification_' . $phone);
        
        if (!$storedCode || $storedCode !== $code) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired verification code'
            ], 401);
        }
        
        // Clear the code from cache
        Cache::forget('phone_verification_' . $phone);
        
        // Find or create user
        $user = User::firstOrCreate(
            ['phone' => $phone],
            [
                'name' => 'User',
                'email' => null,
                'password' => bcrypt(Str::random(32))
            ]
        );
        
        // Create access token
        $token = $user->createToken('auth-token')->plainTextToken;
        
        return response()->json([
            'success' => true,
            'message' => 'Successfully logged in',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email
            ],
            'token' => $token
        ]);
    }
    
    /**
     * Log out the user
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out'
        ]);
    }
} 