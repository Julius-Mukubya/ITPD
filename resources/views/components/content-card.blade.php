@props(['content' => null, 'title', 'category' => 'General', 'description', 'image', 'type' => 'article', 'url' => '#'])

<a href="{{ $url }}" class="group block bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-primary/30 hover:-translate-y-1 h-full flex flex-col">
    <!-- Image Section -->
    <div class="relative h-48 overflow-hidden flex-shrink-0">
        <img alt="{{ $title }}" 
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" 
             src="{{ $image }}"/>
        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
        
        @if($type === 'video')
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="bg-white/20 backdrop-blur-sm rounded-full p-4">
                <span class="material-symbols-outlined text-white text-4xl leading-none">play_arrow</span>
            </div>
        </div>
        @endif
        
        <!-- Category Badge -->
        <div class="absolute top-4 left-4">
            <span class="bg-white/90 backdrop-blur-sm text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">
                {{ $category }}
            </span>
        </div>
    </div>
    
    <!-- Content Section -->
    <div class="p-6 flex flex-col flex-1">
        <!-- Title - Fixed height container -->
        <div class="mb-4 min-h-[3.5rem] flex items-start">
            <h3 class="font-bold text-gray-900 dark:text-white text-lg group-hover:text-primary transition-colors line-clamp-2">
                {{ $title }}
            </h3>
        </div>
        
        <!-- Description - Flexible height -->
        <div class="flex-1 mb-4">
            <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 leading-relaxed">
                {{ $description }}
            </p>
        </div>
        
        <!-- Learn More Link - Fixed at bottom -->
        <div class="flex items-center text-primary font-semibold text-sm group-hover:gap-2 transition-all mt-auto">
            @if($type === 'video')
                <span>Watch Video</span>
                <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">play_circle</span>
            @else
                <span>Read More</span>
                <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">arrow_forward</span>
            @endif
        </div>
    </div>
</a>