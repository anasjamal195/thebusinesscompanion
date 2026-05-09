with open("resources/views/welcome.blade.php", "r") as f:
    content = f.read()

# Replace left section
old_left_section = """      <div class="space-y-6 pr-0 lg:pr-8 relative z-10 flex flex-col justify-center h-full">
         
         <div class="overflow-hidden h-[280px] md:h-[320px] w-full relative mask-image-bottom">
             <div class="transition-transform duration-700 ease-in-out w-full absolute top-0 left-0" :style="`transform: translateY(-${activeSlide * 100}%)`">
                 
                 <!-- Slide 1 Text -->
                 <div class="h-[280px] md:h-[320px] w-full flex flex-col justify-start space-y-6 pt-2">
                     <h1 class="text-4xl md:text-5xl lg:text-[56px] font-bold text-white leading-[1.1] tracking-tight">
                        Overcome trust issues & procrastination
                     </h1>
                     <p class="text-lg md:text-[19px] text-[#AFBBE0] leading-relaxed max-w-lg">
                        If you are a millionaire or want to become one, you need a smart business companion. Delegate tasks autonomously without sharing insecurities with your team.
                     </p>
                 </div>
                 
                 <!-- Slide 2 Text -->
                 <div class="h-[280px] md:h-[320px] w-full flex flex-col justify-start space-y-6 pt-2">
                     <h1 class="text-4xl md:text-5xl lg:text-[56px] font-bold text-white leading-[1.1] tracking-tight">
                        Solve business problems you can't share
                     </h1>
                     <p class="text-lg md:text-[19px] text-[#AFBBE0] leading-relaxed max-w-lg">
                        Assign tasks, explain the issue on call, and get proactive updates. Discuss queries, completion status, and your next directions effortlessly.
                     </p>
                 </div>

                 <!-- Slide 3 Text -->
                 <div class="h-[280px] md:h-[320px] w-full flex flex-col justify-start space-y-6 pt-2">
                     <h1 class="text-4xl md:text-5xl lg:text-[56px] font-bold text-white leading-[1.1] tracking-tight">
                        Choose the best AI models for the job
                     </h1>
                     <p class="text-lg md:text-[19px] text-[#AFBBE0] leading-relaxed max-w-lg">
                        Maximize your productivity by choosing the most suitable AI models for your specific tasks through our unified business companion platform.
                     </p>
                 </div>

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
      </div>"""

new_left_section = """      <div class="space-y-8 pr-0 lg:pr-8 relative z-10 flex flex-col justify-center h-full">
         <h1 class="text-4xl md:text-5xl lg:text-[56px] font-bold text-white leading-[1.1] tracking-tight">
            A Smart Business Companion for High Achievers
         </h1>
         
         <div class="h-[80px] md:h-[60px] overflow-hidden text-[#AFBBE0] text-xl md:text-[22px] font-medium relative">
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
      </div>"""

content = content.replace(old_left_section, new_left_section)

# Replace right section
old_right_section = """      <!-- Hero Graphics -->
      <div class="relative w-full h-[500px] flex justify-center items-center">
        
        <!-- Slide 1: Task Assignment -->
        <div x-show="activeSlide === 0" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-8" class="absolute w-[80%] max-w-[400px] bg-[#272459] rounded-2xl border border-white/10 shadow-2xl z-20 flex flex-col overflow-hidden">
            <div class="h-10 border-b border-white/5 flex items-center px-4 gap-2 bg-[#25224A]">
                <div class="flex items-center gap-2"><span class="material-symbols-outlined text-sm text-[#AFBBE0]">task</span><span class="text-xs text-[#AFBBE0] font-medium">Task Assignment</span></div>
            </div>
            <div class="p-6 flex flex-col gap-4">
                <div class="flex gap-3 items-start">
                    <div class="w-8 h-8 rounded-full bg-[#3E50F7] flex items-center justify-center text-white text-xs">You</div>
                    <div class="bg-white/10 p-3 rounded-lg rounded-tl-none text-sm text-white/90">Analyze our competitor's new pricing and summarize it.</div>
                </div>
                <div class="flex gap-3 items-start flex-row-reverse">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-[#3E50F7] to-[#2bd9ff] p-[2px]"><img src="https://i.pravatar.cc/150?img=68" class="rounded-full" alt="AI"></div>
                    <div class="bg-[#3E50F7]/20 p-3 rounded-lg rounded-tr-none text-sm text-white/90 border border-[#3E50F7]/30">On it! I'll call you when the analysis is ready.</div>
                </div>
            </div>
        </div>

        <!-- Slide 2: Voice Updates -->
        <div x-show="activeSlide === 1" x-cloak x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-8" class="absolute w-[80%] max-w-[400px] bg-[#272459] rounded-3xl p-6 shadow-2xl z-20 flex flex-col items-center justify-center border border-white/10">
            <div class="w-24 h-24 rounded-full bg-gradient-to-tr from-[#3E50F7] to-[#2bd9ff] p-1 mb-6 shadow-[0_0_30px_rgba(64,86,232,0.4)] animate-pulse">
                <img src="https://i.pravatar.cc/150?img=68" alt="AI Agent" class="w-full h-full rounded-full border-4 border-[#272459]">
            </div>
            <div class="text-white font-semibold text-lg mb-1">Business Companion</div>
            <div class="flex items-center gap-2 mb-8">
               <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
               <div class="text-green-400 text-xs font-semibold tracking-wider uppercase">Calling you...</div>
            </div>
            <div class="flex gap-5">
                <div class="w-14 h-14 rounded-full bg-green-500 flex items-center justify-center text-white cursor-pointer shadow-lg shadow-green-500/30 hover:bg-green-600 transition-colors"><span class="material-symbols-outlined">call</span></div>
                <div class="w-14 h-14 rounded-full bg-red-500 flex items-center justify-center text-white cursor-pointer shadow-lg shadow-red-500/30 hover:bg-red-600 transition-colors"><span class="material-symbols-outlined">call_end</span></div>
            </div>
        </div>

        <!-- Slide 3: Model Selection -->
        <div x-show="activeSlide === 2" x-cloak x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-8" class="absolute w-[80%] max-w-[400px] bg-[#272459] rounded-2xl border border-white/10 shadow-2xl z-20 flex flex-col overflow-hidden">
            <div class="h-10 border-b border-white/5 flex items-center px-4 gap-2 bg-[#25224A]">
                <div class="flex items-center gap-2"><span class="material-symbols-outlined text-sm text-[#AFBBE0]">tune</span><span class="text-xs text-[#AFBBE0] font-medium">Choose AI Model</span></div>
            </div>
            <div class="p-6 flex flex-col gap-3">
                <div class="flex items-center justify-between p-3 rounded-lg border border-[#3E50F7] bg-[#3E50F7]/10 cursor-pointer">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded bg-white/10 flex items-center justify-center"><span class="material-symbols-outlined text-sm text-white">smart_toy</span></div>
                        <div>
                            <div class="text-sm font-semibold text-white">GPT-4o</div>
                            <div class="text-xs text-[#AFBBE0]">Best for reasoning</div>
                        </div>
                    </div>
                    <span class="material-symbols-outlined text-[#3E50F7] text-sm">check_circle</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-lg border border-white/5 bg-white/5 cursor-pointer opacity-70 hover:bg-white/10 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded bg-white/10 flex items-center justify-center"><span class="material-symbols-outlined text-sm text-white">psychology</span></div>
                        <div>
                            <div class="text-sm font-semibold text-white">Claude 3.5 Sonnet</div>
                            <div class="text-xs text-[#AFBBE0]">Best for writing</div>
                        </div>
                    </div>
                </div>
                 <div class="flex items-center justify-between p-3 rounded-lg border border-white/5 bg-white/5 cursor-pointer opacity-70 hover:bg-white/10 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded bg-white/10 flex items-center justify-center"><span class="material-symbols-outlined text-sm text-white">bolt</span></div>
                        <div>
                            <div class="text-sm font-semibold text-white">Llama 3</div>
                            <div class="text-xs text-[#AFBBE0]">Fastest execution</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slider Indicators -->
        <div class="absolute bottom-4 flex gap-2 z-30">
            <div class="h-1.5 rounded-full transition-all duration-300" :class="activeSlide === 0 ? 'w-6 bg-[#3E50F7]' : 'w-2 bg-white/20'"></div>
            <div class="h-1.5 rounded-full transition-all duration-300" :class="activeSlide === 1 ? 'w-6 bg-[#3E50F7]' : 'w-2 bg-white/20'"></div>
            <div class="h-1.5 rounded-full transition-all duration-300" :class="activeSlide === 2 ? 'w-6 bg-[#3E50F7]' : 'w-2 bg-white/20'"></div>
        </div>
      </div>"""

new_right_section = """      <!-- Hero Graphics -->
      <div class="relative w-full h-[500px] flex justify-center items-center overflow-hidden mask-image-bottom">
        
        <div class="absolute top-0 left-0 w-full transition-transform duration-700 ease-in-out z-20" :style="`transform: translateY(-${activeSlide * 100}%)`">
        
            <!-- Slide 1: Task Assignment -->
            <div class="h-[500px] w-full flex justify-center items-center">
                <div class="w-[80%] max-w-[400px] bg-[#272459] rounded-2xl border border-white/10 shadow-2xl flex flex-col overflow-hidden">
                    <div class="h-10 border-b border-white/5 flex items-center px-4 gap-2 bg-[#25224A]">
                        <div class="flex items-center gap-2"><span class="material-symbols-outlined text-sm text-[#AFBBE0]">task</span><span class="text-xs text-[#AFBBE0] font-medium">Task Assignment</span></div>
                    </div>
                    <div class="p-6 flex flex-col gap-4">
                        <div class="flex gap-3 items-start">
                            <div class="w-8 h-8 rounded-full bg-[#3E50F7] flex items-center justify-center text-white text-xs">You</div>
                            <div class="bg-white/10 p-3 rounded-lg rounded-tl-none text-sm text-white/90">Analyze our competitor's new pricing and summarize it.</div>
                        </div>
                        <div class="flex gap-3 items-start flex-row-reverse">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-[#3E50F7] to-[#2bd9ff] p-[2px]"><img src="https://i.pravatar.cc/150?img=68" class="rounded-full" alt="AI"></div>
                            <div class="bg-[#3E50F7]/20 p-3 rounded-lg rounded-tr-none text-sm text-white/90 border border-[#3E50F7]/30">On it! I'll call you when the analysis is ready.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2: Voice Updates -->
            <div class="h-[500px] w-full flex justify-center items-center">
                <div class="w-[80%] max-w-[400px] bg-[#272459] rounded-3xl p-6 shadow-2xl flex flex-col items-center justify-center border border-white/10">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-tr from-[#3E50F7] to-[#2bd9ff] p-1 mb-6 shadow-[0_0_30px_rgba(64,86,232,0.4)] animate-pulse">
                        <img src="https://i.pravatar.cc/150?img=68" alt="AI Agent" class="w-full h-full rounded-full border-4 border-[#272459]">
                    </div>
                    <div class="text-white font-semibold text-lg mb-1">Business Companion</div>
                    <div class="flex items-center gap-2 mb-8">
                       <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                       <div class="text-green-400 text-xs font-semibold tracking-wider uppercase">Calling you...</div>
                    </div>
                    <div class="flex gap-5">
                        <div class="w-14 h-14 rounded-full bg-green-500 flex items-center justify-center text-white cursor-pointer shadow-lg shadow-green-500/30 hover:bg-green-600 transition-colors"><span class="material-symbols-outlined">call</span></div>
                        <div class="w-14 h-14 rounded-full bg-red-500 flex items-center justify-center text-white cursor-pointer shadow-lg shadow-red-500/30 hover:bg-red-600 transition-colors"><span class="material-symbols-outlined">call_end</span></div>
                    </div>
                </div>
            </div>

            <!-- Slide 3: Model Selection -->
            <div class="h-[500px] w-full flex justify-center items-center">
                <div class="w-[80%] max-w-[400px] bg-[#272459] rounded-2xl border border-white/10 shadow-2xl flex flex-col overflow-hidden">
                    <div class="h-10 border-b border-white/5 flex items-center px-4 gap-2 bg-[#25224A]">
                        <div class="flex items-center gap-2"><span class="material-symbols-outlined text-sm text-[#AFBBE0]">tune</span><span class="text-xs text-[#AFBBE0] font-medium">Choose AI Model</span></div>
                    </div>
                    <div class="p-6 flex flex-col gap-3">
                        <div class="flex items-center justify-between p-3 rounded-lg border border-[#3E50F7] bg-[#3E50F7]/10 cursor-pointer">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded bg-white/10 flex items-center justify-center"><span class="material-symbols-outlined text-sm text-white">smart_toy</span></div>
                                <div>
                                    <div class="text-sm font-semibold text-white">GPT-4o</div>
                                    <div class="text-xs text-[#AFBBE0]">Best for reasoning</div>
                                </div>
                            </div>
                            <span class="material-symbols-outlined text-[#3E50F7] text-sm">check_circle</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg border border-white/5 bg-white/5 cursor-pointer opacity-70 hover:bg-white/10 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded bg-white/10 flex items-center justify-center"><span class="material-symbols-outlined text-sm text-white">psychology</span></div>
                                <div>
                                    <div class="text-sm font-semibold text-white">Claude 3.5 Sonnet</div>
                                    <div class="text-xs text-[#AFBBE0]">Best for writing</div>
                                </div>
                            </div>
                        </div>
                         <div class="flex items-center justify-between p-3 rounded-lg border border-white/5 bg-white/5 cursor-pointer opacity-70 hover:bg-white/10 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded bg-white/10 flex items-center justify-center"><span class="material-symbols-outlined text-sm text-white">bolt</span></div>
                                <div>
                                    <div class="text-sm font-semibold text-white">Llama 3</div>
                                    <div class="text-xs text-[#AFBBE0]">Fastest execution</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Slider Indicators -->
        <div class="absolute bottom-4 flex gap-2 z-30">
            <div class="h-1.5 rounded-full transition-all duration-300" :class="activeSlide === 0 ? 'w-6 bg-[#3E50F7]' : 'w-2 bg-white/20'"></div>
            <div class="h-1.5 rounded-full transition-all duration-300" :class="activeSlide === 1 ? 'w-6 bg-[#3E50F7]' : 'w-2 bg-white/20'"></div>
            <div class="h-1.5 rounded-full transition-all duration-300" :class="activeSlide === 2 ? 'w-6 bg-[#3E50F7]' : 'w-2 bg-white/20'"></div>
        </div>
      </div>"""

content = content.replace(old_right_section, new_right_section)

with open("resources/views/welcome.blade.php", "w") as f:
    f.write(content)

