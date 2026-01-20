@extends('layouts.public')

@section('title', $content->title . ' - WellPath')

@section('content')
<!-- Progress Bar -->
<div class="fixed top-16 left-0 right-0 z-40 h-1 bg-gray-200 dark:bg-gray-800">
    <div id="reading-progress" class="h-full bg-gradient-to-r from-primary to-green-500 transition-all duration-300 ease-out" style="width: 0%"></div>
</div>

<!-- Full-width white background container -->
<div class="w-full bg-white dark:bg-gray-900 min-h-screen">
    <!-- Centered content container -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Breadcrumb Navigation -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-xs text-[#61897c] dark:text-gray-400">
            <li><a href="{{ route('home') }}" class="hover:text-primary">Home</a></li>
            <li><span class="material-symbols-outlined !text-sm">chevron_right</span></li>
            <li><a href="{{ route('content.index') }}" class="hover:text-primary">Resources</a></li>
            <li><span class="material-symbols-outlined !text-sm">chevron_right</span></li>
            <li class="text-[#111816] dark:text-white font-medium">{{ Str::limit($content->title, 40) }}</li>
        </ol>
    </nav>

    <!-- Compact Article Header -->
    <header class="mb-8">
        <!-- Category and Meta Tags -->
        <div class="flex flex-wrap items-center gap-3 mb-4">
            <span class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider px-3 py-1.5 rounded-full
                @if($content->category->name === 'Mental Health') text-yellow-700 dark:text-yellow-300 bg-gradient-to-r from-yellow-100 to-yellow-200 dark:from-yellow-900/50 dark:to-yellow-800/50
                @elseif($content->category->name === 'Alcohol') text-blue-700 dark:text-blue-300 bg-gradient-to-r from-blue-100 to-blue-200 dark:from-blue-900/50 dark:to-blue-800/50
                @elseif($content->category->name === 'Drug Information') text-orange-700 dark:text-orange-300 bg-gradient-to-r from-orange-100 to-orange-200 dark:from-orange-900/50 dark:to-orange-800/50
                @elseif($content->category->name === 'Support') text-purple-700 dark:text-purple-300 bg-gradient-to-r from-purple-100 to-purple-200 dark:from-purple-900/50 dark:to-purple-800/50
                @else text-green-700 dark:text-green-300 bg-gradient-to-r from-green-100 to-green-200 dark:from-green-900/50 dark:to-green-800/50
                @endif">
                {{ $content->category->name }}
            </span>
            
            <div class="flex items-center gap-3 text-xs text-[#61897c] dark:text-gray-400">
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined !text-base">calendar_today</span>
                    {{ $content->published_at->format('M d, Y') }}
                </span>
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined !text-base">{{ $content->type === 'video' ? 'play_circle' : 'schedule' }}</span>
                    {{ $content->reading_time }} min {{ $content->type === 'video' ? 'watch' : 'read' }}
                </span>
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined !text-base">visibility</span>
                    {{ number_format($content->views) }}
                </span>
            </div>
        </div>
        
        <!-- Title -->
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold leading-tight text-[#111816] dark:text-white mb-3">
            {{ $content->title }}
        </h1>
        
        <!-- Description -->
        @if($content->description)
        <p class="text-base text-[#61897c] dark:text-gray-300 leading-relaxed mb-4">
            {{ $content->description }}
        </p>
        @endif
        
        <!-- Author and Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 py-3 border-t border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <img src="{{ $content->author->profile_photo_url }}" alt="{{ $content->author->name }}" 
                     class="w-10 h-10 rounded-full border-2 border-primary/20">
                <div>
                    <p class="font-semibold text-sm text-[#111816] dark:text-white">{{ $content->author->name }}</p>
                    <p class="text-xs text-[#61897c] dark:text-gray-400">Wellness Expert</p>
                </div>
            </div>
            
            <div class="flex items-center gap-2">
                @auth
                    <button onclick="toggleBookmark()" class="flex items-center gap-1.5 px-3 py-1.5 bg-primary/10 text-primary rounded-lg hover:bg-primary/20 transition-all text-sm font-medium">
                        <span class="material-symbols-outlined !text-base" id="bookmark-icon">bookmark_border</span>
                        <span id="bookmark-text">Save</span>
                    </button>
                    <button onclick="shareContent()" class="flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-all text-sm font-medium">
                        <span class="material-symbols-outlined !text-base">share</span>
                        Share
                    </button>
                @else
                    <button onclick="openLoginModal()" class="flex items-center gap-1.5 px-3 py-1.5 bg-primary text-white rounded-lg hover:bg-primary/90 transition-all text-sm font-medium">
                        <span class="material-symbols-outlined !text-base">login</span>
                        Login to Save
                    </button>
                @endauth
            </div>
        </div>
    </header>

    <!-- Featured Image/Hero (Only for non-infographic, non-video content) -->
    @if($content->featured_image && $content->type !== 'infographic' && $content->type !== 'video')
    <div class="mb-8">
        <div class="relative overflow-hidden rounded-xl">
            <img src="{{ $content->featured_image_url }}" alt="{{ $content->title }}" 
                 class="w-full h-48 md:h-80 object-cover">
        </div>
    </div>
    @endif

    <!-- Video Content (Show immediately for videos) -->
    @if($content->type === 'video' && $content->video_url)
    <div id="video" class="mb-8">
        <div class="bg-white dark:bg-gray-800/30 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
            <div class="aspect-video rounded-lg overflow-hidden bg-black">
                    @if(str_contains($content->video_url, 'youtube.com') || str_contains($content->video_url, 'youtu.be'))
                        @php
                            $videoId = '';
                            if (str_contains($content->video_url, 'youtube.com/watch?v=')) {
                                $videoId = substr($content->video_url, strpos($content->video_url, 'v=') + 2);
                                $videoId = substr($videoId, 0, strpos($videoId, '&') ?: strlen($videoId));
                            } elseif (str_contains($content->video_url, 'youtu.be/')) {
                                $videoId = substr($content->video_url, strrpos($content->video_url, '/') + 1);
                            }
                            $embedUrl = "https://www.youtube.com/embed/{$videoId}";
                        @endphp
                        <iframe src="{{ $embedUrl }}" class="w-full h-full" frameborder="0" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
                    @elseif(str_contains($content->video_url, 'vimeo.com'))
                        @php
                            $videoId = substr($content->video_url, strrpos($content->video_url, '/') + 1);
                            $embedUrl = "https://player.vimeo.com/video/{$videoId}";
                        @endphp
                        <iframe src="{{ $embedUrl }}" class="w-full h-full" frameborder="0" allowfullscreen allow="autoplay; fullscreen; picture-in-picture"></iframe>
                    @else
                        @if(str_contains($content->video_url, '.mp4') || str_contains($content->video_url, '.webm') || str_contains($content->video_url, '.ogg'))
                            <video class="w-full h-full object-cover" controls>
                                <source src="{{ $content->video_url }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @else
                            <iframe src="{{ $content->video_url }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                        @endif
                    @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Article Content -->
    <div class="mb-12">
        <!-- Main Content -->
        <article class="px-4 sm:px-6 lg:px-8">
            <!-- Infographic Image (inside main content area) -->
            @if($content->type === 'infographic' && $content->featured_image)
            <div class="mb-6">
                <div class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-900 flex items-center justify-center" style="max-height: 600px;">
                    <img src="{{ $content->featured_image_url }}" alt="{{ $content->title }}" 
                         class="w-full h-auto object-contain" style="max-height: 600px;">
                </div>
            </div>
            @endif

            <div class="px-4 sm:px-6 lg:px-12">
                <div class="prose prose-base max-w-none dark:prose-invert 
                           prose-headings:font-bold prose-headings:text-[#111816] dark:prose-headings:text-white prose-headings:tracking-tight
                           prose-p:text-[#61897c] dark:prose-p:text-gray-300 prose-p:leading-relaxed prose-p:text-lg
                           prose-a:text-primary prose-a:no-underline hover:prose-a:underline prose-a:font-semibold
                           prose-strong:text-[#111816] dark:prose-strong:text-white prose-strong:font-bold
                           prose-blockquote:border-l-4 prose-blockquote:border-primary prose-blockquote:bg-primary/5 dark:prose-blockquote:bg-primary/10 
                           prose-blockquote:rounded-r-xl prose-blockquote:p-6 prose-blockquote:my-8 prose-blockquote:font-medium
                           prose-ul:text-[#61897c] dark:prose-ul:text-gray-300 prose-li:text-lg prose-li:leading-relaxed
                           prose-ol:text-[#61897c] dark:prose-ol:text-gray-300
                           prose-code:bg-gray-100 dark:prose-code:bg-gray-800 prose-code:px-2 prose-code:py-1 prose-code:rounded prose-code:text-sm
                           prose-pre:bg-gray-900 prose-pre:rounded-xl prose-pre:p-6">
                    {!! $content->content !!}
                </div>
            </div>
        </article>
    </div>



    <!-- File Download -->
    @if($content->file_path)
    <div id="downloads" class="mb-8">
        <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-6 border border-green-200 dark:border-green-800">
            <h3 class="text-lg font-bold text-[#111816] dark:text-white mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-green-600">download</span>
                Download Resources
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Main Download -->
                <div class="bg-white dark:bg-gray-800/50 rounded-lg p-4 border border-gray-200 dark:border-gray-700 hover:border-primary transition-all">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary !text-2xl">
                                @php
                                    $fileExtension = strtolower(pathinfo($content->file_path ?? '', PATHINFO_EXTENSION));
                                @endphp
                                @if($fileExtension === 'pdf')
                                    picture_as_pdf
                                @elseif(in_array($fileExtension, ['doc', 'docx']))
                                    description
                                @elseif(in_array($fileExtension, ['xls', 'xlsx']))
                                    table_chart
                                @elseif(in_array($fileExtension, ['ppt', 'pptx']))
                                    slideshow
                                @elseif(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                    image
                                @elseif(in_array($fileExtension, ['zip', 'rar']))
                                    folder_zip
                                @else
                                    description
                                @endif
                            </span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-sm text-[#111816] dark:text-white">Resource File</h4>
                            <p class="text-xs text-[#61897c] dark:text-gray-400">
                                @php
                                    $fileExtension = pathinfo($content->file_path ?? '', PATHINFO_EXTENSION);
                                    $fileType = strtoupper($fileExtension) ?: 'FILE';
                                @endphp
                                {{ $fileType }} • Supplementary Material
                            </p>
                        </div>
                    </div>
                    <a href="{{ $content->file_url ?? asset('storage/' . $content->file_path) }}" 
                       class="inline-flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-lg font-medium hover:bg-primary/90 transition-all text-sm w-full justify-center" 
                       download
                       target="_blank">
                        <span class="material-symbols-outlined !text-base">file_download</span>
                        Download
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Enhanced Interactive Actions -->
    <x-content-feedback :content="$content" />

    <!-- Enhanced Related Content -->
    @if(isset($relatedContents) && $relatedContents->count() > 0)
    <div id="related" class="mb-16">
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-3 bg-primary/20 dark:bg-primary/30 text-primary px-6 py-3 rounded-full font-semibold mb-4">
                <span class="material-symbols-outlined !text-xl">explore</span>
                Continue Learning
            </div>
            <h3 class="text-3xl md:text-4xl font-black text-[#111816] dark:text-white mb-4 tracking-tight">
                You Might Also Like
            </h3>
            <p class="text-[#61897c] dark:text-gray-400 max-w-2xl mx-auto">
                Discover more valuable resources to expand your knowledge and support your wellness journey.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
            @foreach($relatedContents->take(3) as $related)
            <article class="group bg-white dark:bg-gray-800/50 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-[#f0f4f3] dark:border-gray-800 transform hover:-translate-y-2">
                <!-- Enhanced Image Container -->
                <div class="relative w-full aspect-video bg-center bg-no-repeat bg-cover overflow-hidden" 
                     style="background-image: url('{{ $related->featured_image ? $related->featured_image_url : 'https://lh3.googleusercontent.com/aida-public/AB6AXuDuXoSapEBaja_kQ1hrYBGTGOGzYhm8hAs4J1cnbzKK5K4J3XnDAZgVzVLDrTSqsLKear5TspYM6ur2y5JoX9vXUlm6wR287hGWzn1-HvqOtuRpyVefLK8NtI5ORkjQFiB6MBqwd8fwMNkEHk84VAS-lbFQyOMpL7VoHohpIb_HpqXUYCS7bIDxZU8Xf5CN7riZcvzO2voJDsPEsy3bKcGBVfn1UoAm23rLIjMHroTlkiDHVGlaEGfPWH-OE908XwE3hynanLtD3w' }}')">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <!-- Content Type Badge -->
                    <div class="absolute top-4 left-4">
                        <div class="flex items-center gap-1 bg-white/95 dark:bg-gray-900/95 backdrop-blur-sm px-3 py-1.5 rounded-full text-xs font-semibold text-[#111816] dark:text-white shadow-sm">
                            <span class="material-symbols-outlined !text-sm">
                                @if($related->type === 'video') play_circle
                                @elseif($related->type === 'infographic') image
                                @elseif($related->type === 'guide') menu_book
                                @else article
                                @endif
                            </span>
                            {{ ucfirst($related->type) }}
                        </div>
                    </div>
                    
                    <!-- Reading Time -->
                    <div class="absolute top-4 right-4">
                        <div class="flex items-center gap-1 bg-primary/90 backdrop-blur-sm px-3 py-1.5 rounded-full text-xs font-semibold text-white shadow-sm">
                            <span class="material-symbols-outlined !text-sm">schedule</span>
                            {{ $related->reading_time }} min
                        </div>
                    </div>
                    
                    <!-- Bookmark Indicator -->
                    @auth
                        @if($related->isBookmarkedBy(auth()->id()))
                            <div class="absolute top-16 right-4">
                                <div class="flex items-center justify-center w-8 h-8 bg-primary rounded-full shadow-lg">
                                    <span class="material-symbols-outlined !text-sm text-white">bookmark</span>
                                </div>
                            </div>
                        @endif
                    @endauth
                    
                    <!-- Hover Overlay -->
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="bg-primary/90 backdrop-blur-sm rounded-full p-3 transform scale-75 group-hover:scale-100 transition-transform duration-300">
                            <span class="material-symbols-outlined text-white !text-xl">arrow_forward</span>
                        </div>
                    </div>
                </div>
                
                <!-- Enhanced Content -->
                <div class="p-6 flex flex-col gap-4 flex-1">
                    <!-- Category and Actions -->
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center gap-1 text-xs font-bold uppercase tracking-wider px-3 py-1.5 rounded-full
                            @if($related->category->name === 'Mental Health') text-yellow-700 dark:text-yellow-300 bg-yellow-100 dark:bg-yellow-900/50
                            @elseif($related->category->name === 'Alcohol') text-blue-700 dark:text-blue-300 bg-blue-100 dark:bg-blue-900/50
                            @elseif($related->category->name === 'Drug Information') text-orange-700 dark:text-orange-300 bg-orange-100 dark:bg-orange-900/50
                            @elseif($related->category->name === 'Support') text-purple-700 dark:text-purple-300 bg-purple-100 dark:bg-purple-900/50
                            @else text-green-700 dark:text-green-300 bg-green-100 dark:bg-green-900/50
                            @endif">
                            <span class="material-symbols-outlined !text-sm">category</span>
                            {{ $related->category->name }}
                        </span>
                        
                        @auth
                            <button onclick="toggleBookmark({{ $related->id }}, this)" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors opacity-0 group-hover:opacity-100" data-bookmarked="{{ $related->isBookmarkedBy(auth()->id()) ? 'true' : 'false' }}">
                                <span class="material-symbols-outlined !text-lg {{ $related->isBookmarkedBy(auth()->id()) ? 'text-primary' : 'text-[#61897c] dark:text-gray-400' }} hover:text-primary">
                                    {{ $related->isBookmarkedBy(auth()->id()) ? 'bookmark' : 'bookmark_border' }}
                                </span>
                            </button>
                        @else
                            <button onclick="openLoginModal()" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors opacity-0 group-hover:opacity-100">
                                <span class="material-symbols-outlined !text-lg text-[#61897c] dark:text-gray-400 hover:text-primary">bookmark_border</span>
                            </button>
                        @endauth
                    </div>
                    
                    <!-- Title -->
                    <h4 class="text-[#111816] dark:text-white text-xl font-bold leading-tight group-hover:text-primary dark:group-hover:text-primary transition-colors duration-200 line-clamp-2">
                        <a href="{{ route('content.show', $related) }}" class="block">{{ $related->title }}</a>
                    </h4>
                    
                    <!-- Description -->
                    <p class="text-[#61897c] dark:text-gray-400 text-sm leading-relaxed line-clamp-3 flex-1">
                        {{ Str::limit($related->description, 120) }}
                    </p>
                    
                    <!-- Footer Stats -->
                    <div class="flex items-center justify-between pt-4 border-t border-[#f0f4f3] dark:border-gray-700">
                        <div class="flex items-center gap-3 text-xs text-[#61897c] dark:text-gray-500">
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined !text-base">visibility</span>
                                <span class="font-medium">{{ number_format($related->views) }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined !text-base">calendar_today</span>
                                <span class="font-medium">{{ $related->created_at->format('M j') }}</span>
                            </div>
                        </div>
                        
                        <a href="{{ route('content.show', $related) }}" 
                           class="inline-flex items-center gap-1 text-primary hover:text-primary/80 text-sm font-semibold transition-colors group/read opacity-0 group-hover:opacity-100">
                            Read More
                            <span class="material-symbols-outlined !text-sm transform group-hover/read:translate-x-0.5 transition-transform">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        
        <!-- View More Button -->
        <div class="text-center mt-12">
            <a href="{{ route('content.index') }}" 
               class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-primary to-green-500 text-white rounded-2xl font-semibold hover:from-primary/90 hover:to-green-500/90 transition-all duration-200 transform hover:scale-105 shadow-lg">
                <span class="material-symbols-outlined !text-xl">library_books</span>
                Explore All Resources
                <span class="material-symbols-outlined !text-xl">arrow_forward</span>
            </a>
        </div>
    </div>
    @endif

    <!-- Enhanced Back Navigation -->
    <div class="text-center">
        <div class="bg-white dark:bg-gray-800/50 rounded-2xl p-8 shadow-sm border border-[#f0f4f3] dark:border-gray-800">
            <div class="max-w-2xl mx-auto">
                <h3 class="text-xl font-bold text-[#111816] dark:text-white mb-4">
                    Continue Your Learning Journey
                </h3>
                <p class="text-[#61897c] dark:text-gray-400 mb-6">
                    Explore more educational resources and discover valuable content to support your wellness goals.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('content.index') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-xl hover:bg-primary/90 transition-all duration-200 transform hover:scale-105 font-semibold shadow-sm">
                        <span class="material-symbols-outlined !text-lg">arrow_back</span>
                        Back to Resources
                    </a>
                    <a href="{{ route('home') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-gray-800 border border-[#f0f4f3] dark:border-gray-700 text-[#111816] dark:text-gray-300 rounded-xl hover:bg-white dark:hover:bg-gray-700 transition-all duration-200 transform hover:scale-105 font-semibold">
                        <span class="material-symbols-outlined !text-lg">home</span>
                        Return Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End of centered content container -->
</div>
<!-- End of full-width white background container -->

@push('styles')
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
    
    /* Quill Editor List Styles */
    .prose ul, .prose ol {
        padding-left: 1.5rem;
        margin: 1rem 0;
    }
    
    .prose ul li {
        list-style-type: disc;
        margin: 0.5rem 0;
        padding-left: 0.25rem;
    }
    
    .prose ol li {
        list-style-type: decimal;
        margin: 0.5rem 0;
        padding-left: 0.25rem;
    }
    
    .prose ul ul li {
        list-style-type: circle;
    }
    
    .prose ul ul ul li {
        list-style-type: square;
    }
    
    .prose ol ol li {
        list-style-type: lower-alpha;
    }
    
    .prose ol ol ol li {
        list-style-type: lower-roman;
    }
    
    /* Fix paragraph spacing to match Quill editor */
    .prose p {
        margin-top: 1em;
        margin-bottom: 1em;
    }
    
    .prose p:first-child {
        margin-top: 0;
    }
    
    .prose p:last-child {
        margin-bottom: 0;
    }
    
    /* Ensure consistent line breaks */
    .prose br {
        display: block;
        margin: 0.5em 0;
        content: "";
    }
    
    /* Handle Quill's empty paragraphs */
    .prose p:empty {
        margin: 0.5em 0;
        min-height: 1em;
    }
    
    /* Handle consecutive paragraphs */
    .prose p + p {
        margin-top: 1em;
    }
    
    /* Quill specific classes */
    .ql-indent-1 { margin-left: 3rem; }
    .ql-indent-2 { margin-left: 4.5rem; }
    .ql-indent-3 { margin-left: 6rem; }
    .ql-indent-4 { margin-left: 7.5rem; }
    .ql-indent-5 { margin-left: 9rem; }
    .ql-indent-6 { margin-left: 10.5rem; }
    .ql-indent-7 { margin-left: 12rem; }
    .ql-indent-8 { margin-left: 13.5rem; }
    
    /* Smooth scroll behavior */
    html {
        scroll-behavior: smooth;
    }
    
    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #14eba3;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #12d494;
    }
    
    /* Reading progress animation */
    #reading-progress {
        transition: width 0.3s ease-out;
    }
    
    /* Toast animations */
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    .toast-enter {
        animation: slideInRight 0.3s ease-out;
    }
    
    .toast-exit {
        animation: slideOutRight 0.3s ease-out;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Reading progress bar
    function updateReadingProgress() {
        const article = document.querySelector('article');
        if (!article) return;
        
        const articleTop = article.offsetTop;
        const articleHeight = article.offsetHeight;
        const windowHeight = window.innerHeight;
        const scrollTop = window.pageYOffset;
        
        const progress = Math.min(
            Math.max((scrollTop - articleTop + windowHeight * 0.3) / articleHeight, 0),
            1
        ) * 100;
        
        document.getElementById('reading-progress').style.width = progress + '%';
    }
    
    window.addEventListener('scroll', updateReadingProgress);
    updateReadingProgress();
    
    // Smooth scroll for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe elements for fade-in animation
    document.querySelectorAll('article.group, .bg-gradient-to-br').forEach(element => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';
        element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(element);
    });
});

// Enhanced bookmark functionality
function toggleBookmark() {
    const icons = document.querySelectorAll('#bookmark-icon, #bookmark-icon-main');
    const texts = document.querySelectorAll('#bookmark-text, #bookmark-text-main');
    
    // Make AJAX call to save/remove the bookmark
    fetch('{{ route("content.bookmark", $content) }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            icons.forEach(icon => {
                if (data.bookmarked) {
                    icon.textContent = 'bookmark';
                    icon.classList.add('text-primary');
                } else {
                    icon.textContent = 'bookmark_border';
                    icon.classList.remove('text-primary');
                }
            });
            
            texts.forEach(text => {
                if (data.bookmarked) {
                    text.textContent = 'Saved to Library';
                } else {
                    text.textContent = 'Save to My Library';
                }
            });
            
            showToast(data.message, data.bookmarked ? 'success' : 'info');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred', 'error');
    });
}

// Enhanced share functionality
function shareContent() {
    openShareModal();
}

// Share modal functions
function openShareModal() {
    const modal = document.getElementById('shareModal');
    const modalContent = document.getElementById('shareModalContent');
    
    modal.classList.remove('hidden');
    
    // Animate modal in
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
    
    // Close on backdrop click
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeShareModal();
        }
    });
    
    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeShareModal();
        }
    });
}

function closeShareModal() {
    const modal = document.getElementById('shareModal');
    const modalContent = document.getElementById('shareModalContent');
    
    // Animate modal out
    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

// Share platform functions
function shareToTwitter() {
    const text = encodeURIComponent('{{ $content->title }} - {{ $content->description }}');
    const url = encodeURIComponent(window.location.href);
    window.open(`https://twitter.com/intent/tweet?text=${text}&url=${url}`, '_blank');
    showToast('Opening Twitter...', 'info');
    closeShareModal();
}

function shareToLinkedIn() {
    const url = encodeURIComponent(window.location.href);
    window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}`, '_blank');
    showToast('Opening LinkedIn...', 'info');
    closeShareModal();
}

function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        showToast('Link copied to clipboard! 📋', 'success');
        closeShareModal();
    }).catch(() => {
        showToast('Failed to copy link', 'error');
    });
}

function shareViaEmail() {
    const subject = encodeURIComponent('{{ $content->title }}');
    const body = encodeURIComponent(`I thought you might find this interesting:\n\n{{ $content->title }}\n{{ $content->description }}\n\n${window.location.href}`);
    window.location.href = `mailto:?subject=${subject}&body=${body}`;
    showToast('Opening email client...', 'info');
    closeShareModal();
}

// Enhanced feedback functionality
function rateFeedback(type) {
    const message = type === 'positive' 
        ? 'Thank you for your positive feedback! 👍' 
        : 'Thanks for your feedback. We\'ll work to improve! 💪';
    
    showToast(message, type === 'positive' ? 'success' : 'info');
    
    // Disable buttons after rating
    const buttons = document.querySelectorAll('button[onclick*="rateFeedback"]');
    buttons.forEach(btn => {
        btn.disabled = true;
        btn.classList.add('opacity-50', 'cursor-not-allowed');
    });
    
    // Here you would make an AJAX call to save the feedback
}

// Utility functions
function printContent() {
    window.print();
    showToast('Opening print dialog...', 'info');
}

function saveAsPDF() {
    showToast('PDF generation coming soon! 📄', 'info');
    // Here you would implement PDF generation
}

// Enhanced toast notification system
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    const bgColor = {
        'success': 'bg-green-500',
        'error': 'bg-red-500',
        'info': 'bg-blue-500',
        'warning': 'bg-yellow-500'
    }[type] || 'bg-primary';
    
    toast.className = `fixed top-24 right-4 z-50 px-6 py-4 rounded-2xl shadow-2xl text-white font-semibold ${bgColor} toast-enter max-w-sm`;
    toast.innerHTML = `
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined !text-xl">
                ${type === 'success' ? 'check_circle' : 
                  type === 'error' ? 'error' : 
                  type === 'warning' ? 'warning' : 'info'}
            </span>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Auto remove after 4 seconds
    setTimeout(() => {
        toast.classList.remove('toast-enter');
        toast.classList.add('toast-exit');
        setTimeout(() => {
            if (document.body.contains(toast)) {
                document.body.removeChild(toast);
            }
        }, 300);
    }, 4000);
    
    // Click to dismiss
    toast.addEventListener('click', () => {
        toast.classList.remove('toast-enter');
        toast.classList.add('toast-exit');
        setTimeout(() => {
            if (document.body.contains(toast)) {
                document.body.removeChild(toast);
            }
        }, 300);
    });
}

// Scroll to video section
function scrollToVideo() {
    const videoSection = document.getElementById('video');
    if (videoSection) {
        videoSection.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
}

// Initialize tooltips and other interactive elements
document.addEventListener('DOMContentLoaded', function() {
    // Add hover effects to buttons
    const buttons = document.querySelectorAll('button, a');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.02)';
        });
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
});
</script>
@endpush

<!-- Share Modal -->
<div id="shareModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="shareModalContent">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-xl font-bold text-[#111816] dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">share</span>
                Share This Content
            </h3>
            <button onclick="closeShareModal()" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                <span class="material-symbols-outlined text-gray-500 dark:text-gray-400">close</span>
            </button>
        </div>
        
        <!-- Modal Body -->
        <div class="p-6">
            <p class="text-sm text-[#61897c] dark:text-gray-400 mb-6">
                Share "{{ $content->title }}" with others who might find it helpful.
            </p>
            
            <!-- Share Options -->
            <div class="space-y-3">
                <!-- Twitter -->
                <button onclick="shareToTwitter()" class="flex items-center gap-3 w-full p-4 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-all duration-200 transform hover:scale-105 font-medium">
                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-white !text-lg">share</span>
                    </div>
                    <div class="text-left">
                        <div class="font-semibold">Share on Twitter</div>
                        <div class="text-xs opacity-75">Share with your followers</div>
                    </div>
                </button>
                
                <!-- LinkedIn -->
                <button onclick="shareToLinkedIn()" class="flex items-center gap-3 w-full p-4 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-all duration-200 transform hover:scale-105 font-medium">
                    <div class="w-10 h-10 bg-blue-700 rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-white !text-lg">business</span>
                    </div>
                    <div class="text-left">
                        <div class="font-semibold">Share on LinkedIn</div>
                        <div class="text-xs opacity-75">Share with your network</div>
                    </div>
                </button>
                
                <!-- Copy Link -->
                <button onclick="copyLink()" class="flex items-center gap-3 w-full p-4 bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-600 transition-all duration-200 transform hover:scale-105 font-medium">
                    <div class="w-10 h-10 bg-gray-500 rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-white !text-lg">link</span>
                    </div>
                    <div class="text-left">
                        <div class="font-semibold">Copy Link</div>
                        <div class="text-xs opacity-75">Copy to clipboard</div>
                    </div>
                </button>
                
                <!-- Email -->
                <button onclick="shareViaEmail()" class="flex items-center gap-3 w-full p-4 bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-xl hover:bg-green-100 dark:hover:bg-green-900/50 transition-all duration-200 transform hover:scale-105 font-medium">
                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-white !text-lg">mail</span>
                    </div>
                    <div class="text-left">
                        <div class="font-semibold">Share via Email</div>
                        <div class="text-xs opacity-75">Send to someone</div>
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>

@endsection