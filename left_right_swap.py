import re

with open("resources/views/welcome.blade.php", "r") as f:
    content = f.read()

# Replace the inner parts of the grid with the new swapped structure
# The grid starts at <div class="max-w-7xl mx-auto px-6 md:px-12 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center" ...>
# And ends before <!-- Stats Section -->

grid_start_idx = content.find('<div class="max-w-7xl mx-auto px-6 md:px-12 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center"')
stats_start_idx = content.find('<!-- Stats Section -->')

if grid_start_idx != -1 and stats_start_idx != -1:
    before_grid = content[:grid_start_idx]
    
    # We will close the grid manually.
    grid_start_tag = content[grid_start_idx:content.find('>', grid_start_idx) + 1]

    new_grid_content = grid_start_tag + """
      <!-- Hero Graphics (Left Section) -->
      <div class="order-2 lg:order-1 relative w-full h-[450px] md:h-[500px] flex justify-center items-start overflow-hidden pt-4" style="-webkit-mask-image: linear-gradient(to bottom, black 80%, transparent 100%); mask-image: linear-gradient(to bottom, black 80%, transparent 100%);">
        
        <div class="w-full transition-transform duration-1000 ease-in-out z-20" :style="`transform: translateY(-${activeSlide * 380}px)`">
            <div class="relative w-full max-w-[400px] mx-auto h-[1200px]">
                
                <!-- Connecting lines SVG -->
                <svg viewBox="0 0 400 1200" class="absolute top-0 left-0 w-full h-full z-0 pointer-events-none" fill="none" stroke="rgba(255,255,255,0.15)" stroke-width="2" stroke-dasharray="6 6">
                    <!-- Path 1 -->
                    <path d="M 150 260 L 150 330 Q 150 350 170 350 L 230 350 Q 250 350 250 370 L 250 420" />
                    <circle cx="250" cy="390" r="6" fill="#fff" style="filter: drop-shadow(0 0 8px #fff);" />

                    <!-- Path 2 -->
                    <path d="M 250 640 L 250 700 Q 250 720 230 720 L 170 720 Q 150 720 150 740 L 150 800" />
                    <circle cx="150" cy="770" r="6" fill="#fff" style="filter: drop-shadow(0 0 8px #fff);" />
                </svg>

                <!-- Widget 1: Task Assignment (Top Left) -->
                <div class="absolute top-[40px] left-0 w-[300px] z-10 transition-all duration-700" :class="activeSlide === 0 ? 'opacity-100 scale-100' : 'opacity-40 scale-95'">
                    <div class="bg-[#BAC8E8] rounded-2xl p-6 shadow-xl text-[#25224A]">
                        <div class="flex justify-between items-end mb-6">
                            <div class="font-bold text-xl tracking-tight">Delegated Task</div>
                            <div class="font-black text-2xl tracking-tighter">Urgent</div>
                        </div>
                        <div class="space-y-3 mb-6">
                            <div class="h-3 bg-[#25224A]/15 rounded w-full"></div>
                            <div class="h-3 bg-[#25224A]/15 rounded w-5/6"></div>
                            <div class="h-3 bg-[#25224A]/15 rounded w-4/6"></div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="h-12 bg-[#25224A]/10 rounded flex items-center px-3 gap-2">
                                <div class="w-4 h-4 rounded-full bg-[#3E50F7]"></div>
                                <div class="h-2 w-12 bg-[#25224A]/20 rounded"></div>
                            </div>
                            <div class="h-12 bg-[#25224A]/10 rounded flex items-center px-3 gap-2">
                                <div class="w-4 h-4 rounded-full bg-green-500"></div>
                                <div class="h-2 w-12 bg-[#25224A]/20 rounded"></div>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-[#25224A]/10 space-y-2">
                            <div class="h-2 bg-[#25224A]/15 rounded w-full"></div>
                            <div class="h-2 bg-[#25224A]/15 rounded w-full"></div>
                        </div>
                    </div>
                    
                    <!-- Overlapping profile card -->
                    <div class="absolute -right-8 -top-6 bg-[#272459] rounded-xl p-3 shadow-2xl border border-white/10 z-20 w-[180px]">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-[#3E50F7] p-0.5 relative shrink-0">
                                <img src="https://i.pravatar.cc/150?img=68" class="rounded-full w-full h-full" alt="AI">
                                <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-400 border-2 border-[#272459] rounded-full"></div>
                            </div>
                            <div>
                                <div class="text-[10px] text-[#AFBBE0]">AI Companion</div>
                                <div class="text-xs text-white font-bold">On it!</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Widget 2: Voice Call (Middle Right) -->
                <div class="absolute top-[420px] right-0 w-[320px] z-10 transition-all duration-700" :class="activeSlide === 1 ? 'opacity-100 scale-100' : 'opacity-40 scale-95'">
                    <div class="bg-[#BAC8E8] rounded-2xl p-6 shadow-xl text-[#25224A]">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-16 h-16 rounded-full bg-white p-1 shadow-sm relative shrink-0">
                                <img src="https://i.pravatar.cc/150?img=68" class="rounded-full w-full h-full" alt="AI">
                                <div class="absolute bottom-0 right-0 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></div>
                            </div>
                            <div class="text-right">
                                <div class="text-xs text-[#5F5770] font-medium">Incoming Call</div>
                                <div class="font-bold text-lg leading-tight tracking-tight">Business Companion</div>
                                <div class="text-[11px] font-semibold text-green-700 mt-1 flex items-center justify-end gap-1">
                                    <span class="material-symbols-outlined text-[12px]">lock</span> Encrypted
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3 mb-6">
                            <div class="text-center bg-[#25224A]/5 p-3 rounded-xl border border-[#25224A]/10">
                                <div class="text-[10px] text-[#5F5770] uppercase font-bold tracking-wider mb-1">Status</div>
                                <div class="font-bold text-sm">Completed</div>
                            </div>
                            <div class="text-center bg-[#25224A]/5 p-3 rounded-xl border border-[#25224A]/10">
                                <div class="text-[10px] text-[#5F5770] uppercase font-bold tracking-wider mb-1">Time Saved</div>
                                <div class="font-bold text-sm">4.5 hrs</div>
                            </div>
                        </div>

                        <div class="space-y-2 mb-6 opacity-70">
                            <div class="h-2 bg-[#25224A]/20 rounded w-full"></div>
                            <div class="h-2 bg-[#25224A]/20 rounded w-full"></div>
                            <div class="h-2 bg-[#25224A]/20 rounded w-3/4"></div>
                        </div>

                        <div class="flex gap-4">
                            <div class="flex-1 bg-white/40 border border-[#25224A]/10 hover:bg-white/60 text-[#25224A] py-3 rounded-lg flex justify-center items-center cursor-pointer transition text-xs font-bold shadow-sm">
                                Email Report
                            </div>
                            <div class="flex-1 bg-[#3E50F7] hover:bg-[#0000EE] text-white py-3 rounded-lg flex justify-center items-center cursor-pointer transition shadow-lg shadow-[#3E50F7]/30 text-xs font-bold">
                                Answer Call
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Widget 3: Model Selection (Bottom Left) -->
                <div class="absolute top-[800px] left-0 w-[300px] z-10 transition-all duration-700" :class="activeSlide === 2 ? 'opacity-100 scale-100' : 'opacity-40 scale-95'">
                    <div class="bg-[#BAC8E8] rounded-2xl p-6 shadow-xl text-[#25224A]">
                        <div class="font-bold text-xl mb-4 tracking-tight">Select Intelligence</div>
                        
                        <div class="bg-white/60 rounded-xl p-4 mb-3 border border-[#3E50F7]/30 shadow-sm relative overflow-hidden">
                            <div class="absolute left-0 top-0 w-1 h-full bg-[#3E50F7]"></div>
                            <div class="flex items-center justify-between mb-3 pl-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded bg-[#3E50F7]/10 flex items-center justify-center text-[#3E50F7]">
                                        <span class="material-symbols-outlined text-sm">smart_toy</span>
                                    </div>
                                    <span class="text-sm font-bold">GPT-4o</span>
                                </div>
                                <span class="material-symbols-outlined text-[#3E50F7] text-lg">check_circle</span>
                            </div>
                            <div class="pl-2">
                                <div class="h-2 bg-[#25224A]/15 rounded w-full mb-2"></div>
                                <div class="h-2 bg-[#25224A]/15 rounded w-2/3"></div>
                            </div>
                        </div>

                        <div class="bg-white/30 rounded-xl p-4 mb-3 border border-[#25224A]/10 hover:bg-white/50 cursor-pointer transition">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded bg-[#25224A]/5 flex items-center justify-center text-[#5F5770]">
                                        <span class="material-symbols-outlined text-sm">psychology</span>
                                    </div>
                                    <span class="text-sm font-bold text-[#5F5770]">Claude 3.5</span>
                                </div>
                            </div>
                            <div class="h-2 bg-[#25224A]/15 rounded w-full mb-2"></div>
                            <div class="h-2 bg-[#25224A]/15 rounded w-1/2"></div>
                        </div>
                        
                        <div class="bg-[#25224A]/5 h-8 rounded mt-4 w-full border border-[#25224A]/10"></div>
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

      <!-- Hero Text (Right Section) -->
      <div class="order-1 lg:order-2 space-y-8 lg:pl-8 relative z-10 flex flex-col justify-center h-full">
         <h1 class="text-4xl md:text-5xl lg:text-[56px] font-bold text-white leading-[1.1] tracking-tight">
            A Smart Business Companion for High Achievers
         </h1>
         
         <div class="h-[80px] md:h-[60px] overflow-hidden text-[#AFBBE0] text-xl md:text-[22px] font-medium relative mask-image-bottom">
           <div class="animate-text-slide absolute top-0 left-0 w-full flex flex-col">
              <div class="h-[80px] md:h-[60px] flex items-center">Overcome trust issues & procrastination.</div>
              <div class="h-[80px] md:h-[60px] flex items-center">Solve business problems you can't share.</div>
              <div class="h-[80px] md:h-[60px] flex items-center">Assign tasks & get updates via voice calls.</div>
              <div class="h-[80px] md:h-[60px] flex items-center">Choose the best AI models for the job.</div>
              <div class="h-[80px] md:h-[60px] flex items-center">Overcome trust issues & procrastination.</div>
           </div>
         </div>

         <!-- Buttons and Rating -->
         <div class="pt-2">
              <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <button @click="waitlistModalOpen = true" class="px-8 py-3.5 bg-[#3E50F7] hover:bg-[#0000EE] text-white font-semibold rounded-lg transition-all text-base flex items-center gap-2 shadow-lg shadow-[#3E50F7]/20">
                  Join Waitlist <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </button>
                <button class="px-8 py-3.5 bg-transparent border border-white/20 hover:border-white/40 hover:bg-white/5 text-white font-semibold rounded-lg transition-all text-base flex items-center gap-2">
                  <span class="material-symbols-outlined text-[22px]">play_circle</span> Our story
                </button>
              </div>
              <div class="flex items-center gap-3 pt-6 text-sm text-[#AFBBE0]">
                <div class="flex text-yellow-400 text-[16px] tracking-widest">
                  ★★★★★
                </div>
                <p>4.9 average rating based on 500+ reviews</p>
              </div>
         </div>
      </div>
    </div>
  </section>
"""

    after_grid = content[content.find('</section>', grid_start_idx):]

    final_content = before_grid + new_grid_content + after_grid
    
    with open("resources/views/welcome.blade.php", "w") as f:
        f.write(final_content)
