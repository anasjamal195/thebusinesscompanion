<!DOCTYPE html>
<html class="light scroll-smooth" lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <link rel="icon" type="image/png" href="{{ asset('assets/logo-min.png') }}">
  <title>Dialer.best - Mobile App</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
    rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
    rel="stylesheet" />
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-12px); }
    }
    .animate-float {
      animation: float 3s ease-in-out infinite;
    }
  </style>
</head>

<body class="antialiased text-[#25224A]">

  <!-- Navbar -->
  <nav class="bg-[#25224A] w-full border-b border-white/5">
    <div class="flex justify-between items-center h-20 px-6 md:px-12 max-w-[1600px] mx-auto">
      <div class="flex items-center gap-12">
        <a href="/" class="font-bold tracking-tight text-white flex items-center">
          <img src="{{ asset('assets/logo-light-new.png') }}" alt="dialer.best" class="h-20 w-auto">
        </a>
        <div class="hidden lg:flex items-center space-x-10 text-[15px] font-semibold text-white/70">
          <a class="hover:text-white transition-colors" href="/#how-it-works">How It Works</a>
          <a class="hover:text-white transition-colors" href="/#features">Features</a>
          <a class="hover:text-white transition-colors" href="/#mobile-app">Mobile App</a>
          <a class="hover:text-white transition-colors" href="/#faq">FAQ</a>
        </div>
      </div>
      <div class="flex items-center gap-8">
        @auth
          <a href="{{ route('dashboard') }}"
            class="hidden md:block text-[15px] font-semibold text-white/70 hover:text-white transition-colors">Dashboard</a>
          <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="hidden md:block text-[15px] font-semibold text-white/70 hover:text-white transition-colors">Sign out</button>
          </form>
        @else
          <a href="{{ route('login') }}"
            class="hidden md:block text-[15px] font-semibold text-white/70 hover:text-white transition-colors">Sign in</a>
        @endauth
        <a href="{{ Auth::check() ? route('dashboard') : route('register') }}"
          class="px-6 py-2.5 bg-[#3E50F7] hover:bg-[#3E50F7]/90 text-white font-bold rounded-full transition-all text-sm shadow-lg shadow-[#3E50F7]/20">
          {{ Auth::check() ? 'Dashboard' : 'Get started' }}
        </a>
      </div>
    </div>
  </nav>

  <!-- Hero -->
  <section class="bg-[#25224A] pt-16 pb-24 overflow-hidden relative">
    <div class="absolute inset-0 pointer-events-none">
      <div class="absolute top-1/2 right-0 -translate-y-1/2 w-[600px] h-[600px] bg-[#3E50F7]/10 rounded-full blur-[120px]"></div>
    </div>
    <div class="max-w-[1400px] mx-auto px-6 md:px-12 relative z-10">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        <div class="space-y-8">
          <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-[#3E50F7] text-xs font-bold uppercase tracking-widest">
            <span class="material-symbols-outlined text-[20px]">phone_android</span> Mobile App
          </div>
          <h1 class="text-4xl md:text-6xl lg:text-7xl font-black text-white leading-[1.1] tracking-tight">
            dialer.best<br>
            <span class="text-[#AFBBE0]">On the Go</span>
          </h1>
          <p class="text-xl text-white/70 max-w-xl leading-relaxed">
            The full dialer.best experience in your pocket. Manage calls, tasks, and daily planning — from anywhere in the world.
          </p>
          <div class="flex flex-col sm:flex-row items-center gap-4">
            <a href="{{ route('apk.download') }}"
              class="inline-flex items-center gap-3 px-8 py-4 bg-[#3E50F7] hover:bg-[#3E50F7]/90 text-white font-bold rounded-2xl transition-all text-base shadow-lg shadow-[#3E50F7]/25 group">
              <span class="material-symbols-outlined text-[22px] group-hover:animate-bounce">download</span>
              Download APK
            </a>
            <a href="/#how-it-works"
              class="px-8 py-4 bg-white/5 border border-white/10 hover:bg-white/10 text-white font-bold rounded-2xl transition-all text-base flex items-center justify-center gap-2 w-full sm:w-auto">
              <span class="material-symbols-outlined text-[20px]">play_arrow</span>
              How it works
            </a>
          </div>
        </div>
        <div class="flex items-center justify-center lg:justify-end">
          <div class="relative w-72 h-[520px] animate-float">
            <div class="absolute inset-0 bg-[#25224A] rounded-[3rem] border-4 border-white/10 shadow-2xl overflow-hidden">
              <div class="absolute top-0 left-1/2 -translate-x-1/2 w-28 h-6 bg-[#25224A] rounded-b-xl z-10"></div>
              <div class="absolute inset-2 bg-white rounded-[2.5rem] overflow-hidden flex flex-col">
                <div class="bg-[#25224A] px-4 pt-8 pb-4">
                  <div class="flex items-center gap-2 mb-3">
                    <div class="w-6 h-6 rounded-full bg-[#3E50F7] flex items-center justify-center">
                      <span class="text-white text-[10px] font-bold">D</span>
                    </div>
                    <span class="text-white text-[10px] font-bold tracking-tight">dialer.best</span>
                  </div>
                  <div class="text-white text-lg font-black">Good morning!</div>
                  <div class="text-white/60 text-[10px]">Ready to plan your day?</div>
                </div>
                <div class="flex-1 p-3 space-y-2 bg-[#F8FAFF]">
                  <div class="bg-white p-3 rounded-xl border border-[#DEE8FF] shadow-sm flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-[#3E50F7]/10 flex items-center justify-center">
                      <span class="material-symbols-outlined text-[#3E50F7] text-sm">call</span>
                    </div>
                    <div class="flex-1">
                      <div class="text-[10px] font-bold text-[#25224A]">Morning Planning Call</div>
                      <div class="text-[8px] text-[#7F798D]">8:30 AM • Incoming</div>
                    </div>
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                  </div>
                  <div class="bg-white p-3 rounded-xl border border-[#DEE8FF] shadow-sm flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-[#22C55E]/10 flex items-center justify-center">
                      <span class="material-symbols-outlined text-[#22C55E] text-sm">check_circle</span>
                    </div>
                    <div class="flex-1">
                      <div class="text-[10px] font-bold text-[#25224A]">Draft proposal</div>
                      <div class="text-[8px] text-[#7F798D]">Completed</div>
                    </div>
                    <span class="text-[8px] text-[#22C55E] font-bold">Done</span>
                  </div>
                  <div class="bg-white p-3 rounded-xl border border-[#DEE8FF] shadow-sm flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-[#3E50F7]/10 flex items-center justify-center">
                      <span class="material-symbols-outlined text-[#3E50F7] text-sm">radio_button_unchecked</span>
                    </div>
                    <div class="flex-1">
                      <div class="text-[10px] font-bold text-[#25224A]">Review budget</div>
                      <div class="text-[8px] text-[#7F798D]">In Progress</div>
                    </div>
                    <span class="text-[8px] text-[#3E50F7] font-bold">1:30 PM</span>
                  </div>
                  <div class="bg-white p-3 rounded-xl border border-[#DEE8FF] shadow-sm flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-[#EF4444]/10 flex items-center justify-center">
                      <span class="material-symbols-outlined text-[#EF4444] text-sm">call_missed</span>
                    </div>
                    <div class="flex-1">
                      <div class="text-[10px] font-bold text-[#25224A]">Follow-up Check</div>
                      <div class="text-[8px] text-[#7F798D]">Missed - Will retry</div>
                    </div>
                    <span class="text-[8px] text-[#EF4444] font-bold">Missed</span>
                  </div>
                </div>
                <div class="bg-white border-t border-[#DEE8FF] px-4 py-2 flex justify-around">
                  <span class="material-symbols-outlined text-[#3E50F7] text-lg">home</span>
                  <span class="material-symbols-outlined text-[#7F798D] text-lg">list_alt</span>
                  <span class="material-symbols-outlined text-[#7F798D] text-lg">history</span>
                  <span class="material-symbols-outlined text-[#7F798D] text-lg">person</span>
                </div>
              </div>
            </div>
            <div class="absolute -inset-4 bg-[#3E50F7]/10 rounded-[4rem] blur-2xl -z-10"></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Why Mobile App -->
  <section class="bg-white py-24">
    <div class="max-w-[1400px] mx-auto px-6 md:px-12">
      <div class="text-center mb-20">
        <h2 class="text-3xl md:text-5xl font-black text-[#25224A] tracking-tight mb-6">Why the <span class="text-[#3E50F7]">Mobile App</span>?</h2>
        <p class="text-[#7F798D] text-lg max-w-2xl mx-auto">We built the mobile app so users everywhere can access dialer.best — even outside the US.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-[#F8FAFF] p-8 rounded-[2.5rem] border border-[#DEE8FF] group hover:border-[#3E50F7]/30 transition-all hover:-translate-y-2 shadow-sm">
          <div class="w-16 h-16 rounded-2xl bg-white shadow-md flex items-center justify-center mb-6 text-[#3E50F7] group-hover:scale-110 transition-transform">
            <span class="material-symbols-outlined text-[32px]">language</span>
          </div>
          <h3 class="text-xl font-bold text-[#25224A] mb-3 leading-tight">Global Access</h3>
          <p class="text-[15px] text-[#7F798D] leading-relaxed">Use dialer.best from anywhere. Our mobile app is built for non-US based customers who need reliable access to receive calls and manage their tasks.</p>
        </div>

        <div class="bg-[#25224A] p-8 rounded-[2.5rem] border border-white/10 group hover:border-[#3E50F7]/30 transition-all hover:-translate-y-2 shadow-2xl">
          <div class="w-16 h-16 rounded-2xl bg-[#3E50F7] shadow-md flex items-center justify-center mb-6 text-white group-hover:scale-110 transition-transform">
            <span class="material-symbols-outlined text-[32px]">call_quality</span>
          </div>
          <h3 class="text-xl font-bold text-white mb-3 leading-tight">VoIP Calling</h3>
          <p class="text-[15px] text-white/60 leading-relaxed">Make and receive calls directly through the app over the internet. No need for a US phone number — use VoIP to stay connected from any country.</p>
        </div>

        <div class="bg-[#F8FAFF] p-8 rounded-[2.5rem] border border-[#DEE8FF] group hover:border-[#3E50F7]/30 transition-all hover:-translate-y-2 shadow-sm">
          <div class="w-16 h-16 rounded-2xl bg-white shadow-md flex items-center justify-center mb-6 text-[#22C55E] group-hover:scale-110 transition-transform">
            <span class="material-symbols-outlined text-[32px]">sync_alt</span>
          </div>
          <h3 class="text-xl font-bold text-[#25224A] mb-3 leading-tight">Seamless Sync</h3>
          <p class="text-[15px] text-[#7F798D] leading-relaxed">Your calls, tasks, and reports sync instantly across devices. Start a task on the web, track it on mobile — everything stays in sync.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- VoIP Coming Soon -->
  <section class="bg-[#1E204A] py-24 relative overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
      <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-[#3E50F7]/10 rounded-full blur-[120px]"></div>
    </div>
    <div class="max-w-[1400px] mx-auto px-6 md:px-12 relative z-10">
      <div class="max-w-3xl mx-auto text-center">
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-[#3E50F7] text-xs font-bold uppercase tracking-widest mb-6">
          <span class="material-symbols-outlined text-[20px]">construction</span> In Development
        </div>
        <h2 class="text-3xl md:text-5xl font-black text-white tracking-tight mb-8">
          VoIP Calling for<br>
          <span class="text-[#3E50F7]">International Users</span>
        </h2>
        <p class="text-xl text-white/60 leading-relaxed mb-6 max-w-2xl mx-auto">
          We know our non-US customers need a way to use dialer.best too. That's why we're working hard to implement <strong class="text-white">VoIP calling for international users</strong> — so you can receive calls, plan your day, and stay on top of tasks no matter where you are.
        </p>
        <p class="text-lg text-white/40 leading-relaxed mb-12 max-w-xl mx-auto">
          The mobile app is the first step toward a fully global dialer.best experience. Stay tuned.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
          <a href="{{ route('apk.download') }}"
            class="inline-flex items-center gap-3 px-8 py-4 bg-[#3E50F7] hover:bg-[#3E50F7]/90 text-white font-bold rounded-2xl transition-all text-base shadow-lg shadow-[#3E50F7]/25 group">
            <span class="material-symbols-outlined text-[22px] group-hover:animate-bounce">download</span>
            Download APK
          </a>
          <a href="/"
            class="px-8 py-4 bg-white/5 border border-white/10 hover:bg-white/10 text-white font-bold rounded-2xl transition-all text-base flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-[20px]">arrow_back</span>
            Back to Home
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Features -->
  <section class="bg-white py-24">
    <div class="max-w-[1400px] mx-auto px-6 md:px-12">
      <div class="text-center mb-20">
        <h2 class="text-3xl md:text-5xl font-black text-[#25224A] tracking-tight mb-6">App <span class="text-[#3E50F7]">Features</span></h2>
        <p class="text-[#7F798D] text-lg max-w-2xl mx-auto">Everything you love about dialer.best, now in your pocket.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-[#F8FAFF] p-6 rounded-[2rem] border border-[#DEE8FF] text-center hover:border-[#3E50F7]/30 transition-all hover:-translate-y-1">
          <div class="w-14 h-14 rounded-2xl bg-white shadow-sm flex items-center justify-center mb-4 text-[#3E50F7] mx-auto">
            <span class="material-symbols-outlined text-[28px]">call</span>
          </div>
          <h3 class="text-lg font-bold text-[#25224A] mb-2">Receive Calls</h3>
          <p class="text-sm text-[#7F798D] leading-relaxed">Answer incoming AI calls directly on your phone. No web browser needed.</p>
        </div>

        <div class="bg-[#F8FAFF] p-6 rounded-[2rem] border border-[#DEE8FF] text-center hover:border-[#3E50F7]/30 transition-all hover:-translate-y-1">
          <div class="w-14 h-14 rounded-2xl bg-white shadow-sm flex items-center justify-center mb-4 text-[#22C55E] mx-auto">
            <span class="material-symbols-outlined text-[28px]">checklist</span>
          </div>
          <h3 class="text-lg font-bold text-[#25224A] mb-2">Manage Tasks</h3>
          <p class="text-sm text-[#7F798D] leading-relaxed">View, complete, and organize your tasks with a tap. Stay on top of your day.</p>
        </div>

        <div class="bg-[#F8FAFF] p-6 rounded-[2rem] border border-[#DEE8FF] text-center hover:border-[#3E50F7]/30 transition-all hover:-translate-y-1">
          <div class="w-14 h-14 rounded-2xl bg-white shadow-sm flex items-center justify-center mb-4 text-[#3E50F7] mx-auto">
            <span class="material-symbols-outlined text-[28px]">history</span>
          </div>
          <h3 class="text-lg font-bold text-[#25224A] mb-2">Call Logs</h3>
          <p class="text-sm text-[#7F798D] leading-relaxed">Browse your call history with transcripts. Review what was discussed in every call.</p>
        </div>

        <div class="bg-[#F8FAFF] p-6 rounded-[2rem] border border-[#DEE8FF] text-center hover:border-[#3E50F7]/30 transition-all hover:-translate-y-1">
          <div class="w-14 h-14 rounded-2xl bg-white shadow-sm flex items-center justify-center mb-4 text-[#22C55E] mx-auto">
            <span class="material-symbols-outlined text-[28px]">bar_chart</span>
          </div>
          <h3 class="text-lg font-bold text-[#25224A] mb-2">Daily Reports</h3>
          <p class="text-sm text-[#7F798D] leading-relaxed">Get your end-of-day productivity report with stats and progress, right on mobile.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Download CTA -->
  <section class="bg-[#25224A] py-24 relative overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
      <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[800px] bg-[#3E50F7]/5 rounded-full blur-[120px]"></div>
    </div>
    <div class="max-w-[1400px] mx-auto px-6 md:px-12 relative z-10 text-center">
      <h2 class="text-3xl md:text-5xl font-black text-white tracking-tight mb-6">
        Ready to Take <span class="text-[#3E50F7]">dialer.best</span><br>
        Everywhere You Go?
      </h2>
      <p class="text-lg text-white/60 max-w-xl mx-auto mb-10 leading-relaxed">
        Download the APK now and start managing your calls and tasks from anywhere in the world.
      </p>
      <a href="{{ route('apk.download') }}"
        class="inline-flex items-center gap-3 px-10 py-5 bg-[#3E50F7] hover:bg-[#3E50F7]/90 text-white font-bold rounded-2xl transition-all text-lg shadow-lg shadow-[#3E50F7]/25 group">
        <span class="material-symbols-outlined text-[26px] group-hover:animate-bounce">download</span>
        Download APK Now
      </a>
      <p class="text-sm text-white/30 mt-6">Version 1.0 • Android 8.0+ • ~15 MB</p>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-white border-t border-[#DEE8FF] py-16">
    <div class="max-w-[1600px] mx-auto px-6 md:px-12">
      <div class="grid grid-cols-2 md:grid-cols-5 gap-8 mb-16">
        <div class="col-span-2 md:col-span-2 space-y-6">
          <a href="/" class="block">
            <img src="{{ asset('assets/logo-dark.png') }}" alt="dialer.best" class="h-40 w-auto">
          </a>
          <p class="text-sm text-[#7F798D] max-w-xs leading-relaxed">
            The AI todo assistant that calls you — schedules tasks, follows up, and keeps you accountable. Now available on mobile.
          </p>
          <div class="flex gap-4 text-[#7F798D]">
            <a href="#" class="hover:text-[#3E50F7]"><span class="material-symbols-outlined text-[20px]">language</span></a>
            <a href="#" class="hover:text-[#3E50F7]"><span class="material-symbols-outlined text-[20px]">mail</span></a>
          </div>
        </div>
        <div>
          <h4 class="font-bold text-[#25224A] mb-4 text-sm">Product</h4>
          <ul class="space-y-3 text-sm text-[#7F798D]">
            <li><a href="/#how-it-works" class="hover:text-[#3E50F7]">How It Works</a></li>
            <li><a href="/#voice" class="hover:text-[#3E50F7]">Call System</a></li>
            <li><a href="/#features" class="hover:text-[#3E50F7]">Features</a></li>
            <li><a href="{{ route('mobile.app') }}" class="hover:text-[#3E50F7]">Mobile App</a></li>
          </ul>
        </div>
        <div>
          <h4 class="font-bold text-[#25224A] mb-4 text-sm">Company</h4>
          <ul class="space-y-3 text-sm text-[#7F798D]">
            <li><a href="#" class="hover:text-[#3E50F7]">About</a></li>
            <li><a href="#" class="hover:text-[#3E50F7]">Careers</a></li>
            <li><a href="/#faq" class="hover:text-[#3E50F7]">FAQ</a></li>
          </ul>
        </div>
        <div>
          <h4 class="font-bold text-[#25224A] mb-4 text-sm">Legal</h4>
          <ul class="space-y-3 text-sm text-[#7F798D]">
            <li><a href="#" class="hover:text-[#3E50F7]">Privacy Policy</a></li>
            <li><a href="#" class="hover:text-[#3E50F7]">Terms of Service</a></li>
          </ul>
        </div>
      </div>
      <div class="border-t border-[#DEE8FF] pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-[#7F798D]">
        <p>&copy; {{ date('Y') }} dialer.best. All rights reserved.</p>
        <p>Engineered for Excellence.</p>
      </div>
    </div>
  </footer>
</body>
</html>