import re

with open("resources/views/welcome.blade.php", "r") as f:
    content = f.read()

# Locate the outer grid and replace the hero graphics section
start_marker = '<!-- Hero Graphics (Left Section) -->'
end_marker = '<!-- Hero Text (Right Section) -->'

start_idx = content.find(start_marker)
end_idx = content.find(end_marker)

if start_idx != -1 and end_idx != -1:
    new_graphics = """      <!-- Hero Graphics (Left Section) -->
      <div class="order-2 lg:order-2 relative w-full h-[450px] md:h-[550px] flex justify-center items-start overflow-hidden pt-4" style="-webkit-mask-image: linear-gradient(to bottom, black 70%, transparent 100%); mask-image: linear-gradient(to bottom, black 70%, transparent 100%);">
        
        <div class="w-full transition-transform duration-1000 ease-in-out z-20" :style="`transform: translateY(-${activeSlide * 400}px)`">
            <div class="relative w-full max-w-[500px] mx-auto h-[1300px]">
                
                <!-- Connective SVG Layer -->
                <svg viewBox="0 0 500 1300" class="absolute top-0 left-0 w-full h-full z-0 pointer-events-none">
                    <!-- Dotted Lines -->
                    <g fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="2" stroke-dasharray="4 6" stroke-linecap="round">
                        <!-- Path A -->
                        <path d="M 260 80 L 260 250 Q 260 270 280 270 L 310 270 Q 330 270 330 290 L 330 420" />
                        <!-- Path B -->
                        <path d="M 160 380 L 160 420 Q 160 440 140 440 L 120 440 Q 100 440 100 460 L 100 520" />
                        <!-- Path C -->
                        <path d="M 330 740 L 330 800 Q 330 820 310 820 L 180 820 Q 160 820 160 840 L 160 860" />
                    </g>

                    <!-- Pulsing Dashes -->
                    <g fill="none" stroke="#3E50F7" stroke-width="4" stroke-linecap="round" style="filter: drop-shadow(0 0 8px #3E50F7);">
                        <path d="M 260 80 L 260 250 Q 260 270 280 270 L 310 270 Q 330 270 330 290 L 330 420" pathLength="100" stroke-dasharray="15 100">
                            <animate attributeName="stroke-dashoffset" from="100" to="-15" dur="3s" repeatCount="indefinite" />
                        </path>
                        <path d="M 160 380 L 160 420 Q 160 440 140 440 L 120 440 Q 100 440 100 460 L 100 520" pathLength="100" stroke-dasharray="15 100">
                            <animate attributeName="stroke-dashoffset" from="100" to="-15" dur="2.5s" repeatCount="indefinite" begin="1s" />
                        </path>
                        <path d="M 330 740 L 330 800 Q 330 820 310 820 L 180 820 Q 160 820 160 840 L 160 860" pathLength="100" stroke-dasharray="15 100">
                            <animate attributeName="stroke-dashoffset" from="100" to="-15" dur="3s" repeatCount="indefinite" begin="0.5s" />
                        </path>
                    </g>
                </svg>

                <!-- SLIDE 1 (y = 0 to 400) -->
                <!-- Top-Right Dark Skeleton Card -->
                <div class="absolute top-[40px] right-[40px] w-[220px] z-10 transition-all duration-700" :class="activeSlide === 0 ? 'opacity-100 scale-100' : 'opacity-30 scale-95 translate-y-4'">
                    <div class="bg-[#272459] rounded-2xl p-5 shadow-2xl border border-white/10">
                        <div class="flex justify-between items-center mb-4">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-[#3E50F7] to-[#2bd9ff] p-0.5">
                                <img src="https://i.pravatar.cc/150?img=68" class="rounded-full w-full h-full" alt="AI">
                            </div>
                            <div class="text-[10px] uppercase tracking-wider text-green-400 font-bold animate-pulse">Running</div>
                        </div>
                        <div class="space-y-2">
                            <div class="h-2 bg-white/10 rounded w-full"></div>
                            <div class="h-2 bg-white/10 rounded w-3/4"></div>
                        </div>
                    </div>
                </div>

                <!-- Left Main Card (Market Analysis) -->
                <div class="absolute top-[80px] left-[0px] w-[320px] z-20 transition-all duration-700 origin-bottom" :class="activeSlide === 0 ? 'opacity-100 scale-100' : 'opacity-40 scale-95 translate-y-4'">
                    <div class="absolute -bottom-4 -right-4 w-full h-full bg-[#1e1b3d] rounded-2xl z-0 opacity-40 blur-md"></div>
                    
                    <div class="bg-[#BAC8E8] rounded-2xl p-6 shadow-2xl border-b-[24px] border-[#8A9Ccc] relative z-10 text-[#25224A]">
                        <div class="flex justify-between items-end mb-4">
                            <div class="font-bold text-xl tracking-tight">Market Analysis</div>
                            <div class="font-black text-2xl tracking-tighter text-[#3E50F7]">99%</div>
                        </div>
                        <div class="space-y-2 mb-6">
                            <div class="h-1.5 bg-[#25224A]/15 rounded w-full"></div>
                            <div class="h-1.5 bg-[#25224A]/15 rounded w-5/6"></div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <!-- Bar chart widget -->
                            <div class="bg-white/40 p-3 rounded-lg border border-white/40 h-24 flex flex-col justify-end">
                                <div class="flex items-end gap-1.5 h-12">
                                   <div class="w-full bg-[#3E50F7]/40 rounded-t h-[40%] animate-[pulse_2s_ease-in-out_infinite]"></div>
                                   <div class="w-full bg-[#3E50F7]/60 rounded-t h-[70%] animate-[pulse_2s_ease-in-out_infinite_0.2s]"></div>
                                   <div class="w-full bg-[#3E50F7] rounded-t h-[90%] animate-[pulse_2s_ease-in-out_infinite_0.4s]"></div>
                                   <div class="w-full bg-[#25224A]/20 rounded-t h-[30%]"></div>
                                </div>
                            </div>
                            <!-- Donut chart widget -->
                            <div class="bg-white/40 p-3 rounded-lg border border-white/40 h-24 flex flex-col items-center justify-center">
                                <div class="w-12 h-12 rounded-full border-[5px] border-[#25224A]/10 border-t-[#3E50F7] border-r-[#3E50F7] animate-[spin_3s_linear_infinite]"></div>
                            </div>
                        </div>
                        
                        <!-- Area chart widget -->
                        <div class="bg-white/40 p-3 rounded-lg border border-white/40 h-20 relative overflow-hidden flex items-end">
                            <div class="absolute top-3 left-3 h-1.5 bg-[#25224A]/15 rounded w-1/3"></div>
                            <svg viewBox="0 0 100 40" class="w-full h-12 drop-shadow-md" preserveAspectRatio="none">
                                <path d="M0,40 L0,25 Q10,35 20,20 T40,25 T60,10 T80,15 L100,5 L100,40 Z" fill="rgba(62, 80, 247, 0.2)" />
                                <path d="M0,25 Q10,35 20,20 T40,25 T60,10 T80,15 L100,5" fill="none" stroke="#3E50F7" stroke-width="2.5" />
                            </svg>
                        </div>

                        <!-- White Connecting Dot -->
                        <div class="absolute -bottom-[36px] left-1/2 -translate-x-1/2 w-6 h-6 bg-white rounded-full shadow-[0_0_15px_rgba(255,255,255,1)] flex items-center justify-center z-30">
                            <div class="w-2 h-2 bg-[#8A9Ccc] rounded-full"></div>
                        </div>
                    </div>
                </div>


                <!-- SLIDE 2 (y = 400 to 800) -->
                <!-- Bottom-Left Dark Skeleton Card -->
                <div class="absolute top-[520px] left-[0px] w-[200px] z-10 transition-all duration-700" :class="activeSlide === 1 ? 'opacity-100 scale-100' : 'opacity-30 scale-95 translate-y-4'">
                    <div class="bg-[#272459] rounded-2xl p-4 shadow-2xl border border-white/10">
                        <div class="h-2 w-1/2 bg-green-400/50 rounded mb-4"></div>
                        <div class="space-y-3">
                            <div class="h-2 bg-white/10 rounded w-full"></div>
                            <div class="h-2 bg-white/10 rounded w-full"></div>
                            <div class="h-2 bg-white/10 rounded w-3/4"></div>
                        </div>
                    </div>
                </div>

                <!-- Right Main Card (Voice Update) -->
                <div class="absolute top-[420px] right-[0px] w-[340px] z-20 transition-all duration-700 origin-bottom" :class="activeSlide === 1 ? 'opacity-100 scale-100' : 'opacity-40 scale-95 translate-y-4'">
                    <div class="absolute -bottom-4 -right-4 w-full h-full bg-[#1e1b3d] rounded-2xl z-0 opacity-40 blur-md"></div>
                    
                    <div class="bg-[#BAC8E8] rounded-2xl p-6 shadow-2xl border-b-[24px] border-[#8A9Ccc] relative z-10 text-[#25224A]">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-16 h-16 rounded-full bg-white p-1 shadow-sm relative shrink-0">
                                <img src="https://i.pravatar.cc/150?img=68" class="rounded-full w-full h-full" alt="AI">
                                <div class="absolute bottom-0 right-0 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></div>
                            </div>
                            <div>
                                <div class="text-[10px] text-[#5F5770] font-bold uppercase tracking-wider mb-1">Incoming Voice Update</div>
                                <div class="font-bold text-xl leading-tight tracking-tight">Business Companion</div>
                                <div class="text-[11px] font-semibold text-[#25224A] mt-1 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[12px] text-green-600">verified</span> Verified connection
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-3 gap-3 mb-6">
                            <div class="text-left bg-white/30 p-2.5 rounded-lg border border-white/40">
                                <div class="text-[9px] text-[#5F5770] uppercase font-bold tracking-wider mb-1">Status</div>
                                <div class="font-bold text-[11px]">Calling...</div>
                            </div>
                            <div class="text-left bg-white/30 p-2.5 rounded-lg border border-white/40">
                                <div class="text-[9px] text-[#5F5770] uppercase font-bold tracking-wider mb-1">Task</div>
                                <div class="font-bold text-[11px]">Research</div>
                            </div>
                            <div class="text-left bg-white/30 p-2.5 rounded-lg border border-white/40">
                                <div class="text-[9px] text-[#5F5770] uppercase font-bold tracking-wider mb-1">Saved</div>
                                <div class="font-bold text-[11px]">4 hrs</div>
                            </div>
                        </div>

                        <div class="space-y-2 mb-6">
                            <div class="h-1.5 bg-[#25224A]/20 rounded w-full"></div>
                            <div class="h-1.5 bg-[#25224A]/20 rounded w-full"></div>
                            <div class="h-1.5 bg-[#25224A]/20 rounded w-5/6"></div>
                        </div>

                        <div class="flex gap-4">
                            <div class="flex-1 bg-white/40 border border-[#25224A]/10 hover:bg-white/60 text-[#25224A] py-3 rounded-lg flex justify-center items-center cursor-pointer transition text-xs font-bold shadow-sm">
                                Reject request
                            </div>
                            <div class="flex-1 bg-[#3E50F7] hover:bg-[#0000EE] text-white py-3 rounded-lg flex justify-center items-center cursor-pointer transition shadow-lg shadow-[#3E50F7]/30 text-xs font-bold">
                                Answer call
                            </div>
                        </div>

                        <!-- White Connecting Dot -->
                        <div class="absolute -bottom-[36px] left-1/2 -translate-x-1/2 w-6 h-6 bg-white rounded-full shadow-[0_0_15px_rgba(255,255,255,1)] flex items-center justify-center z-30">
                            <div class="w-2 h-2 bg-[#8A9Ccc] rounded-full"></div>
                        </div>
                    </div>
                </div>


                <!-- SLIDE 3 (y = 800 to 1200) -->
                <!-- Bottom-Right Dark Skeleton Card -->
                <div class="absolute top-[960px] right-[40px] w-[200px] z-10 transition-all duration-700" :class="activeSlide === 2 ? 'opacity-100 scale-100' : 'opacity-30 scale-95 translate-y-4'">
                    <div class="bg-[#272459] rounded-2xl p-5 shadow-2xl border border-white/10">
                        <div class="h-3 w-1/3 bg-[#3E50F7] rounded mb-4"></div>
                        <div class="space-y-2">
                            <div class="h-2 bg-white/10 rounded w-full"></div>
                            <div class="h-2 bg-white/10 rounded w-4/5"></div>
                        </div>
                    </div>
                </div>

                <!-- Left Main Card (Model Selection) -->
                <div class="absolute top-[860px] left-[0px] w-[320px] z-20 transition-all duration-700 origin-bottom" :class="activeSlide === 2 ? 'opacity-100 scale-100' : 'opacity-40 scale-95 translate-y-4'">
                    <div class="absolute -bottom-4 -right-4 w-full h-full bg-[#1e1b3d] rounded-2xl z-0 opacity-40 blur-md"></div>
                    
                    <div class="bg-[#BAC8E8] rounded-2xl p-6 shadow-2xl border-b-[24px] border-[#8A9Ccc] relative z-10 text-[#25224A]">
                        <div class="font-bold text-xl mb-6 tracking-tight">Select Intelligence</div>
                        
                        <div class="bg-white/60 rounded-xl p-4 mb-3 border border-[#3E50F7]/30 shadow-md relative overflow-hidden group hover:scale-[1.02] transition-transform cursor-pointer">
                            <div class="absolute left-0 top-0 w-1.5 h-full bg-[#3E50F7]"></div>
                            <div class="flex items-center justify-between mb-3 pl-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded bg-[#3E50F7]/10 flex items-center justify-center text-[#3E50F7]">
                                        <span class="material-symbols-outlined text-[20px]">smart_toy</span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-[#25224A]">GPT-4o</div>
                                        <div class="text-[10px] text-[#5F5770] font-semibold uppercase tracking-wider">Active</div>
                                    </div>
                                </div>
                                <span class="material-symbols-outlined text-[#3E50F7] text-xl">check_circle</span>
                            </div>
                            <div class="pl-3 space-y-1.5">
                                <div class="h-1.5 bg-[#25224A]/15 rounded w-full"></div>
                                <div class="h-1.5 bg-[#25224A]/15 rounded w-2/3"></div>
                            </div>
                        </div>

                        <div class="bg-white/30 rounded-xl p-4 mb-3 border border-[#25224A]/10 hover:bg-white/50 cursor-pointer transition-colors group">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded bg-[#25224A]/5 flex items-center justify-center text-[#5F5770] group-hover:text-[#3E50F7] transition-colors">
                                        <span class="material-symbols-outlined text-[20px]">psychology</span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-[#5F5770] group-hover:text-[#25224A] transition-colors">Claude 3.5 Sonnet</div>
                                        <div class="text-[10px] text-[#5F5770]/60 font-semibold uppercase tracking-wider">Available</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-[#25224A]/5 h-10 rounded-xl mt-4 w-full border border-[#25224A]/10 flex items-center px-4">
                            <div class="h-2 w-1/3 bg-[#25224A]/20 rounded"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Slider Indicators -->
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-30">
            <div class="h-1.5 rounded-full transition-all duration-300 cursor-pointer" @click="activeSlide = 0" :class="activeSlide === 0 ? 'w-6 bg-[#3E50F7]' : 'w-2 bg-white/20'"></div>
            <div class="h-1.5 rounded-full transition-all duration-300 cursor-pointer" @click="activeSlide = 1" :class="activeSlide === 1 ? 'w-6 bg-[#3E50F7]' : 'w-2 bg-white/20'"></div>
            <div class="h-1.5 rounded-full transition-all duration-300 cursor-pointer" @click="activeSlide = 2" :class="activeSlide === 2 ? 'w-6 bg-[#3E50F7]' : 'w-2 bg-white/20'"></div>
        </div>
      </div>
"""

    content = content[:start_idx] + new_graphics + content[end_idx:]

    with open("resources/views/welcome.blade.php", "w") as f:
        f.write(content)
