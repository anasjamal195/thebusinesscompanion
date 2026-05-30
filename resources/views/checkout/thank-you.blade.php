<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Successful — dialer.best</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: "#00AFF0" },
                    fontFamily: { sans: ["Inter", "sans-serif"] },
                },
            },
        }
    </script>
</head>
<body class="bg-[#f7f9fb] text-[#191c1e] font-sans antialiased min-h-dvh flex items-center justify-center p-6">
    <div class="w-full max-w-md text-center animate-[fadeIn_0.6s_ease-out]">
        <div class="bg-white rounded-[2.5rem] p-10 shadow-xl shadow-gray-200/50 border border-gray-100">
            @if(request('cancelled'))
                <div class="w-16 h-16 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-black text-gray-900 mb-2">Checkout Cancelled</h1>
                <p class="text-gray-500 font-medium mb-2">You have cancelled the payment. No charges were made.</p>
                <p class="text-sm text-gray-400 font-medium mb-8">You can try again whenever you're ready.</p>
            @else
                <div class="w-16 h-16 rounded-full bg-green-100 text-green-600 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-black text-gray-900 mb-2">Payment Successful!</h1>
                <p class="text-gray-500 font-medium mb-2">Your credits have been added to your account.</p>
                <p class="text-sm text-gray-400 font-medium mb-8">You can now close this page and return to the app.</p>
            @endif

            <a href="dialerapp://checkout/success"
               onclick="window.location.href='dialerapp://checkout/success'; setTimeout(function(){ document.getElementById('fallback').classList.remove('hidden') }, 2000); return false;"
               class="inline-flex items-center gap-3 px-8 py-4 bg-primary hover:brightness-90 text-white font-bold rounded-2xl shadow-xl shadow-primary/20 transition-all active:scale-95 text-base">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8.688c0-.864.933-1.405 1.683-.977l7.108 4.062a1.125 1.125 0 010 1.954l-7.108 4.062A1.125 1.125 0 013 16.812V8.688zM12.75 8.688c0-.864.933-1.405 1.683-.977l7.108 4.062a1.125 1.125 0 010 1.954l-7.108 4.062a1.125 1.125 0 01-1.683-.977V8.688z"/>
                </svg>
                Back to App
            </a>

            <div id="fallback" class="hidden mt-6 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                <p class="text-sm text-gray-500 font-medium mb-3">If the app didn't open automatically:</p>
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 text-white font-bold rounded-xl hover:bg-gray-800 transition-all text-sm">
                    Go to Dashboard
                </a>
            </div>
        </div>

        <p class="mt-8 text-xs text-gray-400 font-medium">
            &copy; {{ date('Y') }} dialer.best &mdash; The AI that calls you.
        </p>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</body>
</html>
