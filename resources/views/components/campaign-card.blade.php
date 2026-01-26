@props(['title', 'description', 'image', 'url' => '#', 'status' => 'active', 'participants' => null])

<a href="{{ $url }}" class="group block bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-primary/30 hover:-translate-y-1 h-full">
    <!-- Image Section -->
    <div class="relative h-48 overflow-hidden">
        <img src="{{ $image }}" alt="{{ $title }}" 
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
             onerror="this.src='https://images.unsplash.com/photo-1559757148-5c350d0d3c56?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'">
        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
        
        <!-- Status Badge -->
        <div class="absolute top-4 left-4">
            <span class="bg-white/90 backdrop-blur-sm 
                @if($status === 'active') text-primary bg-primary/10
                @elseif($status === 'upcoming') text-primary bg-primary/10
                @elseif($status === 'completed') text-green-700 bg-green-100
                @else text-primary bg-primary/10
                @endif px-3 py-1 rounded-full text-xs font-semibold flex items-center gap-1 border border-primary/20">
                @if($status === 'active')
                    <span class="w-2 h-2 bg-primary rounded-full animate-pulse"></span>
                    Active
                @elseif($status === 'upcoming')
                    <span class="material-symbols-outlined !text-sm text-primary">schedule</span>
                    Upcoming
                @elseif($status === 'completed')
                    <span class="material-symbols-outlined !text-sm text-green-600">check_circle</span>
                    Completed
                @else
                    <span class="material-symbols-outlined !text-sm text-primary">campaign</span>
                    Campaign
                @endif
            </span>
        </div>
        
        <!-- Participants Badge -->
        @if($participants)
        <div class="absolute top-4 right-4">
            <span class="bg-primary/10 backdrop-blur-sm text-primary border border-primary/20 px-3 py-1 rounded-full text-xs font-semibold flex items-center gap-1">
                <span class="material-symbols-outlined !text-sm">group</span>
                {{ $participants }}
            </span>
        </div>
        @endif
    </div>
    
    <!-- Content Section -->
    <div class="p-6">
        <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-2 group-hover:text-primary transition-colors line-clamp-2">
            {{ $title }}
        </h3>
        <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 leading-relaxed mb-4">
            {{ Str::limit($description, 120) }}
        </p>
        
        <!-- Learn More Link -->
        <div class="flex items-center text-primary font-semibold text-sm group-hover:gap-2 transition-all">
            @if($status === 'active')
                <span>Join Campaign</span>
                <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform text-primary">volunteer_activism</span>
            @elseif($status === 'upcoming')
                <span>Learn More</span>
                <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform text-primary">schedule</span>
            @elseif($status === 'completed')
                <span>View Details</span>
                <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform text-primary">visibility</span>
            @else
                <span>Learn More</span>
                <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform text-primary">arrow_forward</span>
            @endif
        </div>
    </div>
</a>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>