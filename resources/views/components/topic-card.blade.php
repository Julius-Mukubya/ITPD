@props(['icon', 'title', 'url' => '#', 'image' => null, 'description' => null, 'color' => 'primary'])

<a href="{{ $url }}" class="group block bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-primary/30 hover:-translate-y-1 h-full">
    <!-- Image Section -->
    <div class="relative h-48 overflow-hidden">
        <img src="{{ $image ?? 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=600&h=400&fit=crop&crop=center' }}" 
             alt="{{ $title }}" 
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
        
        <!-- Category Badge -->
        <div class="absolute top-4 left-4">
            <span class="bg-white/90 backdrop-blur-sm text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">
                {{ $title }}
            </span>
        </div>
    </div>
    
    <!-- Content Section -->
    <div class="p-6">
        <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-2 group-hover:text-primary transition-colors">
            {{ $title }}
        </h3>
        @if($description)
            <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 leading-relaxed">{{ $description }}</p>
        @endif
        
        <!-- Learn More Link -->
        <div class="mt-4 flex items-center text-primary font-semibold text-sm group-hover:gap-2 transition-all">
            <span>Learn More</span>
            <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">arrow_forward</span>
        </div>
    </div>
</a>