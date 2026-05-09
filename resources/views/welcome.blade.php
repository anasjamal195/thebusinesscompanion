<!DOCTYPE html>
<html class="light scroll-smooth" lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>The Business Companion - Engineered for Excellence</title>
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
          <span class="text-xl font-extrabold tracking-tight">The Business Companion</span>
        </div>
        <div class="hidden lg:flex items-center space-x-10 text-[15px] font-semibold text-white/70">
          <a class="hover:text-white transition-colors" href="#evolution">The Big Picture</a>
          <a class="hover:text-white transition-colors" href="#voice">Voice Engine</a>
          <a class="hover:text-white transition-colors" href="#concept">Companions</a>
          <a class="hover:text-white transition-colors" href="#faq">FAQ</a>
        </div>
      </div>
      <div class="flex items-center gap-8">
        <a href="#"
          class="hidden md:block text-[15px] font-semibold text-white/70 hover:text-white transition-colors">Sign in</a>
        <button @click="waitlistModalOpen = true"
          class="px-6 py-2.5 bg-[#3E50F7] hover:bg-[#3E50F7]/90 text-white font-bold rounded-full transition-all text-sm shadow-lg shadow-[#3E50F7]/20">
          Join Waitlist
        </button>
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
                  from { stroke-dashoffset: 400; }
                  to { stroke-dashoffset: 0; }
                }
                @keyframes heroPulseRev {
                  from { stroke-dashoffset: -400; }
                  to { stroke-dashoffset: 0; }
                }
                .hero-path-base { stroke: rgba(255,255,255,0.15); stroke-width: 2.5; fill: none; stroke-dasharray: 4 4; }
                .hero-path-flow { stroke: #3E50F7; stroke-width: 4; fill: none; stroke-linecap: round; stroke-dasharray: 40 360; animation: heroPulse 3s linear infinite; }
                .hero-path-flow-rev { stroke: #3E50F7; stroke-width: 4; fill: none; stroke-linecap: round; stroke-dasharray: 40 360; animation: heroPulseRev 3s linear infinite; }
                .hero-node { fill: white; stroke: #3E50F7; stroke-width: 2; }
                .hero-node-pulse { fill: #3E50F7; opacity: 0.4; }
              </style>
              
              <!-- Line 1: SaaS Right Top Slot -> Buyer Top Middle Slot -->
              <path class="hero-path-base" d="M 480 105 L 730 105 Q 750 105 750 125 L 750 255" />
              <path class="hero-path-flow" d="M 480 105 L 730 105 Q 750 105 750 125 L 750 255" />
              
              <!-- Line 2: SaaS Bottom Middle Slot -> Buyer Left Bottom Slot -->
              <path class="hero-path-base" d="M 250 435 L 250 565 Q 250 585 270 585 L 520 585" />
              <path class="hero-path-flow-rev" d="M 250 435 L 250 565 Q 250 585 270 585 L 520 585" />

              <!-- Slot Nodes -->
              <g>
                <circle class="hero-node-pulse" cx="480" cy="105" r="8"><animate attributeName="r" values="6;10;6" dur="2s" repeatCount="indefinite" /></circle>
                <circle class="hero-node" cx="480" cy="105" r="4" />
              </g>
              <g>
                <circle class="hero-node-pulse" cx="750" cy="255" r="8"><animate attributeName="r" values="6;10;6" dur="2s" repeatCount="indefinite" /></circle>
                <circle class="hero-node" cx="750" cy="255" r="4" />
              </g>
              <g>
                <circle class="hero-node-pulse" cx="250" cy="435" r="8"><animate attributeName="r" values="6;10;6" dur="2s" repeatCount="indefinite" /></circle>
                <circle class="hero-node" cx="250" cy="435" r="4" />
              </g>
              <g>
                <circle class="hero-node-pulse" cx="520" cy="585" r="8"><animate attributeName="r" values="6;10;6" dur="2s" repeatCount="indefinite" /></circle>
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

                <!-- Active Content (SaaS Startup) -->
                <div class="absolute inset-0 flex flex-col transition-opacity duration-300"
                  :class="(activeSlide === 0 && !isScrolling) ? 'opacity-100' : 'opacity-0 pointer-events-none'">

                  <!-- AI Advisor Floating Card -->
                  <div
                    class="absolute -right-16 -top-12 bg-[#1E204A] rounded-2xl p-4 w-[200px] shadow-2xl border border-white/10 z-30 transition-transform hover:scale-105">
                    <div class="flex items-center gap-3">
                      <div class="relative">
                        <img src="https://i.pravatar.cc/100?img=12"
                          class="w-10 h-10 rounded-full border-2 border-[#3E50F7]" alt="Christian S.">
                        <div
                          class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-[#1E204A] rounded-full">
                        </div>
                      </div>
                      <div>
                        <div class="text-[10px] text-white/50 font-bold uppercase tracking-wider">AI Advisor</div>
                        <div class="text-[13px] text-white font-bold">Christian S.</div>
                      </div>
                    </div>
                  </div>

                  <div class="p-8 flex flex-col h-full text-[#1E204A]">
                    <div class="font-extrabold text-2xl mb-8">SaaS Startup</div>

                    <!-- Charts Grid -->
                    <div class="flex-1 grid grid-cols-2 gap-6">
                      <!-- Bar Charts -->
                      <div class="space-y-4">
                        <div class="h-16 flex items-end gap-1.5">
                          <div class="w-full bg-[#3E50F7]/20 rounded-t-sm h-[40%]"></div>
                          <div class="w-full bg-[#3E50F7]/40 rounded-t-sm h-[70%]"></div>
                          <div class="w-full bg-[#3E50F7]/60 rounded-t-sm h-[55%]"></div>
                          <div class="w-full bg-[#3E50F7] rounded-t-sm h-[90%]"></div>
                        </div>
                        <div class="h-16 flex items-end gap-1.5 opacity-60">
                          <div class="w-full bg-[#3E50F7]/20 rounded-t-sm h-[60%]"></div>
                          <div class="w-full bg-[#3E50F7]/40 rounded-t-sm h-[30%]"></div>
                          <div class="w-full bg-[#3E50F7]/60 rounded-t-sm h-[80%]"></div>
                          <div class="w-full bg-[#3E50F7] rounded-t-sm h-[50%]"></div>
                        </div>
                      </div>

                      <!-- Circle Chart -->
                      <div class="flex items-center justify-center">
                        <div class="relative w-24 h-24">
                          <svg class="w-full h-full" viewBox="0 0 36 36">
                            <path class="text-[#3E50F7]/10" stroke-width="4" stroke="currentColor" fill="none"
                              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            <path class="text-[#3E50F7]" stroke-width="4" stroke-dasharray="75, 100"
                              stroke-linecap="round" stroke="currentColor" fill="none"
                              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                          </svg>
                        </div>
                      </div>
                    </div>

                    <!-- Bottom Skeleton -->
                    <div class="mt-auto space-y-3">
                      <div class="h-2 bg-[#3E50F7]/10 rounded-full w-full"></div>
                      <div class="h-2 bg-[#3E50F7]/10 rounded-full w-2/3"></div>
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
                      <img src="https://i.pravatar.cc/150?img=68" class="rounded-full w-full h-full" alt="AI">
                      <div
                        class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full animate-pulse">
                      </div>
                    </div>
                    <div>
                      <div class="text-[10px] text-[#525E7A] uppercase font-bold tracking-wider">Voice Update</div>
                      <div class="font-extrabold text-lg">Business Companion</div>
                    </div>
                  </div>
                  <div
                    class="bg-white/40 p-4 rounded-xl border border-white/40 h-24 flex items-center justify-center gap-2 mb-6">
                    <div class="w-2.5 bg-[#3E50F7] rounded-full h-[40%] animate-[pulse_1s_ease-in-out_infinite]"></div>
                    <div class="w-2.5 bg-[#3E50F7] rounded-full h-[80%] animate-[pulse_1s_ease-in-out_infinite_0.1s]">
                    </div>
                    <div class="w-2.5 bg-[#3E50F7] rounded-full h-[60%] animate-[pulse_1s_ease-in-out_infinite_0.2s]">
                    </div>
                    <div class="w-2.5 bg-[#3E50F7] rounded-full h-[100%] animate-[pulse_1s_ease-in-out_infinite_0.3s]">
                    </div>
                    <div class="w-2.5 bg-[#3E50F7] rounded-full h-[70%] animate-[pulse_1s_ease-in-out_infinite_0.4s]">
                    </div>
                    <div class="w-2.5 bg-[#3E50F7] rounded-full h-[30%] animate-[pulse_1s_ease-in-out_infinite_0.5s]">
                    </div>
                  </div>
                  <div class="space-y-2 mt-auto">
                    <div class="h-2 bg-[#1E204A]/10 rounded-full w-full"></div>
                    <div class="h-2 bg-[#1E204A]/10 rounded-full w-2/3"></div>
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
                  <div class="font-extrabold text-xl mb-6 tracking-tight">Intelligence</div>
                  <div
                    class="bg-white/60 rounded-2xl p-4 mb-4 border border-[#3E50F7]/30 shadow-md relative overflow-hidden cursor-pointer">
                    <div class="absolute left-0 top-0 w-1.5 h-full bg-[#3E50F7]"></div>
                    <div class="flex items-center justify-between pl-3">
                      <div class="flex items-center gap-4">
                        <div
                          class="w-10 h-10 rounded-xl bg-[#3E50F7]/10 flex items-center justify-center text-[#3E50F7]">
                          <span class="material-symbols-outlined text-[20px]">smart_toy</span>
                        </div>
                        <div>
                          <div class="text-sm font-extrabold text-[#1E204A]">GPT-4o</div>
                          <div class="text-[10px] text-[#525E7A] font-bold uppercase tracking-wider">Active</div>
                        </div>
                      </div>
                      <span class="material-symbols-outlined text-[#3E50F7] text-2xl">check_circle</span>
                    </div>
                  </div>
                  <div class="bg-white/30 rounded-2xl p-4 border border-[#1E204A]/10 cursor-pointer">
                    <div class="flex items-center justify-between pl-1">
                      <div class="flex items-center gap-4">
                        <div
                          class="w-10 h-10 rounded-xl bg-[#1E204A]/5 flex items-center justify-center text-[#525E7A]">
                          <span class="material-symbols-outlined text-[20px]">psychology</span>
                        </div>
                        <div>
                          <div class="text-sm font-extrabold text-[#525E7A]">Claude 3.5</div>
                        </div>
                      </div>
                    </div>
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

                <!-- Active Content (Buyer Profile) -->
                <div class="absolute inset-0 flex flex-col transition-opacity duration-300 text-[#1E204A]"
                  :class="(activeSlide === 0 && !isScrolling) ? 'opacity-100' : 'opacity-0 pointer-events-none'">

                  <div class="p-8 flex flex-col h-full">
                    <div class="flex items-center gap-4 mb-8">
                      <img src="https://i.pravatar.cc/100?img=69"
                        class="w-14 h-14 rounded-full border-2 border-white/50 object-cover shadow-sm"
                        alt="Gabriel Smith">
                      <div>
                        <div class="text-[10px] text-[#525E7A] font-bold uppercase tracking-wider">Buyer Profile</div>
                        <div class="text-xl font-extrabold leading-tight">Gabriel Smith</div>
                        <div class="text-[10px] font-bold text-[#22C55E]">Verified funds: $2.3M</div>
                      </div>
                    </div>

                    <!-- Stats Row -->
                    <div class="grid grid-cols-3 gap-2 mb-8 border-y border-[#1E204A]/10 py-4">
                      <div>
                        <div class="text-[9px] text-[#525E7A] font-bold uppercase mb-1">Profile</div>
                        <div class="text-[13px] font-extrabold">SaaS</div>
                      </div>
                      <div>
                        <div class="text-[9px] text-[#525E7A] font-bold uppercase mb-1">Price Range</div>
                        <div class="text-[13px] font-extrabold">$1M - $5M</div>
                      </div>
                      <div>
                        <div class="text-[9px] text-[#525E7A] font-bold uppercase mb-1">Closed</div>
                        <div class="text-[13px] font-extrabold">7</div>
                      </div>
                    </div>

                    <!-- Skeleton bars -->
                    <div class="space-y-3 mb-8">
                      <div class="h-2 bg-[#1E204A]/10 rounded-full w-full"></div>
                      <div class="h-2 bg-[#1E204A]/10 rounded-full w-full"></div>
                      <div class="h-2 bg-[#1E204A]/10 rounded-full w-4/5"></div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4 mt-auto">
                      <button
                        class="flex-1 py-3 rounded-xl border border-[#1E204A]/20 text-[11px] font-bold hover:bg-[#1E204A]/5 transition-colors uppercase tracking-wider">Reject
                        request</button>
                      <button
                        class="flex-1 py-3 rounded-xl bg-[#3E50F7] text-white text-[11px] font-bold shadow-lg shadow-[#3E50F7]/25 hover:bg-[#3E50F7]/90 transition-colors uppercase tracking-wider">Approve
                        request</button>
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
                  <div class="font-extrabold text-xl tracking-tight mb-6 flex items-center gap-3">
                    <span class="material-symbols-outlined text-[#3E50F7] text-2xl">mark_email_read</span> Final Report
                  </div>
                  <div class="bg-white/40 p-5 rounded-2xl border border-white/40 mb-6 space-y-4">
                    <div class="h-3 bg-[#1E204A]/20 rounded-full w-1/3"></div>
                    <div class="h-2 bg-[#1E204A]/10 rounded-full w-full"></div>
                    <div class="h-2 bg-[#1E204A]/10 rounded-full w-full"></div>
                    <div class="h-2 bg-[#1E204A]/10 rounded-full w-4/5"></div>
                  </div>
                  <div class="flex gap-2 mt-auto">
                    <div
                      class="flex-1 bg-[#3E50F7] text-white text-center py-3.5 rounded-xl text-xs font-bold cursor-pointer hover:bg-[#3E50F7]/90 shadow-lg shadow-[#3E50F7]/20 transition-all uppercase tracking-wider">
                      Forward to team</div>
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
                  <div class="font-extrabold text-xl mb-6 tracking-tight flex items-center gap-3">
                    <span class="material-symbols-outlined text-[#22C55E]">desktop_windows</span> Private Business OS
                  </div>
                  <div class="space-y-4 bg-white/40 p-5 rounded-2xl border border-white/40">
                    <div class="flex items-center gap-3 text-sm font-bold">
                      <div class="w-6 h-6 rounded-full bg-[#22C55E]/10 flex items-center justify-center"><span
                          class="material-symbols-outlined text-[14px] text-[#22C55E]">check</span></div>Isolated VM Environment
                    </div>
                    <div class="flex items-center gap-3 text-sm font-bold">
                      <div class="w-6 h-6 rounded-full bg-[#22C55E]/10 flex items-center justify-center"><span
                          class="material-symbols-outlined text-[14px] text-[#22C55E]">check</span></div>Computer Navigation
                    </div>
                    <div class="flex items-center gap-3 text-sm font-bold">
                      <div class="w-6 h-6 rounded-full bg-[#22C55E]/10 flex items-center justify-center"><span
                          class="material-symbols-outlined text-[14px] text-[#22C55E]">check</span></div>Persistent Memory
                    </div>
                  </div>
                  <div
                    class="bg-[#22C55E]/10 text-[#22C55E] text-xs font-bold text-center py-3.5 rounded-xl mt-auto border border-[#22C55E]/20 uppercase tracking-widest">
                    Stride Core Active</div>
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

          <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white leading-[1] tracking-tight">
            The Private<br>
            Business OS<br>
            <span class="text-[#AFBBE0]">powered by<br>Stride AI</span>
          </h1>
        </div>

        <div class="space-y-6">
          <p class="text-white/90 text-xl font-semibold max-w-xl leading-relaxed">
            A digital identity that lives in its own computer, capable of planning, analysis, and managing your business 24/7.
          </p>
        </div>

        <!-- Buttons -->
        <div class="flex flex-col sm:flex-row items-center gap-4 pt-4">
          <button @click="waitlistModalOpen = true"
            class="px-10 py-4 bg-[#3E50F7] hover:bg-[#3E50F7]/90 text-white font-bold rounded-xl transition-all text-base flex items-center justify-center gap-2 w-full sm:w-auto shadow-lg shadow-[#3E50F7]/25">
            Join Waitlist <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
          </button>
          <button
            class="px-10 py-4 bg-white/5 border border-white/10 hover:bg-white/10 text-white font-bold rounded-xl transition-all text-base flex items-center justify-center gap-3 w-full sm:w-auto">
            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center">
              <span class="material-symbols-outlined text-[#1E204A] text-[20px] ml-0.5">play_arrow</span>
            </div>
            Our story
          </button>
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
          <div class="text-2xl font-bold text-white mb-1">1M+</div>
          <div class="text-xs text-[#AFBBE0] uppercase tracking-wider font-semibold">Tasks Executed</div>
        </div>
        <div class="px-4">
          <div class="text-2xl font-bold text-white mb-1">150+</div>
          <div class="text-xs text-[#AFBBE0] uppercase tracking-wider font-semibold">Industries Supported</div>
        </div>
        <div class="px-4">
          <div class="text-2xl font-bold text-white mb-1">24/7</div>
          <div class="text-xs text-[#AFBBE0] uppercase tracking-wider font-semibold">Availability</div>
        </div>
        <div class="px-4 hidden md:block">
          <div class="text-2xl font-bold text-white mb-1">100%</div>
          <div class="text-xs text-[#AFBBE0] uppercase tracking-wider font-semibold">Autonomous</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Steps Section -->
  <section class="bg-[#F8FAFF] py-24 relative overflow-hidden">
    <div class="max-w-[1200px] mx-auto px-6">
      <div class="text-center mb-16">
        <h2 class="text-3xl md:text-4xl font-bold text-[#25224A] max-w-2xl mx-auto leading-tight">Your intelligent
          workflow, simplified</h2>
      </div>

      <div class="relative w-full max-w-[1000px] mx-auto z-10">
        <!-- SVG Connecting Lines Desktop -->
        <svg class="hidden md:block absolute inset-0 w-full h-[380px] pointer-events-none -z-10" viewBox="0 0 1000 380"
          preserveAspectRatio="none">
          <style>
            @keyframes flowLine {
              to {
                stroke-dashoffset: -440;
              }
            }

            .path-base {
              stroke: #CBD5E1;
              stroke-width: 2;
              stroke-dasharray: 4 4;
              fill: none;
            }

            .path-flow {
              stroke: #3E50F7;
              stroke-width: 3;
              fill: none;
              stroke-linecap: round;
              stroke-dasharray: 40 400;
              animation: flowLine 3s linear infinite;
            }
          </style>
          <!-- Left to Center Line Base -->
          <path class="path-base" vector-effect="non-scaling-stroke"
            d="M 300 150 L 315 150 Q 325 150 325 160 L 325 320 Q 325 330 335 330 L 490 330 Q 500 330 500 320 L 500 300" />
          <!-- Left to Center Animated Line -->
          <path class="path-flow" vector-effect="non-scaling-stroke"
            d="M 300 150 L 315 150 Q 325 150 325 160 L 325 320 Q 325 330 335 330 L 490 330 Q 500 330 500 320 L 500 300" />

          <!-- Center to Right Line Base -->
          <path class="path-base" vector-effect="non-scaling-stroke"
            d="M 500 300 L 500 320 Q 500 330 510 330 L 665 330 Q 675 330 675 320 L 675 160 Q 675 150 685 150 L 700 150" />
          <!-- Center to Right Animated Line -->
          <path class="path-flow" vector-effect="non-scaling-stroke" style="animation-delay: 1.5s;"
            d="M 500 300 L 500 320 Q 500 330 510 330 L 665 330 Q 675 330 675 320 L 675 160 Q 675 150 685 150 L 700 150" />
        </svg>

        <div class="flex flex-col md:flex-row justify-between items-start gap-8 md:gap-0 relative">
          <!-- Step 1 -->
          <div class="w-full md:w-[30%] h-auto md:h-[300px] relative">
            <div
              class="h-full flex flex-col items-center p-6 bg-white rounded-2xl shadow-sm border border-[#DEE8FF] hover:-translate-y-1 transition-transform bg-opacity-95 backdrop-blur-sm z-10 relative">
              <div class="w-full flex-1 flex flex-col gap-3 justify-center mb-4">
                <div
                  class="self-end bg-[#3E50F7] text-white p-3 rounded-2xl rounded-tr-sm max-w-[95%] text-[13px] shadow-md font-medium">
                  "Audit our recent SaaS expenses and flag anomalies."
                </div>
                <div
                  class="self-start bg-[#F8FAFF] border border-[#DEE8FF] text-[#464154] p-3 rounded-2xl rounded-tl-sm max-w-[95%] text-[13px] shadow-sm flex items-center gap-2 font-medium">
                  <div class="w-1.5 h-1.5 bg-[#3E50F7] rounded-full animate-ping"></div>
                  Analyzing 1,200 transactions...
                </div>
              </div>
              <div class="mt-auto text-center w-full">
                <h3 class="font-bold text-[#25224A] text-lg mb-1">1. Delegate Tasks</h3>
                <p class="text-[13px] text-[#7F798D] leading-relaxed px-1">Assign operational tasks securely through
                  text or voice.</p>
              </div>
            </div>
            <!-- Node -->
            <div
              class="hidden md:block absolute top-[150px] -right-2.5 w-5 h-5 bg-white border-[3px] border-[#CBD5E1] rounded-full z-20 -translate-y-1/2">
            </div>
          </div>

          <!-- Step 2 -->
          <div class="w-full md:w-[30%] h-auto md:h-[300px] relative mt-10 md:mt-0">
            <div
              class="h-full flex flex-col items-center p-6 bg-white rounded-2xl shadow-xl shadow-[#3E50F7]/10 border border-[#3E50F7]/30 hover:-translate-y-1 transition-transform bg-opacity-95 backdrop-blur-sm z-10 relative">
              <div class="w-full flex-1 flex flex-col gap-2.5 justify-center pt-2 mb-4">
                <div class="flex items-center gap-3 bg-[#F8FAFF] p-3 rounded-xl border border-[#DEE8FF]">
                  <span class="material-symbols-outlined text-[#3E50F7] text-[20px]">computer</span>
                  <span class="text-[13px] font-bold text-[#25224A]">Isolated VM Computer</span>
                </div>
                <div class="flex items-center gap-3 bg-[#F8FAFF] p-3 rounded-xl border border-[#DEE8FF]">
                  <span class="material-symbols-outlined text-green-600 text-[20px]">history</span>
                  <span class="text-[13px] font-bold text-[#25224A]">Digital Identity & Memory</span>
                </div>
                <div class="flex items-center gap-3 bg-[#F8FAFF] p-3 rounded-xl border border-[#DEE8FF]">
                  <span class="material-symbols-outlined text-[#F59E0B] text-[20px]">auto_mode</span>
                  <span class="text-[13px] font-bold text-[#25224A]">Autonomous Planning</span>
                </div>
              </div>
              <div class="mt-auto text-center w-full">
                <h3 class="font-bold text-[#25224A] text-lg mb-1">2. Stride Engine</h3>
                <p class="text-[13px] text-[#7F798D] leading-relaxed px-1">The AI uses its own digital identity to navigate apps and execute complex tasks.</p>
              </div>
            </div>
            <!-- Node -->
            <div
              class="hidden md:block absolute top-[300px] left-1/2 w-5 h-5 bg-white border-[3px] border-[#CBD5E1] rounded-full z-20 -translate-x-1/2 -translate-y-1/2 flex items-center justify-center">
              <div class="w-1.5 h-1.5 bg-[#3E50F7] rounded-full animate-pulse"></div>
            </div>
          </div>

          <!-- Step 3 -->
          <div class="w-full md:w-[30%] h-auto md:h-[300px] relative mt-10 md:mt-0">
            <div
              class="h-full flex flex-col items-center p-6 bg-white rounded-2xl shadow-sm border border-[#DEE8FF] hover:-translate-y-1 transition-transform bg-opacity-95 backdrop-blur-sm z-10 relative">
              <div class="w-full flex-1 flex flex-col gap-4 justify-center mb-4">
                <div class="bg-white border border-[#DEE8FF] rounded-xl p-4 shadow-sm relative overflow-hidden w-full">
                  <div class="absolute top-0 left-0 w-1 h-full bg-green-500"></div>
                  <div class="flex justify-between items-center mb-3 pl-2">
                    <span class="text-[11px] font-bold text-[#7F798D] uppercase tracking-wider">Final Report</span>
                    <span
                      class="text-[10px] text-green-600 font-bold bg-green-50 px-2 py-0.5 rounded border border-green-100">Completed</span>
                  </div>
                  <div class="pl-2 space-y-2">
                    <div class="h-2 bg-[#EEF2FE] rounded w-full"></div>
                    <div class="h-2 bg-[#EEF2FE] rounded w-4/5"></div>
                    <div class="h-2 bg-[#EEF2FE] rounded w-5/6"></div>
                  </div>
                </div>
                <div class="flex justify-center gap-3">
                  <div
                    class="text-[11px] bg-[#EEF2FE] text-[#3E50F7] px-3 py-1.5 rounded font-bold flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[14px]">mail</span> Email
                  </div>
                  <div
                    class="text-[11px] bg-[#EEF2FE] text-[#3E50F7] px-3 py-1.5 rounded font-bold flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[14px]">call</span> Call
                  </div>
                </div>
              </div>
              <div class="mt-auto text-center w-full">
                <h3 class="font-bold text-[#25224A] text-lg mb-1">3. Receive Updates</h3>
                <p class="text-[13px] text-[#7F798D] leading-relaxed px-1">Review executive summaries or discuss
                  results.</p>
              </div>
            </div>
            <!-- Node -->
            <div
              class="hidden md:block absolute top-[150px] -left-2.5 w-5 h-5 bg-white border-[3px] border-[#CBD5E1] rounded-full z-20 -translate-y-1/2">
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

  <!-- Why Business Companion app is Different Section -->
  <section class="bg-white py-24 relative overflow-hidden">
    <div class="max-w-[1400px] mx-auto px-6 md:px-12">
      <div class="text-center mb-20">
        <h2 class="text-3xl md:text-5xl font-black text-[#25224A] tracking-tight mb-6">Why Business Companion is <span
            class="text-[#3E50F7]">Different</span></h2>
        <p class="text-[#7F798D] text-lg max-w-2xl mx-auto">We've eliminated the friction between your vision and AI
          execution. No complex prompts, just natural collaboration.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 relative">
        <!-- Connecting Line background -->
        <div
          class="hidden lg:block absolute top-1/2 left-0 w-full h-px bg-gradient-to-r from-transparent via-[#DEE8FF] to-transparent -translate-y-1/2 -z-10">
        </div>

        <!-- Step 1 -->
        <div
          class="group relative bg-[#F8FAFF] p-8 rounded-[2.5rem] border border-[#DEE8FF] hover:border-[#3E50F7]/30 transition-all hover:-translate-y-2 shadow-sm">
          <div
            class="w-16 h-16 rounded-2xl bg-white shadow-md flex items-center justify-center mb-6 text-[#3E50F7] group-hover:scale-110 transition-transform">
            <span class="material-symbols-outlined text-[32px]">auto_fix_off</span>
          </div>
          <h3 class="text-xl font-bold text-[#25224A] mb-3 leading-tight">Zero Prompt Engineering</h3>
          <p class="text-[15px] text-[#7F798D] leading-relaxed">Stop wasting hours learning complex prompt structures.
            Our system understands your intent natively.</p>
        </div>

        <!-- Step 2 -->
        <div
          class="group relative bg-[#F8FAFF] p-8 rounded-[2.5rem] border border-[#DEE8FF] hover:border-[#3E50F7]/30 transition-all hover:-translate-y-2 shadow-sm">
          <div
            class="w-16 h-16 rounded-2xl bg-white shadow-md flex items-center justify-center mb-6 text-[#3E50F7] group-hover:scale-110 transition-transform">
            <span class="material-symbols-outlined text-[32px]">call</span>
          </div>
          <h3 class="text-xl font-bold text-[#25224A] mb-3 leading-tight">Discuss on Call</h3>
          <p class="text-[15px] text-[#7F798D] leading-relaxed">Simply explain your business goals to your hired
            companion via a natural voice discussion.</p>
        </div>

        <!-- Step 3 -->
        <div
          class="group relative bg-[#F8FAFF] p-8 rounded-[2.5rem] border border-[#DEE8FF] hover:border-[#3E50F7]/30 transition-all hover:-translate-y-2 shadow-sm">
          <div
            class="w-16 h-16 rounded-2xl bg-white shadow-md flex items-center justify-center mb-6 text-[#3E50F7] group-hover:scale-110 transition-transform">
            <span class="material-symbols-outlined text-[32px]">smart_toy</span>
          </div>
          <h3 class="text-xl font-bold text-[#25224A] mb-3 leading-tight">Hurdle Management</h3>
          <p class="text-[15px] text-[#7F798D] leading-relaxed">Let your companion handle the technical hurdles and
            prompt iterations while you focus on strategy.</p>
        </div>

        <!-- Step 4 -->
        <div
          class="group relative bg-[#F8FAFF] p-8 rounded-[2.5rem] border border-[#DEE8FF] hover:border-[#3E50F7]/30 transition-all hover:-translate-y-2 shadow-sm">
          <div
            class="w-16 h-16 rounded-2xl bg-white shadow-md flex items-center justify-center mb-6 text-[#3E50F7] group-hover:scale-110 transition-transform">
            <span class="material-symbols-outlined text-[32px]">task_alt</span>
          </div>
          <h3 class="text-xl font-bold text-[#25224A] mb-3 leading-tight">Execution Delivered</h3>
          <p class="text-[15px] text-[#7F798D] leading-relaxed">Receive your completed tasks and results without ever
            touching a command line or prompt window.</p>
        </div>
      </div>

      <!-- Disclaimer Highlighted -->
      <div class="mt-20 p-8 rounded-3xl bg-gradient-to-br from-[#25224A] to-[#3E50F7] relative overflow-hidden group">
        <div
          class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10">
        </div>
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
          <div class="w-16 h-16 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-white text-[32px]">info</span>
          </div>
          <div class="flex-1 text-center md:text-left">
            <h4 class="text-white font-bold text-xl mb-2 uppercase tracking-wider opacity-60 text-[12px]">Important
              Disclaimer</h4>
            <p class="text-white/90 text-lg leading-relaxed">
              Our tool isn't a substitute for any <span
                class="text-white font-bold underline decoration-[#3E50F7] decoration-4 underline-offset-4">Human
                Resources</span>. It is built to enhance entrepreneur productivity and contribute to the success of
              future millionaires—because more success means Earth becomes a better place to live.
            </p>
          </div>
          <button @click="waitlistModalOpen = true"
            class="px-8 py-4 bg-white text-[#25224A] font-black rounded-2xl hover:bg-opacity-90 transition-all shadow-xl whitespace-nowrap">
            Join the Mission
          </button>
        </div>
      </div>
    </div>
  </section>

  <!-- The Big Picture / Evolution Section -->
  <section id="evolution" class="bg-[#25224A] py-24 relative overflow-hidden">
    <!-- Background Glow -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full pointer-events-none">
      <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-[#3E50F7]/20 blur-[120px] rounded-full"></div>
      <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-[#2bd9ff]/10 blur-[120px] rounded-full"></div>
    </div>

    <div class="max-w-[1400px] mx-auto px-6 md:px-12 relative z-10">
      <div class="text-center mb-20">
        <h2 class="text-3xl md:text-5xl font-black text-white tracking-tight mb-6">The <span class="text-[#3E50F7]">Evolution</span> of Stride</h2>
        <p class="text-white/60 text-lg max-w-2xl mx-auto">Early adopters aren't just buying a tool—they're hiring a digital identity that grows with their business.</p>
      </div>

      <div class="relative max-w-[1100px] mx-auto">
        <!-- Connecting Line -->
        <svg class="hidden lg:block absolute top-[100px] left-0 w-full h-[100px] pointer-events-none" viewBox="0 0 1100 100" fill="none">
          <path d="M 150 50 L 950 50" stroke="rgba(255,255,255,0.1)" stroke-width="2" stroke-dasharray="8 8" />
          <path d="M 150 50 L 950 50" stroke="#3E50F7" stroke-width="3" stroke-dasharray="50 350" stroke-linecap="round">
            <animate attributeName="stroke-dashoffset" from="400" to="0" dur="3s" repeatCount="indefinite" />
          </path>
        </svg>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative">
          <!-- Stage 1 -->
          <div class="flex flex-col items-center text-center group">
            <div class="w-24 h-24 rounded-3xl bg-white/5 border border-white/10 flex items-center justify-center mb-8 relative group-hover:scale-110 transition-transform duration-500 shadow-2xl">
              <span class="material-symbols-outlined text-4xl text-[#3E50F7]">person_add</span>
              <div class="absolute -top-3 -right-3 px-3 py-1 bg-[#3E50F7] text-white text-[10px] font-bold rounded-full uppercase tracking-tighter">Phase 01</div>
            </div>
            <h3 class="text-2xl font-bold text-white mb-4">Adopt Your Identity</h3>
            <p class="text-white/50 text-[15px] leading-relaxed">Choose your dedicated Business Companion today with a one-time adoption fee. They start working on your server-side tasks immediately.</p>
          </div>

          <!-- Stage 2 -->
          <div class="flex flex-col items-center text-center group">
            <div class="w-24 h-24 rounded-3xl bg-white/5 border border-white/10 flex items-center justify-center mb-8 relative group-hover:scale-110 transition-transform duration-500 shadow-2xl">
              <span class="material-symbols-outlined text-4xl text-[#22C55E]">model_training</span>
              <div class="absolute -top-3 -right-3 px-3 py-1 bg-[#22C55E] text-white text-[10px] font-bold rounded-full uppercase tracking-tighter">Phase 02</div>
            </div>
            <h3 class="text-2xl font-bold text-white mb-4">Train on Reality</h3>
            <p class="text-white/50 text-[15px] leading-relaxed">As your companion handles calls and emails, they build a deep context of your business logic, preferences, and strategic goals.</p>
          </div>

          <!-- Stage 3 -->
          <div class="flex flex-col items-center text-center group">
            <div class="w-24 h-24 rounded-3xl bg-[#3E50F7] border border-[#3E50F7] flex items-center justify-center mb-8 relative group-hover:scale-110 transition-transform duration-500 shadow-[0_0_40px_rgba(62,80,247,0.4)]">
              <span class="material-symbols-outlined text-4xl text-white">rocket_launch</span>
              <div class="absolute -top-3 -right-3 px-3 py-1 bg-white text-[#3E50F7] text-[10px] font-bold rounded-full uppercase tracking-tighter">The Flagship</div>
            </div>
            <h3 class="text-2xl font-bold text-white mb-4">Ascend to Stride</h3>
            <p class="text-white/50 text-[15px] leading-relaxed">Early adopters get exclusive Beta access to the Stride Desktop OS. Your already-trained companion carries forward into your full Business OS.</p>
          </div>
        </div>
      </div>

      <!-- Beta Badge Callout -->
      <div class="mt-24 max-w-4xl mx-auto p-1 bg-gradient-to-r from-transparent via-white/10 to-transparent rounded-full">
        <div class="bg-[#1E204A] rounded-full py-4 px-8 flex flex-col md:flex-row items-center justify-between gap-4">
          <div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center">
              <span class="material-symbols-outlined text-[#AFBBE0]">verified</span>
            </div>
            <span class="text-white/80 font-medium italic">"Current companions are Stride-ready and will carry over all training data."</span>
          </div>
          <div class="text-[11px] font-bold text-[#3E50F7] uppercase tracking-widest bg-[#3E50F7]/10 px-4 py-2 rounded-full border border-[#3E50F7]/20">
            Exclusive Beta Access Included
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Feature 1 (Choose Your Dedicated Companion) -->
  <section id="concept" class="bg-white py-24 relative overflow-hidden">
    <style>
      @keyframes float-card {

        0%,
        100% {
          transform: translateY(0px);
        }

        50% {
          transform: translateY(-15px);
        }
      }

      .animate-float-1 {
        animation: float-card 6s ease-in-out infinite;
      }

      .animate-float-2 {
        animation: float-card 7s ease-in-out infinite 1.5s;
      }
    </style>
    <div class="max-w-[1600px] mx-auto px-6 md:px-12 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
      <div class="space-y-8">
        <div>
          <h2 class="text-3xl md:text-4xl lg:text-5xl font-black text-[#25224A] tracking-tight mb-4">Choose
            Your<br><span class="text-[#3E50F7]">Dedicated Companion</span></h2>
        </div>

        <div class="space-y-6">
          <!-- Bullet 1 -->
          <div
            class="flex items-center gap-6 bg-[#F8FAFF] p-5 rounded-3xl border border-[#DEE8FF] hover:border-[#3E50F7]/30 transition-colors shadow-sm">
            <div
              class="w-16 h-16 rounded-full bg-white text-[#3E50F7] flex items-center justify-center shrink-0 shadow-[0_4px_20px_rgb(62,80,247,0.15)] border border-[#EEF2FE]">
              <span class="material-symbols-outlined text-[32px]">verified_user</span>
            </div>
            <div>
              <h4 class="text-xl font-bold text-[#25224A] mb-1">Unwavering Trust & Focus</h4>
              <p class="text-[15px] text-[#7F798D] leading-relaxed">Overcome execution anxiety with a reliable partner
                who never sleeps.</p>
            </div>
          </div>

          <!-- Bullet 2 -->
          <div
            class="flex items-center gap-6 bg-[#F8FAFF] p-5 rounded-3xl border border-[#DEE8FF] hover:border-[#3E50F7]/30 transition-colors shadow-sm">
            <div
              class="w-16 h-16 rounded-full bg-white text-[#3E50F7] flex items-center justify-center shrink-0 shadow-[0_4px_20px_rgb(62,80,247,0.15)] border border-[#EEF2FE]">
              <span class="material-symbols-outlined text-[32px]">psychology</span>
            </div>
            <div>
              <h4 class="text-xl font-bold text-[#25224A] mb-1">Industry-Leading Intelligence</h4>
              <p class="text-[15px] text-[#7F798D] leading-relaxed">Powered by top AI models best suited for your
                specific industry tasks.</p>
            </div>
          </div>

          <!-- Bullet 3 -->
          <div
            class="flex items-center gap-6 bg-[#F8FAFF] p-5 rounded-3xl border border-[#DEE8FF] hover:border-[#3E50F7]/30 transition-colors shadow-sm">
            <div
              class="w-16 h-16 rounded-full bg-white text-[#3E50F7] flex items-center justify-center shrink-0 shadow-[0_4px_20px_rgb(62,80,247,0.15)] border border-[#EEF2FE]">
              <span class="material-symbols-outlined text-[32px]">tune</span>
            </div>
            <div>
              <h4 class="text-xl font-bold text-[#25224A] mb-1">Complete Manual Control</h4>
              <p class="text-[15px] text-[#7F798D] leading-relaxed">Manage everything manually through our intuitive
                dashboard with full oversight.</p>
            </div>
          </div>
        </div>

        <div class="pt-2">
          <button @click="waitlistModalOpen = true"
            class="px-8 py-4 bg-[#3E50F7] hover:bg-[#0000EE] text-white font-bold rounded-2xl shadow-xl shadow-[#3E50F7]/20 transition-all active:scale-95 text-[15px] flex items-center gap-2 w-fit">
            Find your companion <span class="material-symbols-outlined text-[20px]">person_search</span>
          </button>
        </div>
      </div>

      <!-- Right Side: 4 Companion Cards Grid -->
      <div class="relative w-full h-[650px] flex items-center justify-center lg:justify-end pr-0 lg:pr-10">
        <!-- Central decoration behind cards -->
        <div class="absolute inset-0 flex items-center justify-center -z-10 pointer-events-none lg:translate-x-12">
          <div class="w-[450px] h-[450px] bg-gradient-to-tr from-[#3E50F7]/10 to-[#2bd9ff]/10 rounded-full blur-3xl">
          </div>
        </div>

        <div class="relative w-full max-w-[480px] grid grid-cols-2 gap-4 pb-8">

          <!-- Column 1 -->
          <div class="flex flex-col gap-4 animate-float-1">
            <!-- Card 1 -->
            <div
              class="relative h-[270px] w-full rounded-[2.5rem] overflow-hidden group shadow-lg border-[3px] border-white">
              <img src="https://i.pravatar.cc/300?img=11" alt="James"
                class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
              <div class="absolute inset-0 bg-gradient-to-t from-[#25224A] via-[#25224A]/40 to-transparent opacity-90">
              </div>
              <div
                class="absolute top-4 right-4 w-3 h-3 bg-green-500 rounded-full shadow-[0_0_10px_rgba(34,197,94,1)] animate-pulse">
              </div>

              <div class="absolute bottom-0 left-0 w-full p-5 text-white">
                <h3 class="text-xl font-black mb-0.5">James</h3>
                <p class="text-[9px] font-bold text-[#2bd9ff] uppercase tracking-widest mb-2">Financial Analyst</p>
                <div class="flex items-end justify-between border-t border-white/20 pt-3 mt-2">
                  <span class="text-[11px] text-white/80 line-clamp-1 flex-1 pr-2">Forecasting, Audits</span>
                  <div class="flex items-baseline gap-0.5 whitespace-nowrap">
                    <span class="text-base font-black">$49</span><span class="text-[10px] text-white/60">/usage</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Card 2 -->
            <div
              class="relative h-[270px] w-full rounded-[2.5rem] overflow-hidden group shadow-lg border-[3px] border-white">
              <img src="https://i.pravatar.cc/300?img=47" alt="Sarah"
                class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
              <div class="absolute inset-0 bg-gradient-to-t from-[#25224A] via-[#25224A]/40 to-transparent opacity-90">
              </div>

              <div class="absolute bottom-0 left-0 w-full p-5 text-white">
                <h3 class="text-xl font-black mb-0.5">Sarah</h3>
                <p class="text-[9px] font-bold text-[#2bd9ff] uppercase tracking-widest mb-2">Legal Advisor</p>
                <div class="flex items-end justify-between border-t border-white/20 pt-3 mt-2">
                  <span class="text-[11px] text-white/80 line-clamp-1 flex-1 pr-2">Contracts, Risk</span>
                  <div class="flex items-baseline gap-0.5 whitespace-nowrap">
                    <span class="text-base font-black">$79</span><span class="text-[10px] text-white/60">/usage</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Column 2 (Offset) -->
          <div class="flex flex-col gap-4 translate-y-12 animate-float-2">
            <!-- Card 3 -->
            <div
              class="relative h-[270px] w-full rounded-[2.5rem] overflow-hidden group shadow-lg border-[3px] border-white">
              <img src="https://i.pravatar.cc/300?img=44" alt="Elena"
                class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
              <div class="absolute inset-0 bg-gradient-to-t from-[#25224A] via-[#25224A]/40 to-transparent opacity-90">
              </div>

              <div class="absolute bottom-0 left-0 w-full p-5 text-white">
                <h3 class="text-xl font-black mb-0.5">Elena</h3>
                <p class="text-[9px] font-bold text-[#2bd9ff] uppercase tracking-widest mb-2">Growth Marketer</p>
                <div class="flex items-end justify-between border-t border-white/20 pt-3 mt-2">
                  <span class="text-[11px] text-white/80 line-clamp-1 flex-1 pr-2">SEO, Campaigns</span>
                  <div class="flex items-baseline gap-0.5 whitespace-nowrap">
                    <span class="text-base font-black">$59</span><span class="text-[10px] text-white/60">/usage</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Card 4 -->
            <div
              class="relative h-[270px] w-full rounded-[2.5rem] overflow-hidden group shadow-lg border-[3px] border-white">
              <img src="https://i.pravatar.cc/300?img=68" alt="David"
                class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
              <div class="absolute inset-0 bg-gradient-to-t from-[#25224A] via-[#25224A]/40 to-transparent opacity-90">
              </div>

              <div class="absolute bottom-0 left-0 w-full p-5 text-white">
                <h3 class="text-xl font-black mb-0.5">David</h3>
                <p class="text-[9px] font-bold text-[#2bd9ff] uppercase tracking-widest mb-2">Lead Engineer</p>
                <div class="flex items-end justify-between border-t border-white/20 pt-3 mt-2">
                  <span class="text-[11px] text-white/80 line-clamp-1 flex-1 pr-2">Code, Servers</span>
                  <div class="flex items-baseline gap-0.5 whitespace-nowrap">
                    <span class="text-base font-black">$149</span><span class="text-[10px] text-white/60">/usage</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

  <!-- Feature 2 (Sell quickly -> Voice calls) -->
  <section id="voice" class="bg-[#EEF2FE] py-24 border-y border-[#DEE8FF] relative overflow-hidden">
    <div class="max-w-[1400px] mx-auto px-6">
      <div class="text-center mb-16">
        <div
          class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-[#DEE8FF] text-[#3E50F7] text-xs font-bold uppercase tracking-wider mb-4 shadow-sm">
          <span class="material-symbols-outlined text-[18px]">record_voice_over</span> Voice Intelligence
        </div>
        <h2 class="text-3xl md:text-4xl lg:text-5xl font-black text-[#25224A] max-w-2xl mx-auto leading-tight">Our
          Flagship <span class="text-[#3E50F7]">Calling System</span></h2>
        <p class="text-[17px] text-[#5F5770] max-w-xl mx-auto mt-4 leading-relaxed">Experience seamless collaboration.
          No dashboard required—just talk naturally and let the AI execute tasks on your behalf.</p>
      </div>

      <div class="relative w-full mx-auto z-10">
        <!-- SVG Connecting Lines -->
        <svg class="hidden md:block absolute inset-0 w-full h-[380px] pointer-events-none -z-10" viewBox="0 0 1400 380"
          preserveAspectRatio="none">
          <style>
            @keyframes flowLine2 {
              to {
                stroke-dashoffset: -440;
              }
            }

            .path-base2 {
              stroke: #CBD5E1;
              stroke-width: 2;
              stroke-dasharray: 4 4;
              fill: none;
            }

            .path-flow2 {
              stroke: #3E50F7;
              stroke-width: 3;
              fill: none;
              stroke-linecap: round;
              stroke-dasharray: 40 400;
              animation: flowLine2 3s linear infinite;
            }
          </style>
          <!-- Step 1 to 2 (Down) -->
          <path class="path-base2" d="M 280 120 L 317 120 Q 327 120 327 130 L 327 250 Q 327 260 337 260 L 374 260" />
          <path class="path-flow2" d="M 280 120 L 317 120 Q 327 120 327 130 L 327 250 Q 327 260 337 260 L 374 260" />

          <!-- Step 2 to 3 (Up) -->
          <path class="path-base2" d="M 653 260 L 690 260 Q 700 260 700 250 L 700 130 Q 700 120 710 120 L 747 120" />
          <path class="path-flow2" style="animation-delay: 1s;"
            d="M 653 260 L 690 260 Q 700 260 700 250 L 700 130 Q 700 120 710 120 L 747 120" />

          <!-- Step 3 to 4 (Down) -->
          <path class="path-base2" d="M 1027 120 L 1064 120 Q 1074 120 1074 130 L 1074 250 Q 1074 260 1084 260 L 1121 260" />
          <path class="path-flow2" style="animation-delay: 2s;"
            d="M 1027 120 L 1064 120 Q 1074 120 1074 130 L 1074 250 Q 1074 260 1084 260 L 1121 260" />
        </svg>

        <div class="flex flex-col md:flex-row justify-between items-start gap-8 md:gap-4 relative">
          <!-- Step 1 -->
          <div class="w-full md:w-[20%] h-auto relative">
            <div
              class="h-full flex flex-col items-center p-7 bg-white rounded-[2rem] shadow-sm border border-[#DEE8FF] hover:-translate-y-1 transition-transform relative z-10">
              <div class="w-16 h-16 bg-[#FFF5F5] text-red-500 rounded-full flex items-center justify-center mb-5">
                <span class="material-symbols-outlined text-[32px]">pending_actions</span>
              </div>
              <h3 class="font-bold text-[#25224A] text-center text-lg mb-2">1. Procrastination</h3>
              <p class="text-[13px] text-[#7F798D] text-center leading-relaxed">You're putting off a complex or tedious
                task that needs to be done.</p>
            </div>
            <div
              class="hidden md:block absolute top-[120px] -right-2.5 w-5 h-5 bg-[#EEF2FE] border-[4px] border-[#CBD5E1] rounded-full z-20 -translate-y-1/2">
            </div>
          </div>

          <!-- Step 2 -->
          <div class="w-full md:w-[20%] h-auto relative md:mt-[140px]">
            <div
              class="hidden md:block absolute top-[120px] -left-2.5 w-5 h-5 bg-[#EEF2FE] border-[4px] border-[#CBD5E1] rounded-full z-20 -translate-y-1/2">
            </div>
            <div
              class="h-full flex flex-col items-center p-7 bg-[#25224A] text-white rounded-[2rem] shadow-xl shadow-[#3E50F7]/20 border border-[#3E50F7]/30 hover:-translate-y-1 transition-transform relative z-10">
              <div
                class="w-16 h-16 bg-gradient-to-br from-[#3E50F7] to-[#2bd9ff] text-white rounded-full flex items-center justify-center mb-5 shadow-[0_0_20px_rgba(62,80,247,0.4)] animate-[pulse_2s_ease-in-out_infinite]">
                <span class="material-symbols-outlined text-[32px]">call</span>
              </div>
              <h3 class="font-bold text-white text-center text-lg mb-2">2. Ask Companion to call you.</h3>
              <p class="text-[13px] text-[#AFBBE0] text-center leading-relaxed">Just call your companion and explain
                what needs to be done naturally.</p>
            </div>
            <div
              class="hidden md:block absolute top-[120px] -right-2.5 w-5 h-5 bg-[#EEF2FE] border-[4px] border-[#CBD5E1] rounded-full z-20 -translate-y-1/2 flex items-center justify-center">
              <div class="w-1.5 h-1.5 bg-[#3E50F7] rounded-full animate-pulse"></div>
            </div>
          </div>

          <!-- Step 3 -->
          <div class="w-full md:w-[20%] h-auto relative">
            <div
              class="hidden md:block absolute top-[120px] -left-2.5 w-5 h-5 bg-[#EEF2FE] border-[4px] border-[#CBD5E1] rounded-full z-20 -translate-y-1/2">
            </div>
            <div
              class="h-full flex flex-col items-center p-7 bg-white rounded-[2rem] shadow-sm border border-[#DEE8FF] hover:-translate-y-1 transition-transform relative z-10">
              <div class="w-16 h-16 bg-[#F0FDF4] text-green-600 rounded-full flex items-center justify-center mb-5">
                <span class="material-symbols-outlined text-[32px]">task_alt</span>
              </div>
              <h3 class="font-bold text-[#25224A] text-center text-lg mb-2">3. Auto Execution</h3>
              <p class="text-[13px] text-[#7F798D] text-center leading-relaxed">The companion silently executes the
                task in the
                background using top models.</p>
            </div>
            <div
              class="hidden md:block absolute top-[120px] -right-2.5 w-5 h-5 bg-[#EEF2FE] border-[4px] border-[#CBD5E1] rounded-full z-20 -translate-y-1/2">
            </div>
          </div>

          <!-- Step 4 -->
          <div class="w-full md:w-[20%] h-auto relative md:mt-[140px]">
            <div
              class="hidden md:block absolute top-[120px] -left-2.5 w-5 h-5 bg-[#EEF2FE] border-[4px] border-[#CBD5E1] rounded-full z-20 -translate-y-1/2">
            </div>
            <div
              class="h-full flex flex-col items-center p-7 bg-white rounded-[2rem] shadow-sm border border-[#DEE8FF] hover:-translate-y-1 transition-transform relative z-10">
              <div
                class="w-16 h-16 bg-[#F8FAFF] text-[#3E50F7] border border-[#DEE8FF] rounded-full flex items-center justify-center mb-5">
                <span class="material-symbols-outlined text-[32px]">notifications_active</span>
              </div>
              <h3 class="font-bold text-[#25224A] text-center text-lg mb-2">4. Receive Update</h3>
              <p class="text-[13px] text-[#7F798D] text-center leading-relaxed">Get a proactive phone call or email once
                your task is completed.</p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section class="bg-white py-24">
    <div class="max-w-[1600px] mx-auto px-6 md:px-12">
      <h2 class="text-3xl font-bold text-[#25224A] text-center mb-16">What do professionals say about The Business
        Companion?</h2>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1 -->
        <div class="bg-[#F8FAFF] p-8 rounded-2xl flex flex-col border border-[#DEE8FF] shadow-sm">
          <h3 class="font-bold text-[#25224A] mb-4 text-lg">"A game-changer for my research workflow"</h3>
          <p class="text-[#5F5770] text-sm leading-relaxed mb-8 flex-grow">
            Instead of spending hours scraping competitor sites, I simply give my companion the URLs and go to sleep. In
            the morning, I have a perfectly formatted PDF with all the pricing matrices and feature comparisons ready.
          </p>
          <div class="flex items-center gap-3">
            <img src="https://i.pravatar.cc/100?img=33" alt="Sarah M" class="w-10 h-10 rounded-full">
            <div>
              <div class="font-bold text-sm text-[#25224A]">Sarah M.</div>
              <div class="text-xs text-[#7F798D]">Growth Marketer</div>
            </div>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-[#F8FAFF] p-8 rounded-2xl flex flex-col border border-[#DEE8FF] shadow-sm">
          <h3 class="font-bold text-[#25224A] mb-4 text-lg">"Like having a Senior Analyst on call"</h3>
          <p class="text-[#5F5770] text-sm leading-relaxed mb-8 flex-grow">
            The voice feature is unbelievable. While driving to a meeting, I dropped in to ask my companion to summarize
            a 60-page legal document. It synthesized the key risks verbally and emailed the brief before I parked.
          </p>
          <div class="flex items-center gap-3">
            <img src="https://i.pravatar.cc/100?img=11" alt="James T" class="w-10 h-10 rounded-full">
            <div>
              <div class="font-bold text-sm text-[#25224A]">James T.</div>
              <div class="text-xs text-[#7F798D]">Founder & CEO</div>
            </div>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-[#F8FAFF] p-8 rounded-2xl flex flex-col border border-[#DEE8FF] shadow-sm">
          <h3 class="font-bold text-[#25224A] mb-4 text-lg">"Flawless autonomous execution"</h3>
          <p class="text-[#5F5770] text-sm leading-relaxed mb-8 flex-grow">
            I don't have to guide it step-by-step. I tell it the end goal, and it figures out the intermediate steps.
            The cloud sandbox ensures my data is safe while it explores the web to gather what it needs.
          </p>
          <div class="flex items-center gap-3">
            <img src="https://i.pravatar.cc/100?img=44" alt="Elena R" class="w-10 h-10 rounded-full">
            <div>
              <div class="font-bold text-sm text-[#25224A]">Elena R.</div>
              <div class="text-xs text-[#7F798D]">Product Manager</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Top Picks -> Top Professions -->
  <section id="professions" class="bg-[#F8FAFF] py-24 border-t border-[#DEE8FF]">
    <div class="max-w-[1600px] mx-auto px-6 md:px-12">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-[#25224A] mb-3">Top Professions</h2>
        <p class="text-[#7F798D] text-sm">See how different industries leverage their dedicated digital companion.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1 -->
        <div
          class="bg-white rounded-2xl overflow-hidden shadow-sm border border-[#DEE8FF] flex flex-col transition-transform hover:-translate-y-1">
          <div class="bg-[#272459] p-6 border-b-4 border-[#3E50F7]">
            <div class="text-xs text-[#AFBBE0] uppercase tracking-wider font-semibold mb-1">Profession</div>
            <h3 class="text-white font-bold text-xl">Founder & CEO</h3>
          </div>
          <div class="p-6 flex flex-col flex-grow">
            <h4 class="font-bold text-[#25224A] mb-2 text-[17px]">Scale your vision with autonomous executive support.
            </h4>
            <p class="text-sm text-[#7F798D] mb-6">Offload strategic GTM planning, competitor intelligence, and KPI
              reporting to your companion.</p>
            <div class="mt-auto bg-[#F8FAFF] p-4 rounded-xl border border-[#DEE8FF]">
              <div class="text-xs text-[#7F798D] font-medium mb-1">Key Capability</div>
              <div class="text-sm font-bold text-[#25224A]">Investor Pitch Refinement</div>
            </div>
          </div>
        </div>

        <!-- Card 2 -->
        <div
          class="bg-white rounded-2xl overflow-hidden shadow-sm border border-[#DEE8FF] flex flex-col transition-transform hover:-translate-y-1">
          <div class="bg-[#272459] p-6 border-b-4 border-[#3E50F7]">
            <div class="text-xs text-[#AFBBE0] uppercase tracking-wider font-semibold mb-1">Profession</div>
            <h3 class="text-white font-bold text-xl">Growth Marketer</h3>
          </div>
          <div class="p-6 flex flex-col flex-grow">
            <h4 class="font-bold text-[#25224A] mb-2 text-[17px]">Optimize growth loops and brand positioning.</h4>
            <p class="text-sm text-[#7F798D] mb-6">Automate high-conversion ad copy testing, customer sentiment
              analysis, and campaign reporting.</p>
            <div class="mt-auto bg-[#F8FAFF] p-4 rounded-xl border border-[#DEE8FF]">
              <div class="text-xs text-[#7F798D] font-medium mb-1">Key Capability</div>
              <div class="text-sm font-bold text-[#25224A]">Competitor Ad Monitoring</div>
            </div>
          </div>
        </div>

        <!-- Card 3 -->
        <div
          class="bg-white rounded-2xl overflow-hidden shadow-sm border border-[#DEE8FF] flex flex-col transition-transform hover:-translate-y-1">
          <div class="bg-[#272459] p-6 border-b-4 border-[#3E50F7]">
            <div class="text-xs text-[#AFBBE0] uppercase tracking-wider font-semibold mb-1">Profession</div>
            <h3 class="text-white font-bold text-xl">Lead Engineer</h3>
          </div>
          <div class="p-6 flex flex-col flex-grow">
            <h4 class="font-bold text-[#25224A] mb-2 text-[17px]">Accelerate delivery with architecture assistance.</h4>
            <p class="text-sm text-[#7F798D] mb-6">Generate implementation roadmaps, automated code documentation, and
              run technical debt audits.</p>
            <div class="mt-auto bg-[#F8FAFF] p-4 rounded-xl border border-[#DEE8FF]">
              <div class="text-xs text-[#7F798D] font-medium mb-1">Key Capability</div>
              <div class="text-sm font-bold text-[#25224A]">Security Compliance Checks</div>
            </div>
          </div>
        </div>
      </div>

      <div class="text-center mt-12">
        <button @click="waitlistModalOpen = true"
          class="px-8 py-3 bg-[#272459] text-white text-sm font-semibold rounded-lg hover:bg-black transition-colors">
          See all professions
        </button>
      </div>
    </div>
  </section>

  <!-- Bottom CTA Banner -->
  <section class="bg-white py-16 px-6">
    <div
      class="max-w-[1200px] mx-auto bg-[#EEF2FE] rounded-[2rem] p-12 md:p-20 text-center relative overflow-hidden shadow-sm">
      <!-- Gradient overlay for subtle effect -->
      <div class="absolute inset-0 bg-gradient-to-br from-white/40 to-transparent pointer-events-none"></div>
      <h2 class="text-2xl md:text-4xl font-bold text-[#25224A] mb-8 relative z-10 max-w-xl mx-auto leading-tight">
        Join 10,000+ professionals already augmenting their workflow.
      </h2>
      <button @click="waitlistModalOpen = true"
        class="relative z-10 px-8 py-4 bg-[#464154] hover:bg-[#25224A] text-white font-semibold rounded-lg transition-colors text-sm shadow-md">
        Get Started
      </button>
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
            <span class="text-xl">The Business Companion</span>
          </div>
          <p class="text-sm text-[#7F798D] max-w-xs leading-relaxed">
            Revolutionizing professional productivity through autonomous cloud computers, contextual intelligence, and
            voice-first interaction.
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
            <li><a href="#concept" class="hover:text-[#3E50F7]">Concept</a></li>
            <li><a href="#voice" class="hover:text-[#3E50F7]">Voice Calls</a></li>
            <li><a href="#professions" class="hover:text-[#3E50F7]">Professions</a></li>
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
        <p>© {{ date('Y') }} The Business Companion. All rights reserved.</p>
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
          <p class="text-[#7F798D]">We are currently in private beta. Leave your email to get early access when we
            expand.</p>
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