<!DOCTYPE html>
<html class="light scroll-smooth" lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Dialer.best - Your AI Todo Assistant</title>
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

    [x-cloak] {
      display: none !important;
    }

    @keyframes pulse-horizontal {
      0% {
        left: -50%;
      }

      100% {
        left: 100%;
      }
    }

    .animate-pulse-horizontal {
      position: absolute;
      top: 0;
      width: 50%;
      height: 100%;
      background: linear-gradient(90deg, transparent, #3E50F7, transparent);
      animation: pulse-horizontal 2.5s infinite linear;
    }

    @keyframes text-slide {

      0%,
      20% {
        transform: translateY(0);
      }

      25%,
      45% {
        transform: translateY(-20%);
      }

      50%,
      70% {
        transform: translateY(-40%);
      }

      75%,
      95% {
        transform: translateY(-60%);
      }

      100% {
        transform: translateY(-80%);
      }
    }

    .animate-text-slide {
      animation: text-slide 10s infinite cubic-bezier(0.4, 0, 0.2, 1);
    }
  </style>
</head>

<body class="antialiased text-[#25224A]" x-data="{ waitlistModalOpen: false, waitlistSubmitted: false, email: '' }">

  <!-- Navbar -->
  <nav class="bg-[#25224A] w-full border-b border-white/5">
    <div class="flex justify-between items-center h-20 px-6 md:px-12 max-w-[1600px] mx-auto">
      <div class="flex items-center gap-12">
        <div class="font-bold tracking-tight text-white flex items-center">
          <svg class="w-7 h-7 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2L2 22H22L12 2Z" stroke="#3E50F7" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round" />
            <path d="M12 10L6.5 21H17.5L12 10Z" fill="#3E50F7" />
          </svg>
          <span class="text-xl font-extrabold tracking-tight">Dialer.best</span>
        </div>
        <div class="hidden lg:flex items-center space-x-10 text-[15px] font-semibold text-white/70">
          <a class="hover:text-white transition-colors" href="#how-it-works">How It Works</a>
          <a class="hover:text-white transition-colors" href="#features">Features</a>
          <a class="hover:text-white transition-colors" href="#voice">Call System</a>
          <a class="hover:text-white transition-colors" href="#faq">FAQ</a>
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
          Get started
        </a>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="bg-[#25224A] pt-14 pb-0 lg:pt-20 overflow-hidden min-h-[600px] lg:min-h-[700px] flex items-center">
    <div
      class="w-full max-w-[1600px] mx-auto px-6 md:px-12 grid grid-cols-1 lg:grid-cols-[50%_50%] gap-0 lg:gap-8 items-center"
      x-data="{ activeSlide: 0, isScrolling: false }"
      x-init="setInterval(() => { isScrolling = true; setTimeout(() => { activeSlide = (activeSlide + 1) % 3; setTimeout(() => { isScrolling = false; }, 1000); }, 300); }, 4000)">
      <!-- Hero Graphics (Right Section) -->
      <div
        class="order-2 lg:order-2 relative w-full h-[500px] lg:h-[700px] flex justify-start items-center overflow-hidden"
        style="mask-image: linear-gradient(to bottom, transparent 0%, black 2%, black 98%, transparent 100%); -webkit-mask-image: linear-gradient(to bottom, transparent 0%, black 2%, black 98%, transparent 100%);">

        <div class="relative w-[130%] md:w-[130%] h-full flex">

          <!-- Hero Connecting Lines (Fixed in Active Slots) -->
          <div class="absolute inset-0 pointer-events-none z-0 transition-opacity duration-500 ease-in-out"
            :class="!isScrolling ? 'opacity-100' : 'opacity-0'">
            <svg class="w-full h-full" viewBox="0 0 1000 700" preserveAspectRatio="none">
              <style>
                @keyframes heroPulse {
                  from {
                    stroke-dashoffset: 400;
                  }

                  to {
                    stroke-dashoffset: 0;
                  }
                }

                @keyframes heroPulseRev {
                  from {
                    stroke-dashoffset: -400;
                  }

                  to {
                    stroke-dashoffset: 0;
                  }
                }

                .hero-path-base {
                  stroke: rgba(255, 255, 255, 0.15);
                  stroke-width: 2.5;
                  fill: none;
                  stroke-dasharray: 4 4;
                }

                .hero-path-flow {
                  stroke: #3E50F7;
                  stroke-width: 4;
                  fill: none;
                  stroke-linecap: round;
                  stroke-dasharray: 40 360;
                  animation: heroPulse 3s linear infinite;
                }

                .hero-path-flow-rev {
                  stroke: #3E50F7;
                  stroke-width: 4;
                  fill: none;
                  stroke-linecap: round;
                  stroke-dasharray: 40 360;
                  animation: heroPulseRev 3s linear infinite;
                }

                .hero-node {
                  fill: white;
                  stroke: #3E50F7;
                  stroke-width: 2;
                }

                .hero-node-pulse {
                  fill: #3E50F7;
                  opacity: 0.4;
                }
              </style>

              <!-- Line 1: SaaS Right Top Slot -> Buyer Top Middle Slot -->
              <path class="hero-path-base" d="M 480 105 L 730 105 Q 750 105 750 125 L 750 255" />
              <path class="hero-path-flow" d="M 480 105 L 730 105 Q 750 105 750 125 L 750 255" />

              <!-- Line 2: SaaS Bottom Middle Slot -> Buyer Left Bottom Slot -->
              <path class="hero-path-base" d="M 250 435 L 250 565 Q 250 585 270 585 L 520 585" />
              <path class="hero-path-flow-rev" d="M 250 435 L 250 565 Q 250 585 270 585 L 520 585" />

              <!-- Slot Nodes -->
              <g>
                <circle class="hero-node-pulse" cx="480" cy="105" r="8">
                  <animate attributeName="r" values="6;10;6" dur="2s" repeatCount="indefinite" />
                </circle>
                <circle class="hero-node" cx="480" cy="105" r="4" />
              </g>
              <g>
                <circle class="hero-node-pulse" cx="750" cy="255" r="8">
                  <animate attributeName="r" values="6;10;6" dur="2s" repeatCount="indefinite" />
                </circle>
                <circle class="hero-node" cx="750" cy="255" r="4" />
              </g>
              <g>
                <circle class="hero-node-pulse" cx="250" cy="435" r="8">
                  <animate attributeName="r" values="6;10;6" dur="2s" repeatCount="indefinite" />
                </circle>
                <circle class="hero-node" cx="250" cy="435" r="4" />
              </g>
              <g>
                <circle class="hero-node-pulse" cx="520" cy="585" r="8">
                  <animate attributeName="r" values="6;10;6" dur="2s" repeatCount="indefinite" />
                </circle>
                <circle class="hero-node" cx="520" cy="585" r="4" />
              </g>
            </svg>
          </div>

          <!-- Col 1 -->
          <div class="relative w-1/2 px-4 h-full transition-transform duration-[700ms] ease-in-out"
            :style="`transform: translateY(-${activeSlide * 410}px)`">
            <div class="absolute left-4 right-4 h-[380px] top-[calc(50%-95px-1230px)] -translate-y-1/2">
              <div
                class="w-full h-full rounded-3xl bg-[#272459] border border-white/10 opacity-40 p-6 flex flex-col gap-4 shadow-lg">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-full bg-white/10"></div>
                  <div class="space-y-2 flex-1">
                    <div class="h-2 w-1/3 bg-white/10 rounded"></div>
                    <div class="h-2 w-1/2 bg-white/10 rounded"></div>
                  </div>
                </div>
                <div class="h-24 w-full bg-white/5 rounded-xl mt-4"></div>
                <div class="h-2 w-full bg-white/10 rounded mt-auto"></div>
                <div class="h-2 w-3/4 bg-white/10 rounded"></div>
              </div>
            </div>
            <div class="absolute left-4 right-4 h-[380px] top-[calc(50%-95px-820px)] -translate-y-1/2">
              <div
                class="w-full h-full rounded-3xl bg-[#272459] border border-white/10 opacity-40 p-6 flex flex-col gap-4 shadow-lg">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-full bg-white/10"></div>
                  <div class="space-y-2 flex-1">
                    <div class="h-2 w-1/3 bg-white/10 rounded"></div>
                    <div class="h-2 w-1/2 bg-white/10 rounded"></div>
                  </div>
                </div>
                <div class="h-24 w-full bg-white/5 rounded-xl mt-4"></div>
                <div class="h-2 w-full bg-white/10 rounded mt-auto"></div>
                <div class="h-2 w-3/4 bg-white/10 rounded"></div>
              </div>
            </div>
            <div class="absolute left-4 right-4 h-[380px] top-[calc(50%-95px-410px)] -translate-y-1/2">
              <div
                class="w-full h-full rounded-3xl bg-[#272459] border border-white/10 opacity-40 p-6 flex flex-col gap-4 shadow-lg">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-full bg-white/10"></div>
                  <div class="space-y-2 flex-1">
                    <div class="h-2 w-1/3 bg-white/10 rounded"></div>
                    <div class="h-2 w-1/2 bg-white/10 rounded"></div>
                  </div>
                </div>
                <div class="h-24 w-full bg-white/5 rounded-xl mt-4"></div>
                <div class="h-2 w-full bg-white/10 rounded mt-auto"></div>
                <div class="h-2 w-3/4 bg-white/10 rounded"></div>
              </div>
            </div>

            <div class="absolute left-4 right-4 h-[380px] top-[calc(50%-95px)] -translate-y-1/2">
              <div class="relative w-full h-full rounded-3xl overflow-visible transition-all duration-500 border"
                :class="(activeSlide === 0 && !isScrolling) ? 'bg-white border-white/20 shadow-2xl z-20 scale-100' : 'bg-[#272459] border-white/10 opacity-60 z-10 scale-95 overflow-hidden'">

                <!-- Background Content for inactive state -->
                <div class="absolute inset-0 p-6 flex flex-col gap-4 transition-opacity duration-300"
                  :class="(activeSlide === 0 && !isScrolling) ? 'opacity-0 pointer-events-none' : 'opacity-100'">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white/10"></div>
                    <div class="space-y-2 flex-1">
                      <div class="h-2 w-1/3 bg-white/10 rounded"></div>
                      <div class="h-2 w-1/2 bg-white/10 rounded"></div>
                    </div>
                  </div>
                  <div class="h-24 w-full bg-white/5 rounded-xl mt-4"></div>
                </div>

                <!-- Active Content (Morning Call) -->
                <div class="absolute inset-0 flex flex-col transition-opacity duration-300"
                  :class="(activeSlide === 0 && !isScrolling) ? 'opacity-100' : 'opacity-0 pointer-events-none'">

                  <!-- Incoming Call Badge -->
                  <div
                    class="absolute -right-8 -top-4 bg-green-500 rounded-xl px-4 py-2 shadow-2xl z-30 flex items-center gap-2 animate-pulse">
                    <span class="w-2 h-2 bg-white rounded-full"></span>
                    <span class="text-[10px] text-white font-bold uppercase tracking-wider">Live Call</span>
                  </div>

                  <div class="p-8 flex flex-col h-full text-[#1E204A]">
                    <div class="flex items-center gap-3 mb-6">
                      <div class="w-12 h-12 rounded-full bg-[#3E50F7] flex items-center justify-center text-white shadow-lg">
                        <span class="material-symbols-outlined text-2xl">call</span>
                      </div>
                      <div>
                        <div class="text-[10px] text-[#525E7A] font-bold uppercase tracking-wider">Incoming Call</div>
                        <div class="text-lg font-extrabold">dialer.best AI</div>
                      </div>
                    </div>

                    <div class="flex-1 bg-[#F8FAFF] rounded-2xl p-5 border border-[#DEE8FF] space-y-3">
                      <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-[#3E50F7]/10 flex items-center justify-center">
                          <span class="material-symbols-outlined text-[#3E50F7] text-lg">schedule</span>
                        </div>
                        <div class="flex-1">
                          <div class="text-[11px] font-bold text-[#25224A]">"Good morning! Ready to plan your day?"</div>
                          <div class="text-[9px] text-[#7F798D] font-medium mt-0.5">AI Assistant • Just now</div>
                        </div>
                      </div>
                      <div class="h-px bg-[#DEE8FF]"></div>
                      <div class="flex items-center gap-2 text-[11px] text-[#7F798D]">
                        <span class="w-2 h-2 rounded-full bg-[#22C55E] animate-pulse"></span>
                        <span>AI is speaking...</span>
                      </div>
                    </div>

                    <div class="mt-auto flex gap-2">
                      <div class="flex-1 h-2 bg-[#3E50F7]/10 rounded-full"></div>
                      <div class="flex-1 h-2 bg-[#3E50F7]/10 rounded-full w-2/3"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="absolute left-4 right-4 h-[380px] top-[calc(50%-95px+410px)] -translate-y-1/2">
              <div class="relative w-full h-full rounded-3xl overflow-hidden transition-all duration-500 border"
                :class="(activeSlide === 1 && !isScrolling) ? 'bg-white border-white/20 shadow-2xl z-20 scale-100' : 'bg-[#272459] border-white/10 opacity-60 z-10 scale-95'">
                <div class="absolute inset-0 p-6 flex flex-col gap-4 transition-opacity duration-300"
                  :class="(activeSlide === 1 && !isScrolling) ? 'opacity-0' : 'opacity-100'">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white/10"></div>
                  </div>
                </div>
                <div class="absolute inset-0 p-8 flex flex-col transition-opacity duration-300 text-[#1E204A]"
                  :class="(activeSlide === 1 && !isScrolling) ? 'opacity-100' : 'opacity-0 pointer-events-none'">
                  <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-full bg-white p-1 shadow-sm relative shrink-0">
                      <div class="w-full h-full rounded-full bg-[#3E50F7]/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[#3E50F7]">notifications_active</span>
                      </div>
                      <div
                        class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full animate-pulse">
                      </div>
                    </div>
                    <div>
                      <div class="text-[10px] text-[#525E7A] uppercase font-bold tracking-wider">Follow-up</div>
                      <div class="font-extrabold text-lg">Progress Check</div>
                    </div>
                  </div>
                  <div
                    class="bg-white/40 p-4 rounded-xl border border-white/40 flex-1 space-y-3 mb-6">
                    <div class="flex items-center gap-3 text-[13px]">
                      <span class="material-symbols-outlined text-[#22C55E] text-lg">check_circle</span>
                      <span class="font-bold text-[#25224A]">Draft proposal</span>
                      <span class="ml-auto text-[10px] text-[#22C55E] font-bold">Done</span>
                    </div>
                    <div class="flex items-center gap-3 text-[13px]">
                      <span class="material-symbols-outlined text-[#3E50F7] text-lg">radio_button_unchecked</span>
                      <span class="font-bold text-[#25224A]">Review Q3 budget</span>
                      <span class="ml-auto text-[10px] text-[#3E50F7] font-bold">In Progress</span>
                    </div>
                    <div class="flex items-center gap-3 text-[13px]">
                      <span class="material-symbols-outlined text-[#EF4444] text-lg">radio_button_unchecked</span>
                      <span class="font-bold text-[#25224A]">Call client back</span>
                      <span class="ml-auto text-[10px] text-[#EF4444] font-bold">Overdue</span>
                    </div>
                  </div>
                  <div class="flex items-center gap-2 text-[11px] text-[#3E50F7] font-bold mt-auto">
                    <span class="w-2 h-2 rounded-full bg-[#3E50F7] animate-ping"></span>
                    AI calling back in 30 min...
                  </div>
                </div>
              </div>
            </div>
            <div class="absolute left-4 right-4 h-[380px] top-[calc(50%-95px+820px)] -translate-y-1/2">
              <div class="relative w-full h-full rounded-3xl overflow-hidden transition-all duration-500 border"
                :class="(activeSlide === 2 && !isScrolling) ? 'bg-white border-white/20 shadow-2xl z-20 scale-100' : 'bg-[#272459] border-white/10 opacity-60 z-10 scale-95'">
                <div class="absolute inset-0 p-6 flex flex-col gap-4 transition-opacity duration-300"
                  :class="(activeSlide === 2 && !isScrolling) ? 'opacity-0' : 'opacity-100'">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white/10"></div>
                  </div>
                </div>
                <div class="absolute inset-0 p-8 flex flex-col transition-opacity duration-300 text-[#1E204A]"
                  :class="(activeSlide === 2 && !isScrolling) ? 'opacity-100' : 'opacity-0 pointer-events-none'">
                  <div class="font-extrabold text-lg mb-4 tracking-tight flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#3E50F7]">history</span> Call Logs
                  </div>
                  <div class="flex-1 space-y-3 overflow-hidden">
                    <div class="bg-white/60 rounded-xl p-3 border border-[#DEE8FF] flex items-center gap-3">
                      <div class="w-8 h-8 rounded-full bg-[#3E50F7]/10 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[#3E50F7] text-lg">call_received</span>
                      </div>
                      <div class="flex-1 min-w-0">
                        <div class="text-[11px] font-bold text-[#25224A]">Morning Planning</div>
                        <div class="text-[9px] text-[#7F798D]">Today, 8:30 AM • 12 min</div>
                      </div>
                      <span class="text-[9px] text-[#22C55E] font-bold shrink-0">Completed</span>
                    </div>
                    <div class="bg-white/60 rounded-xl p-3 border border-[#DEE8FF] flex items-center gap-3">
                      <div class="w-8 h-8 rounded-full bg-[#3E50F7]/10 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[#3E50F7] text-lg">call_received</span>
                      </div>
                      <div class="flex-1 min-w-0">
                        <div class="text-[11px] font-bold text-[#25224A]">Follow-up Check</div>
                        <div class="text-[9px] text-[#7F798D]">Today, 11:15 AM • 5 min</div>
                      </div>
                      <span class="text-[9px] text-[#22C55E] font-bold shrink-0">Completed</span>
                    </div>
                    <div class="bg-white/60 rounded-xl p-3 border border-[#DEE8FF] flex items-center gap-3 opacity-70">
                      <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[#7F798D] text-lg">call_missed</span>
                      </div>
                      <div class="flex-1 min-w-0">
                        <div class="text-[11px] font-bold text-[#25224A]">Afternoon Update</div>
                        <div class="text-[9px] text-[#7F798D]">Today, 2:00 PM • Missed</div>
                      </div>
                      <span class="text-[9px] text-[#EF4444] font-bold shrink-0">Missed</span>
                    </div>
                  </div>
                  <div class="mt-3 flex items-center justify-between text-[9px] text-[#3E50F7] font-bold">
                    <span>View all transcripts →</span>
                    <span class="bg-[#3E50F7]/10 px-2 py-0.5 rounded-full">3 calls today</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Col 2 -->
          <div class="relative w-1/2 px-4 h-full transition-transform duration-[1000ms] ease-in-out"
            :style="`transform: translateY(-${activeSlide * 410}px)`">
            <div class="absolute left-4 right-4 h-[380px] top-[calc(50%+95px-1230px)] -translate-y-1/2">
              <div
                class="w-full h-full rounded-3xl bg-[#272459] border border-white/10 opacity-40 p-6 flex flex-col gap-4 shadow-lg">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-full bg-white/10"></div>
                  <div class="space-y-2 flex-1">
                    <div class="h-2 w-1/3 bg-white/10 rounded"></div>
                    <div class="h-2 w-1/2 bg-white/10 rounded"></div>
                  </div>
                </div>
                <div class="h-24 w-full bg-white/5 rounded-xl mt-4"></div>
                <div class="h-2 w-full bg-white/10 rounded mt-auto"></div>
                <div class="h-2 w-3/4 bg-white/10 rounded"></div>
              </div>
            </div>
            <div class="absolute left-4 right-4 h-[380px] top-[calc(50%+95px-820px)] -translate-y-1/2">
              <div
                class="w-full h-full rounded-3xl bg-[#272459] border border-white/10 opacity-40 p-6 flex flex-col gap-4 shadow-lg">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-full bg-white/10"></div>
                  <div class="space-y-2 flex-1">
                    <div class="h-2 w-1/3 bg-white/10 rounded"></div>
                    <div class="h-2 w-1/2 bg-white/10 rounded"></div>
                  </div>
                </div>
                <div class="h-24 w-full bg-white/5 rounded-xl mt-4"></div>
                <div class="h-2 w-full bg-white/10 rounded mt-auto"></div>
                <div class="h-2 w-3/4 bg-white/10 rounded"></div>
              </div>
            </div>
            <div class="absolute left-4 right-4 h-[380px] top-[calc(50%+95px-410px)] -translate-y-1/2">
              <div
                class="w-full h-full rounded-3xl bg-[#272459] border border-white/10 opacity-40 p-6 flex flex-col gap-4 shadow-lg">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-full bg-white/10"></div>
                  <div class="space-y-2 flex-1">
                    <div class="h-2 w-1/3 bg-white/10 rounded"></div>
                    <div class="h-2 w-1/2 bg-white/10 rounded"></div>
                  </div>
                </div>
                <div class="h-24 w-full bg-white/5 rounded-xl mt-4"></div>
                <div class="h-2 w-full bg-white/10 rounded mt-auto"></div>
                <div class="h-2 w-3/4 bg-white/10 rounded"></div>
              </div>
            </div>
            <div class="absolute left-4 right-4 h-[380px] top-[calc(50%+95px)] -translate-y-1/2">
              <div class="relative w-full h-full rounded-3xl overflow-visible transition-all duration-500 border"
                :class="(activeSlide === 0 && !isScrolling) ? 'bg-white border-white/20 shadow-2xl z-20 scale-100' : 'bg-[#272459] border-white/10 opacity-60 z-10 scale-95 overflow-hidden'">

                <!-- Background Content for inactive state -->
                <div class="absolute inset-0 p-6 flex flex-col gap-4 transition-opacity duration-300"
                  :class="(activeSlide === 0 && !isScrolling) ? 'opacity-0 pointer-events-none' : 'opacity-100'">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white/10"></div>
                    <div class="space-y-2 flex-1">
                      <div class="h-2 w-1/3 bg-white/10 rounded"></div>
                      <div class="h-2 w-1/2 bg-white/10 rounded"></div>
                    </div>
                  </div>
                  <div class="h-24 w-full bg-white/5 rounded-xl mt-4"></div>
                </div>

                <!-- Active Content (Today's Tasks) -->
                <div class="absolute inset-0 flex flex-col transition-opacity duration-300 text-[#1E204A]"
                  :class="(activeSlide === 0 && !isScrolling) ? 'opacity-100' : 'opacity-0 pointer-events-none'">

                  <div class="p-8 flex flex-col h-full">
                    <div class="flex items-center justify-between mb-6">
                      <div>
                        <div class="text-[10px] text-[#525E7A] font-bold uppercase tracking-wider">Today's Schedule</div>
                        <div class="text-2xl font-extrabold">5 Tasks</div>
                      </div>
                      <div class="text-right">
                        <div class="text-[10px] text-[#525E7A] font-bold uppercase">Progress</div>
                        <div class="text-lg font-extrabold text-[#3E50F7]">60%</div>
                      </div>
                    </div>

                    <div class="flex-1 space-y-3">
                      <div class="flex items-center gap-3 bg-[#F8FAFF] p-3 rounded-xl border border-[#DEE8FF]">
                        <span class="material-symbols-outlined text-[#22C55E] text-lg">check_circle</span>
                        <div class="flex-1">
                          <div class="text-[13px] font-bold text-[#25224A]">Draft Q4 proposal</div>
                          <div class="text-[9px] text-[#7F798D]">Due: Today • High priority</div>
                        </div>
                      </div>
                      <div class="flex items-center gap-3 bg-[#F8FAFF] p-3 rounded-xl border border-[#DEE8FF]">
                        <span class="material-symbols-outlined text-[#3E50F7] text-lg">radio_button_unchecked</span>
                        <div class="flex-1">
                          <div class="text-[13px] font-bold text-[#25224A]">Review team updates</div>
                          <div class="text-[9px] text-[#7F798D]">Due: Today • Medium</div>
                        </div>
                      </div>
                      <div class="flex items-center gap-3 bg-[#F8FAFF] p-3 rounded-xl border border-[#DEE8FF]">
                        <span class="material-symbols-outlined text-[#3E50F7] text-lg">radio_button_unchecked</span>
                        <div class="flex-1">
                          <div class="text-[13px] font-bold text-[#25224A]">Call Johnson & Co.</div>
                          <div class="text-[9px] text-[#7F798D]">Due: Today • High priority</div>
                        </div>
                      </div>
                      <div class="flex items-center gap-3 opacity-60 p-3">
                        <span class="material-symbols-outlined text-[#7F798D] text-lg">radio_button_unchecked</span>
                        <div class="flex-1">
                          <div class="text-[13px] font-bold text-[#25224A]">Prepare presentation</div>
                          <div class="text-[9px] text-[#7F798D]">Due: Tomorrow</div>
                        </div>
                      </div>
                    </div>

                    <div class="mt-auto pt-4 border-t border-[#DEE8FF] flex justify-between text-[10px] text-[#7F798D] font-bold">
                      <span>2 completed • 3 remaining</span>
                      <span class="text-[#3E50F7]">View all →</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="absolute left-4 right-4 h-[380px] top-[calc(50%+95px+410px)] -translate-y-1/2">
              <div class="relative w-full h-full rounded-3xl overflow-hidden transition-all duration-500 border"
                :class="(activeSlide === 1 && !isScrolling) ? 'bg-white border-white/20 shadow-2xl z-20 scale-100' : 'bg-[#272459] border-white/10 opacity-60 z-10 scale-95'">
                <div class="absolute inset-0 p-6 flex flex-col gap-4 transition-opacity duration-300"
                  :class="(activeSlide === 1 && !isScrolling) ? 'opacity-0' : 'opacity-100'">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white/10"></div>
                  </div>
                </div>
                <div class="absolute inset-0 p-8 flex flex-col transition-opacity duration-300 text-[#1E204A]"
                  :class="(activeSlide === 1 && !isScrolling) ? 'opacity-100' : 'opacity-0 pointer-events-none'">
                  <div class="font-extrabold text-xl tracking-tight mb-4 flex items-center gap-3">
                    <span class="material-symbols-outlined text-[#22C55E] text-2xl">summarize</span> Daily Report
                  </div>
                  <div class="bg-white/40 p-4 rounded-2xl border border-white/40 mb-4 space-y-3">
                    <div class="flex justify-between items-center">
                      <span class="text-[10px] font-bold text-[#525E7A] uppercase">Tasks Completed</span>
                      <span class="text-lg font-extrabold text-[#22C55E]">3/5</span>
                    </div>
                    <div class="h-2 bg-[#DEE8FF] rounded-full overflow-hidden">
                      <div class="h-full w-[60%] bg-[#22C55E] rounded-full"></div>
                    </div>
                    <div class="flex justify-between text-[10px] text-[#7F798D]">
                      <span>Hours logged: 4.5h</span>
                      <span>Calls: 3</span>
                    </div>
                  </div>
                  <div class="bg-white/30 rounded-xl p-3 border border-white/40 text-[11px]">
                    <div class="font-bold text-[#25224A] mb-1">Transcript Preview</div>
                    <div class="text-[#7F798D] italic">"Draft proposal completed. Moving to budget review..."</div>
                  </div>
                  <div class="mt-auto pt-3 flex gap-2">
                    <div
                      class="flex-1 bg-[#3E50F7] text-white text-center py-3 rounded-xl text-[10px] font-bold cursor-pointer hover:bg-[#3E50F7]/90 shadow-lg shadow-[#3E50F7]/20 transition-all uppercase tracking-wider">
                      View Full Report</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="absolute left-4 right-4 h-[380px] top-[calc(50%+95px+820px)] -translate-y-1/2">
              <div class="relative w-full h-full rounded-3xl overflow-hidden transition-all duration-500 border"
                :class="(activeSlide === 2 && !isScrolling) ? 'bg-white border-white/20 shadow-2xl z-20 scale-100' : 'bg-[#272459] border-white/10 opacity-60 z-10 scale-95'">
                <div class="absolute inset-0 p-6 flex flex-col gap-4 transition-opacity duration-300"
                  :class="(activeSlide === 2 && !isScrolling) ? 'opacity-0' : 'opacity-100'">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white/10"></div>
                  </div>
                </div>
                <div class="absolute inset-0 p-8 flex flex-col transition-opacity duration-300 text-[#1E204A]"
                  :class="(activeSlide === 2 && !isScrolling) ? 'opacity-100' : 'opacity-0 pointer-events-none'">
                  <div class="font-extrabold text-xl mb-4 tracking-tight flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#3E50F7]">bar_chart</span> Your Stats
                  </div>
                  <div class="grid grid-cols-2 gap-3 mb-4">
                    <div class="bg-white/60 rounded-xl p-4 border border-[#DEE8FF] text-center">
                      <div class="text-2xl font-extrabold text-[#25224A]">12</div>
                      <div class="text-[9px] text-[#7F798D] font-bold uppercase">Tasks This Week</div>
                    </div>
                    <div class="bg-white/60 rounded-xl p-4 border border-[#DEE8FF] text-center">
                      <div class="text-2xl font-extrabold text-[#22C55E]">9</div>
                      <div class="text-[9px] text-[#7F798D] font-bold uppercase">Completed</div>
                    </div>
                    <div class="bg-white/60 rounded-xl p-4 border border-[#DEE8FF] text-center">
                      <div class="text-2xl font-extrabold text-[#3E50F7]">75%</div>
                      <div class="text-[9px] text-[#7F798D] font-bold uppercase">Completion Rate</div>
                    </div>
                    <div class="bg-white/60 rounded-xl p-4 border border-[#DEE8FF] text-center">
                      <div class="text-2xl font-extrabold text-[#25224A]">8h</div>
                      <div class="text-[9px] text-[#7F798D] font-bold uppercase">Focused Time</div>
                    </div>
                  </div>
                  <div
                    class="bg-[#3E50F7]/5 text-[#3E50F7] text-[10px] font-bold text-center py-3 rounded-xl mt-auto border border-[#3E50F7]/20 uppercase tracking-widest">
                    Procrastination Score: 15% ↓</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Hero Text (Left Section) -->
      <div class="order-1 lg:order-1 space-y-6 lg:space-y-8 pb-10 lg:pb-20 relative z-10 flex flex-col justify-center">

        <div>
          <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/10 mb-6">
            <span class="w-2 h-2 rounded-full bg-[#22C55E] animate-pulse"></span>
            <span class="text-[10px] font-bold text-white/80 uppercase tracking-widest">Now in private beta</span>
          </div>

          <h1 class="text-3xl md:text-5xl lg:text-6xl font-extrabold text-white leading-[1] tracking-tight">
            Plan your day<br>
            with a<br>
            <span class="text-[#AFBBE0]">morning call</span>
          </h1>
        </div>

        <div class="space-y-6">
          <p class="text-white/90 text-xl font-semibold max-w-xl leading-relaxed">
            Kill procrastination. Get more done.
          </p>
          <p class="text-white/70 text-base max-w-lg leading-relaxed">
            An AI that calls you in the morning, schedules your tasks, follows up until completion, and generates your daily report. View call logs with transcripts anytime.
          </p>
        </div>

        <!-- Buttons -->
        <div class="flex flex-col sm:flex-row items-center gap-4 pt-4">
          <button @click="waitlistModalOpen = true"
            class="px-10 py-4 bg-[#3E50F7] hover:bg-[#3E50F7]/90 text-white font-bold rounded-xl transition-all text-base flex items-center justify-center gap-2 w-full sm:w-auto shadow-lg shadow-[#3E50F7]/25">
            Join Waitlist <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
          </button>
          <a href="#how-it-works"
            class="px-10 py-4 bg-white/5 border border-white/10 hover:bg-white/10 text-white font-bold rounded-xl transition-all text-base flex items-center justify-center gap-3 w-full sm:w-auto">
            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center">
              <span class="material-symbols-outlined text-[#1E204A] text-[20px] ml-0.5">play_arrow</span>
            </div>
            How it works
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Stats Section -->
  <section class="bg-[#272459] py-10 border-t border-white/5">
    <div class="max-w-[1600px] mx-auto px-6 md:px-12">
      <div class="grid grid-cols-2 md:grid-cols-5 gap-8 text-center divide-x divide-white/10">
        <div class="px-4">
          <div class="text-2xl font-bold text-white mb-1">10,000+</div>
          <div class="text-xs text-[#AFBBE0] uppercase tracking-wider font-semibold">Active Users</div>
        </div>
        <div class="px-4">
          <div class="text-2xl font-bold text-white mb-1">100K+</div>
          <div class="text-xs text-[#AFBBE0] uppercase tracking-wider font-semibold">Tasks Completed</div>
        </div>
        <div class="px-4">
          <div class="text-2xl font-bold text-white mb-1">50K+</div>
          <div class="text-xs text-[#AFBBE0] uppercase tracking-wider font-semibold">Hours Saved</div>
        </div>
        <div class="px-4">
          <div class="text-2xl font-bold text-white mb-1">24/7</div>
          <div class="text-xs text-[#AFBBE0] uppercase tracking-wider font-semibold">AI Follow-ups</div>
        </div>
        <div class="px-4 hidden md:block">
          <div class="text-2xl font-bold text-white mb-1">US</div>
          <div class="text-xs text-[#AFBBE0] uppercase tracking-wider font-semibold">Phone Numbers</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Section 2: How dialer.best Works -->
  <section id="how-it-works" class="bg-white py-24 relative overflow-hidden">
    <div class="max-w-[1400px] mx-auto px-6 md:px-12">
      <div class="text-center mb-20">
        <h2 class="text-3xl md:text-5xl font-black text-[#25224A] tracking-tight mb-6">How <span
            class="text-[#3E50F7]">dialer.best</span> Works</h2>
        <p class="text-[#7F798D] text-lg max-w-2xl mx-auto">It calls you. You talk. Tasks get done. No apps, no typing.</p>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 relative">
        <!-- Step 1: Morning Call -->
        <div class="bg-[#F8FAFF] p-8 rounded-[2.5rem] border border-[#DEE8FF] relative group overflow-hidden">
          <div class="relative z-10 text-center">
            <div class="w-16 h-16 rounded-2xl bg-white shadow-sm flex items-center justify-center mb-6 text-[#3E50F7] mx-auto">
              <span class="material-symbols-outlined text-3xl">phone_callback</span>
            </div>
            <div class="inline-flex items-center gap-1 px-3 py-1 bg-[#3E50F7]/10 rounded-full text-[10px] font-bold text-[#3E50F7] mb-4">Step 01</div>
            <h3 class="text-2xl font-bold text-[#25224A] mb-3">Morning Call</h3>
            <p class="text-[#7F798D] text-sm leading-relaxed">You wake up. dialer.best calls you. A natural conversation to plan your day, set priorities, and commit to tasks.</p>
          </div>
        </div>

        <!-- Step 2: Schedule -->
        <div class="bg-[#25224A] p-8 rounded-[2.5rem] border border-white/5 relative group overflow-hidden shadow-2xl -mt-4 lg:mt-8">
          <div class="relative z-10 text-center">
            <div class="w-16 h-16 rounded-2xl bg-[#3E50F7] shadow-lg flex items-center justify-center mb-6 text-white mx-auto">
              <span class="material-symbols-outlined text-3xl">checklist</span>
            </div>
            <div class="inline-flex items-center gap-1 px-3 py-1 bg-white/10 rounded-full text-[10px] font-bold text-white/80 mb-4">Step 02</div>
            <h3 class="text-2xl font-bold text-white mb-3">Schedule Tasks</h3>
            <p class="text-white/60 text-sm leading-relaxed">Just talk. Your tasks are parsed, organized, and added to your schedule. Deadlines, priorities, and notes — all captured.</p>
          </div>
        </div>

        <!-- Step 3: Follow-ups -->
        <div class="bg-[#F8FAFF] p-8 rounded-[2.5rem] border border-[#DEE8FF] relative group overflow-hidden">
          <div class="relative z-10 text-center">
            <div class="w-16 h-16 rounded-2xl bg-white shadow-sm flex items-center justify-center mb-6 text-[#22C55E] mx-auto">
              <span class="material-symbols-outlined text-3xl">notifications_active</span>
            </div>
            <div class="inline-flex items-center gap-1 px-3 py-1 bg-[#22C55E]/10 rounded-full text-[10px] font-bold text-[#22C55E] mb-4">Step 03</div>
            <h3 class="text-2xl font-bold text-[#25224A] mb-3">Smart Follow-ups</h3>
            <p class="text-[#7F798D] text-sm leading-relaxed">The AI calls you back throughout the day. Not a notification — an actual conversation. "Did you finish that proposal? Need help?"</p>
          </div>
        </div>

        <!-- Step 4: Report -->
        <div class="bg-[#25224A] p-8 rounded-[2.5rem] border border-white/5 relative group overflow-hidden shadow-2xl -mt-4 lg:mt-8">
          <div class="relative z-10 text-center">
            <div class="w-16 h-16 rounded-2xl bg-[#3E50F7] shadow-lg flex items-center justify-center mb-6 text-white mx-auto">
              <span class="material-symbols-outlined text-3xl">summarize</span>
            </div>
            <div class="inline-flex items-center gap-1 px-3 py-1 bg-white/10 rounded-full text-[10px] font-bold text-white/80 mb-4">Step 04</div>
            <h3 class="text-2xl font-bold text-white mb-3">Daily Report</h3>
            <p class="text-white/60 text-sm leading-relaxed">End of day. You get a full report: tasks completed, hours logged, progress summary. Plus call logs with transcripts to review anytime.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Section: Kill Procrastination -->
  <section id="features" class="bg-white py-24 relative overflow-hidden">
    <div class="max-w-[1400px] mx-auto px-6 md:px-12">
      <div class="text-center mb-20">
        <h2 class="text-3xl md:text-5xl font-black text-[#25224A] tracking-tight mb-6">Why dialer.best <span
            class="text-[#3E50F7]">Kills Procrastination</span></h2>
        <p class="text-[#7F798D] text-lg max-w-2xl mx-auto">Because notifications are too easy to ignore.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
        <!-- Feature 1 -->
        <div
          class="group relative bg-[#F8FAFF] p-8 rounded-[2.5rem] border border-[#DEE8FF] hover:border-[#3E50F7]/30 transition-all hover:-translate-y-2 shadow-sm">
          <div
            class="w-16 h-16 rounded-2xl bg-white shadow-md flex items-center justify-center mb-6 text-[#3E50F7] group-hover:scale-110 transition-transform">
            <span class="material-symbols-outlined text-[32px]">call</span>
          </div>
          <h3 class="text-xl font-bold text-[#25224A] mb-3 leading-tight">Human-like Voice Calls</h3>
          <p class="text-[15px] text-[#7F798D] leading-relaxed">A real voice on the line. Not another notification you can swipe away. The AI calls you with natural conversation that keeps you accountable.</p>
        </div>

        <!-- Feature 2 -->
        <div
          class="group relative bg-[#25224A] p-8 rounded-[2.5rem] border border-white/10 hover:border-[#3E50F7]/30 transition-all hover:-translate-y-2 shadow-2xl">
          <div
            class="w-16 h-16 rounded-2xl bg-[#3E50F7] shadow-md flex items-center justify-center mb-6 text-white group-hover:scale-110 transition-transform">
            <span class="material-symbols-outlined text-[32px]">notifications_active</span>
          </div>
          <h3 class="text-xl font-bold text-white mb-3 leading-tight">Persistent Follow-ups</h3>
          <p class="text-[15px] text-white/60 leading-relaxed">The AI doesn't give up. It calls you back throughout the day — checking in, offering help, and keeping you on track until every task is done.</p>
        </div>

        <!-- Feature 3 -->
        <div
          class="group relative bg-[#F8FAFF] p-8 rounded-[2.5rem] border border-[#DEE8FF] hover:border-[#3E50F7]/30 transition-all hover:-translate-y-2 shadow-sm">
          <div
            class="w-16 h-16 rounded-2xl bg-white shadow-md flex items-center justify-center mb-6 text-[#22C55E] group-hover:scale-110 transition-transform">
            <span class="material-symbols-outlined text-[32px]">fact_check</span>
          </div>
          <h3 class="text-xl font-bold text-[#25224A] mb-3 leading-tight">Call Logs & Transcripts</h3>
          <p class="text-[15px] text-[#7F798D] leading-relaxed">Every call is recorded with a full AI transcript. Review your history, track decisions, and never forget a commitment.</p>
        </div>
      </div>

      <!-- US Only Banner -->
      <div class="mt-20 p-8 rounded-3xl bg-gradient-to-br from-[#25224A] to-[#3E50F7] relative overflow-hidden group">
        <div
          class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10">
        </div>
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
          <div class="w-16 h-16 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-white text-[32px]">phone_in_talk</span>
          </div>
          <div class="flex-1 text-center md:text-left">
            <h4 class="text-white font-bold text-xl mb-2 uppercase tracking-wider text-[12px]">US Phone Numbers Only</h4>
            <p class="text-white/90 text-lg leading-relaxed">
              Currently serving <span
                class="text-white font-bold underline decoration-white/30 decoration-2 underline-offset-4">US-based phone numbers</span> with premium VOIP infrastructure. Crystal-clear calls, minimal latency, enterprise-grade reliability.
            </p>
          </div>
          <span class="px-6 py-3 bg-white/10 backdrop-blur-md text-white font-bold rounded-2xl border border-white/20 text-sm whitespace-nowrap">
            <span class="material-symbols-outlined text-[18px] align-middle mr-1">star</span> More regions coming soon
          </span>
        </div>
      </div>
    </div>
  </section>

  <!-- Section: Smart VOIP Calling System -->
  <section id="voice" class="bg-[#1E204A] py-32 border-y border-white/5 relative overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
      <div
        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-[#3E50F7]/10 rounded-full blur-[120px]">
      </div>
      <div
        class="absolute top-0 left-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10">
      </div>
    </div>

    <div class="max-w-[1400px] mx-auto px-6 relative z-10">
      <div class="text-center mb-24">
        <div
          class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-[#3E50F7] text-xs font-bold uppercase tracking-widest mb-6 shadow-xl">
          <span class="material-symbols-outlined text-[20px] animate-pulse">settings_input_antenna</span> The Technology
        </div>
        <h2
          class="text-4xl md:text-6xl lg:text-7xl font-black text-white max-w-4xl mx-auto leading-[1.1] tracking-tight">
          Smart VOIP<br><span class="text-[#3E50F7]">Calling Assistant</span>
        </h2>
        <p class="text-xl text-white/50 max-w-2xl mx-auto mt-8 leading-relaxed">
          No screens, no typing — just a proactive AI that calls you to plan your day, check progress, and keeps you accountable until every task is done.
        </p>
      </div>

      <div class="relative w-full mx-auto">
        <svg class="hidden md:block absolute inset-0 w-full h-[450px] pointer-events-none -z-10" viewBox="0 0 1400 450"
          preserveAspectRatio="none">
          <style>
            @keyframes flowLineNew {
              to {
                stroke-dashoffset: -440;
              }
            }

            .path-base-new {
              stroke: rgba(255, 255, 255, 0.05);
              stroke-width: 2;
              stroke-dasharray: 8 8;
              fill: none;
            }

            .path-flow-new {
              stroke: #3E50F7;
              stroke-width: 4;
              fill: none;
              stroke-linecap: round;
              stroke-dasharray: 60 400;
              animation: flowLineNew 3s linear infinite;
              filter: drop-shadow(0 0 8px #3E50F7);
            }
          </style>
          <path class="path-base-new" d="M 280 150 L 317 150 Q 327 150 327 160 L 327 300 Q 327 310 337 310 L 374 310" />
          <path class="path-flow-new" d="M 280 150 L 317 150 Q 327 150 327 160 L 327 300 Q 327 310 337 310 L 374 310" />

          <path class="path-base-new" d="M 653 310 L 690 310 Q 700 310 700 300 L 700 160 Q 700 150 710 150 L 747 150" />
          <path class="path-flow-new" style="animation-delay: 1s;"
            d="M 653 310 L 690 310 Q 700 310 700 300 L 700 160 Q 700 150 710 150 L 747 150" />

          <path class="path-base-new"
            d="M 1027 150 L 1064 150 Q 1074 150 1074 160 L 1074 300 Q 1074 310 1084 310 L 1121 310" />
          <path class="path-flow-new" style="animation-delay: 2s;"
            d="M 1027 150 L 1064 150 Q 1074 150 1074 160 L 1074 300 Q 1074 310 1084 310 L 1121 310" />
        </svg>

        <div class="flex flex-col md:flex-row justify-between items-start gap-8 md:gap-4 relative">
          <!-- Step 1 -->
          <div class="w-full md:w-[22%] h-auto relative group">
            <div
              class="h-full flex flex-col items-center p-8 bg-white/5 backdrop-blur-xl rounded-[2.5rem] border border-white/10 group-hover:border-[#3E50F7]/30 transition-all duration-500">
              <div
                class="w-20 h-20 bg-white/5 text-white/20 rounded-full flex items-center justify-center mb-6 group-hover:text-white group-hover:bg-[#3E50F7]/20 transition-all">
                <span class="material-symbols-outlined text-4xl">alarm</span>
              </div>
              <h3 class="font-bold text-white text-center text-xl mb-3">Morning Call</h3>
              <p class="text-sm text-white/40 text-center leading-relaxed">The AI calls you at your set time. Plan your day, set priorities, and commit to tasks.</p>
            </div>
          </div>

          <!-- Step 2 (Active/Grand) -->
          <div class="w-full md:w-[24%] h-auto relative md:mt-[150px] group">
            <div
              class="h-full flex flex-col items-center p-10 bg-gradient-to-br from-[#3E50F7] to-[#25224A] text-white rounded-[3rem] shadow-[0_0_60px_rgba(62,80,247,0.3)] border border-white/20 transform group-hover:scale-105 transition-all duration-500">
              <div
                class="w-24 h-24 bg-white text-[#3E50F7] rounded-full flex items-center justify-center mb-8 shadow-2xl relative">
                <span class="material-symbols-outlined text-5xl">call</span>
                <div class="absolute inset-0 rounded-full border-4 border-white/50 animate-ping"></div>
              </div>
              <h3 class="font-black text-center text-2xl mb-4 tracking-tight">Voice Scheduling</h3>
              <p class="text-sm text-white/80 text-center leading-relaxed font-medium">Just talk naturally. The AI parses your tasks, deadlines, and notes — all through conversation.</p>
            </div>
          </div>

          <!-- Step 3 -->
          <div class="w-full md:w-[22%] h-auto relative group">
            <div
              class="h-full flex flex-col items-center p-8 bg-white/5 backdrop-blur-xl rounded-[2.5rem] border border-white/10 group-hover:border-[#3E50F7]/30 transition-all duration-500">
              <div
                class="w-20 h-20 bg-white/5 text-white/20 rounded-full flex items-center justify-center mb-6 group-hover:text-[#22C55E] group-hover:bg-[#22C55E]/20 transition-all">
                <span class="material-symbols-outlined text-4xl">sync</span>
              </div>
              <h3 class="font-bold text-white text-center text-xl mb-3">Smart Follow-ups</h3>
              <p class="text-sm text-white/40 text-center leading-relaxed">The AI calls you back at intervals until tasks are completed. Persistent accountability.</p>
            </div>
          </div>

          <!-- Step 4 -->
          <div class="w-full md:w-[22%] h-auto relative md:mt-[150px] group">
            <div
              class="h-full flex flex-col items-center p-8 bg-white/5 backdrop-blur-xl rounded-[2.5rem] border border-white/10 group-hover:border-[#3E50F7]/30 transition-all duration-500">
              <div
                class="w-20 h-20 bg-white/5 text-white/20 rounded-full flex items-center justify-center mb-6 group-hover:text-[#AFBBE0] group-hover:bg-[#AFBBE0]/20 transition-all">
                <span class="material-symbols-outlined text-4xl">summarize</span>
              </div>
              <h3 class="font-bold text-white text-center text-xl mb-3">Daily Report</h3>
              <p class="text-sm text-white/40 text-center leading-relaxed">End-of-day summary. Tasks completed, hours logged, progress tracked. Full transcripts available.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ Section -->
  <section id="faq" class="bg-[#F8FAFF] py-24 relative overflow-hidden" x-data="{ activeFaq: null }">
    <div class="max-w-4xl mx-auto px-6 md:px-12">
      <div class="text-center mb-16">
        <h2 class="text-3xl md:text-5xl font-black text-[#25224A] tracking-tight">Everything you <span
            class="text-[#3E50F7]">Need to Know</span></h2>
      </div>

      <div class="space-y-4">
        <!-- FAQ Item 1 -->
        <div class="bg-white rounded-3xl border border-[#DEE8FF] overflow-hidden transition-all shadow-sm">
          <button @click="activeFaq === 1 ? activeFaq = null : activeFaq = 1"
            class="w-full px-8 py-6 text-left flex items-center justify-between group">
            <span class="text-lg md:text-xl font-bold text-[#25224A]">What is dialer.best?</span>
            <span class="material-symbols-outlined text-[#3E50F7] transition-transform duration-300"
              :class="activeFaq === 1 ? 'rotate-45' : ''">add</span>
          </button>
          <div x-show="activeFaq === 1" x-collapse class="px-8 pb-6 text-[#7F798D] leading-relaxed">
            dialer.best is an AI todo assistant that calls you on the phone. It helps you schedule daily tasks, tracks your progress, follows up until everything is done, and generates a daily report — all through natural voice conversations.
          </div>
        </div>

        <!-- FAQ Item 2 -->
        <div class="bg-white rounded-3xl border border-[#DEE8FF] overflow-hidden transition-all shadow-sm">
          <button @click="activeFaq === 2 ? activeFaq = null : activeFaq = 2"
            class="w-full px-8 py-6 text-left flex items-center justify-between group">
            <span class="text-lg md:text-xl font-bold text-[#25224A]">How does it work?</span>
            <span class="material-symbols-outlined text-[#3E50F7] transition-transform duration-300"
              :class="activeFaq === 2 ? 'rotate-45' : ''">add</span>
          </button>
          <div x-show="activeFaq === 2" x-collapse class="px-8 pb-6 text-[#7F798D] leading-relaxed">
            The AI calls you in the morning to plan your day. You talk through your tasks naturally. It schedules them, then calls you back throughout the day to check progress. At the end of the day, you get a full report with call transcripts.
          </div>
        </div>

        <!-- FAQ Item 3 -->
        <div class="bg-white rounded-3xl border border-[#DEE8FF] overflow-hidden transition-all shadow-sm">
          <button @click="activeFaq === 3 ? activeFaq = null : activeFaq = 3"
            class="w-full px-8 py-6 text-left flex items-center justify-between group">
            <span class="text-lg md:text-xl font-bold text-[#25224A]">Is this available internationally?</span>
            <span class="material-symbols-outlined text-[#3E50F7] transition-transform duration-300"
              :class="activeFaq === 3 ? 'rotate-45' : ''">add</span>
          </button>
          <div x-show="activeFaq === 3" x-collapse class="px-8 pb-6 text-[#7F798D] leading-relaxed">
            Currently, dialer.best is available for <strong>US-based phone numbers only</strong>. We are working on expanding to more regions. Join the waitlist to get notified when your region is supported.
          </div>
        </div>

        <!-- FAQ Item 4 -->
        <div class="bg-white rounded-3xl border border-[#DEE8FF] overflow-hidden transition-all shadow-sm">
          <button @click="activeFaq === 4 ? activeFaq = null : activeFaq = 4"
            class="w-full px-8 py-6 text-left flex items-center justify-between group">
            <span class="text-lg md:text-xl font-bold text-[#25224A]">Can I review past calls and transcripts?</span>
            <span class="material-symbols-outlined text-[#3E50F7] transition-transform duration-300"
              :class="activeFaq === 4 ? 'rotate-45' : ''">add</span>
          </button>
          <div x-show="activeFaq === 4" x-collapse class="px-8 pb-6 text-[#7F798D] leading-relaxed">
            Yes! Every call is recorded with a full AI-generated transcript. You can browse your call history, read transcripts, and review task progress at any time from your dashboard.
          </div>
        </div>

        <!-- FAQ Item 5 -->
        <div class="bg-white rounded-3xl border border-[#DEE8FF] overflow-hidden transition-all shadow-sm">
          <button @click="activeFaq === 5 ? activeFaq = null : activeFaq = 5"
            class="w-full px-8 py-6 text-left flex items-center justify-between group">
            <span class="text-lg md:text-xl font-bold text-[#25224A]">What if I miss a call?</span>
            <span class="material-symbols-outlined text-[#3E50F7] transition-transform duration-300"
              :class="activeFaq === 5 ? 'rotate-45' : ''">add</span>
          </button>
          <div x-show="activeFaq === 5" x-collapse class="px-8 pb-6 text-[#7F798D] leading-relaxed">
            No problem. The AI will call you back. You can also check your missed calls and transcripts in your dashboard, or simply wait for the follow-up call.
          </div>
        </div>

        <!-- FAQ Item 6 -->
        <div class="bg-white rounded-3xl border border-[#DEE8FF] overflow-hidden transition-all shadow-sm">
          <button @click="activeFaq === 6 ? activeFaq = null : activeFaq = 6"
            class="w-full px-8 py-6 text-left flex items-center justify-between group">
            <span class="text-lg md:text-xl font-bold text-[#25224A]">How much does it cost?</span>
            <span class="material-symbols-outlined text-[#3E50F7] transition-transform duration-300"
              :class="activeFaq === 6 ? 'rotate-45' : ''">add</span>
          </button>
          <div x-show="activeFaq === 6" x-collapse class="px-8 pb-6 text-[#7F798D] leading-relaxed">
            We're currently in private beta with a free tier. Premium plans will include unlimited calls, advanced scheduling, priority follow-ups, and detailed analytics. Join the waitlist for early access pricing.
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-white border-t border-[#DEE8FF] py-16">
    <div class="max-w-[1600px] mx-auto px-6 md:px-12">
      <div class="grid grid-cols-2 md:grid-cols-5 gap-8 mb-16">
        <!-- Left Column (Logo & address) -->
        <div class="col-span-2 md:col-span-2 space-y-6">
          <div class="font-black tracking-tighter text-[#25224A] flex items-baseline">
            <span class="material-symbols-outlined text-[#3E50F7] mr-2">change_history</span>
            <span class="text-xl">dialer.best</span>
          </div>
          <p class="text-sm text-[#7F798D] max-w-xs leading-relaxed">
            The AI todo assistant that calls you — schedules tasks, follows up, and keeps you accountable. Kill procrastination with human-like voice interactions.
          </p>
          <div class="flex gap-4 text-[#7F798D]">
            <a href="#" class="hover:text-[#3E50F7]"><span
                class="material-symbols-outlined text-[20px]">language</span></a>
            <a href="#" class="hover:text-[#3E50F7]"><span class="material-symbols-outlined text-[20px]">mail</span></a>
          </div>
        </div>

        <!-- Links Cols -->
        <div>
          <h4 class="font-bold text-[#25224A] mb-4 text-sm">Product</h4>
          <ul class="space-y-3 text-sm text-[#7F798D]">
            <li><a href="#how-it-works" class="hover:text-[#3E50F7]">How It Works</a></li>
            <li><a href="#voice" class="hover:text-[#3E50F7]">Call System</a></li>
            <li><a href="#features" class="hover:text-[#3E50F7]">Features</a></li>
          </ul>
        </div>
        <div>
          <h4 class="font-bold text-[#25224A] mb-4 text-sm">Company</h4>
          <ul class="space-y-3 text-sm text-[#7F798D]">
            <li><a href="#" class="hover:text-[#3E50F7]">About</a></li>
            <li><a href="#" class="hover:text-[#3E50F7]">Careers</a></li>
            <li><a href="#faq" class="hover:text-[#3E50F7]">FAQ</a></li>
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
      <div
        class="border-t border-[#DEE8FF] pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-[#7F798D]">
        <p>© {{ date('Y') }} dialer.best. All rights reserved.</p>
        <p>Engineered for Excellence.</p>
      </div>
    </div>
  </footer>

  <!-- Waitlist Modal -->
  <div x-show="waitlistModalOpen" x-cloak
    class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
    @keydown.escape.window="waitlistModalOpen = false">
    <div class="bg-white rounded-[2.5rem] p-8 md:p-12 max-w-lg w-full shadow-2xl relative border border-[#DEE8FF]"
      @click.away="waitlistModalOpen = false">
      <button @click="waitlistModalOpen = false"
        class="absolute top-6 right-6 text-[#7F798D] hover:text-[#5F5770] transition">
        <span class="material-symbols-outlined text-3xl">close</span>
      </button>

      <div x-show="!waitlistSubmitted">
        <div class="mb-8">
          <div class="w-16 h-16 bg-[#3E50F7]/10 rounded-2xl flex items-center justify-center text-[#3E50F7] mb-6">
            <span class="material-symbols-outlined text-3xl">mail</span>
          </div>
          <h3 class="text-3xl font-black text-[#25224A] mb-3">Join the Waitlist</h3>
          <p class="text-[#7F798D]">We are currently in private beta for US phone numbers. Leave your email to get early access.</p>
        </div>

        <form @submit.prevent="
                fetch('/waitlist', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ email: email })
                })
                .then(response => {
                    if (response.ok) {
                        waitlistSubmitted = true;
                    } else {
                        alert('Check your email address or you might already be on the list!');
                    }
                })
            " class="space-y-4">
          <input type="email" x-model="email" required placeholder="Enter your business email"
            class="w-full px-6 py-4 bg-[#F8FAFF] border border-[#DEE8FF] rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#3E50F7]/20 focus:border-[#3E50F7] transition font-medium">
          <button type="submit"
            class="w-full py-4 bg-[#3E50F7] text-white font-bold rounded-2xl shadow-lg shadow-[#3E50F7]/20 hover:bg-[#0000EE] transition-all active:scale-95 flex items-center justify-center gap-2">
            Reserve my spot
            <span class="material-symbols-outlined">send</span>
          </button>
        </form>
      </div>

      <div x-show="waitlistSubmitted" class="text-center py-8">
        <div
          class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center text-green-600 mx-auto mb-8 animate-bounce">
          <span class="material-symbols-outlined text-4xl">check_circle</span>
        </div>
        <h3 class="text-3xl font-black text-[#25224A] mb-4">You're on the list!</h3>
        <p class="text-lg text-[#5F5770] leading-relaxed font-medium">You have been added to waitlist, we will update
          you through email</p>
        <button @click="waitlistModalOpen = false; waitlistSubmitted = false; email = ''"
          class="mt-12 text-[#3E50F7] font-bold hover:underline">Close</button>
      </div>
    </div>
  </div>
</body>

</html>
