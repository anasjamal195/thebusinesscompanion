with open("resources/views/welcome.blade.php", "r") as f:
    content = f.read()

# 1. Move x-data to the parent grid
old_grid = '<div class="max-w-7xl mx-auto px-6 md:px-12 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">'
new_grid = '<div class="max-w-7xl mx-auto px-6 md:px-12 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center" x-data="{ activeSlide: 0 }" x-init="setInterval(() => activeSlide = (activeSlide + 1) % 3, 4000)">'
content = content.replace(old_grid, new_grid)

# 2. Remove x-data from the right side graphics container
old_graphics = '<div class="relative w-full h-[500px] flex justify-center items-center" x-data="{ activeSlide: 0 }" x-init="setInterval(() => activeSlide = (activeSlide + 1) % 3, 4000)">'
new_graphics = '<div class="relative w-full h-[500px] flex justify-center items-center">'
content = content.replace(old_graphics, new_graphics)

# 3. Replace the left section content
old_left_section = """      <div class="space-y-8 pr-0 lg:pr-8 relative z-10">
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
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 pt-2">
          <button @click="waitlistModalOpen = true" class="px-8 py-4 bg-[#3E50F7] hover:bg-[#0000EE] text-white font-semibold rounded-full transition-all text-base flex items-center gap-2">
            Join Waitlist <span class="material-symbols-outlined text-sm">arrow_forward</span>
          </button>
        </div>
        <div class="flex items-center gap-3 pt-6 text-sm text-[#AFBBE0]">
          <div class="flex text-yellow-400 text-lg">
            ★★★★★
          </div>
          <p>Rated 4.9/5 by 10,000+ users</p>
        </div>
      </div>"""

new_left_section = """      <div class="space-y-6 pr-0 lg:pr-8 relative z-10 flex flex-col justify-center h-full">
         
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

content = content.replace(old_left_section, new_left_section)

with open("resources/views/welcome.blade.php", "w") as f:
    f.write(content)

