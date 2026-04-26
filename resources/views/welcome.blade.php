<!DOCTYPE html>
<html class="light scroll-smooth" lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>The Business Companion - Engineered for Excellence</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
    rel="stylesheet" />
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script id="tailwind-config">
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "surface-container": "#eceef0",
            "outline-variant": "#c3c6d7",
            "surface-variant": "#e0e3e5",
            "primary": "#00AFF0",
            blue: {
              600: "#00AFF0",
            },
            "on-primary": "#ffffff",
            "primary-container": "#2563eb",
            "primary-fixed": "#dbe1ff",
            "secondary-fixed-dim": "#4ae176",
            "background": "#f7f9fb",
            "surface": "#f7f9fb",
            "on-surface": "#191c1e",
            "on-surface-variant": "#434655",
            "on-background": "#191c1e",
          },
          fontFamily: {
            "body-md": ["Inter"],
            "headline-xl": ["Inter"],
            "headline-lg": ["Inter"],
            "headline-md": ["Inter"],
          }
        },
      },
    }
  </script>
  <style>
    .material-symbols-outlined {
      font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
      vertical-align: middle;
    }

    .glass-panel {
      background: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
    }

    [x-cloak] {
      display: none !important;
    }
  </style>
</head>

<body class="bg-background text-on-background font-body-md selection:bg-primary-fixed selection:text-primary"
  x-data="{ waitlistModalOpen: false, waitlistSubmitted: false, email: '' }">

  <!-- Top Nav -->
  <nav
    class="docked full-width top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100 shadow-sm fixed w-full">
    <div
      class="flex justify-between items-center h-16 px-6 md:px-12 max-w-7xl mx-auto font-inter antialiased tracking-tight">
      <div class="font-black tracking-tighter text-slate-900 flex items-baseline">
        <span class="text-lg font-bold opacity-40 uppercase mr-0.5">The</span><span
          class="text-primary text-2xl">Business</span><span class="text-dark text-2xl">Companion</span>
      </div>
      <div class="hidden md:flex items-center space-x-8">
        <a class="text-slate-600 hover:text-slate-900 transition-colors font-medium text-sm" href="#concept">Concept</a>

        <a class="text-slate-600 hover:text-slate-900 transition-colors font-medium text-sm" href="#voice">Voice
          Calls</a>
        <a class="text-slate-600 hover:text-slate-900 transition-colors font-medium text-sm" href="#faq">FAQ</a>
      </div>
      <div class="flex items-center gap-4">

        <button @click="waitlistModalOpen = true"
          class="bg-primary hover:bg-primary-container text-white transition-all duration-200 px-5 py-2 rounded-lg text-sm font-semibold shadow-md active:scale-95">Join
          Waitlist</button>
      </div>
    </div>
  </nav>

  <main class="pt-16">
    <!-- HERO SECTION -->
    <section class="relative overflow-hidden bg-surface py-20 lg:py-32">
      <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
          <div class="space-y-8">
            <div
              class="inline-flex items-center gap-2 px-3 py-1.5 bg-primary/10 text-primary rounded-full text-xs font-bold uppercase tracking-wider">
              <span class="material-symbols-outlined text-[16px]">computer</span>
              <span>An AI with its own desktop</span>
            </div>
            <div class="space-y-6">
              <h1 class="text-5xl lg:text-7xl font-extrabold tracking-tight text-gray-900 leading-[1.1]">
                Meet your new <span
                  class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-blue-400">digital
                  employee.</span>
              </h1>
              <p class="text-xl text-gray-600 max-w-lg leading-relaxed">
                It doesn't just chat. The Business Companion comes with its own dedicated secure computer to browse the
                web, generate PDF reports, and execute tasks autonomously while you sleep.
              </p>
            </div>
            <div class="flex flex-wrap gap-4 pt-4">
              <a href="{{ url('/companions') }}"
                class="px-8 py-4 bg-primary hover:bg-primary-container text-white font-bold rounded-xl shadow-lg hover:shadow-primary/20 transition-all active:scale-95 text-lg flex items-center gap-2">
                Hire my Companion <span class="material-symbols-outlined">arrow_forward</span>
              </a>
              <button @click="waitlistModalOpen = true"
                class="px-8 py-4 bg-white text-gray-900 border border-gray-100 font-bold rounded-xl hover:bg-gray-50 transition-all active:scale-95 text-lg">
                Join the Waitlist
              </button>
            </div>

            <div class="flex items-center gap-4 pt-6 text-sm text-gray-500 font-medium">
              <div class="flex -space-x-2">
                <img class="w-8 h-8 rounded-full border-2 border-white" src="https://i.pravatar.cc/100?img=1"
                  alt="User" />
                <img class="w-8 h-8 rounded-full border-2 border-white" src="https://i.pravatar.cc/100?img=2"
                  alt="User" />
                <img class="w-8 h-8 rounded-full border-2 border-white" src="https://i.pravatar.cc/100?img=3"
                  alt="User" />
              </div>
              <p>Join 10,000+ professionals augmenting their workflow.</p>
            </div>
          </div>

          <div class="relative flex justify-center lg:justify-end">
            <!-- Digital Computer Sandbox Visual -->
            <div
              class="w-full max-w-lg rounded-[2rem] bg-gray-900 shadow-2xl relative border-[4px] border-gray-800 p-2 overflow-hidden aspect-[4/3] flex flex-col">
              <!-- Top mock bar -->
              <div class="flex items-center gap-2 px-4 py-3 border-b border-gray-800">
                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                <div class="ml-4 px-3 py-1 bg-gray-800 rounded text-xs text-gray-400 font-mono">Terminal - Autonomous
                  Mode</div>
              </div>
              <!-- Mock Terminal -->
              <div class="p-6 font-mono text-sm text-green-400 flex-grow relative">
                <p class="mb-2">> Booting dedicated workspace...</p>
                <p class="mb-2">> User instruction: "Analyze competitor pricing and generate PDF report."</p>
                <p class="mb-2 text-yellow-400">> Spinning up browser instance...</p>
                <p class="mb-2">> Scraping data across 14 domains...</p>
                <p class="mb-2">> Compiling results into comprehensive layout...</p>
                <p class="mt-4 text-white opacity-80 blink">_</p>

                <div
                  class="absolute bottom-6 right-6 glass-panel p-4 rounded-xl border border-white/20 shadow-xl flex items-center gap-3">
                  <span class="material-symbols-outlined text-green-400 text-3xl">task_alt</span>
                  <div>
                    <p class="text-white font-bold text-sm">Task Complete</p>
                    <p class="text-xs text-gray-300">Report emailed.</p>
                  </div>
                </div>
              </div>
              <style>
                @keyframes blink {

                  0%,
                  100% {
                    opacity: 1;
                  }

                  50% {
                    opacity: 0;
                  }
                }

                .blink {
                  animation: blink 1s step-end infinite;
                }
              </style>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- THE CONCEPT: DEDICATED COMPUTER -->
    <section id="concept" class="py-24 bg-white border-b border-gray-100">
      <div class="max-w-7xl mx-auto px-6 md:px-12 text-center">
        <h2 class="text-primary font-bold tracking-wider uppercase text-sm mb-3">The Paradigm Shift</h2>
        <h3 class="text-4xl md:text-6xl font-black text-gray-900 mb-6 tracking-tight">
          Autonomy. Speed. Results.
        </h3>
        <p class="text-xl text-gray-500 max-w-2xl mx-auto mb-16 leading-relaxed">
          While others chat, we execute. The Business Companion uses a dedicated cloud machine to navigate the web and
          deliver verified results directly to your inbox.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="text-left p-8 rounded-3xl bg-surface-container border border-outline-variant/30">
            <span class="material-symbols-outlined text-4xl text-primary mb-4">language</span>
            <h4 class="text-xl font-bold mb-3">Real Web Browsing</h4>
            <p class="text-gray-600">Your companion navigates the actual internet. It reads documentation, monitors
              competitor sites, and extracts raw data bypassing simple API limitations.</p>
          </div>
          <div class="text-left p-8 rounded-3xl bg-surface-container border border-outline-variant/30">
            <span class="material-symbols-outlined text-4xl text-primary mb-4">analytics</span>
            <h4 class="text-xl font-bold mb-3">Data Synthesis</h4>
            <p class="text-gray-600">Give it hours of work. It can process spreadsheets, format numbers, run analysis,
              and compile actionable insights without requiring baby-sitting.</p>
          </div>
          <div class="text-left p-8 rounded-3xl bg-surface-container border border-outline-variant/30">
            <span class="material-symbols-outlined text-4xl text-primary mb-4">picture_as_pdf</span>
            <h4 class="text-xl font-bold mb-3">Delivery & Reporting</h4>
            <p class="text-gray-600">Once the task is verified, the companion generates a professionally formatted PDF
              report containing executive summaries, and pushes it directly to your email.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- FLAGSHIP CALLING FEATURE -->
    <section id="voice" class="py-24 bg-gray-900 text-white relative overflow-hidden">
      <!-- Background glow -->
      <div
        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-primary/20 rounded-full blur-[120px] pointer-events-none">
      </div>

      <div class="max-w-7xl mx-auto px-6 md:px-12 relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        <div class="order-2 lg:order-1 flex justify-center">
          <!-- Voice Interface Mockup -->
          <div
            class="w-full max-w-sm aspect-[9/16] bg-black rounded-[3rem] border-[10px] border-gray-800 shadow-2xl relative overflow-hidden">
            <div
              class="absolute inset-0 bg-gradient-to-b from-gray-900 to-black flex flex-col items-center justify-center p-8">
              <div class="mb-12 relative">
                <div class="absolute inset-0 bg-primary rounded-full blur-xl animate-pulse opacity-50"></div>
                <img src="https://i.pravatar.cc/150?img=68"
                  class="w-32 h-32 rounded-full border-2 border-primary relative z-10" alt="AI Agent">
              </div>

              <h3 class="text-2xl font-bold text-white mb-2">Alex (Growth Exec)</h3>
              <p class="text-green-400 text-sm font-medium tracking-wide flex items-center gap-2 mb-12">
                <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                On Active Call - 12:45
              </p>

              <!-- Audio Wave Mockup -->
              <div class="flex items-center gap-1.5 h-12 mb-16">
                <div class="w-1.5 h-4 bg-white/40 rounded-full"></div>
                <div class="w-1.5 h-8 bg-white/60 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                <div class="w-1.5 h-12 bg-primary rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                <div class="w-1.5 h-6 bg-white/80 rounded-full animate-bounce" style="animation-delay: 0.3s"></div>
                <div class="w-1.5 h-10 bg-primary/80 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                <div class="w-1.5 h-5 bg-white/50 rounded-full animate-bounce" style="animation-delay: 0.5s"></div>
              </div>

              <div class="flex gap-6">
                <button
                  class="w-16 h-16 rounded-full bg-gray-800 flex items-center justify-center text-white hover:bg-gray-700 transition">
                  <span class="material-symbols-outlined text-3xl">mic_off</span>
                </button>
                <button
                  class="w-16 h-16 rounded-full bg-red-600 flex items-center justify-center text-white hover:bg-red-700 transition shadow-lg shadow-red-600/30">
                  <span class="material-symbols-outlined text-3xl">call_end</span>
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="space-y-8 order-1 lg:order-2">
          <span class="text-primary-fixed uppercase tracking-widest font-bold text-sm">Flagship Feature</span>
          <h2 class="text-4xl md:text-5xl font-extrabold leading-tight">Drop in for a live status update anytime.</h2>
          <p class="text-xl text-gray-400 leading-relaxed">
            Need an update on a long-running research task? Stuck on a strategic decision? Schedule a call natively
            within the app.
          </p>
          <ul class="space-y-4 text-lg text-gray-300">
            <li class="flex items-start gap-4">
              <span class="material-symbols-outlined text-primary-fixed mt-1">check_circle</span>
              <span><strong>Natural Conversations:</strong> Extremely low latency voice interfacing makes it feel like
                you are speaking to a real human partner.</span>
            </li>
            <li class="flex items-start gap-4">
              <span class="material-symbols-outlined text-primary-fixed mt-1">check_circle</span>
              <span><strong>Interrupt & Redirect:</strong> Verbally interrupt the AI to steer its focus or assign new
                priorities on the fly.</span>
            </li>
            <li class="flex items-start gap-4">
              <span class="material-symbols-outlined text-primary-fixed mt-1">check_circle</span>
              <span><strong>Meeting Transcripts:</strong> All calls are documented and mapped to your active project
                context.</span>
            </li>
          </ul>
        </div>
      </div>
    </section>

    <!-- PROFESSIONS SECTION -->
    <section id="professions" class="py-24 bg-surface" x-data="{ 
        activeProfession: 'Founder',
        professions: {
            'Founder': {
                icon: 'rocket_launch',
                description: 'Scale your vision with autonomous executive support.',
                features: ['Strategic GTM Planning', 'Competitor Intelligence', 'Investor Pitch Refinement', 'KPI Tracking & Reporting']
            },
            'Engineer': {
                icon: 'terminal',
                description: 'Accelerate delivery with technical architecture assistance.',
                features: ['Implementation Roadmaps', 'Automated Code Documentation', 'Technical Debt Audits', 'Security Compliance Checks']
            },
            'Marketer': {
                icon: 'campaign',
                description: 'Optimize growth loops and brand positioning.',
                features: ['High-Conversion Ad Copy', 'Customer Sentiment Analysis', 'Automated Campaign Reporting', 'Competitor Ad Monitoring']
            },
            'Researcher': {
                icon: 'biotech',
                description: 'Synthesize complex data into evidentiary summaries.',
                features: ['Literature Review Synthesis', 'Trend Forecasting Models', 'Deep-Dive Market Analysis', 'Data Extraction & Cleaning']
            },
            'Creator': {
                icon: 'article',
                description: 'Turn ideas into high-performing content assets.',
                features: ['Multi-Platform Strategy', 'Script & Hook Ideation', 'Publishing Cadence Optimization', 'Audience Growth Analytics']
            },
            'Musician': {
                icon: 'music_note',
                description: 'Manage releases and fan engagement efficiently.',
                features: ['Release Project Management', 'Digital Marketing Plans', 'Tour Logistics Support', 'Royalties Analysis']
            },
            'Parent': {
                icon: 'family_restroom',
                description: 'Organize your household with calm, digital structure.',
                features: ['Family Schedule Optimization', 'Nutritional Meal Planning', 'Educational Resource Discovery', 'Travel & Logic Coordination']
            },
            'Trader': {
                icon: 'monitoring',
                description: 'Manage risk and discipline with automated logic.',
                features: ['Post-Trade Performance Audits', 'Market Sentiment Monitoring', 'Trading Plan Structuring', 'Risk Exposure Reporting']
            },
            'Teacher': {
                icon: 'school',
                description: 'Focus on teaching while AI handles the prep.',
                features: ['Curriculum Content Generation', 'Educational Research Summaries', 'Lesson Plan Optimization', 'Automated Grading Assistance']
            },
            'Student': {
                icon: 'edit_note',
                description: 'Master complex topics with organized intelligence.',
                features: ['Thesis Research Organization', 'Complex Concept Synthesis', 'Study Schedule Automation', 'Citation & Source Management']
            },
            'Doctor': {
                icon: 'medical_services',
                description: 'Streamline research and administrative workflows.',
                features: ['Clinical Literature Updates', 'Patient Communication Templates', 'Medical Case Organization', 'Continuing Education Planning']
            },
            'Medical Staff': {
                icon: 'health_and_safety',
                description: 'Manage operations and administrative logistics.',
                features: ['Facility Inventory Forecasting', 'Shift Coordination Support', 'Compliance Documentation', 'Supplier Management']
            },
            'Healthcare': {
                icon: 'healing',
                description: 'Optimize care delivery and policy compliance.',
                features: ['Policy Audit Summaries', 'Care Workflow Optimization', 'Public Health Monitoring', 'Insurance Logic Research']
            },
            'Drivers': {
                icon: 'local_shipping',
                description: 'Track logistics and maintenance autonomously.',
                features: ['Route Optimization Research', 'Vehicle Maintenance Tracking', 'Automated Logbook Summaries', 'Fuel Efficiency Auditing']
            },
            'Textile Owner': {
                icon: 'inventory',
                description: 'Manage supply chains and manufacturing trends.',
                features: ['Fabric Trend Analysis', 'Supply Chain Visibility', 'Production Scheduling', 'Export Compliance Logic']
            },
            'Food Business Owner': {
                icon: 'restaurant',
                description: 'Optimize menus and control kitchen costs.',
                features: ['Recipe Cost Analysis', 'Supplier Price Fluctuations', 'Menu Profitability Audits', 'Operational Safety Checks']
            }
        }
    }">
      <div class="max-w-7xl mx-auto px-6 md:px-12 text-center">
        <h2 class="text-primary font-bold tracking-wider uppercase text-sm mb-3">One Tool, Every Industry</h2>
        <h3 class="text-4xl md:text-5xl font-black text-gray-900 mb-12">The perfect teammate for your profession.</h3>

        <!-- Horizontal Tabs -->
        <div class="mb-12 relative">
          <div class="flex overflow-x-auto no-scrollbar gap-3 pb-4 px-2 -mx-2 snap-x">
            <template x-for="(data, name) in professions" :key="name">
              <button @click="activeProfession = name"
                :class="activeProfession === name ? 'bg-primary text-white shadow-lg shadow-primary/30 scale-105 z-10' : 'bg-white text-gray-500 hover:bg-gray-50 border border-gray-100'"
                class="flex-shrink-0 flex items-center gap-2 px-6 py-3 rounded-full transition-all duration-300 snap-start active:scale-95">
                <span class="material-symbols-outlined text-[20px]" x-text="data.icon"></span>
                <span class="font-bold text-sm whitespace-nowrap" x-text="name"></span>
              </button>
            </template>
          </div>
          <!-- Gradient overlays for scroll indicator -->
          <div
            class="absolute left-0 top-0 bottom-4 w-12 bg-gradient-to-r from-surface to-transparent pointer-events-none">
          </div>
          <div
            class="absolute right-0 top-0 bottom-4 w-12 bg-gradient-to-l from-surface to-transparent pointer-events-none">
          </div>
        </div>

        <!-- Enhanced Content Area with Infographic -->
        <div class="relative group">
          <div
            class="bg-white rounded-[3.5rem] p-8 md:p-20 shadow-[0_32px_64px_-12px_rgba(0,0,0,0.08)] border border-gray-50 text-left relative overflow-hidden transition-all duration-500">

            <!-- Background Illustration Element -->
            <div
              class="absolute -right-20 -top-20 w-96 h-96 bg-primary/5 rounded-full blur-3xl group-hover:bg-primary/10 transition-colors duration-700">
            </div>

            <div class="relative z-10 flex flex-col lg:flex-row gap-16 items-center">
              <!-- Left Side: Text Info -->
              <div class="lg:w-2/5 space-y-8">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 text-primary rounded-xl">
                  <span class="material-symbols-outlined" x-text="professions[activeProfession].icon"></span>
                  <span class="font-bold text-xs uppercase tracking-widest" x-text="activeProfession"></span>
                </div>
                <h4 class="text-4xl md:text-6xl font-black text-gray-900 leading-[1.1]"
                  x-text="professions[activeProfession].description"></h4>
                <p class="text-lg text-gray-500 leading-relaxed">Your dedicated companion operates a secure cloud
                  environment to execute your industry-specific tasks autonomously.</p>

                <div class="pt-4">
                  <button @click="waitlistModalOpen = true"
                    class="inline-flex items-center gap-2 px-8 py-4 bg-gray-900 text-white font-bold rounded-2xl hover:bg-gray-800 transition-all shadow-xl hover:shadow-gray-900/20 group/btn">
                    Join the Waitlist
                    <span
                      class="material-symbols-outlined group-hover/btn:translate-x-1 transition-transform">arrow_forward</span>
                  </button>
                </div>
              </div>

              <!-- Right Side: The Infographic Workflow -->
              <div class="lg:w-3/5 w-full">
                <div class="relative p-8 bg-gray-50 rounded-[2.5rem] border border-gray-100/50">
                  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative">
                    <!-- Connecting Lines (Desktop) -->
                    <div
                      class="hidden md:block absolute top-1/2 left-[20%] right-[20%] h-0.5 bg-gradient-to-r from-primary/20 via-primary to-primary/20 -translate-y-1/2">
                    </div>

                    <!-- Step 1: Input -->
                    <div
                      class="relative z-10 flex flex-col items-center text-center p-6 bg-white rounded-3xl shadow-sm border border-gray-100">
                      <div
                        class="w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center text-primary mb-4 transition-transform hover:scale-110">
                        <span class="material-symbols-outlined text-3xl">input</span>
                      </div>
                      <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Input</p>
                      <p class="text-sm font-bold text-gray-900" x-text="professions[activeProfession].features[0]"></p>
                    </div>

                    <!-- Step 2: Processing (The AI) -->
                    <div
                      class="relative z-10 flex flex-col items-center text-center p-6 bg-primary rounded-3xl shadow-xl shadow-primary/20 scale-110 -translate-y-2 md:translate-y-0">
                      <div
                        class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center text-white mb-4 animate-pulse">
                        <span class="material-symbols-outlined text-3xl">memory</span>
                      </div>
                      <p class="text-xs font-bold text-white/60 uppercase tracking-widest mb-2">Execution</p>
                      <p class="text-sm font-bold text-white">Autonomous Cloud Workflow</p>
                    </div>

                    <!-- Step 3: Result -->
                    <div
                      class="relative z-10 flex flex-col items-center text-center p-6 bg-white rounded-3xl shadow-sm border border-gray-100">
                      <div
                        class="w-16 h-16 rounded-2xl bg-green-50 flex items-center justify-center text-green-500 mb-4 transition-transform hover:scale-110">
                        <span class="material-symbols-outlined text-3xl">picture_as_pdf</span>
                      </div>
                      <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Outcome</p>
                      <p class="text-sm font-bold text-gray-900" x-text="professions[activeProfession].features[3]"></p>
                    </div>
                  </div>

                  <div class="mt-8 flex flex-wrap justify-center gap-3">
                    <template x-for="(feature, index) in professions[activeProfession].features" :key="feature">
                      <div x-show="index !== 0 && index !== 3"
                        class="flex items-center gap-2 px-4 py-2 bg-white rounded-xl border border-gray-100 text-xs font-semibold text-gray-600">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary/40"></span>
                        <span x-text="feature"></span>
                      </div>
                    </template>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <style>
        .no-scrollbar::-webkit-scrollbar {
          display: none;
        }

        .no-scrollbar {
          -ms-overflow-style: none;
          scrollbar-width: none;
        }
      </style>

    </section>


    <!-- FAQ SECTION -->
    <section id="faq" class="py-24 bg-white border-t border-gray-100">
      <div class="max-w-4xl mx-auto px-6 md:px-12">
        <h2 class="text-4xl font-extrabold text-gray-900 text-center mb-12">Frequently Asked Questions</h2>

        <div class="space-y-6">
          <!-- FAQ Item -->
          <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
            <h4 class="text-lg font-bold text-gray-900 mb-2">How is this different from ChatGPT or Claude?</h4>
            <p class="text-gray-600">Chat interfaces wait for you to do the heavy lifting of prompting, reading, and
              clicking links. The Business Companion spins up a dedicated worker in the cloud that executes multi-step
              actions autonomously over hours, finally compiling a verified report and sending it to you.</p>
          </div>
          <!-- FAQ Item -->
          <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
            <h4 class="text-lg font-bold text-gray-900 mb-2">Can I interrupt a working task?</h4>
            <p class="text-gray-600">Yes! You can jump onto a voice call at any moment with your companion to check
              status, review the data it has scraped so far, and instruct it to pivot its attention.</p>
          </div>
          <!-- FAQ Item -->
          <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
            <h4 class="text-lg font-bold text-gray-900 mb-2">Are the reports customizable?</h4>
            <p class="text-gray-600">The AI naturally structures PDF reports based on the type of task (e.g., creating a
              competitor matrix vs drafting a legal summary). In the future, you will be able to supply strict layout
              templates.</p>
          </div>
          <!-- FAQ Item -->
          <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
            <h4 class="text-lg font-bold text-gray-900 mb-2">Is my data secure?</h4>
            <p class="text-gray-600">Absolutely. Your dedicated companion operates in isolated cloud environments. The
              workspace is spun out and securely encrypted per project. We do not use your proprietary business data to
              train foundational models.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Final CTA Section -->
    <section class="py-24 bg-primary text-white text-center">
      <div class="max-w-4xl mx-auto px-6 space-y-8 relative z-10">
        <h2 class="text-5xl font-extrabold tracking-tight">Ready to hire your new partner?</h2>
        <p class="text-primary-fixed text-xl max-w-2xl mx-auto">
          Scale your productivity and get hours back into your day without expanding your payroll.
        </p>
        <div class="pt-8">
          <button @click="waitlistModalOpen = true"
            class="inline-block px-12 py-5 bg-white text-primary font-bold text-lg rounded-2xl shadow-xl hover:scale-105 transition-transform active:scale-95 border-b-[4px] border-gray-300">
            Join the Waitlist
          </button>
        </div>
        <p class="text-sm text-primary-fixed pt-4">Secure subscriptions starting at $4.99/mo.</p>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer class="py-12 bg-slate-50 border-t border-gray-200">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 px-6 md:px-12 max-w-7xl mx-auto font-inter">
      <div class="space-y-4">
        <div class="font-black tracking-tighter text-slate-900 flex items-baseline">
          <span class="text-xs font-bold opacity-40 uppercase mr-0.5">The</span><span
            class="text-primary text-lg">Business</span><span class="text-dark text-lg">Companion</span>
        </div>
        <p class="text-sm text-slate-500 max-w-sm">
          Revolutionizing professional productivity through autonomous cloud computers, contextual intelligence and
          voice-first interaction.
        </p>
      </div>
      <div
        class="flex flex-col md:flex-row justify-between items-center gap-4 pt-8 mt-8 border-t border-slate-200 md:col-span-2">
        <div class="text-sm text-slate-500">© {{ date('Y') }} The Business Companion AI. Engineered for Excellence.
        </div>
        <div class="flex gap-6">
          <a href="#"
            class="text-slate-400 hover:text-primary transition-colors hover:-translate-y-1 transform">Privacy</a>
          <a href="#"
            class="text-slate-400 hover:text-primary transition-colors hover:-translate-y-1 transform">Terms</a>
          <a href="#"
            class="text-slate-400 hover:text-primary transition-colors hover:-translate-y-1 transform">Contact</a>
        </div>
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
    <div class="bg-white rounded-[2.5rem] p-8 md:p-12 max-w-lg w-full shadow-2xl relative border border-gray-100"
      @click.away="waitlistModalOpen = false">
      <button @click="waitlistModalOpen = false"
        class="absolute top-6 right-6 text-gray-400 hover:text-gray-600 transition">
        <span class="material-symbols-outlined text-3xl">close</span>
      </button>

      <div x-show="!waitlistSubmitted">
        <div class="mb-8">
          <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mb-6">
            <span class="material-symbols-outlined text-3xl">mail</span>
          </div>
          <h3 class="text-3xl font-black text-gray-900 mb-3">Join the Waitlist</h3>
          <p class="text-gray-500">We are currently in private beta. Leave your email to get early access when we
            expand.
          </p>
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
            class="w-full px-6 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition font-medium">
          <button type="submit"
            class="w-full py-4 bg-primary text-white font-bold rounded-2xl shadow-lg shadow-primary/20 hover:bg-primary-container transition-all active:scale-95 flex items-center justify-center gap-2">
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
        <h3 class="text-3xl font-black text-gray-900 mb-4">You're on the list!</h3>
        <p class="text-lg text-gray-600 leading-relaxed font-medium">You have been added to waitlist, we will update you
          through email</p>
        <button @click="waitlistModalOpen = false; waitlistSubmitted = false; email = ''"
          class="mt-12 text-primary font-bold hover:underline">Close</button>
      </div>
    </div>
  </div>

</body>

</html>