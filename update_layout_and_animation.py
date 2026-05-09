with open("resources/views/welcome.blade.php", "r") as f:
    content = f.read()

# 1. Swap order classes
# Graphics section from `order-2 lg:order-1` to `order-2 lg:order-2`
content = content.replace(
    '<div class="order-2 lg:order-1 relative w-full h-[450px] md:h-[500px]',
    '<div class="order-2 lg:order-2 relative w-full h-[450px] md:h-[500px]'
)

# Text section from `order-1 lg:order-2 space-y-8 lg:pl-8` to `order-1 lg:order-1 space-y-8 pr-0 lg:pr-8`
content = content.replace(
    '<div class="order-1 lg:order-2 space-y-8 lg:pl-8 relative z-10 flex flex-col justify-center h-full">',
    '<div class="order-1 lg:order-1 space-y-8 pr-0 lg:pr-8 relative z-10 flex flex-col justify-center h-full">'
)

# 2. Update Text Animation to use activeSlide
old_text_animation = """         <div class="h-[80px] md:h-[60px] overflow-hidden text-[#AFBBE0] text-xl md:text-[22px] font-medium relative mask-image-bottom">
           <div class="animate-text-slide absolute top-0 left-0 w-full flex flex-col">
              <div class="h-[80px] md:h-[60px] flex items-center">Overcome trust issues & procrastination.</div>
              <div class="h-[80px] md:h-[60px] flex items-center">Solve business problems you can't share.</div>
              <div class="h-[80px] md:h-[60px] flex items-center">Assign tasks & get updates via voice calls.</div>
              <div class="h-[80px] md:h-[60px] flex items-center">Choose the best AI models for the job.</div>
              <div class="h-[80px] md:h-[60px] flex items-center">Overcome trust issues & procrastination.</div>
           </div>
         </div>"""

new_text_animation = """         <div class="h-[80px] md:h-[60px] overflow-hidden text-[#AFBBE0] text-xl md:text-[22px] font-medium relative mask-image-bottom">
           <div class="absolute top-0 left-0 w-full h-[300%] flex flex-col transition-transform duration-1000 ease-in-out" :style="`transform: translateY(-${activeSlide * 33.333333}%)`">
              <div class="h-1/3 flex items-center shrink-0">Overcome trust issues & procrastination.</div>
              <div class="h-1/3 flex items-center shrink-0">Assign tasks & get updates via voice calls.</div>
              <div class="h-1/3 flex items-center shrink-0">Choose the best AI models for the job.</div>
           </div>
         </div>"""

content = content.replace(old_text_animation, new_text_animation)

# 3. Add pulsing animations to SVG paths
old_svg = """                <svg viewBox="0 0 400 1200" class="absolute top-0 left-0 w-full h-full z-0 pointer-events-none" fill="none" stroke="rgba(255,255,255,0.15)" stroke-width="2" stroke-dasharray="6 6">
                    <!-- Path 1 -->
                    <path d="M 150 260 L 150 330 Q 150 350 170 350 L 230 350 Q 250 350 250 370 L 250 420" />
                    <circle cx="250" cy="390" r="6" fill="#fff" style="filter: drop-shadow(0 0 8px #fff);" />

                    <!-- Path 2 -->
                    <path d="M 250 640 L 250 700 Q 250 720 230 720 L 170 720 Q 150 720 150 740 L 150 800" />
                    <circle cx="150" cy="770" r="6" fill="#fff" style="filter: drop-shadow(0 0 8px #fff);" />
                </svg>"""

new_svg = """                <svg viewBox="0 0 400 1200" class="absolute top-0 left-0 w-full h-full z-0 pointer-events-none">
                    <!-- Path 1 -->
                    <path d="M 150 260 L 150 330 Q 150 350 170 350 L 230 350 Q 250 350 250 370 L 250 420" fill="none" stroke="rgba(255,255,255,0.15)" stroke-width="2" stroke-dasharray="6 6" />
                    <circle cx="250" cy="390" r="6" fill="#fff" style="filter: drop-shadow(0 0 8px #fff);" />
                    <!-- Traveling Pulse 1 -->
                    <circle r="4" fill="#3E50F7" style="filter: drop-shadow(0 0 10px #3E50F7); shadow-opacity: 1;">
                        <animateMotion dur="3s" repeatCount="indefinite" path="M 150 260 L 150 330 Q 150 350 170 350 L 230 350 Q 250 350 250 370 L 250 420" />
                    </circle>

                    <!-- Path 2 -->
                    <path d="M 250 640 L 250 700 Q 250 720 230 720 L 170 720 Q 150 720 150 740 L 150 800" fill="none" stroke="rgba(255,255,255,0.15)" stroke-width="2" stroke-dasharray="6 6" />
                    <circle cx="150" cy="770" r="6" fill="#fff" style="filter: drop-shadow(0 0 8px #fff);" />
                    <!-- Traveling Pulse 2 -->
                    <circle r="4" fill="#3E50F7" style="filter: drop-shadow(0 0 10px #3E50F7); shadow-opacity: 1;">
                        <animateMotion dur="3s" repeatCount="indefinite" path="M 250 640 L 250 700 Q 250 720 230 720 L 170 720 Q 150 720 150 740 L 150 800" />
                    </circle>
                </svg>"""

content = content.replace(old_svg, new_svg)

with open("resources/views/welcome.blade.php", "w") as f:
    f.write(content)

