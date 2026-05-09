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
                          class="material-symbols-outlined text-[14px] text-[#22C55E]">check</span></div>Isolated VM
                      Environment
                    </div>
                    <div class="flex items-center gap-3 text-sm font-bold">
                      <div class="w-6 h-6 rounded-full bg-[#22C55E]/10 flex items-center justify-center"><span
                          class="material-symbols-outlined text-[14px] text-[#22C55E]">check</span></div>Computer
                      Navigation
                    </div>
                    <div class="flex items-center gap-3 text-sm font-bold">
                      <div class="w-6 h-6 rounded-full bg-[#22C55E]/10 flex items-center justify-center"><span
                          class="material-symbols-outlined text-[14px] text-[#22C55E]">check</span></div>Persistent
                      Memory
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
            The smartest<br>
            Business<br>
            Companion<br>
            <span class="text-[#AFBBE0]">for high<br>achievers</span>
          </h1>
        </div>

        <div class="space-y-6">
          <p class="text-white/90 text-xl font-semibold max-w-xl leading-relaxed">
            Overcome trust issues & procrastination in execution.
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

  <!-- Section 2: Storytelling Workflow -->
  <section class="bg-white py-24 relative overflow-hidden">
    <div class="max-w-[1400px] mx-auto px-6 md:px-12">
      <div class="text-center mb-20">
        <h2 class="text-3xl md:text-5xl font-black text-[#25224A] tracking-tight mb-6">Built for <span
            class="text-[#3E50F7]">Daily Life</span></h2>
        <p class="text-[#7F798D] text-lg max-w-2xl mx-auto">See how The Business Companion handles the heavy lifting
          while you focus on the vision.</p>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 relative">
        <!-- Step 1: The Problem -->
        <div class="bg-[#F8FAFF] p-10 rounded-[3rem] border border-[#DEE8FF] relative group overflow-hidden">
          <div class="relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-white shadow-sm flex items-center justify-center mb-8 text-[#3E50F7]">
              <span class="material-symbols-outlined text-3xl">lightbulb</span>
            </div>
            <h3 class="text-2xl font-bold text-[#25224A] mb-4">The Idea</h3>
            <p class="text-[#7F798D] leading-relaxed mb-8 italic">"I'm a SaaS founder. I need to finalize a monetization
              strategy for my new tool, but I'm stuck on competitor research and pricing models."</p>

            <!-- Thought Bubble UI -->
            <div class="bg-white p-4 rounded-2xl shadow-md border border-[#EEF2FE] animate-float-1">
              <div class="flex items-center gap-3 mb-2">
                <div class="w-2 h-2 rounded-full bg-red-400"></div>
                <div class="text-[10px] font-bold text-[#7F798D]">BLOCKER</div>
              </div>
              <div class="h-2 w-full bg-[#F8FAFF] rounded mb-1"></div>
              <div class="h-2 w-2/3 bg-[#F8FAFF] rounded"></div>
            </div>
          </div>
        </div>

        <!-- Step 2: The Action -->
        <div class="bg-[#25224A] p-10 rounded-[3rem] border border-white/5 relative group overflow-hidden shadow-2xl">
          <div class="relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-[#3E50F7] shadow-lg flex items-center justify-center mb-8 text-white">
              <span class="material-symbols-outlined text-3xl">call</span>
            </div>
            <h3 class="text-2xl font-bold text-white mb-4">The Discussion</h3>
            <p class="text-white/60 leading-relaxed mb-8">Your companion gives you a call. You explain your vision,
              goals, and constraints naturally, just like talking to a human co-founder.</p>

            <!-- Call Interface UI -->
            <div class="bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/10">
              <div class="flex items-center gap-4">
                <div class="relative">
                  <div class="w-10 h-10 rounded-full bg-[#3E50F7] flex items-center justify-center">
                    <span class="material-symbols-outlined text-white text-sm">person</span>
                  </div>
                  <div class="absolute inset-0 rounded-full border-2 border-[#3E50F7] animate-ping"></div>
                </div>
                <div class="flex-1">
                  <div class="h-1.5 w-1/2 bg-white/20 rounded mb-1"></div>
                  <div class="h-1 w-1/3 bg-white/10 rounded"></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Step 3: The Result -->
        <div class="bg-[#F8FAFF] p-10 rounded-[3rem] border border-[#DEE8FF] relative group overflow-hidden">
          <div class="relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-white shadow-sm flex items-center justify-center mb-8 text-[#22C55E]">
              <span class="material-symbols-outlined text-3xl">task_alt</span>
            </div>
            <h3 class="text-2xl font-bold text-[#25224A] mb-4">The Execution</h3>
            <p class="text-[#7F798D] leading-relaxed mb-8">Stride researches 10 competitors, analyzes market fit, and
              delivers a comprehensive strategy document directly to your inbox.</p>

            <!-- Document UI -->
            <div class="bg-white p-5 rounded-2xl shadow-md border border-[#EEF2FE]">
              <div class="flex items-center justify-between mb-4">
                <div class="text-[10px] font-black text-[#3E50F7]">FINAL_STRATEGY.PDF</div>
                <span class="material-symbols-outlined text-green-500 text-sm">download</span>
              </div>
              <div class="space-y-2">
                <div class="h-1.5 w-full bg-[#F8FAFF] rounded"></div>
                <div class="h-1.5 w-full bg-[#F8FAFF] rounded"></div>
                <div class="h-1.5 w-4/5 bg-[#F8FAFF] rounded"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Section 3: Own Computer Concept -->
  <section class="bg-[#F8FAFF] py-24 border-y border-[#DEE8FF]">
    <div class="max-w-[1400px] mx-auto px-6 md:px-12 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
      <div class="order-2 lg:order-1 relative">
        <!-- VM Visualization -->
        <div class="relative w-full aspect-square max-w-[500px] mx-auto">
          <div class="absolute inset-0 bg-gradient-to-tr from-[#3E50F7]/20 to-[#2bd9ff]/20 rounded-[4rem] blur-3xl">
          </div>
          <div
            class="relative bg-[#25224A] rounded-[3rem] p-8 h-full border border-white/10 shadow-2xl overflow-hidden">
            <div class="flex items-center gap-2 mb-6">
              <div class="w-3 h-3 rounded-full bg-red-500/50"></div>
              <div class="w-3 h-3 rounded-full bg-yellow-500/50"></div>
              <div class="w-3 h-3 rounded-full bg-green-500/50"></div>
              <div class="ml-4 text-[10px] text-white/30 font-mono">ssh stride-vm-01 --secure</div>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div class="bg-white/5 rounded-2xl p-4 border border-white/10">
                <span class="material-symbols-outlined text-white/40 mb-2">browser_updated</span>
                <div class="h-1.5 w-full bg-white/10 rounded mb-1"></div>
                <div class="h-1.5 w-2/3 bg-white/5 rounded"></div>
              </div>
              <div class="bg-white/5 rounded-2xl p-4 border border-white/10">
                <span class="material-symbols-outlined text-white/40 mb-2">terminal</span>
                <div class="h-1.5 w-full bg-white/10 rounded mb-1"></div>
                <div class="h-1.5 w-1/2 bg-white/5 rounded"></div>
              </div>
              <div class="bg-[#3E50F7]/20 rounded-2xl p-4 border border-[#3E50F7]/30 col-span-2">
                <div class="flex items-center gap-3">
                  <span class="material-symbols-outlined text-[#3E50F7]">database</span>
                  <div class="flex-1">
                    <div class="h-1.5 w-1/2 bg-white/20 rounded mb-1"></div>
                    <div class="h-1.5 w-1/3 bg-white/10 rounded"></div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Identity Card floating -->
            <div
              class="absolute bottom-8 right-8 bg-white rounded-2xl p-4 shadow-2xl w-[180px] animate-float-2 border border-[#DEE8FF]">
              <div class="flex items-center gap-3 mb-3">
                <div
                  class="w-8 h-8 rounded-full bg-[#3E50F7] flex items-center justify-center text-white text-xs font-bold">
                  S</div>
                <div class="text-[10px] font-bold text-[#25224A]">Stride Identity</div>
              </div>
              <div class="text-[9px] text-[#7F798D] uppercase tracking-widest font-bold">Status: Online</div>
            </div>
          </div>
        </div>
      </div>

      <div class="order-1 lg:order-2 space-y-8">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#3E50F7]/10 border border-[#3E50F7]/20">
          <span class="text-[10px] font-black text-[#3E50F7] uppercase tracking-widest">Isolated Technology</span>
        </div>
        <h2 class="text-3xl md:text-5xl font-black text-[#25224A] leading-tight">Every Agent has its<br><span
            class="text-[#3E50F7]">Own Computer</span></h2>
        <p class="text-[#7F798D] text-lg leading-relaxed">Unlike simple chatbots, Stride operates within a secure,
          isolated Virtual Machine. It has its own browser, its own memory, and its own digital identity—allowing it to
          navigate the web and use tools exactly like a human would.</p>

        <ul class="space-y-4">
          <li class="flex items-center gap-4 text-[#25224A] font-bold">
            <span class="material-symbols-outlined text-[#3E50F7]">check_circle</span>
            Private VMs for absolute data isolation
          </li>
          <li class="flex items-center gap-4 text-[#25224A] font-bold">
            <span class="material-symbols-outlined text-[#3E50F7]">check_circle</span>
            Autonomous web navigation & form filling
          </li>
          <li class="flex items-center gap-4 text-[#25224A] font-bold">
            <span class="material-symbols-outlined text-[#3E50F7]">check_circle</span>
            Persistent environment that never forgets
          </li>
        </ul>
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
        <h2 class="text-3xl md:text-5xl font-black text-white tracking-tight mb-6">The <span
            class="text-[#3E50F7]">Evolution</span> of Stride</h2>
        <p class="text-white/60 text-lg max-w-2xl mx-auto">Early adopters aren't just buying a tool—they're hiring a
          digital identity that grows with their business.</p>
      </div>

      <div class="relative max-w-[1100px] mx-auto">
        <!-- Connecting Line -->
        <svg class="hidden lg:block absolute top-[100px] left-0 w-full h-[100px] pointer-events-none"
          viewBox="0 0 1100 100" fill="none">
          <path d="M 150 50 L 950 50" stroke="rgba(255,255,255,0.1)" stroke-width="2" stroke-dasharray="8 8" />
          <path d="M 150 50 L 950 50" stroke="#3E50F7" stroke-width="3" stroke-dasharray="50 350"
            stroke-linecap="round">
            <animate attributeName="stroke-dashoffset" from="400" to="0" dur="3s" repeatCount="indefinite" />
          </path>
        </svg>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative">
          <!-- Stage 1 -->
          <div class="flex flex-col items-center text-center group">
            <div
              class="w-24 h-24 rounded-3xl bg-white/5 border border-white/10 flex items-center justify-center mb-8 relative group-hover:scale-110 transition-transform duration-500 shadow-2xl">
              <span class="material-symbols-outlined text-4xl text-[#3E50F7]">person_add</span>
              <div
                class="absolute -top-3 -right-3 px-3 py-1 bg-[#3E50F7] text-white text-[10px] font-bold rounded-full uppercase tracking-tighter">
                Phase 01</div>
            </div>
            <h3 class="text-2xl font-bold text-white mb-4">Adopt Your Identity</h3>
            <p class="text-white/50 text-[15px] leading-relaxed">Choose your dedicated Business Companion today with a
              one-time adoption fee. They start working on your server-side tasks immediately.</p>
          </div>

          <!-- Stage 2 -->
          <div class="flex flex-col items-center text-center group">
            <div
              class="w-24 h-24 rounded-3xl bg-white/5 border border-white/10 flex items-center justify-center mb-8 relative group-hover:scale-110 transition-transform duration-500 shadow-2xl">
              <span class="material-symbols-outlined text-4xl text-[#22C55E]">model_training</span>
              <div
                class="absolute -top-3 -right-3 px-3 py-1 bg-[#22C55E] text-white text-[10px] font-bold rounded-full uppercase tracking-tighter">
                Phase 02</div>
            </div>
            <h3 class="text-2xl font-bold text-white mb-4">Train on Reality</h3>
            <p class="text-white/50 text-[15px] leading-relaxed">As your companion handles calls and emails, they build
              a deep context of your business logic, preferences, and strategic goals.</p>
          </div>

          <!-- Stage 3 -->
          <div class="flex flex-col items-center text-center group">
            <div
              class="w-24 h-24 rounded-3xl bg-[#3E50F7] border border-[#3E50F7] flex items-center justify-center mb-8 relative group-hover:scale-110 transition-transform duration-500 shadow-[0_0_40px_rgba(62,80,247,0.4)]">
              <span class="material-symbols-outlined text-4xl text-white">rocket_launch</span>
              <div
                class="absolute -top-3 -right-3 px-3 py-1 bg-white text-[#3E50F7] text-[10px] font-bold rounded-full uppercase tracking-tighter">
                The Flagship</div>
            </div>
            <h3 class="text-2xl font-bold text-white mb-4">Ascend to Stride</h3>
            <p class="text-white/50 text-[15px] leading-relaxed">Early adopters get exclusive Beta access to the Stride
              Desktop OS. Your already-trained companion carries forward into your full Business OS.</p>
          </div>
        </div>
      </div>

      <!-- Beta Badge Callout -->
      <div
        class="mt-24 max-w-4xl mx-auto p-1 bg-gradient-to-r from-transparent via-white/10 to-transparent rounded-full">
        <div class="bg-[#1E204A] rounded-full py-4 px-8 flex flex-col md:flex-row items-center justify-between gap-4">
          <div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center">
              <span class="material-symbols-outlined text-[#AFBBE0]">verified</span>
            </div>
            <span class="text-white/80 font-medium italic">"Current companions are Stride-ready and will carry over all
              training data."</span>
          </div>
          <div
            class="text-[11px] font-bold text-[#3E50F7] uppercase tracking-widest bg-[#3E50F7]/10 px-4 py-2 rounded-full border border-[#3E50F7]/20">
            Exclusive Beta Access Included
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Section 4: Flagship Calling Feature (Enhanced & Grand) -->
  <section id="voice" class="bg-[#1E204A] py-32 border-y border-white/5 relative overflow-hidden">
    <!-- Immersive Background Elements -->
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
          <span class="material-symbols-outlined text-[20px] animate-pulse">settings_input_antenna</span> The Gold
          Standard
        </div>
        <h2
          class="text-4xl md:text-6xl lg:text-7xl font-black text-white max-w-4xl mx-auto leading-[1.1] tracking-tight">
          The Flagship<br><span class="text-[#3E50F7]">Calling System</span>
        </h2>
        <p class="text-xl text-white/50 max-w-2xl mx-auto mt-8 leading-relaxed">
          The ultimate interface. No screens, no typing—just a proactive partner that calls you to discuss goals,
          provide updates, and execute your vision.
        </p>
      </div>

      <div class="relative w-full mx-auto">
        <!-- SVG Connecting Lines (Immersive) -->
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
                <span class="material-symbols-outlined text-4xl">hourglass_empty</span>
              </div>
              <h3 class="font-bold text-white text-center text-xl mb-3">Thinking Phase</h3>
              <p class="text-sm text-white/40 text-center leading-relaxed">You have a complex business hurdle that needs
                strategic execution.</p>
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
              <h3 class="font-black text-center text-2xl mb-4 tracking-tight">The Discussion</h3>
              <p class="text-sm text-white/80 text-center leading-relaxed font-medium">Talk naturally. Your companion
                understands context, nuances, and specific goals without prompts.</p>
            </div>
          </div>

          <!-- Step 3 -->
          <div class="w-full md:w-[22%] h-auto relative group">
            <div
              class="h-full flex flex-col items-center p-8 bg-white/5 backdrop-blur-xl rounded-[2.5rem] border border-white/10 group-hover:border-[#3E50F7]/30 transition-all duration-500">
              <div
                class="w-20 h-20 bg-white/5 text-white/20 rounded-full flex items-center justify-center mb-6 group-hover:text-[#22C55E] group-hover:bg-[#22C55E]/20 transition-all">
                <span class="material-symbols-outlined text-4xl">cloud_sync</span>
              </div>
              <h3 class="font-bold text-white text-center text-xl mb-3">Auto-Execution</h3>
              <p class="text-sm text-white/40 text-center leading-relaxed">The agent navigates the digital world to
                finalize your request in the background.</p>
            </div>
          </div>

          <!-- Step 4 -->
          <div class="w-full md:w-[22%] h-auto relative md:mt-[150px] group">
            <div
              class="h-full flex flex-col items-center p-8 bg-white/5 backdrop-blur-xl rounded-[2.5rem] border border-white/10 group-hover:border-[#3E50F7]/30 transition-all duration-500">
              <div
                class="w-20 h-20 bg-white/5 text-white/20 rounded-full flex items-center justify-center mb-6 group-hover:text-[#AFBBE0] group-hover:bg-[#AFBBE0]/20 transition-all">
                <span class="material-symbols-outlined text-4xl">task_alt</span>
              </div>
              <h3 class="font-bold text-white text-center text-xl mb-3">Outcome Delivered</h3>
              <p class="text-sm text-white/40 text-center leading-relaxed">Get a final call or email with the completed
                work, ready for your review.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Section 5: Choose Your Companion -->
  <section id="concept" class="bg-white py-32 relative overflow-hidden">
    <div class="max-w-[1600px] mx-auto px-6 md:px-12 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
      <div class="space-y-8">
        <div>
          <h2 class="text-4xl md:text-5xl lg:text-6xl font-black text-[#25224A] tracking-tight mb-6">Choose
            Your<br><span class="text-[#3E50F7]">Dedicated Identity</span></h2>
          <p class="text-[#7F798D] text-lg max-w-xl">Claim a companion that aligns with your industry. This identity
            will grow with you and eventually transition into your Stride OS.</p>
        </div>

        <div class="space-y-6">
          <!-- Bullet 1 -->
          <div
            class="flex items-center gap-6 bg-[#F8FAFF] p-6 rounded-[2.5rem] border border-[#DEE8FF] hover:border-[#3E50F7]/30 transition-all shadow-sm group">
            <div
              class="w-16 h-16 rounded-full bg-white text-[#3E50F7] flex items-center justify-center shrink-0 shadow-lg group-hover:scale-110 transition-transform">
              <span class="material-symbols-outlined text-[32px]">shield_person</span>
            </div>
            <div>
              <h4 class="text-xl font-bold text-[#25224A] mb-1">Persistent Digital Twin</h4>
              <p class="text-[14px] text-[#7F798D] leading-relaxed">An identity that knows your past, understands your
                present, and plans for your future.</p>
            </div>
          </div>

          <!-- Bullet 2 -->
          <div
            class="flex items-center gap-6 bg-[#F8FAFF] p-6 rounded-[2.5rem] border border-[#DEE8FF] hover:border-[#3E50F7]/30 transition-all shadow-sm group">
            <div
              class="w-16 h-16 rounded-full bg-white text-[#3E50F7] flex items-center justify-center shrink-0 shadow-lg group-hover:scale-110 transition-transform">
              <span class="material-symbols-outlined text-[32px]">account_balance_wallet</span>
            </div>
            <div>
              <h4 class="text-xl font-bold text-[#25224A] mb-1">One-Time Adoption</h4>
              <p class="text-[14px] text-[#7F798D] leading-relaxed">Adopt your companion once. After that, you only pay
                for the computing usage they consume.</p>
            </div>
          </div>
        </div>

        <div class="pt-4">
          <button @click="waitlistModalOpen = true"
            class="px-12 py-5 bg-[#3E50F7] text-white font-black rounded-2xl shadow-xl shadow-[#3E50F7]/20 hover:scale-105 transition-all text-base flex items-center gap-3 w-fit uppercase tracking-widest">
            Find your identity <span class="material-symbols-outlined text-[20px]">person_search</span>
          </button>
        </div>
      </div>

      <!-- Right Side: 4 Companion Cards Grid -->
      <div class="relative w-full h-[650px] flex items-center justify-center lg:justify-end">
        <div class="relative w-full max-w-[480px] grid grid-cols-2 gap-4">
          <!-- Column 1 -->
          <div class="flex flex-col gap-4 animate-float-1">
            <div
              class="relative h-[270px] w-full rounded-[2.5rem] overflow-hidden group shadow-lg border-[3px] border-white">
              <img src="https://i.pravatar.cc/300?img=11" alt="James"
                class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
              <div class="absolute inset-0 bg-gradient-to-t from-[#25224A] via-[#25224A]/40 to-transparent opacity-90">
              </div>
              <div class="absolute bottom-0 left-0 w-full p-5 text-white">
                <h3 class="text-xl font-black">James</h3>
                <p class="text-[9px] font-bold text-[#2bd9ff] uppercase tracking-widest">Financial Analyst</p>
                <div class="flex items-baseline gap-1 border-t border-white/20 pt-3 mt-2">
                  <span class="text-lg font-black">$49</span><span class="text-[10px] text-white/60">/usage</span>
                </div>
              </div>
            </div>
            <div
              class="relative h-[270px] w-full rounded-[2.5rem] overflow-hidden group shadow-lg border-[3px] border-white">
              <img src="https://i.pravatar.cc/300?img=47" alt="Sarah"
                class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
              <div class="absolute inset-0 bg-gradient-to-t from-[#25224A] via-[#25224A]/40 to-transparent opacity-90">
              </div>
              <div class="absolute bottom-0 left-0 w-full p-5 text-white">
                <h3 class="text-xl font-black">Sarah</h3>
                <p class="text-[9px] font-bold text-[#2bd9ff] uppercase tracking-widest">Legal Advisor</p>
                <div class="flex items-baseline gap-1 border-t border-white/20 pt-3 mt-2">
                  <span class="text-lg font-black">$79</span><span class="text-[10px] text-white/60">/usage</span>
                </div>
              </div>
            </div>
          </div>
          <!-- Column 2 -->
          <div class="flex flex-col gap-4 translate-y-12 animate-float-2">
            <div
              class="relative h-[270px] w-full rounded-[2.5rem] overflow-hidden group shadow-lg border-[3px] border-white">
              <img src="https://i.pravatar.cc/300?img=44" alt="Elena"
                class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
              <div class="absolute inset-0 bg-gradient-to-t from-[#25224A] via-[#25224A]/40 to-transparent opacity-90">
              </div>
              <div class="absolute bottom-0 left-0 w-full p-5 text-white">
                <h3 class="text-xl font-black">Elena</h3>
                <p class="text-[9px] font-bold text-[#2bd9ff] uppercase tracking-widest">Growth Marketer</p>
                <div class="flex items-baseline gap-1 border-t border-white/20 pt-3 mt-2">
                  <span class="text-lg font-black">$59</span><span class="text-[10px] text-white/60">/usage</span>
                </div>
              </div>
            </div>
            <div
              class="relative h-[270px] w-full rounded-[2.5rem] overflow-hidden group shadow-lg border-[3px] border-white">
              <img src="https://i.pravatar.cc/300?img=68" alt="David"
                class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
              <div class="absolute inset-0 bg-gradient-to-t from-[#25224A] via-[#25224A]/40 to-transparent opacity-90">
              </div>
              <div class="absolute bottom-0 left-0 w-full p-5 text-white">
                <h3 class="text-xl font-black">David</h3>
                <p class="text-[9px] font-bold text-[#2bd9ff] uppercase tracking-widest">Lead Engineer</p>
                <div class="flex items-baseline gap-1 border-t border-white/20 pt-3 mt-2">
                  <span class="text-lg font-black">$149</span><span class="text-[10px] text-white/60">/usage</span>
                </div>
              </div>
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

  <!-- Section 6: The Big Picture (Stride vs Cursor) -->
  <section id="big-picture" class="bg-[#25224A] py-24 relative overflow-hidden">
    <div class="max-w-[1400px] mx-auto px-6 md:px-12 relative z-10 text-center">
      <div
        class="inline-flex items-center gap-3 px-4 py-2 rounded-2xl bg-white/5 border border-white/10 text-white text-sm font-bold mb-12">
        <span class="material-symbols-outlined text-[#3E50F7]">auto_awesome</span>
        Stride vs Cursor
      </div>
      <h2 class="text-4xl md:text-6xl font-black text-white tracking-tight mb-8">Stride is for <span
          class="text-[#3E50F7]">Business</span><br>as Cursor is for development.</h2>
      <p class="text-white/60 text-xl max-w-3xl mx-auto leading-relaxed mb-16">Just as Cursor revolutionized the way
        engineers write code, Stride is here to revolutionize the way founders run businesses. It's not a tool; it's an
        extension of your professional identity.</p>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
        <div class="bg-white/5 p-8 rounded-3xl border border-white/10 text-left">
          <div class="text-[#3E50F7] font-black text-xl mb-4">Cursor</div>
          <p class="text-white/40 text-sm">Automates syntax, logic, and debugging. Focus on building architecture.</p>
        </div>
        <div class="bg-[#3E50F7]/10 p-8 rounded-3xl border border-[#3E50F7]/20 text-left relative overflow-hidden">
          <div class="absolute top-0 right-0 p-4 opacity-10">
            <span class="material-symbols-outlined text-white text-6xl">rocket</span>
          </div>
          <div class="text-white font-black text-xl mb-4">Stride</div>
          <p class="text-white/80 text-sm">Automates operations, research, and execution. Focus on high-level strategy.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Section 7: Perks & Early Contribution -->
  <section id="perks" class="bg-white py-24 relative overflow-hidden">
    <div class="max-w-[1400px] mx-auto px-6 md:px-12">
      <div
        class="bg-gradient-to-br from-[#25224A] to-[#3E50F7] rounded-[4rem] p-12 md:p-24 text-center relative shadow-2xl overflow-hidden">
        <div
          class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10">
        </div>
        <div class="relative z-10">
          <h2 class="text-3xl md:text-5xl font-black text-white tracking-tight mb-8">Perks of being an <span
              class="text-[#2bd9ff]">Early Contributor</span></h2>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16 text-left">
            <div class="bg-white/10 backdrop-blur-md p-6 rounded-3xl border border-white/10">
              <span class="material-symbols-outlined text-[#2bd9ff] text-3xl mb-4">verified</span>
              <h4 class="text-white font-bold mb-2">Beta Access</h4>
              <p class="text-white/60 text-sm">Priority access to Stride Desktop OS before the global release.</p>
            </div>
            <div class="bg-white/10 backdrop-blur-md p-6 rounded-3xl border border-white/10">
              <span class="material-symbols-outlined text-[#2bd9ff] text-3xl mb-4">history</span>
              <h4 class="text-white font-bold mb-2">Legacy Companion</h4>
              <p class="text-white/60 text-sm">Your trained AI identity carries over to the flagship product forever.
              </p>
            </div>
            <div class="bg-white/10 backdrop-blur-md p-6 rounded-3xl border border-white/10">
              <span class="material-symbols-outlined text-[#2bd9ff] text-3xl mb-4">savings</span>
              <h4 class="text-white font-bold mb-2">Founder Pricing</h4>
              <p class="text-white/60 text-sm">Locked-in early adopter rates on all future usage costs.</p>
            </div>
          </div>
          <button @click="waitlistModalOpen = true"
            class="px-12 py-5 bg-white text-[#25224A] font-black rounded-2xl hover:scale-105 transition-transform shadow-2xl uppercase tracking-widest">
            Contribute Now
          </button>
        </div>
      </div>
    </div>
  </section>

  <!-- Section 8: FAQ Section -->
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
            <span class="text-lg md:text-xl font-bold text-[#25224A]">What is The Business Companion?</span>
            <span class="material-symbols-outlined text-[#3E50F7] transition-transform duration-300"
              :class="activeFaq === 1 ? 'rotate-45' : ''">add</span>
          </button>
          <div x-show="activeFaq === 1" x-collapse class="px-8 pb-6 text-[#7F798D] leading-relaxed">
            The Business Companion is an AI-powered professional assistant that lives in its own secure, private
            computer. Unlike standard chatbots, it has a persistent digital identity and can execute complex business
            tasks autonomously, from research and analysis to planning and execution.
          </div>
        </div>

        <!-- FAQ Item 2 -->
        <div class="bg-white rounded-3xl border border-[#DEE8FF] overflow-hidden transition-all shadow-sm">
          <button @click="activeFaq === 2 ? activeFaq = null : activeFaq = 2"
            class="w-full px-8 py-6 text-left flex items-center justify-between group">
            <span class="text-lg md:text-xl font-bold text-[#25224A]">What can it do?</span>
            <span class="material-symbols-outlined text-[#3E50F7] transition-transform duration-300"
              :class="activeFaq === 2 ? 'rotate-45' : ''">add</span>
          </button>
          <div x-show="activeFaq === 2" x-collapse class="px-8 pb-6 text-[#7F798D] leading-relaxed">
            It can handle competitor research, monetization strategies, KPI reporting, legal document summarization,
            voice-based task delegation, and autonomous web navigation. Essentially, anything a high-level executive
            assistant can do, your companion can do 24/7.
          </div>
        </div>

        <!-- FAQ Item 3 -->
        <div class="bg-white rounded-3xl border border-[#DEE8FF] overflow-hidden transition-all shadow-sm">
          <button @click="activeFaq === 3 ? activeFaq = null : activeFaq = 3"
            class="w-full px-8 py-6 text-left flex items-center justify-between group">
            <span class="text-lg md:text-xl font-bold text-[#25224A]">Does it keep running when I close the tab?</span>
            <span class="material-symbols-outlined text-[#3E50F7] transition-transform duration-300"
              :class="activeFaq === 3 ? 'rotate-45' : ''">add</span>
          </button>
          <div x-show="activeFaq === 3" x-collapse class="px-8 pb-6 text-[#7F798D] leading-relaxed">
            Yes. Because every companion operates on its own dedicated Virtual Machine (VM), it doesn't depend on your
            browser being open. You can delegate a task, close your laptop, and your companion will finish the work and
            notify you via email or a proactive call.
          </div>
        </div>

        <!-- FAQ Item 4 -->
        <div class="bg-white rounded-3xl border border-[#DEE8FF] overflow-hidden transition-all shadow-sm">
          <button @click="activeFaq === 4 ? activeFaq = null : activeFaq = 4"
            class="w-full px-8 py-6 text-left flex items-center justify-between group">
            <span class="text-lg md:text-xl font-bold text-[#25224A]">Does it remember me?</span>
            <span class="material-symbols-outlined text-[#3E50F7] transition-transform duration-300"
              :class="activeFaq === 4 ? 'rotate-45' : ''">add</span>
          </button>
          <div x-show="activeFaq === 4" x-collapse class="px-8 pb-6 text-[#7F798D] leading-relaxed">
            Absolutely. It features persistent memory that stores your preferences, business context, and past
            interactions. The more you work with your companion, the more it aligns with your strategic thinking and
            operational style.
          </div>
        </div>

        <!-- FAQ Item 5 -->
        <div class="bg-white rounded-3xl border border-[#DEE8FF] overflow-hidden transition-all shadow-sm">
          <button @click="activeFaq === 5 ? activeFaq = null : activeFaq = 5"
            class="w-full px-8 py-6 text-left flex items-center justify-between group">
            <span class="text-lg md:text-xl font-bold text-[#25224A]">What apps can it connect to?</span>
            <span class="material-symbols-outlined text-[#3E50F7] transition-transform duration-300"
              :class="activeFaq === 5 ? 'rotate-45' : ''">add</span>
          </button>
          <div x-show="activeFaq === 5" x-collapse class="px-8 pb-6 text-[#7F798D] leading-relaxed">
            Stride can interact with any web-based application via its own browser. It natively integrates with popular
            stacks like Gmail, Slack, Notion, Stripe, and LinkedIn, but its ability to navigate any URL means it can
            work with virtually any digital tool you use.
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
            Our model is simple: A one-time adoption fee to claim your dedicated companion, followed by a flexible usage
            cost (weekly or monthly) based on the computing power and tasks performed. This ensures you only pay for the
            value delivered.
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