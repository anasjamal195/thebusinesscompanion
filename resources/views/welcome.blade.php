<!DOCTYPE html>
<html class="light scroll-smooth" lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>The Business Companion - Engineered for Excellence</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
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
  </style>
</head>

<body class="bg-background text-on-background font-body-md selection:bg-primary-fixed selection:text-primary">
  
  <!-- Top Nav -->
  <nav class="docked full-width top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100 shadow-sm fixed w-full">
    <div class="flex justify-between items-center h-16 px-6 md:px-12 max-w-7xl mx-auto font-inter antialiased tracking-tight">
      <div class="text-xl font-bold tracking-tighter text-slate-900">The Business Companion</div>
      <div class="hidden md:flex items-center space-x-8">
        <a class="text-slate-600 hover:text-slate-900 transition-colors font-medium text-sm" href="#concept">Concept</a>
        <a class="text-slate-600 hover:text-slate-900 transition-colors font-medium text-sm" href="#workflow">How It Works</a>
        <a class="text-slate-600 hover:text-slate-900 transition-colors font-medium text-sm" href="#voice">Voice Calls</a>
        <a class="text-slate-600 hover:text-slate-900 transition-colors font-medium text-sm" href="#faq">FAQ</a>
      </div>
      <div class="flex items-center gap-4">
        <a href="{{ url('/login') }}" class="text-slate-600 hover:bg-slate-50 transition-all duration-200 px-4 py-2 rounded-lg text-sm font-medium">Sign In</a>
        <a href="{{ url('/companions') }}" class="bg-primary hover:bg-primary-container text-white transition-all duration-200 px-5 py-2 rounded-lg text-sm font-semibold shadow-md active:scale-95">Get Started</a>
      </div>
    </div>
  </nav>

  <main class="pt-16">
    <!-- HERO SECTION -->
    <section class="relative overflow-hidden bg-surface py-20 lg:py-32">
      <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
          <div class="space-y-8">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-primary/10 text-primary rounded-full text-xs font-bold uppercase tracking-wider">
              <span class="material-symbols-outlined text-[16px]">computer</span>
              <span>An AI with its own desktop</span>
            </div>
            <div class="space-y-6">
              <h1 class="text-5xl lg:text-7xl font-extrabold tracking-tight text-gray-900 leading-[1.1]">
                Meet your new <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-blue-400">digital employee.</span>
              </h1>
              <p class="text-xl text-gray-600 max-w-lg leading-relaxed">
                It doesn't just chat. The Business Companion comes with its own dedicated secure computer to browse the web, generate PDF reports, and execute tasks autonomously while you sleep.
              </p>
            </div>
            <div class="flex flex-wrap gap-4 pt-4">
              <a href="{{ url('/companions') }}" class="px-8 py-4 bg-primary hover:bg-primary-container text-white font-semibold rounded-xl shadow-lg hover:shadow-primary/20 transition-all active:scale-95 text-lg flex items-center gap-2">
                Select your Companion <span class="material-symbols-outlined">arrow_forward</span>
              </a>
            </div>
            
            <div class="flex items-center gap-4 pt-6 text-sm text-gray-500 font-medium">
              <div class="flex -space-x-2">
                <img class="w-8 h-8 rounded-full border-2 border-white" src="https://i.pravatar.cc/100?img=1" alt="User" />
                <img class="w-8 h-8 rounded-full border-2 border-white" src="https://i.pravatar.cc/100?img=2" alt="User" />
                <img class="w-8 h-8 rounded-full border-2 border-white" src="https://i.pravatar.cc/100?img=3" alt="User" />
              </div>
              <p>Join 10,000+ professionals augmenting their workflow.</p>
            </div>
          </div>
          
          <div class="relative flex justify-center lg:justify-end">
            <!-- Digital Computer Sandbox Visual -->
            <div class="w-full max-w-lg rounded-[2rem] bg-gray-900 shadow-2xl relative border-[4px] border-gray-800 p-2 overflow-hidden aspect-[4/3] flex flex-col">
                <!-- Top mock bar -->
                <div class="flex items-center gap-2 px-4 py-3 border-b border-gray-800">
                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                    <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                    <div class="ml-4 px-3 py-1 bg-gray-800 rounded text-xs text-gray-400 font-mono">Terminal - Autonomous Mode</div>
                </div>
                <!-- Mock Terminal -->
                <div class="p-6 font-mono text-sm text-green-400 flex-grow relative">
                    <p class="mb-2">> Booting dedicated workspace...</p>
                    <p class="mb-2">> User instruction: "Analyze competitor pricing and generate PDF report."</p>
                    <p class="mb-2 text-yellow-400">> Spinning up browser instance...</p>
                    <p class="mb-2">> Scraping data across 14 domains...</p>
                    <p class="mb-2">> Compiling results into comprehensive layout...</p>
                    <p class="mt-4 text-white opacity-80 blink">_</p>
                    
                    <div class="absolute bottom-6 right-6 glass-panel p-4 rounded-xl border border-white/20 shadow-xl flex items-center gap-3">
                        <span class="material-symbols-outlined text-green-400 text-3xl">task_alt</span>
                        <div>
                            <p class="text-white font-bold text-sm">Task Complete</p>
                            <p class="text-xs text-gray-300">Report emailed.</p>
                        </div>
                    </div>
                </div>
                <style>
                    @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0; } }
                    .blink { animation: blink 1s step-end infinite; }
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
        <h3 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-8 max-w-3xl mx-auto leading-tight">
          Operates autonomously.<br/>Navigates the web.<br/>Delivers results.
        </h3>
        <p class="text-xl text-gray-600 max-w-4xl mx-auto mb-16 leading-relaxed">
          Standard AI operates in a restrictive chat window. The Business Companion is assigned a dedicated cloud machine instance. When you give it a task, it uses a real browser, writes real code, compiles data, formats PDF reports, and then emails the deliverables to you.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-left p-8 rounded-3xl bg-surface-container border border-outline-variant/30">
                <span class="material-symbols-outlined text-4xl text-primary mb-4">language</span>
                <h4 class="text-xl font-bold mb-3">Real Web Browsing</h4>
                <p class="text-gray-600">Your companion navigates the actual internet. It reads documentation, monitors competitor sites, and extracts raw data bypassing simple API limitations.</p>
            </div>
            <div class="text-left p-8 rounded-3xl bg-surface-container border border-outline-variant/30">
                <span class="material-symbols-outlined text-4xl text-primary mb-4">analytics</span>
                <h4 class="text-xl font-bold mb-3">Data Synthesis</h4>
                <p class="text-gray-600">Give it hours of work. It can process spreadsheets, format numbers, run analysis, and compile actionable insights without requiring baby-sitting.</p>
            </div>
            <div class="text-left p-8 rounded-3xl bg-surface-container border border-outline-variant/30">
                <span class="material-symbols-outlined text-4xl text-primary mb-4">picture_as_pdf</span>
                <h4 class="text-xl font-bold mb-3">Delivery & Reporting</h4>
                <p class="text-gray-600">Once the task is verified, the companion generates a professionally formatted PDF report containing executive summaries, and pushes it directly to your email.</p>
            </div>
        </div>
      </div>
    </section>

    <!-- FLAGSHIP CALLING FEATURE -->
    <section id="voice" class="py-24 bg-gray-900 text-white relative overflow-hidden">
      <!-- Background glow -->
      <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-primary/20 rounded-full blur-[120px] pointer-events-none"></div>
      
      <div class="max-w-7xl mx-auto px-6 md:px-12 relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        <div class="order-2 lg:order-1 flex justify-center">
             <!-- Voice Interface Mockup -->
             <div class="w-full max-w-sm aspect-[9/16] bg-black rounded-[3rem] border-[10px] border-gray-800 shadow-2xl relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-b from-gray-900 to-black flex flex-col items-center justify-center p-8">
                  <div class="mb-12 relative">
                    <div class="absolute inset-0 bg-primary rounded-full blur-xl animate-pulse opacity-50"></div>
                    <img src="https://i.pravatar.cc/150?img=68" class="w-32 h-32 rounded-full border-2 border-primary relative z-10" alt="AI Agent">
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
                      <button class="w-16 h-16 rounded-full bg-gray-800 flex items-center justify-center text-white hover:bg-gray-700 transition">
                        <span class="material-symbols-outlined text-3xl">mic_off</span>
                      </button>
                      <button class="w-16 h-16 rounded-full bg-red-600 flex items-center justify-center text-white hover:bg-red-700 transition shadow-lg shadow-red-600/30">
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
                Need an update on a long-running research task? Stuck on a strategic decision? Schedule a call natively within the app. 
            </p>
            <ul class="space-y-4 text-lg text-gray-300">
                <li class="flex items-start gap-4">
                    <span class="material-symbols-outlined text-primary-fixed mt-1">check_circle</span>
                    <span><strong>Natural Conversations:</strong> Extremely low latency voice interfacing makes it feel like you are speaking to a real human partner.</span>
                </li>
                <li class="flex items-start gap-4">
                    <span class="material-symbols-outlined text-primary-fixed mt-1">check_circle</span>
                    <span><strong>Interrupt & Redirect:</strong> Verbally interrupt the AI to steer its focus or assign new priorities on the fly.</span>
                </li>
                <li class="flex items-start gap-4">
                    <span class="material-symbols-outlined text-primary-fixed mt-1">check_circle</span>
                    <span><strong>Meeting Transcripts:</strong> All calls are documented and mapped to your active project context.</span>
                </li>
            </ul>
        </div>
      </div>
    </section>

    <!-- HOW IT WORKS WORKFLOW -->
    <section id="workflow" class="py-24 bg-surface">
      <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="text-center mb-16">
            <h2 class="text-primary font-bold tracking-wider uppercase text-sm mb-3">Workflow</h2>
            <h3 class="text-4xl font-extrabold text-gray-900">From onboarding to daily execution</h3>
        </div>

        <div class="relative">
            <!-- Connecting line for desktop -->
            <div class="hidden md:block absolute top-[50px] left-[10%] right-[10%] h-1 bg-gray-200 -z-10"></div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Step 1 -->
                <div class="flex flex-col items-center text-center relative z-10">
                    <div class="w-24 h-24 rounded-2xl bg-white shadow-xl flex items-center justify-center text-4xl mb-6 border-2 border-primary">
                        👨‍💼
                    </div>
                    <h4 class="text-2xl font-bold text-gray-900 mb-3">1. Select Companion</h4>
                    <p class="text-gray-600">Browse our directory and subscribe to an AI specialist fine-tuned for your exact domain (e.g., Marketing, Architecture, Research).</p>
                </div>
                <!-- Step 2 -->
                <div class="flex flex-col items-center text-center relative z-10">
                    <div class="w-24 h-24 rounded-2xl bg-white shadow-xl flex items-center justify-center text-4xl mb-6 border border-gray-200">
                        📋
                    </div>
                    <h4 class="text-2xl font-bold text-gray-900 mb-3">2. Assign the Task</h4>
                    <p class="text-gray-600">Provide your business context. Schedule a voice call to brief your companion or drop the instructions into your project dashboard.</p>
                </div>
                <!-- Step 3 -->
                <div class="flex flex-col items-center text-center relative z-10">
                    <div class="w-24 h-24 rounded-2xl bg-primary shadow-xl flex items-center justify-center text-white mb-6 shadow-primary/30">
                        <span class="material-symbols-outlined text-4xl">mark_email_read</span>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-900 mb-3">3. Receive Deliverables</h4>
                    <p class="text-gray-600">Sit back. The companion drives its dedicated PC to figure it out, and will automatically email you a beautifully structured PDF report.</p>
                </div>
            </div>
        </div>
      </div>
    </section>

    <!-- FAQ SECTION -->
    <section id="faq" class="py-24 bg-white border-t border-gray-100">
        <div class="max-w-4xl mx-auto px-6 md:px-12">
            <h2 class="text-4xl font-extrabold text-gray-900 text-center mb-12">Frequently Asked Questions</h2>
            
            <div class="space-y-6">
                <!-- FAQ Item -->
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <h4 class="text-lg font-bold text-gray-900 mb-2">How is this different from ChatGPT or Claude?</h4>
                    <p class="text-gray-600">Chat interfaces wait for you to do the heavy lifting of prompting, reading, and clicking links. The Business Companion spins up a dedicated worker in the cloud that executes multi-step actions autonomously over hours, finally compiling a verified report and sending it to you.</p>
                </div>
                <!-- FAQ Item -->
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <h4 class="text-lg font-bold text-gray-900 mb-2">Can I interrupt a working task?</h4>
                    <p class="text-gray-600">Yes! You can jump onto a voice call at any moment with your companion to check status, review the data it has scraped so far, and instruct it to pivot its attention.</p>
                </div>
                <!-- FAQ Item -->
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <h4 class="text-lg font-bold text-gray-900 mb-2">Are the reports customizable?</h4>
                    <p class="text-gray-600">The AI naturally structures PDF reports based on the type of task (e.g., creating a competitor matrix vs drafting a legal summary). In the future, you will be able to supply strict layout templates.</p>
                </div>
                <!-- FAQ Item -->
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <h4 class="text-lg font-bold text-gray-900 mb-2">Is my data secure?</h4>
                    <p class="text-gray-600">Absolutely. Your dedicated companion operates in isolated cloud environments. The workspace is spun out and securely encrypted per project. We do not use your proprietary business data to train foundational models.</p>
                </div>
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
            <h3 class="text-4xl font-extrabold text-gray-900 mb-12">The perfect teammate for your profession.</h3>

            <div class="flex flex-col lg:flex-row gap-12">
                <!-- Navigation -->
                <div class="lg:w-1/3 text-left overflow-y-auto max-h-[600px] pr-4 custom-scrollbar">
                    <div class="grid grid-cols-2 lg:grid-cols-1 gap-2">
                        <template x-for="(data, name) in professions" :key="name">
                            <button 
                                @click="activeProfession = name"
                                :class="activeProfession === name ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-100'"
                                class="flex items-center gap-3 px-6 py-4 rounded-2xl transition-all duration-200 group text-left"
                            >
                                <span class="material-symbols-outlined" x-text="data.icon"></span>
                                <span class="font-semibold text-sm lg:text-base" x-text="name"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Dynamic Content -->
                <div class="lg:w-2/3">
                    <div class="bg-white rounded-[3rem] p-8 md:p-16 shadow-2xl border border-gray-50 text-left min-h-[500px] flex flex-col justify-center relative overflow-hidden">
                        <!-- Decorative background icon -->
                        <span class="absolute -right-8 -bottom-8 material-symbols-outlined text-[15rem] text-primary/5 opacity-40 select-none" x-text="professions[activeProfession].icon"></span>
                        
                        <div class="relative z-10">
                            <h4 class="text-3xl md:text-5xl font-extrabold text-gray-900 mb-6" x-text="activeProfession"></h4>
                            <p class="text-xl md:text-2xl text-gray-600 mb-12 leading-relaxed" x-text="professions[activeProfession].description"></p>
                            
                            <p class="text-sm font-bold text-primary uppercase tracking-widest mb-6">Key Usecases</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <template x-for="feature in professions[activeProfession].features" :key="feature">
                                    <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                        <span class="material-symbols-outlined text-primary">check_circle</span>
                                        <span class="text-gray-700 font-medium" x-text="feature"></span>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .custom-scrollbar::-webkit-scrollbar { width: 6px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
            .custom-scrollbar::-webkit-scrollbar-thumb { background: #00AFF0; border-radius: 10px; }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #0088bb; }
        </style>
    </section>

    <!-- Final CTA Section -->
    <section class="py-24 bg-primary text-white text-center">
      <div class="max-w-4xl mx-auto px-6 space-y-8 relative z-10">
        <h2 class="text-5xl font-extrabold tracking-tight">Ready to hire your new partner?</h2>
        <p class="text-primary-fixed text-xl max-w-2xl mx-auto">
          Scale your productivity and get hours back into your day without expanding your payroll.
        </p>
        <div class="pt-8">
          <a href="{{ url('/companions') }}" class="inline-block px-12 py-5 bg-white text-primary font-bold text-lg rounded-2xl shadow-xl hover:scale-105 transition-transform active:scale-95 border-b-[4px] border-gray-300">
            View the Companions Directory
          </a>
        </div>
        <p class="text-sm text-primary-fixed pt-4">Secure subscriptions starting at $4.99/mo.</p>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer class="py-12 bg-slate-50 border-t border-gray-200">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 px-6 md:px-12 max-w-7xl mx-auto font-inter">
      <div class="space-y-4">
        <div class="font-bold text-slate-900 text-lg">The Business Companion AI</div>
        <p class="text-sm text-slate-500 max-w-sm">
          Revolutionizing professional productivity through autonomous cloud computers, contextual intelligence and voice-first interaction.
        </p>
      </div>
      <div class="flex flex-col md:flex-row justify-between items-center gap-4 pt-8 mt-8 border-t border-slate-200 md:col-span-2">
        <div class="text-sm text-slate-500">© {{ date('Y') }} The Business Companion AI. Engineered for Excellence.</div>
        <div class="flex gap-6">
          <a href="#" class="text-slate-400 hover:text-primary transition-colors hover:-translate-y-1 transform">Privacy</a>
          <a href="#" class="text-slate-400 hover:text-primary transition-colors hover:-translate-y-1 transform">Terms</a>
          <a href="#" class="text-slate-400 hover:text-primary transition-colors hover:-translate-y-1 transform">Contact</a>
        </div>
      </div>
    </div>
  </footer>

</body>
</html>