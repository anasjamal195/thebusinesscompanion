import re

with open("resources/views/welcome.blade.php", "r") as f:
    content = f.read()

# Replace colors
replacements = {
    "#13142B": "#25224A",
    "#1E1F38": "#272459",
    "#1A1C33": "#272459",
    "#4056E8": "#3E50F7",
    "#3448cd": "#0000EE",
    "#11122a": "#25224A",
    "#F5F7FA": "#F8FAFF",
    "#0D0E1F": "#272459",
    "#8992b4": "#AFBBE0",
    "bg-gray-100": "bg-[#EEF2FE]",
    "bg-gray-200": "bg-[#CCDCFC]",
    "border-gray-100": "border-[#DEE8FF]",
    "border-gray-200": "border-[#DEE8FF]",
    "text-gray-400": "text-[#7F798D]",
    "text-gray-500": "text-[#7F798D]",
    "text-gray-600": "text-[#5F5770]",
    "text-gray-700": "text-[#464154]",
    "bg-gray-50": "bg-[#F8FAFF]",
    "#E5F0FF": "#EEF2FE",
    "#8E9BBA": "#464154",
    "#7a86a6": "#25224A",
    "#D8E1F4": "#EEF2FE"
}

for old, new in replacements.items():
    content = content.replace(old, new)

# Add text-slide animation to CSS
css_to_add = """
    @keyframes text-slide {
        0%, 20% { transform: translateY(0); }
        25%, 45% { transform: translateY(-20%); }
        50%, 70% { transform: translateY(-40%); }
        75%, 95% { transform: translateY(-60%); }
        100% { transform: translateY(-80%); }
    }
    .animate-text-slide {
        animation: text-slide 10s infinite cubic-bezier(0.4, 0, 0.2, 1);
    }
  </style>"""
content = content.replace("  </style>", css_to_add)

# Replace Hero paragraph with Animated typography
hero_text_old = """        <p class="text-lg text-[#AFBBE0] max-w-lg leading-relaxed">
          Overcome trust issues and procrastination. Don't share your insecurities with your team—share them with a dedicated AI companion that understands your business context. Assign tasks, get updates via voice calls, and choose the best AI models for the job.
        </p>"""

hero_text_new = """        <div class="h-[80px] md:h-[60px] overflow-hidden text-[#AFBBE0] text-xl md:text-[22px] font-medium relative">
          <div class="animate-text-slide absolute top-0 left-0 w-full flex flex-col">
             <div class="h-[80px] md:h-[60px] flex items-center">Overcome trust issues & procrastination.</div>
             <div class="h-[80px] md:h-[60px] flex items-center">Solve business problems you can't share.</div>
             <div class="h-[80px] md:h-[60px] flex items-center">Assign tasks & get updates via voice calls.</div>
             <div class="h-[80px] md:h-[60px] flex items-center">Choose the best AI models for the job.</div>
             <div class="h-[80px] md:h-[60px] flex items-center">Overcome trust issues & procrastination.</div>
          </div>
        </div>"""

content = content.replace(hero_text_old, hero_text_new)

with open("resources/views/welcome.blade.php", "w") as f:
    f.write(content)

