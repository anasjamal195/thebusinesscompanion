import re

with open("resources/views/welcome.blade.php", "r") as f:
    content = f.read()

start_marker = '<!-- Hero Graphics (Left Section) -->'
end_marker = '<!-- Hero Text (Right Section) -->'

start_idx = content.find(start_marker)
end_idx = content.find(end_marker)

if start_idx != -1 and end_idx != -1:
    new_graphics = """      <!-- Hero Graphics (Right Section) -->
      <div class="order-2 lg:order-2 relative w-full h-[500px] md:h-[600px] flex justify-center items-start overflow-hidden pt-4" style="-webkit-mask-image: linear-gradient(to bottom, black 80%, transparent 100%); mask-image: linear-gradient(to bottom, black 80%, transparent 100%);">
        
        <div class="w-full transition-transform duration-1000 ease-in-out z-20" :style="`transform: translateY(-${activeSlide * 600}px)`">
            <div class="relative w-full max-w-[600px] mx-auto h-[1800px]">

                <!-- Background Skeletons -->
                <!-- Slide 1 Skeletons -->
                <div class="absolute top-[-10px] -left-[20px] md:-left-[40px] w-[260px] h-[240px] bg-[#272459] rounded-3xl opacity-40 z-0 border border-white/10 shadow-lg"></div>
                <div class="absolute top-[360px] -right-[20px] md:-right-[40px] w-[260px] h-[240px] bg-[#272459] rounded-3xl opacity-40 z-0 border border-white/10 shadow-lg"></div>
                <div class="absolute top-[300px] left-[40px] w-[180px] h-[180px] bg-[#272459] rounded-3xl opacity-20 z-0 border border-white/5"></div>
                
                <!-- Slide 2 Skeletons -->
                <div class="absolute top-[590px] -right-[20px] md:-right-[40px] w-[260px] h-[240px] bg-[#272459] rounded-3xl opacity-40 z-0 border border-white/10 shadow-lg"></div>
                <div class="absolute top-[960px] -left-[20px] md:-left-[40px] w-[260px] h-[240px] bg-[#272459] rounded-3xl opacity-40 z-0 border border-white/10 shadow-lg"></div>
                <div class="absolute top-[900px] right-[40px] w-[180px] h-[180px] bg-[#272459] rounded-3xl opacity-20 z-0 border border-white/5"></div>
                
                <!-- Slide 3 Skeletons -->
                <div class="absolute top-[1190px] -left-[20px] md:-left-[40px] w-[260px] h-[240px] bg-[#272459] rounded-3xl opacity-40 z-0 border border-white/10 shadow-lg"></div>
                <div class="absolute top-[1560px] -right-[20px] md:-right-[40px] w-[260px] h-[240px] bg-[#272459] rounded-3xl opacity-40 z-0 border border-white/10 shadow-lg"></div>

                <!-- Connective SVG Lines & Pulses -->
                <svg viewBox="0 0 600 1800" class="absolute top-0 left-0 w-full h-full z-0 pointer-events-none">
                    <!-- Base Dotted Lines -->
                    <g fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="2" stroke-dasharray="4 6" stroke-linecap="round">
                        <!-- Slide 1 Line -->
                        <path d="M 140 330 L 140 370 Q 140 390 160 390 L 440 390 Q 460 390 460 410 L 460 440" />
                        <!-- Slide 1 to 2 Transition Line -->
                        <path d="M 460 520 L 460 560 Q 460 580 440 580 L 160 580 Q 140 580 140 600 L 140 630" />
                        <!-- Slide 2 Line -->
                        <path d="M 140 930 L 140 970 Q 140 990 160 990 L 440 990 Q 460 990 460 1010 L 460 1040" />
                        <!-- Slide 2 to 3 Transition Line -->
                        <path d="M 460 1120 L 460 1160 Q 460 1180 440 1180 L 160 1180 Q 140 1180 140 1200 L 140 1230" />
                        <!-- Slide 3 Line -->
                        <path d="M 140 1530 L 140 1570 Q 140 1590 160 1590 L 440 1590 Q 460 1590 460 1610 L 460 1640" />
                    </g>
                    <!-- Animated Pulses -->
                    <g fill="none" stroke="#3E50F7" stroke-width="4" stroke-linecap="round" style="filter: drop-shadow(0 0 8px #3E50F7);">
                        <path d="M 140 330 L 140 370 Q 140 390 160 390 L 440 390 Q 460 390 460 410 L 460 440" pathLength="100" stroke-dasharray="25 100">
                            <animate attributeName="stroke-dashoffset" from="100" to="-25" dur="2.5s" repeatCount="indefinite" />
                        </path>
                        <path d="M 460 520 L 460 560 Q 460 580 440 580 L 160 580 Q 140 580 140 600 L 140 630" pathLength="100" stroke-dasharray="25 100">
                            <animate attributeName="stroke-dashoffset" from="100" to="-25" dur="2.5s" repeatCount="indefinite" begin="1s"/>
                        </path>
                        <path d="M 140 930 L 140 970 Q 140 990 160 990 L 440 990 Q 460 990 460 1010 L 460 1040" pathLength="100" stroke-dasharray="25 100">
                            <animate attributeName="stroke-dashoffset" from="100" to="-25" dur="2.5s" repeatCount="indefinite" begin="0.5s"/>
                        </path>
                        <path d="M 460 1120 L 460 1160 Q 460 1180 440 1180 L 160 1180 Q 140 1180 140 1200 L 140 1230" pathLength="100" stroke-dasharray="25 100">
                            <animate attributeName="stroke-dashoffset" from="100" to="-25" dur="2.5s" repeatCount="indefinite" begin="1.5s"/>
                        </path>
                        <path d="M 140 1530 L 140 1570 Q 140 1590 160 1590 L 440 1590 Q 460 1590 460 1610 L 460 1640" pathLength="100" stroke-dasharray="25 100">
                            <animate attributeName="stroke-dashoffset" from="100" to="-25" dur="2.5s" repeatCount="indefinite" />
                        </path>
                    </g>
                </svg>

                <!-- ================= SLIDE 1 ================= -->
                <div class="absolute top-0 w-full h-[600px] transition-opacity duration-700" :class="activeSlide === 0 ? 'opacity-100' : 'opacity-30'">
                    <!-- Small Overlapping Card (Z-index 30 -> IN FRONT) -->
                    <div class="absolute top-[40px] right-[260px] md:left-[180px] w-[180px] md:w-[200px] z-30 transform hover:-translate-y-1 transition-transform">
                        <div class="bg-[#272459] rounded-2xl p-4 shadow-2xl border border-white/10">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-[#3E50F7] p-0.5 shrink-0"><img src="https://i.pravatar.cc/150?img=68" class="rounded-full w-full h-full"></div>
                                <div>
                                    <div class="text-[10px] text-[#AFBBE0]">AI Advisor</div>
                                    <div class="text-xs text-white font-bold">Christian S.</div>
                                </div>
                            </div>
                            <div class="space-y-1.5 mt-3">
                                <div class="h-1.5 bg-white/10 rounded w-full"></div>
                                <div class="h-1.5 bg-white/10 rounded w-3/4"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Left Main Card -->
                    <div class="absolute top-[80px] left-0 w-[260px] md:w-[280px] z-20">
                        <div class="absolute -bottom-4 -right-4 w-full h-full bg-[#1e1b3d] rounded-2xl z-0 opacity-40 blur-md"></div>
                        <div class="bg-[#BAC8E8] rounded-2xl p-5 shadow-2xl border-b-[20px] border-[#8A9Ccc] relative text-[#25224A] z-10">
                            <div class="flex justify-between items-end mb-4">
                                <div class="font-bold text-lg tracking-tight">SaaS Startup</div>
                                <div class="font-black text-xl tracking-tighter text-[#3E50F7]">$1.5M</div>
                            </div>
                            <div class="space-y-1.5 mb-4">
                                <div class="h-1.5 bg-[#25224A]/15 rounded w-full"></div>
                                <div class="h-1.5 bg-[#25224A]/15 rounded w-5/6"></div>
                            </div>
                            <div class="grid grid-cols-2 gap-2 mb-2">
                                <div class="bg-white/40 p-2 rounded border border-white/40 h-20 flex flex-col justify-end">
                                    <div class="flex items-end gap-1 h-10">
                                       <div class="w-full bg-[#3E50F7]/40 rounded-t h-[40%] animate-[pulse_2s_ease-in-out_infinite]"></div>
                                       <div class="w-full bg-[#3E50F7]/60 rounded-t h-[70%] animate-[pulse_2s_ease-in-out_infinite_0.2s]"></div>
                                       <div class="w-full bg-[#3E50F7] rounded-t h-[90%] animate-[pulse_2s_ease-in-out_infinite_0.4s]"></div>
                                    </div>
                                </div>
                                <div class="bg-white/40 p-2 rounded border border-white/40 h-20 flex items-center justify-center">
                                    <div class="w-10 h-10 rounded-full border-[4px] border-[#25224A]/10 border-t-[#3E50F7] border-r-[#3E50F7] animate-[spin_3s_linear_infinite]"></div>
                                </div>
                            </div>
                            <div class="bg-white/40 p-2 rounded border border-white/40 h-16 flex items-end overflow-hidden">
                                <svg viewBox="0 0 100 40" class="w-full h-10" preserveAspectRatio="none">
                                    <path d="M0,40 L0,25 Q10,35 20,20 T40,25 T60,10 T80,15 L100,5 L100,40 Z" fill="rgba(62, 80, 247, 0.2)" />
                                </svg>
                            </div>
                            <!-- Dot -->
                            <div class="absolute -bottom-[26px] left-1/2 -translate-x-1/2 w-5 h-5 bg-white rounded-full shadow-[0_0_10px_rgba(255,255,255,1)] flex items-center justify-center z-30">
                                <div class="w-1.5 h-1.5 bg-[#8A9Ccc] rounded-full"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Main Card (Offset Vertically) -->
                    <div class="absolute top-[260px] right-0 w-[260px] md:w-[280px] z-20">
                        <div class="absolute -bottom-4 -right-4 w-full h-full bg-[#1e1b3d] rounded-2xl z-0 opacity-40 blur-md"></div>
                        <div class="bg-[#BAC8E8] rounded-2xl p-5 shadow-2xl border-b-[20px] border-[#8A9Ccc] relative text-[#25224A] z-10">
                            <!-- Connective Top Dot from previous path -->
                            <div class="absolute -top-[26px] left-1/2 -translate-x-1/2 w-5 h-5 bg-white rounded-full shadow-[0_0_10px_rgba(255,255,255,1)] flex items-center justify-center z-30">
                                <div class="w-1.5 h-1.5 bg-[#8A9Ccc] rounded-full"></div>
                            </div>
                            
                            <div class="flex items-center gap-3 mb-4">
                                <img src="https://i.pravatar.cc/150?img=11" class="w-12 h-12 rounded-full border-2 border-white shadow-sm">
                                <div>
                                    <div class="text-[9px] text-[#5F5770] uppercase font-bold">Buyer Profile</div>
                                    <div class="font-bold text-sm">Gabriel Smith</div>
                                    <div class="text-[9px] font-semibold text-green-700 mt-0.5">Verified funds: $2.3M</div>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-2 mb-4 bg-white/30 p-2 rounded-lg">
                                <div>
                                    <div class="text-[8px] text-[#5F5770] uppercase font-bold mb-0.5">Profile</div>
                                    <div class="font-bold text-xs">SaaS</div>
                                </div>
                                <div>
                                    <div class="text-[8px] text-[#5F5770] uppercase font-bold mb-0.5">Price range</div>
                                    <div class="font-bold text-[10px]">$1M - $5M</div>
                                </div>
                                <div>
                                    <div class="text-[8px] text-[#5F5770] uppercase font-bold mb-0.5">Closed</div>
                                    <div class="font-bold text-xs">7</div>
                                </div>
                            </div>
                            <div class="space-y-1.5 mb-4">
                                <div class="h-1.5 bg-[#25224A]/15 rounded w-full"></div>
                                <div class="h-1.5 bg-[#25224A]/15 rounded w-full"></div>
                                <div class="h-1.5 bg-[#25224A]/15 rounded w-3/4"></div>
                            </div>
                            <div class="flex gap-2">
                                <div class="flex-1 border border-[#25224A]/20 text-center py-2 rounded text-[10px] font-bold cursor-pointer hover:bg-white/30">Reject request</div>
                                <div class="flex-1 bg-[#3E50F7] text-white text-center py-2 rounded text-[10px] font-bold cursor-pointer hover:bg-[#0000EE] shadow-md shadow-[#3E50F7]/20">Approve request</div>
                            </div>
                            
                            <!-- Bottom Dot -->
                            <div class="absolute -bottom-[26px] left-1/2 -translate-x-1/2 w-5 h-5 bg-white rounded-full shadow-[0_0_10px_rgba(255,255,255,1)] flex items-center justify-center z-30">
                                <div class="w-1.5 h-1.5 bg-[#8A9Ccc] rounded-full"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ================= SLIDE 2 ================= -->
                <div class="absolute top-[600px] w-full h-[600px] transition-opacity duration-700" :class="activeSlide === 1 ? 'opacity-100' : 'opacity-30'">
                    <!-- Small Overlapping Card -->
                    <div class="absolute top-[40px] right-[260px] md:left-[180px] w-[180px] md:w-[200px] z-30 transform hover:-translate-y-1 transition-transform">
                        <div class="bg-[#272459] rounded-2xl p-4 shadow-2xl border border-white/10">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-green-500 p-0.5 shrink-0 flex items-center justify-center text-white"><span class="material-symbols-outlined text-[16px]">call</span></div>
                                <div>
                                    <div class="text-[10px] text-[#AFBBE0]">Connection</div>
                                    <div class="text-xs text-white font-bold">Secured E2E</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Left Main Card (Voice Update) -->
                    <div class="absolute top-[80px] left-0 w-[260px] md:w-[280px] z-20">
                        <div class="absolute -bottom-4 -right-4 w-full h-full bg-[#1e1b3d] rounded-2xl z-0 opacity-40 blur-md"></div>
                        <div class="bg-[#BAC8E8] rounded-2xl p-5 shadow-2xl border-b-[20px] border-[#8A9Ccc] relative text-[#25224A] z-10">
                            <!-- Connective Top Dot -->
                            <div class="absolute -top-[26px] left-1/2 -translate-x-1/2 w-5 h-5 bg-white rounded-full shadow-[0_0_10px_rgba(255,255,255,1)] flex items-center justify-center z-30">
                                <div class="w-1.5 h-1.5 bg-[#8A9Ccc] rounded-full"></div>
                            </div>

                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-12 h-12 rounded-full bg-white p-1 shadow-sm relative shrink-0">
                                    <img src="https://i.pravatar.cc/150?img=68" class="rounded-full w-full h-full" alt="AI">
                                    <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full animate-pulse"></div>
                                </div>
                                <div>
                                    <div class="text-[9px] text-[#5F5770] uppercase font-bold">Voice Update</div>
                                    <div class="font-bold text-sm">Business Companion</div>
                                </div>
                            </div>
                            
                            <div class="bg-white/40 p-3 rounded-lg border border-white/40 h-24 flex items-center justify-center gap-1 mb-4">
                                <div class="w-1.5 bg-[#3E50F7] rounded-full h-[40%] animate-[pulse_1s_ease-in-out_infinite]"></div>
                                <div class="w-1.5 bg-[#3E50F7] rounded-full h-[80%] animate-[pulse_1s_ease-in-out_infinite_0.1s]"></div>
                                <div class="w-1.5 bg-[#3E50F7] rounded-full h-[60%] animate-[pulse_1s_ease-in-out_infinite_0.2s]"></div>
                                <div class="w-1.5 bg-[#3E50F7] rounded-full h-[100%] animate-[pulse_1s_ease-in-out_infinite_0.3s]"></div>
                                <div class="w-1.5 bg-[#3E50F7] rounded-full h-[70%] animate-[pulse_1s_ease-in-out_infinite_0.4s]"></div>
                                <div class="w-1.5 bg-[#3E50F7] rounded-full h-[30%] animate-[pulse_1s_ease-in-out_infinite_0.5s]"></div>
                            </div>
                            
                            <!-- Bottom Dot -->
                            <div class="absolute -bottom-[26px] left-1/2 -translate-x-1/2 w-5 h-5 bg-white rounded-full shadow-[0_0_10px_rgba(255,255,255,1)] flex items-center justify-center z-30">
                                <div class="w-1.5 h-1.5 bg-[#8A9Ccc] rounded-full"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Main Card (Email Report) -->
                    <div class="absolute top-[260px] right-0 w-[260px] md:w-[280px] z-20">
                        <div class="absolute -bottom-4 -right-4 w-full h-full bg-[#1e1b3d] rounded-2xl z-0 opacity-40 blur-md"></div>
                        <div class="bg-[#BAC8E8] rounded-2xl p-5 shadow-2xl border-b-[20px] border-[#8A9Ccc] relative text-[#25224A] z-10">
                            <!-- Connective Top Dot -->
                            <div class="absolute -top-[26px] left-1/2 -translate-x-1/2 w-5 h-5 bg-white rounded-full shadow-[0_0_10px_rgba(255,255,255,1)] flex items-center justify-center z-30">
                                <div class="w-1.5 h-1.5 bg-[#8A9Ccc] rounded-full"></div>
                            </div>

                            <div class="font-bold text-lg tracking-tight mb-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-[#3E50F7]">mark_email_read</span> Final Report
                            </div>
                            <div class="bg-white/40 p-3 rounded-lg border border-white/40 mb-4 space-y-2">
                                <div class="h-2 bg-[#25224A]/20 rounded w-1/3"></div>
                                <div class="h-1.5 bg-[#25224A]/15 rounded w-full"></div>
                                <div class="h-1.5 bg-[#25224A]/15 rounded w-full"></div>
                                <div class="h-1.5 bg-[#25224A]/15 rounded w-4/5"></div>
                            </div>
                            <div class="flex gap-2">
                                <div class="flex-1 bg-[#3E50F7] text-white text-center py-2 rounded text-[10px] font-bold cursor-pointer hover:bg-[#0000EE] shadow-md shadow-[#3E50F7]/20">Forward to team</div>
                            </div>

                            <!-- Bottom Dot -->
                            <div class="absolute -bottom-[26px] left-1/2 -translate-x-1/2 w-5 h-5 bg-white rounded-full shadow-[0_0_10px_rgba(255,255,255,1)] flex items-center justify-center z-30">
                                <div class="w-1.5 h-1.5 bg-[#8A9Ccc] rounded-full"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ================= SLIDE 3 ================= -->
                <div class="absolute top-[1200px] w-full h-[600px] transition-opacity duration-700" :class="activeSlide === 2 ? 'opacity-100' : 'opacity-30'">
                    <!-- Small Overlapping Card -->
                    <div class="absolute top-[40px] right-[260px] md:left-[180px] w-[180px] md:w-[200px] z-30 transform hover:-translate-y-1 transition-transform">
                        <div class="bg-[#272459] rounded-2xl p-4 shadow-2xl border border-white/10">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-[#3E50F7] p-0.5 shrink-0 flex items-center justify-center text-white"><span class="material-symbols-outlined text-[16px]">speed</span></div>
                                <div>
                                    <div class="text-[10px] text-[#AFBBE0]">Performance</div>
                                    <div class="text-xs text-white font-bold">Optimized route</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Left Main Card (Model Selection) -->
                    <div class="absolute top-[80px] left-0 w-[260px] md:w-[280px] z-20">
                        <div class="absolute -bottom-4 -right-4 w-full h-full bg-[#1e1b3d] rounded-2xl z-0 opacity-40 blur-md"></div>
                        <div class="bg-[#BAC8E8] rounded-2xl p-5 shadow-2xl border-b-[20px] border-[#8A9Ccc] relative text-[#25224A] z-10">
                            <!-- Connective Top Dot -->
                            <div class="absolute -top-[26px] left-1/2 -translate-x-1/2 w-5 h-5 bg-white rounded-full shadow-[0_0_10px_rgba(255,255,255,1)] flex items-center justify-center z-30">
                                <div class="w-1.5 h-1.5 bg-[#8A9Ccc] rounded-full"></div>
                            </div>

                            <div class="font-bold text-lg mb-4 tracking-tight">Select Intelligence</div>
                            
                            <div class="bg-white/60 rounded-xl p-3 mb-2 border border-[#3E50F7]/30 shadow-md relative overflow-hidden cursor-pointer">
                                <div class="absolute left-0 top-0 w-1.5 h-full bg-[#3E50F7]"></div>
                                <div class="flex items-center justify-between pl-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded bg-[#3E50F7]/10 flex items-center justify-center text-[#3E50F7]">
                                            <span class="material-symbols-outlined text-[16px]">smart_toy</span>
                                        </div>
                                        <div>
                                            <div class="text-xs font-bold text-[#25224A]">GPT-4o</div>
                                            <div class="text-[9px] text-[#5F5770] font-semibold uppercase">Active</div>
                                        </div>
                                    </div>
                                    <span class="material-symbols-outlined text-[#3E50F7] text-lg">check_circle</span>
                                </div>
                            </div>

                            <div class="bg-white/30 rounded-xl p-3 border border-[#25224A]/10 cursor-pointer">
                                <div class="flex items-center justify-between pl-1">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded bg-[#25224A]/5 flex items-center justify-center text-[#5F5770]">
                                            <span class="material-symbols-outlined text-[16px]">psychology</span>
                                        </div>
                                        <div>
                                            <div class="text-xs font-bold text-[#5F5770]">Claude 3.5 Sonnet</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Bottom Dot -->
                            <div class="absolute -bottom-[26px] left-1/2 -translate-x-1/2 w-5 h-5 bg-white rounded-full shadow-[0_0_10px_rgba(255,255,255,1)] flex items-center justify-center z-30">
                                <div class="w-1.5 h-1.5 bg-[#8A9Ccc] rounded-full"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Main Card (Security) -->
                    <div class="absolute top-[260px] right-0 w-[260px] md:w-[280px] z-20">
                        <div class="absolute -bottom-4 -right-4 w-full h-full bg-[#1e1b3d] rounded-2xl z-0 opacity-40 blur-md"></div>
                        <div class="bg-[#BAC8E8] rounded-2xl p-5 shadow-2xl border-b-[20px] border-[#8A9Ccc] relative text-[#25224A] z-10">
                            <!-- Connective Top Dot -->
                            <div class="absolute -top-[26px] left-1/2 -translate-x-1/2 w-5 h-5 bg-white rounded-full shadow-[0_0_10px_rgba(255,255,255,1)] flex items-center justify-center z-30">
                                <div class="w-1.5 h-1.5 bg-[#8A9Ccc] rounded-full"></div>
                            </div>

                            <div class="font-bold text-lg mb-4 tracking-tight flex items-center gap-2">
                                <span class="material-symbols-outlined text-green-600">shield</span> Cloud Sandbox
                            </div>
                            
                            <div class="space-y-3">
                                <div class="flex items-center gap-2 text-xs font-semibold">
                                    <span class="material-symbols-outlined text-[14px] text-green-600">check</span> Data isolated
                                </div>
                                <div class="flex items-center gap-2 text-xs font-semibold">
                                    <span class="material-symbols-outlined text-[14px] text-green-600">check</span> No training on data
                                </div>
                                <div class="flex items-center gap-2 text-xs font-semibold">
                                    <span class="material-symbols-outlined text-[14px] text-green-600">check</span> SOC 2 Compliant
                                </div>
                            </div>

                            <div class="bg-green-500/10 text-green-700 text-[10px] font-bold text-center py-2 rounded mt-4 border border-green-500/20">System secure</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
      </div>
"""
    content = content[:start_idx] + new_graphics + content[end_idx:]

    with open("resources/views/welcome.blade.php", "w") as f:
        f.write(content)

