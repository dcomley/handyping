<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Mailgun\Mailgun;

class TestEmailController extends Controller
{
    /**
     * Send a test email using Mailgun
     */
    public function sendTestEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'subject' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:1000'
        ]);

        try {
            // Get Mailgun configuration
            $domain = config('services.mailgun.domain');
            $secret = config('services.mailgun.secret');
            
            if (!$domain || !$secret) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mailgun is not properly configured. Please check your .env file.'
                ], 500);
            }

            // Create Mailgun client
            $mgClient = Mailgun::create($secret);
            
            // Prepare email data
            $subject = $validated['subject'] ?? 'Test Email from HandyPing';
            $message = $validated['message'] ?? 'This is a test email from your HandyPing application. If you received this, your email configuration is working correctly!';
            
            // Send email
            $result = $mgClient->messages()->send($domain, [
                'from'    => config('mail.from.address'),
                'to'      => $validated['email'],
                'subject' => $subject,
                'text'    => $message,
                'html'    => '<p>' . nl2br(htmlspecialchars($message)) . '</p>'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Test email sent successfully!',
                'mailgun_id' => $result->getId()
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send email: ' . $e->getMessage()
            ], 500);
        }
    }
} 