<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>HandyPing - Never forget another licence renewal</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css'])
</head>
<body class="antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col items-center justify-center px-4">
        <div class="max-w-md w-full space-y-8 text-center">
            <div>
                <h1 class="text-5xl font-bold text-gray-900 mb-4">HandyPing</h1>
                <p class="text-xl text-gray-600">Never forget another licence renewal.</p>
            </div>

            <!-- Demo reminder card -->
            <div class="bg-white rounded-lg shadow-md p-6 text-left">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">White Card Renewal</h3>
                        <p class="text-sm text-gray-600">Due: 10 Aug 2025</p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                        3 days left
                    </span>
                </div>
            </div>

            <!-- CTA Buttons -->
            <div class="space-y-4">
                <a href="/login" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                    Add Reminder
                </a>
                <a href="/login" class="block w-full bg-gray-200 hover:bg-gray-300 text-gray-900 font-semibold py-3 px-6 rounded-lg transition duration-200">
                    Start Free Trial
                </a>
            </div>

            <!-- Features -->
            <div class="pt-8 space-y-4 text-sm text-gray-600">
                <p>✓ SMS & Email reminders</p>
                <p>✓ No app installation required</p>
                <p>✓ 30-day free trial</p>
                <p>✓ Only $9/month</p>
            </div>
        </div>
    </div>
</body>
</html> 