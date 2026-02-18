<header class="fixed top-0 left-0 right-0 z-50 w-full glass-header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between py-3">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 flex-shrink-0 header-logo">
                    <img src="{{ asset('images/leaf-logo.svg') }}" alt="WellPath Logo" class="w-full h-full object-contain">
                </div>
                <h2 class="header-text text-base sm:text-lg font-bold leading-tight tracking-[-0.015em] hidden xs:block">WellPath</h2>
                <h2 class="header-text text-base font-bold leading-tight tracking-[-0.015em] xs:hidden">WellPath</h2>
            </div>
            
            <nav class="hidden lg:flex items-center gap-4 xl:gap-6">
                <a class="header-text hover:opacity-80 text-sm font-medium leading-normal flex items-center gap-1.5" href="{{ route('home') }}">
                    <span class="material-symbols-outlined text-base">home</span>
                    <span>Home</span>
                </a>
                <!-- Resources Dropdown -->
                <div class="relative group">
                    <a href="{{ route('content.index') }}" class="header-text hover:opacity-80 text-sm font-medium leading-normal flex items-center gap-1.5 {{ request()->routeIs('content.*') ? 'font-bold' : '' }}">
                        <span class="material-symbols-outlined text-base">library_books</span>
                        <span>Resources</span>
                        <span class="material-symbols-outlined text-sm">expand_more</span>
                    </a>
                    <div class="absolute top-full left-0 mt-2 w-80 glass-dropdown rounded-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="p-2">
                            <!-- All Resources with nested dropdown -->
                            <div class="relative category-item group/allresources">
                                <div class="flex items-center justify-between px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors cursor-pointer">
                                    <a href="{{ route('content.index') }}#filters-section" class="flex items-center gap-3 flex-1">
                                        <span class="material-symbols-outlined" style="color: rgb(34, 197, 94);">library_books</span>
                                        <div>
                                            <div class="font-medium">All Resources</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Browse all educational content</div>
                                        </div>
                                    </a>
                                    <div class="p-1 hover:bg-gray-200 dark:hover:bg-gray-600 rounded transition-colors">
                                        <span class="material-symbols-outlined text-sm">chevron_right</span>
                                    </div>
                                </div>
                                <!-- Nested All Resources Dropdown -->
                                <div class="opacity-0 invisible group-hover/allresources:opacity-100 group-hover/allresources:visible absolute left-full top-0 ml-2 w-96 glass-dropdown rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 z-50 transition-all duration-200">
                                    <div class="p-3 max-h-96 overflow-y-auto custom-scrollbar">
                                        <!-- Header with gradient -->
                                        <div class="px-3 py-3 mb-2 bg-gradient-to-r from-green-50 to-green-50 dark:from-green-900/20 dark:to-green-900/20 rounded-lg border-l-4 border-green-500">
                                            <div class="flex items-center gap-2">
                                                <span class="material-symbols-outlined text-lg" style="color: rgb(34, 197, 94);">library_books</span>
                                                <p class="text-sm font-bold text-gray-800 dark:text-gray-200">All Resources</p>
                                            </div>
                                            @php
                                                $totalAllResources = \App\Models\EducationalContent::where('is_published', true)->count();
                                            @endphp
                                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ $totalAllResources }} {{ Str::plural('resource', $totalAllResources) }} available</p>
                                        </div>
                                        
                                        @php
                                            $allResources = \App\Models\EducationalContent::where('is_published', true)->orderBy('created_at', 'desc')->limit(8)->get();
                                        @endphp
                                        @if($allResources->count() > 0)
                                            <div class="space-y-1">
                                                @foreach($allResources as $resource)
                                                    <a href="{{ route('content.show', $resource) }}" class="group block px-3 py-2.5 text-sm hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 dark:hover:from-gray-700 dark:hover:to-gray-600 rounded-lg transition-all duration-200 border border-transparent hover:border-gray-200 dark:hover:border-gray-600">
                                                        <div class="flex items-start gap-3">
                                                            <!-- Resource Image -->
                                                            <div class="w-16 h-16 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-700">
                                                                @if($resource->featured_image)
                                                                    <img src="{{ $resource->featured_image_url }}" alt="{{ $resource->title }}" class="w-full h-full object-cover">
                                                                @else
                                                                    <div class="w-full h-full flex items-center justify-center">
                                                                        <span class="material-symbols-outlined text-gray-400 dark:text-gray-500">
                                                                            @if($resource->content_type === 'video') play_circle
                                                                            @elseif($resource->content_type === 'infographic') image
                                                                            @elseif($resource->content_type === 'guide') menu_book
                                                                            @else article
                                                                            @endif
                                                                        </span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="flex-1 min-w-0">
                                                                <div class="font-semibold text-gray-800 dark:text-gray-200 group-hover:text-green-700 dark:group-hover:text-green-300 transition-colors break-words line-clamp-2">{{ $resource->title }}</div>
                                                                @if($resource->content_type)
                                                                    <div class="flex items-center gap-1 mt-1">
                                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                                                            {{ ucfirst($resource->content_type) }}
                                                                        </span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <span class="material-symbols-outlined text-gray-300 dark:text-gray-600 text-sm opacity-0 group-hover:opacity-100 transition-all flex-shrink-0 mt-1" style="color: rgb(34, 197, 94);">arrow_forward</span>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            </div>
                                            
                                            @if($totalAllResources > 8)
                                                <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-600">
                                                    <a href="{{ route('content.index') }}" class="flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-green-600 to-green-600 hover:from-green-700 hover:to-green-700 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                                                        <span>View all {{ $totalAllResources }} resources</span>
                                                        <span class="material-symbols-outlined text-base">arrow_forward</span>
                                                    </a>
                                                </div>
                                            @endif
                                        @else
                                            <div class="px-4 py-8 text-center">
                                                <span class="material-symbols-outlined text-gray-300 dark:text-gray-600 text-4xl mb-2">folder_open</span>
                                                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">No resources available</p>
                                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Check back later for updates</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>
                            <div class="px-2 py-1">
                                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">By Category</p>
                            </div>
                            @php
                                $categories = \App\Models\Category::active()->ordered()->get();
                                $categoryIcons = [
                                    'alcohol-awareness' => 'local_bar',
                                    'drug-prevention' => 'medication',
                                    'mental-health' => 'psychology',
                                    'healthy-living' => 'spa',
                                    'peer-pressure' => 'groups',
                                    'recovery-support' => 'favorite',
                                ];
                            @endphp
                            @foreach($categories as $category)
                                <div class="relative category-item group/category">
                                    <div class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors cursor-pointer">
                                        <a href="{{ route('content.index', ['category' => $category->slug]) }}" class="flex items-center gap-3 flex-1">
                                            <span class="material-symbols-outlined" style="color: rgb(34, 197, 94);">{{ $categoryIcons[$category->slug] ?? 'article' }}</span>
                                            <span>{{ $category->name }}</span>
                                        </a>
                                        <div class="p-1 hover:bg-gray-200 dark:hover:bg-gray-600 rounded transition-colors">
                                            <span class="material-symbols-outlined text-sm">chevron_right</span>
                                        </div>
                                    </div>
                                    <!-- Nested Resources Dropdown -->
                                    <div class="opacity-0 invisible group-hover/category:opacity-100 group-hover/category:visible absolute left-full top-0 ml-2 w-96 glass-dropdown rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 z-50 transition-all duration-200">
                                        <div class="p-3 max-h-96 overflow-y-auto custom-scrollbar">
                                            <!-- Header with gradient -->
                                            <div class="px-3 py-3 mb-2 bg-gradient-to-r from-green-50 to-green-50 dark:from-green-900/20 dark:to-green-900/20 rounded-lg border-l-4 border-green-500">
                                                <div class="flex items-center gap-2">
                                                    <span class="material-symbols-outlined text-lg" style="color: rgb(34, 197, 94);">{{ $categoryIcons[$category->slug] ?? 'article' }}</span>
                                                    <p class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ $category->name }}</p>
                                                </div>
                                                @php
                                                    $totalResources = $category->contents()->where('is_published', true)->count();
                                                @endphp
                                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ $totalResources }} {{ Str::plural('resource', $totalResources) }} available</p>
                                            </div>
                                            
                                            @php
                                                $resources = $category->contents()->where('is_published', true)->orderBy('title')->limit(8)->get();
                                            @endphp
                                            @if($resources->count() > 0)
                                                <div class="space-y-1">
                                                    @foreach($resources as $resource)
                                                        <a href="{{ route('content.show', $resource) }}" class="group block px-3 py-2.5 text-sm hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 dark:hover:from-gray-700 dark:hover:to-gray-600 rounded-lg transition-all duration-200 border border-transparent hover:border-gray-200 dark:hover:border-gray-600">
                                                            <div class="flex items-start gap-3">
                                                                <!-- Resource Image -->
                                                                <div class="w-16 h-16 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-700">
                                                                    @if($resource->featured_image)
                                                                        <img src="{{ $resource->featured_image_url }}" alt="{{ $resource->title }}" class="w-full h-full object-cover">
                                                                    @else
                                                                        <div class="w-full h-full flex items-center justify-center">
                                                                            <span class="material-symbols-outlined text-gray-400 dark:text-gray-500">
                                                                                @if($resource->content_type === 'video') play_circle
                                                                                @elseif($resource->content_type === 'infographic') image
                                                                                @elseif($resource->content_type === 'guide') menu_book
                                                                                @else article
                                                                                @endif
                                                                            </span>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="flex-1 min-w-0">
                                                                    <div class="font-semibold text-gray-800 dark:text-gray-200 group-hover:text-green-700 dark:group-hover:text-green-300 transition-colors break-words line-clamp-2">{{ $resource->title }}</div>
                                                                    @if($resource->content_type)
                                                                        <div class="flex items-center gap-1 mt-1">
                                                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                                                                {{ ucfirst($resource->content_type) }}
                                                                            </span>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <span class="material-symbols-outlined text-gray-300 dark:text-gray-600 text-sm opacity-0 group-hover:opacity-100 transition-all flex-shrink-0 mt-1" style="color: rgb(34, 197, 94);">arrow_forward</span>
                                                            </div>
                                                        </a>
                                                    @endforeach
                                                </div>
                                                
                                                @if($totalResources > 8)
                                                    <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-600">
                                                        <a href="{{ route('content.index', ['category' => $category->slug]) }}" class="flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-green-600 to-green-600 hover:from-green-700 hover:to-green-700 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                                                            <span>View all {{ $totalResources }} resources</span>
                                                            <span class="material-symbols-outlined text-base">arrow_forward</span>
                                                        </a>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="px-4 py-8 text-center">
                                                    <span class="material-symbols-outlined text-gray-300 dark:text-gray-600 text-4xl mb-2">folder_open</span>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">No resources available</p>
                                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Check back later for updates</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Counseling Dropdown -->
                <div class="relative group">
                    <a href="{{ route('public.counseling.index') }}" class="header-text hover:opacity-80 text-sm font-medium leading-normal flex items-center gap-1.5 {{ request()->routeIs('public.counseling.*') || request()->routeIs('student.counseling.*') ? 'font-bold' : '' }}">
                        <span class="material-symbols-outlined text-base">psychology</span>
                        <span>Counseling</span>
                        <span class="material-symbols-outlined text-sm">expand_more</span>
                    </a>
                    <div class="absolute top-full left-0 mt-2 w-80 glass-dropdown rounded-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="p-2">
                            <!-- Counseling Services with nested dropdown -->
                            <div class="relative category-item group/services">
                                <div class="flex items-center justify-between px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors cursor-pointer">
                                    <a href="{{ route('public.counseling.index') }}" class="flex items-center gap-3 flex-1">
                                        <span class="material-symbols-outlined" style="color: rgb(34, 197, 94);">support_agent</span>
                                        <div>
                                            <div class="font-medium">Counseling Services</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Professional counseling support</div>
                                        </div>
                                    </a>
                                    <div class="p-1 hover:bg-gray-200 dark:hover:bg-gray-600 rounded transition-colors">
                                        <span class="material-symbols-outlined text-sm">chevron_right</span>
                                    </div>
                                </div>
                                <!-- Nested Services Dropdown -->
                                <div class="opacity-0 invisible group-hover/services:opacity-100 group-hover/services:visible absolute left-full top-0 ml-2 w-80 glass-dropdown rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 z-50 transition-all duration-200">
                                    <div class="p-3 max-h-96 overflow-y-auto custom-scrollbar">
                                        <!-- Header -->
                                        <div class="px-3 py-3 mb-2 bg-gradient-to-r from-green-50 to-green-50 dark:from-green-900/20 dark:to-green-900/20 rounded-lg border-l-4 border-green-500">
                                            <div class="flex items-center gap-2">
                                                <span class="material-symbols-outlined text-lg" style="color: rgb(34, 197, 94);">psychology</span>
                                                <p class="text-sm font-bold text-gray-800 dark:text-gray-200">Our Services</p>
                                            </div>
                                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Professional support for your wellbeing</p>
                                        </div>
                                        
                                        <div class="space-y-1">
                                            @php
                                                $counselingServices = [
                                                    ['name' => 'Individual Counseling', 'icon' => 'person', 'desc' => 'One-on-one personal support'],
                                                    ['name' => 'Group Counseling', 'icon' => 'groups', 'desc' => 'Peer support groups'],
                                                    ['name' => 'Substance Abuse Support', 'icon' => 'medication', 'desc' => 'Recovery and prevention'],
                                                    ['name' => 'Mental Health Support', 'icon' => 'psychology', 'desc' => 'Anxiety, depression, stress'],
                                                    ['name' => 'Crisis Intervention', 'icon' => 'emergency', 'desc' => 'Immediate support available'],
                                                    ['name' => 'Academic Stress', 'icon' => 'school', 'desc' => 'Study and exam support'],
                                                    ['name' => 'Family Counseling', 'icon' => 'family_restroom', 'desc' => 'Involving parents/guardians'],
                                                    ['name' => 'Peer Pressure Support', 'icon' => 'diversity_3', 'desc' => 'Building confidence'],
                                                ];
                                            @endphp
                                            @foreach($counselingServices as $service)
                                                <div class="group/service px-3 py-2.5 text-sm hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 dark:hover:from-gray-700 dark:hover:to-gray-600 rounded-lg transition-all duration-200 border border-transparent hover:border-gray-200 dark:hover:border-gray-600">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-8 h-8 flex-shrink-0 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                                                            <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-lg">{{ $service['icon'] }}</span>
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <div class="font-semibold text-gray-800 dark:text-gray-200 group-hover/service:text-green-700 dark:group-hover/service:text-green-300 transition-colors">{{ $service['name'] }}</div>
                                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $service['desc'] }}</div>
                                                        </div>
                                                        <span class="material-symbols-outlined text-gray-300 dark:text-gray-600 text-sm opacity-0 group-hover/service:opacity-100 transition-all flex-shrink-0" style="color: rgb(34, 197, 94);">check_circle</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        
                                        <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-600">
                                            <a href="{{ route('public.counseling.index') }}" class="flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-green-600 to-green-600 hover:from-green-700 hover:to-green-700 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                                                <span>Learn More About Our Services</span>
                                                <span class="material-symbols-outlined text-base">arrow_forward</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @auth
                                @php
                                    $userSessionsCount = auth()->user()->allCounselingSessions()->count();
                                @endphp
                                @if($userSessionsCount > 0)
                                    <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>
                                    <a href="{{ route('public.counseling.sessions') }}" class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                        <div class="flex items-center gap-3">
                                            <span class="material-symbols-outlined text-green-600">psychology</span>
                                            <div>
                                                <div class="font-medium">My Sessions</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">View your counseling sessions</div>
                                            </div>
                                        </div>
                                    </a>
                                @endif
                                <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>
                                <a href="{{ route('public.counseling.sessions') }}#how-to-talk" class="block px-4 py-3 text-sm text-white bg-primary hover:bg-primary/90 rounded-lg transition-colors">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined">chat</span>
                                        <div class="font-medium">Talk to a Counselor</div>
                                    </div>
                                </a>
                            @else
                                <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>
                                <button onclick="openLoginModal()" class="block w-full px-4 py-3 text-sm text-white bg-primary hover:bg-primary/90 rounded-lg transition-colors">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined">chat</span>
                                        <div class="font-medium">Talk to a Counselor</div>
                                    </div>
                                </button>
                            @endauth
                        </div>
                    </div>
                </div>
                
                <!-- Assessments Dropdown -->
                <div class="relative group">
                    <a href="{{ route('public.assessments.index') }}" class="header-text hover:opacity-80 text-sm font-medium leading-normal flex items-center gap-1.5 {{ request()->routeIs('public.assessments.*') ? 'font-bold' : '' }}">
                        <span class="material-symbols-outlined text-base">quiz</span>
                        <span>Assessments</span>
                        <span class="material-symbols-outlined text-sm">expand_more</span>
                    </a>
                    <div class="absolute top-full left-0 mt-2 w-80 glass-dropdown rounded-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="p-2">
                            <!-- All Assessments Link -->
                            <a href="{{ route('public.assessments.index') }}" class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined" style="color: rgb(34, 197, 94);">quiz</span>
                                    <div>
                                        <div class="font-medium">All Assessments</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Mental health screening tools</div>
                                    </div>
                                </div>
                            </a>
                            
                            <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>
                            
                            <!-- Individual Assessments -->
                            @php
                                $assessments = \App\Models\Assessment::where('is_active', true)->orderBy('name')->limit(6)->get();
                            @endphp
                            @if($assessments->count() > 0)
                                <div class="space-y-1 max-h-80 overflow-y-auto custom-scrollbar">
                                    @foreach($assessments as $assessment)
                                        <a href="{{ route('public.assessments.show', $assessment->type) }}" class="group block px-3 py-2.5 text-sm hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 dark:hover:from-gray-700 dark:hover:to-gray-600 rounded-lg transition-all duration-200">
                                            <div class="flex items-start gap-3">
                                                <!-- Assessment Image -->
                                                <div class="w-12 h-12 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-700">
                                                    @if($assessment->card_image)
                                                        <img src="{{ $assessment->card_image_url }}" alt="{{ $assessment->full_name ?? $assessment->name }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center">
                                                            <span class="material-symbols-outlined text-green-600 dark:text-green-400">psychology_alt</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="font-semibold text-gray-800 dark:text-gray-200 group-hover:text-green-700 dark:group-hover:text-green-300 transition-colors break-words line-clamp-2">{{ $assessment->full_name ?? $assessment->name }}</div>
                                                    @if($assessment->description)
                                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-1">{{ Str::limit($assessment->description, 50) }}</p>
                                                    @endif
                                                </div>
                                                <span class="material-symbols-outlined text-gray-300 dark:text-gray-600 text-sm opacity-0 group-hover:opacity-100 transition-all flex-shrink-0 mt-1" style="color: rgb(34, 197, 94);">arrow_forward</span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="px-4 py-6 text-center">
                                    <span class="material-symbols-outlined text-gray-300 dark:text-gray-600 text-3xl mb-2">quiz</span>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">No assessments available</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Community Dropdown -->
                <div class="relative group">
                    <a href="{{ route('public.forum.index') }}" class="header-text hover:opacity-80 text-sm font-medium leading-normal flex items-center gap-1.5 {{ request()->routeIs('public.forum.*') || request()->routeIs('student.forum.*') ? 'font-bold' : '' }}">
                        <span class="material-symbols-outlined text-base">forum</span>
                        <span>Community</span>
                        <span class="material-symbols-outlined text-sm">expand_more</span>
                    </a>
                    <div class="absolute top-full left-0 mt-2 w-80 glass-dropdown rounded-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="p-2">
                            <!-- All Discussions Link -->
                            <a href="{{ route('public.forum.index') }}" class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined" style="color: rgb(34, 197, 94);">forum</span>
                                    <div>
                                        <div class="font-medium">All Discussions</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Browse community topics</div>
                                    </div>
                                </div>
                            </a>
                            
                            <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>
                            
                            <!-- Forum Categories -->
                            @php
                                $forumCategories = \App\Models\ForumCategory::withCount('posts')->orderBy('name')->get();
                            @endphp
                            @if($forumCategories->count() > 0)
                                <div class="space-y-1 max-h-80 overflow-y-auto custom-scrollbar">
                                    @foreach($forumCategories as $forumCategory)
                                        <a href="{{ route('public.forum.category', $forumCategory->slug) }}" class="group block px-3 py-2.5 text-sm hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 dark:hover:from-gray-700 dark:hover:to-gray-600 rounded-lg transition-all duration-200">
                                            <div class="flex items-start gap-3">
                                                <div class="w-10 h-10 flex-shrink-0 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-green-600 dark:text-green-400">{{ $forumCategory->icon ?? 'chat_bubble' }}</span>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="font-semibold text-gray-800 dark:text-gray-200 group-hover:text-green-700 dark:group-hover:text-green-300 transition-colors">{{ $forumCategory->name }}</div>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $forumCategory->posts_count }} {{ Str::plural('post', $forumCategory->posts_count) }}</p>
                                                </div>
                                                <span class="material-symbols-outlined text-gray-300 dark:text-gray-600 text-sm opacity-0 group-hover:opacity-100 transition-all flex-shrink-0 mt-1" style="color: rgb(34, 197, 94);">arrow_forward</span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="px-4 py-6 text-center">
                                    <span class="material-symbols-outlined text-gray-300 dark:text-gray-600 text-3xl mb-2">forum</span>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">No categories available</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Events Dropdown -->
                <div class="relative group">
                    <a href="{{ route('campaigns.index') }}" class="header-text hover:opacity-80 text-sm font-medium leading-normal flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-base">campaign</span>
                        <span>Events</span>
                        <span class="material-symbols-outlined text-sm">expand_more</span>
                    </a>
                    <div class="absolute top-full left-0 mt-2 w-80 glass-dropdown rounded-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="p-2">
                            <!-- All Events Link -->
                            <a href="{{ route('campaigns.index') }}" class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined" style="color: rgb(34, 197, 94);">campaign</span>
                                    <div>
                                        <div class="font-medium">All Events</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">View upcoming campaigns</div>
                                    </div>
                                </div>
                            </a>
                            
                            <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>
                            
                            <!-- Upcoming Events -->
                            @php
                                $campaigns = \App\Models\Campaign::where('status', 'published')->where('end_date', '>=', now())->orderBy('start_date')->limit(6)->get();
                            @endphp
                            @if($campaigns->count() > 0)
                                <div class="space-y-1 max-h-80 overflow-y-auto custom-scrollbar">
                                    @foreach($campaigns as $campaign)
                                        <a href="{{ route('campaigns.show', $campaign) }}" class="group block px-3 py-2.5 text-sm hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 dark:hover:from-gray-700 dark:hover:to-gray-600 rounded-lg transition-all duration-200">
                                            <div class="flex items-start gap-3">
                                                <!-- Event Image -->
                                                <div class="w-12 h-12 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-700">
                                                    @if($campaign->banner_image)
                                                        <img src="{{ asset('storage/' . $campaign->banner_image) }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center">
                                                            <span class="material-symbols-outlined text-green-600 dark:text-green-400">event</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="font-semibold text-gray-800 dark:text-gray-200 group-hover:text-green-700 dark:group-hover:text-green-300 transition-colors break-words line-clamp-2">{{ $campaign->title }}</div>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $campaign->start_date->format('M d, Y') }}</p>
                                                </div>
                                                <span class="material-symbols-outlined text-gray-300 dark:text-gray-600 text-sm opacity-0 group-hover:opacity-100 transition-all flex-shrink-0 mt-1" style="color: rgb(34, 197, 94);">arrow_forward</span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="px-4 py-6 text-center">
                                    <span class="material-symbols-outlined text-gray-300 dark:text-gray-600 text-3xl mb-2">event_busy</span>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">No upcoming events</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- More Dropdown -->
                <div class="relative group">
                    <a href="{{ route('public.about') }}" class="header-text hover:opacity-80 text-sm font-medium leading-normal flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-base">more_horiz</span>
                        <span>More</span>
                        <span class="material-symbols-outlined text-sm">expand_more</span>
                    </a>
                    <div class="absolute top-full left-0 mt-2 w-48 glass-dropdown rounded-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="p-2">
                            <a href="{{ route('public.about') }}" class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-green-600">info</span>
                                    <span class="font-medium">About Us</span>
                                </div>
                            </a>
                            <a href="{{ route('public.contact') }}" class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined" style="color: rgb(34, 197, 94);">mail</span>
                                    <span class="font-medium">Contact</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
            
            <div class="flex items-center gap-2 sm:gap-3">
                <!-- Dark Mode Toggle -->
                <button id="darkModeToggle" class="flex items-center justify-center w-10 h-10 header-text hover:bg-white/20 rounded-lg transition-colors" title="Toggle dark mode">
                    <span id="darkModeIcon" class="material-symbols-outlined">dark_mode</span>
                </button>
                
                @auth
                    <!-- Mobile Profile Dropdown (visible on mobile only) -->
                    <div class="sm:hidden relative group">
                        <button class="relative flex items-center justify-center w-10 h-10 header-text hover:bg-white/20 rounded-lg transition-colors" title="Profile">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover">
                            @else
                                <div class="w-8 h-8 bg-gradient-to-br from-primary to-cyan-600 rounded-full flex items-center justify-center text-xs font-bold text-white">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                </div>
                            @endif
                            @php
                                $unreadCount = auth()->user()->unreadNotificationsCount();
                            @endphp
                            @if($unreadCount > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full min-w-[16px] h-[16px] flex items-center justify-center border border-white dark:border-gray-800">
                                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                </span>
                            @endif
                        </button>
                        
                        <!-- Mobile Dropdown Menu -->
                        <div class="absolute right-0 top-full mt-2 w-56 glass-dropdown rounded-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="p-3 border-b border-gray-200 dark:border-gray-700">
                                <p class="text-sm font-semibold text-[#111816] dark:text-white truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="p-2">
                                <!-- User Menu -->
                                <a href="{{ route('public.counseling.sessions') }}#sessions" class="flex items-center justify-between px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined style="color: rgb(34, 197, 94);"">psychology</span>
                                        <span>My Counseling</span>
                                    </div>
                                    @php
                                        $sessionsCount = auth()->user()->allCounselingSessions()->count();
                                    @endphp
                                    @if($sessionsCount > 0)
                                        <span class="bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-semibold px-2 py-1 rounded-full min-w-[20px] text-center">{{ $sessionsCount }}</span>
                                    @endif
                                </a>
                                <a href="{{ route('public.assessments.index') }}#completed" class="flex items-center justify-between px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-green-600">quiz</span>
                                        <span>My Assessments</span>
                                    </div>
                                    @php
                                        $assessmentsCount = auth()->user()->assessmentAttempts()->count();
                                    @endphp
                                    @if($assessmentsCount > 0)
                                        <span class="bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-semibold px-2 py-1 rounded-full min-w-[20px] text-center">{{ $assessmentsCount }}</span>
                                    @endif
                                </a>
                                <a href="{{ route('public.forum.index') }}?filter=my" class="flex items-center justify-between px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-green-600">forum</span>
                                        <span>My Posts</span>
                                    </div>
                                    @php
                                        $postsCount = auth()->user()->forumPosts()->count();
                                    @endphp
                                    @if($postsCount > 0)
                                        <span class="bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-semibold px-2 py-1 rounded-full min-w-[20px] text-center">{{ $postsCount }}</span>
                                    @endif
                                </a>
                                <a href="{{ route('content.index', ['bookmarked' => 1]) }}#resources" class="flex items-center justify-between px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-orange-600">bookmark</span>
                                        <span>My Bookmarks</span>
                                    </div>
                                    @php
                                        $bookmarksCount = auth()->user()->bookmarks()
                                            ->where('bookmarkable_type', \App\Models\EducationalContent::class)
                                            ->count();
                                    @endphp
                                    @if($bookmarksCount > 0)
                                        <span class="bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300 text-xs font-semibold px-2 py-1 rounded-full min-w-[20px] text-center">{{ $bookmarksCount }}</span>
                                    @endif
                                </a>
                                @if(auth()->user()->role !== 'user')
                                    <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
                                    <!-- Admin/Counselor Menu -->
                                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined text-primary">dashboard</span>
                                        <span>Dashboard</span>
                                    </a>
                                @endif
                                <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
                                <button onclick="openProfileModal()" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors w-full text-left">
                                    <span class="material-symbols-outlined text-green-600">person</span>
                                    <span>Profile Settings</span>
                                </button>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined">logout</span>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth
                
                @guest
                    <button onclick="openLoginModal()" class="hidden sm:flex items-center justify-center rounded-lg h-9 sm:h-10 px-3 sm:px-5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-[#111816] dark:text-white text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Sign In
                    </button>
                    <button onclick="openSignupModal()" class="hidden sm:flex items-center justify-center rounded-lg h-9 sm:h-10 px-3 sm:px-5 bg-primary text-white text-sm font-bold hover:bg-primary/90 transition-colors">
                        Sign Up
                    </button>
                @else
                    <!-- Profile Dropdown -->
                    <div class="hidden sm:block relative group">
                        <button class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                            <div class="relative">
                                @if(auth()->user()->avatar)
                                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="size-9 sm:size-10 rounded-full object-cover border-2 border-primary">
                                @else
                                    <div class="size-9 sm:size-10 bg-gradient-to-br from-primary to-cyan-600 rounded-full flex items-center justify-center text-sm font-bold text-white border-2 border-primary">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                    </div>
                                @endif
                                @php
                                    $unreadCount = auth()->user()->unreadNotificationsCount();
                                @endphp
                                @if($unreadCount > 0)
                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full min-w-[18px] h-[18px] flex items-center justify-center border-2 border-white dark:border-gray-800">
                                        {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                                    </span>
                                @endif
                            </div>
                            <span class="material-symbols-outlined text-sm text-[#111816] dark:text-white">expand_more</span>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 top-full mt-2 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="p-3 border-b border-gray-200 dark:border-gray-700">
                                <p class="text-sm font-semibold text-[#111816] dark:text-white truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="p-2">
                                <!-- User Menu -->
                                <a href="{{ route('public.counseling.sessions') }}#sessions" class="flex items-center justify-between px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined style="color: rgb(34, 197, 94);"">psychology</span>
                                        <span>My Counseling</span>
                                    </div>
                                    @php
                                        $sessionsCount = auth()->user()->allCounselingSessions()->count();
                                    @endphp
                                    @if($sessionsCount > 0)
                                        <span class="bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-semibold px-2 py-1 rounded-full min-w-[20px] text-center">{{ $sessionsCount }}</span>
                                    @endif
                                </a>
                                <a href="{{ route('public.assessments.index') }}#completed" class="flex items-center justify-between px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-green-600">quiz</span>
                                        <span>My Assessments</span>
                                    </div>
                                    @php
                                        $assessmentsCount = auth()->user()->assessmentAttempts()->count();
                                    @endphp
                                    @if($assessmentsCount > 0)
                                        <span class="bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-semibold px-2 py-1 rounded-full min-w-[20px] text-center">{{ $assessmentsCount }}</span>
                                    @endif
                                </a>
                                <a href="{{ route('public.forum.index') }}?filter=my" class="flex items-center justify-between px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-green-600">forum</span>
                                        <span>My Posts</span>
                                    </div>
                                    @php
                                        $postsCount = auth()->user()->forumPosts()->count();
                                    @endphp
                                    @if($postsCount > 0)
                                        <span class="bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-semibold px-2 py-1 rounded-full min-w-[20px] text-center">{{ $postsCount }}</span>
                                    @endif
                                </a>
                                <a href="{{ route('content.index', ['bookmarked' => 1]) }}#resources" class="flex items-center justify-between px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-orange-600">bookmark</span>
                                        <span>My Bookmarks</span>
                                    </div>
                                    @php
                                        $bookmarksCount = auth()->user()->bookmarks()
                                            ->where('bookmarkable_type', \App\Models\EducationalContent::class)
                                            ->count();
                                    @endphp
                                    @if($bookmarksCount > 0)
                                        <span class="bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300 text-xs font-semibold px-2 py-1 rounded-full min-w-[20px] text-center">{{ $bookmarksCount }}</span>
                                    @endif
                                </a>
                                @if(auth()->user()->role !== 'user')
                                    <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
                                    <!-- Admin/Counselor Menu -->
                                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined text-primary">dashboard</span>
                                        <span>Dashboard</span>
                                    </a>
                                @endif
                                <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
                                <button onclick="openProfileModal()" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors w-full text-left">
                                    <span class="material-symbols-outlined text-green-600">person</span>
                                    <span>Profile Settings</span>
                                </button>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined">logout</span>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth
                
                <!-- Mobile Menu Toggle -->
                <button onclick="toggleMobileSidebar()" class="lg:hidden flex items-center justify-center w-10 h-10 header-text hover:bg-white/20 rounded-lg transition-colors">
                    <span class="material-symbols-outlined">menu</span>
                </button>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Sidebar Overlay -->
<div id="mobile-sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden transition-opacity" onclick="toggleMobileSidebar()"></div>

<!-- Mobile Sidebar -->
<div id="mobile-sidebar" class="fixed top-0 left-0 bottom-0 w-80 max-w-[85vw] glass-sidebar z-50 transform -translate-x-full transition-transform duration-300 ease-in-out lg:hidden shadow-2xl">
    <div class="flex flex-col h-full">
        <!-- Sidebar Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-800">
            <h3 class="text-lg font-bold text-[#111816] dark:text-white">Menu</h3>
            <button onclick="toggleMobileSidebar()" class="flex items-center justify-center w-10 h-10 text-[#111816] dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <!-- Sidebar Content -->
        <div class="flex-1 overflow-y-auto p-4">
            <nav class="space-y-1">
                <a class="flex items-center gap-3 text-gray-900 dark:text-primary hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-700 dark:hover:text-primary/80 px-4 py-3 rounded-lg transition-colors" href="{{ route('home') }}">
                    <span class="material-symbols-outlined">home</span>
                    <span class="font-medium">Home</span>
                </a>
                
                <!-- Resources Section -->
                <div class="py-2">
                    <button onclick="toggleResourcesDropdown()" class="flex items-center justify-between w-full text-gray-900 dark:text-primary px-4 py-2 font-semibold hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined">library_books</span>
                            <span>Resources</span>
                        </div>
                        <span id="resourcesDropdownIcon" class="material-symbols-outlined text-sm transition-transform duration-200">expand_more</span>
                    </button>
                    <div id="resourcesDropdownContent" class="ml-8 space-y-1 mt-1 hidden">
                        <a class="flex items-center gap-3 text-gray-900 dark:text-primary hover:text-gray-700 dark:hover:text-primary/80 px-4 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors" href="{{ route('content.index') }}">
                            <span class="material-symbols-outlined !text-base">library_books</span>
                            <span>All Resources</span>
                        </a>
                        @php
                            $categories = \App\Models\Category::active()->ordered()->get();
                            $categoryIcons = [
                                'alcohol-awareness' => 'local_bar',
                                'drug-prevention' => 'medication',
                                'mental-health' => 'psychology',
                                'healthy-living' => 'spa',
                                'peer-pressure' => 'groups',
                                'recovery-support' => 'favorite',
                            ];
                        @endphp
                        @foreach($categories as $category)
                            <a class="flex items-center gap-3 text-gray-900 dark:text-primary hover:text-gray-700 dark:hover:text-primary/80 px-4 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors" href="{{ route('content.index', ['category' => $category->slug]) }}">
                                <span class="material-symbols-outlined !text-base" style="color: rgb(34, 197, 94);">{{ $categoryIcons[$category->slug] ?? 'article' }}</span>
                                <span>{{ $category->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
                
                <!-- Counseling Section -->
                <div class="py-2">
                    <button onclick="toggleCounselingDropdown()" class="flex items-center justify-between w-full text-gray-900 dark:text-primary px-4 py-2 font-semibold hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined">psychology</span>
                            <span>Counseling</span>
                        </div>
                        <span id="counselingDropdownIcon" class="material-symbols-outlined text-sm transition-transform duration-200">expand_more</span>
                    </button>
                    <div id="counselingDropdownContent" class="ml-8 space-y-1 mt-1 hidden">
                        <a class="flex items-center gap-3 text-gray-900 dark:text-primary hover:text-gray-700 dark:hover:text-primary/80 px-4 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors" href="{{ route('public.counseling.index') }}">
                            <span class="material-symbols-outlined !text-base">support_agent</span>
                            <span>Our Services</span>
                        </a>
                        <a class="flex items-center gap-3 text-gray-900 dark:text-primary hover:text-gray-700 dark:hover:text-primary/80 px-4 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors" href="{{ route('public.counseling.counselors') }}">
                            <span class="material-symbols-outlined !text-base">group</span>
                            <span>Our Counselors</span>
                        </a>
                        @auth
                            <a class="flex items-center gap-3 text-gray-900 dark:text-primary hover:text-gray-700 dark:hover:text-primary/80 px-4 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors" href="{{ route('public.counseling.sessions') }}">
                                <span class="material-symbols-outlined !text-base">calendar_today</span>
                                <span>My Sessions</span>
                            </a>
                            <a class="flex items-center gap-3 text-gray-900 dark:text-primary font-medium px-4 py-2 rounded-lg hover:bg-primary/10 transition-colors" href="{{ route('public.counseling.sessions') }}">
                                <span class="material-symbols-outlined !text-base">add_circle</span>
                                <span>Request Session</span>
                            </a>
                        @else
                            <button onclick="openLoginModal(); toggleMobileSidebar();" class="flex items-center gap-3 w-full text-left text-gray-900 dark:text-primary font-medium px-4 py-2 rounded-lg hover:bg-primary/10 transition-colors">
                                <span class="material-symbols-outlined !text-base">add_circle</span>
                                <span>Request Session</span>
                            </button>
                        @endauth
                    </div>
                </div>
                
                <a class="flex items-center gap-3 text-gray-900 dark:text-primary hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-700 dark:hover:text-primary/80 px-4 py-3 rounded-lg transition-colors" href="{{ route('public.assessments.index') }}">
                    <span class="material-symbols-outlined">quiz</span>
                    <span class="font-medium">Assessments</span>
                </a>
                
                <a class="flex items-center gap-3 text-gray-900 dark:text-primary hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-700 dark:hover:text-primary/80 px-4 py-3 rounded-lg transition-colors" href="{{ route('public.forum.index') }}">
                    <span class="material-symbols-outlined">forum</span>
                    <span class="font-medium">Community Forum</span>
                </a>
                
                <a class="flex items-center gap-3 text-gray-900 dark:text-primary hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-700 dark:hover:text-primary/80 px-4 py-3 rounded-lg transition-colors" href="{{ route('campaigns.index') }}">
                    <span class="material-symbols-outlined">campaign</span>
                    <span class="font-medium">Events</span>
                </a>
                
                <a class="flex items-center gap-3 text-gray-900 dark:text-primary hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-700 dark:hover:text-primary/80 px-4 py-3 rounded-lg transition-colors" href="{{ route('public.about') }}">
                    <span class="material-symbols-outlined">info</span>
                    <span class="font-medium">About Us</span>
                </a>
                
                <a class="flex items-center gap-3 text-gray-900 dark:text-primary hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-700 dark:hover:text-primary/80 px-4 py-3 rounded-lg transition-colors" href="{{ route('public.contact') }}">
                    <span class="material-symbols-outlined">mail</span>
                    <span class="font-medium">Contact</span>
                </a>
            </nav>
        </div>
        
        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-gray-200 dark:border-gray-800 space-y-2">
            @guest
                <button onclick="openSignupModal(); toggleMobileSidebar();" class="flex items-center justify-center gap-2 w-full bg-primary text-white py-3 px-4 rounded-lg font-bold hover:bg-primary/90 transition-colors">
                    <span class="material-symbols-outlined">person_add</span>
                    Sign Up
                </button>
                <button onclick="openLoginModal(); toggleMobileSidebar();" class="flex items-center justify-center gap-2 w-full bg-gray-200 dark:bg-gray-800 text-[#111816] dark:text-white py-3 px-4 rounded-lg font-bold hover:bg-gray-300 dark:hover:bg-gray-700 transition-colors">
                    <span class="material-symbols-outlined">login</span>
                    Sign In
                </button>
            @else
                @if(auth()->user()->role !== 'user')
                    <a href="{{ route('dashboard') }}" class="flex items-center justify-center gap-2 w-full bg-primary text-white py-3 px-4 rounded-lg font-bold hover:bg-primary/90 transition-colors">
                        <span class="material-symbols-outlined">dashboard</span>
                        Dashboard
                    </a>
                @endif
                <button onclick="openProfileModal(); toggleMobileSidebar();" class="flex items-center justify-center gap-2 w-full bg-gray-200 dark:bg-gray-800 text-[#111816] dark:text-white py-3 px-4 rounded-lg font-bold hover:bg-gray-300 dark:hover:bg-gray-700 transition-colors">
                    <span class="material-symbols-outlined">person</span>
                    Profile
                </button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center justify-center gap-2 w-full bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 py-3 px-4 rounded-lg font-bold hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors">
                        <span class="material-symbols-outlined">logout</span>
                        Logout
                    </button>
                </form>
            @endguest
        </div>
    </div>
</div>

<script>
function toggleMobileSidebar() {
    const sidebar = document.getElementById('mobile-sidebar');
    const overlay = document.getElementById('mobile-sidebar-overlay');
    
    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
    
    // Prevent body scroll when sidebar is open
    document.body.classList.toggle('overflow-hidden');
}

function toggleCounselingDropdown() {
    const content = document.getElementById('counselingDropdownContent');
    const icon = document.getElementById('counselingDropdownIcon');
    
    if (content && icon) {
        const isHidden = content.classList.contains('hidden');
        
        if (isHidden) {
            content.classList.remove('hidden');
            icon.textContent = 'expand_less';
            icon.style.transform = 'rotate(180deg)';
        } else {
            content.classList.add('hidden');
            icon.textContent = 'expand_more';
            icon.style.transform = 'rotate(0deg)';
        }
    }
}

function toggleResourcesDropdown() {
    const content = document.getElementById('resourcesDropdownContent');
    const icon = document.getElementById('resourcesDropdownIcon');
    
    if (content && icon) {
        const isHidden = content.classList.contains('hidden');
        
        if (isHidden) {
            content.classList.remove('hidden');
            icon.textContent = 'expand_less';
            icon.style.transform = 'rotate(180deg)';
        } else {
            content.classList.add('hidden');
            icon.textContent = 'expand_more';
            icon.style.transform = 'rotate(0deg)';
        }
    }
}

function toggleCategoryResources(event, categorySlug) {
    event.preventDefault();
    event.stopPropagation();
    
    // Close all other category dropdowns
    document.querySelectorAll('[id^="resources-"]').forEach(dropdown => {
        if (dropdown.id !== `resources-${categorySlug}`) {
            dropdown.classList.add('hidden');
        }
    });
    
    // Toggle the clicked category dropdown
    const dropdown = document.getElementById(`resources-${categorySlug}`);
    if (dropdown) {
        dropdown.classList.toggle('hidden');
    }
}

// Close category dropdowns when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.category-item')) {
        document.querySelectorAll('[id^="resources-"]').forEach(dropdown => {
            dropdown.classList.add('hidden');
        });
    }
});
</script>

