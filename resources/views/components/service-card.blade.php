@props(['icon', 'title', 'description', 'color' => 'primary'])

<div class="group relative flex flex-1 flex-col gap-6 rounded-2xl bg-white dark:bg-gray-900/50 p-8 text-center items-center transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 border-2 border-transparent hover:border-{{ $color }}/20">
    <!-- Decorative background gradient -->
    <div class="absolute inset-0 bg-gradient-to-br from-{{ $color }}/5 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
    
    <!-- Icon with animated background -->
    <div class="relative z-10">
        <div class="w-20 h-20 bg-gradient-to-br from-{{ $color }}/20 to-{{ $color }}/10 rounded-2xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg group-hover:shadow-{{ $color }}/30">
            <span class="material-symbols-outlined text-{{ $color }} text-5xl">{{ $icon }}</span>
        </div>
    </div>
    
    <!-- Content -->
    <div class="relative z-10 flex flex-col gap-3">
        <h3 class="text-gray-900 dark:text-white text-2xl font-bold leading-tight group-hover:text-{{ $color }} transition-colors duration-300">{{ $title }}</h3>
        <p class="text-gray-600 dark:text-gray-400 text-base font-normal leading-relaxed">{{ $description }}</p>
    </div>
    
    <!-- Hover indicator -->
    <div class="relative z-10 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
        <div class="flex items-center gap-2 text-{{ $color }} font-semibold text-sm">
            <span>Learn More</span>
            <span class="material-symbols-outlined text-lg">arrow_forward</span>
        </div>
    </div>
</div>