<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment &mdash; dialer.best</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-sm text-center">
        <div class="bg-white rounded-xl p-8 shadow-sm border border-gray-200">
            @if(request('cancelled'))
                <div class="w-12 h-12 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center mx-auto mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <h1 class="text-lg font-bold text-gray-900 mb-2">Checkout Cancelled</h1>
                <p class="text-sm text-gray-500 mb-6">No charges were made. You can try again anytime.</p>
            @else
                <div class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center mx-auto mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                    </svg>
                </div>
                <h1 class="text-lg font-bold text-gray-900 mb-2">Payment Successful!</h1>
                <p class="text-sm text-gray-500 mb-6">Your credits have been added to your account.</p>
            @endif

            <a href="dialerapp://checkout/success"
               onclick="window.location.href='dialerapp://checkout/success'; setTimeout(function(){ document.getElementById('fallback').classList.remove('hidden') }, 2000); return false;"
               class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg bg-primary text-white text-sm font-semibold hover:bg-primary-container transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8.688c0-.864.933-1.405 1.683-.977l7.108 4.062a1.125 1.125 0 010 1.954l-7.108 4.062A1.125 1.125 0 013 16.812V8.688zM12.75 8.688c0-.864.933-1.405 1.683-.977l7.108 4.062a1.125 1.125 0 010 1.954l-7.108 4.062a1.125 1.125 0 01-1.683-.977V8.688z"/>
                </svg>
                Back to App
            </a>

            <div id="fallback" class="hidden mt-5 p-4 bg-gray-50 rounded-lg border border-gray-100">
                <p class="text-sm text-gray-500 mb-3">If the app didn't open automatically:</p>
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-gray-900 text-white text-sm font-semibold hover:bg-gray-800 transition-all">
                    Go to Dashboard
                </a>
            </div>
        </div>

        <p class="mt-6 text-xs text-gray-400">
            &copy; {{ date('Y') }} dialer.best
        </p>
    </div>
</body>
</html>
