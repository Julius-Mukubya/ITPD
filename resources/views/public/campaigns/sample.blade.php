@extends('layouts.public')

@section('title', $sampleCampaign['title'] . ' - WellPath Hub')

@section('content')
<!-- Breadcrumb Navigation -->
<div class="bg-white dark:bg-gray-800/50 border-b border-[#f0f4f3] dark:border-gray-800 py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-[#61897c] dark:text-gray-400 hover:text-primary transition-colors group">
                <span class="material-symbols-outlined !text-lg group-hover:scale-110 transition-transform">home</span>
                Home
            </a>
            <span class="material-symbols-outlined !text-lg text-[#61897c] dark:text-gray-400">chevron_right</span>
            <a href="{{ route('campaigns.index') }}" class="flex items-center gap-2 text-[#61897c] dark:text-gray-400 hover:text-primary transition-colors group">
                <span class="material-symbols-outlined !text-lg group-hover:scale-110 transition-transform">campaign</span>
                Campaigns
            </a>
            <span class="material-symbols-outlined !text-lg text-[#61897c] dark:text-gray-400">chevron_right</span>
            <span class="text-[#111816] dark:text-white font-semibold flex items-center gap-2">
                <span class="material-symbols-outlined !text-lg text-primary">preview</span>
                {{ Str::limit($sampleCampaign['title'], 30) }} (Preview)
            </span>
        </nav>
    </div>
</div>

<!-- Sample Campaign Notice -->
<div class="bg-gradient-to-r from-orange-100 to-yellow-100 dark:from-orange-900/30 dark:to-yellow-900/30 border-b border-orange-200 dark:border-orange-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex items-center justify-center gap-3 text-orange-800 dark:text-orange-200">
            <span class="material-symbols-outlined !text-xl">preview</span>
            <span class="font-semibold">This is a sample campaign preview</span>
            <span class="text-sm opacity-75">• Real campaigns will be available soon</span>
        </div>
    </div>
</div>

<!-- Enhanced Hero Section -->
<div class="relative overflow-hidden">
    <img src="{{ $sampleCampaign['image'] }}" alt="{{ $sampleCampaign['title'] }}" 
         class="w-full h-80 sm:h-96 lg:h-[500px] object-cover">
    
    <!-- Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
    
    <!-- Sample Watermark -->
    <div class="absolute top-8 right-8 opacity-30">
        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-sm px-4 py-2 rounded-xl text-lg font-bold text-[#111816] dark:text-white transform rotate-12 border-2 border-dashed border-orange-400">
            SAMPLE PREVIEW
        </div>
    </div>
    
    <!-- Hero Content -->
    <div class="absolute inset-0 flex items-end">
        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
            <div class="max-w-4xl">
                <!-- Status Badge -->
                <div class="flex items-center gap-3 mb-6">
                    <div class="flex items-center gap-2 bg-orange-500 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                        <span class="material-symbols-outlined !text-sm">preview</span>
                        Sample Campaign
                    </div>
                    <div class="text-white/80 text-sm">
                        {{ $sampleCampaign['type'] }} Campaign Preview
                    </div>
                </div>
                
                <!-- Title -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white leading-tight tracking-tight mb-6">
                    {{ $sampleCampaign['title'] }}
                </h1>
                
                <!-- Description -->
                <p class="text-xl text-white/90 leading-relaxed mb-8 max-w-3xl">
                    {{ $sampleCampaign['description'] }}
                </p>
                
                <!-- Meta Information -->
                <div class="flex flex-col sm:flex-row gap-6 text-white/80">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined !text-xl">calendar_today</span>
                        <span class="font-medium">{{ $sampleCampaign['dates'] }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined !text-xl">group</span>
                        <span class="font-medium">{{ $sampleCampaign['participants'] }} participants</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined !text-xl">person</span>
                        <span class="font-medium">By WellPath Wellness Team</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        
        <!-- Left Column - Main Content -->
        <div class="lg:col-span-2 space-y-10">
            
            <!-- Campaign Overview -->
            <div class="bg-white dark:bg-gray-800/50 rounded-3xl p-8 shadow-sm border border-[#f0f4f3] dark:border-gray-800">
                <h2 class="text-3xl font-bold text-[#111816] dark:text-white mb-6 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary !text-2xl">info</span>
                    About This Campaign
                </h2>
                <div class="prose prose-lg max-w-none dark:prose-invert 
                           prose-headings:font-bold prose-headings:text-[#111816] dark:prose-headings:text-white
                           prose-p:text-[#61897c] dark:prose-p:text-gray-300 prose-p:leading-relaxed
                           prose-a:text-primary prose-a:no-underline hover:prose-a:underline">
                    <p class="text-lg">{{ $sampleCampaign['description'] }}</p>
                    
                    <h3>Goals & Objectives</h3>
                    <p>{{ $sampleCampaign['goals'] }}</p>
                    
                    <h3>Who Should Join</h3>
                    <p>{{ $sampleCampaign['target_audience'] }}</p>
                </div>
            </div>

            <!-- Campaign Timeline -->
            <div class="bg-white dark:bg-gray-800/50 rounded-3xl p-8 shadow-sm border border-[#f0f4f3] dark:border-gray-800">
                <h3 class="text-2xl font-bold text-[#111816] dark:text-white mb-8 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary !text-2xl">timeline</span>
                    Campaign Timeline
                </h3>
                <div class="relative">
                    <!-- Timeline Line -->
                    <div class="absolute left-6 top-8 bottom-8 w-0.5 bg-gradient-to-b from-primary to-gray-300 dark:to-gray-600"></div>
                    
                    <div class="space-y-8">
                        @foreach($sampleCampaign['timeline'] as $event)
                        <div class="flex items-start gap-6">
                            <div class="w-12 h-12 {{ $event['color'] }} rounded-full flex items-center justify-center shadow-lg flex-shrink-0">
                                <span class="material-symbols-outlined text-white !text-xl">{{ $event['icon'] }}</span>
                            </div>
                            <div class="pt-2">
                                <h4 class="font-bold text-[#111816] dark:text-white text-lg">{{ $event['title'] }}</h4>
                                <p class="text-[#61897c] dark:text-gray-400 mb-2">{{ $event['date'] }}</p>
                                <p class="text-sm text-[#61897c] dark:text-gray-400">{{ $event['description'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Impact & Statistics -->
            <div class="bg-gradient-to-br from-primary/10 to-green-500/10 dark:from-primary/20 dark:to-green-500/20 rounded-3xl p-8 border border-primary/20">
                <h3 class="text-2xl font-bold text-[#111816] dark:text-white mb-8 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary !text-2xl">trending_up</span>
                    Expected Impact
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="text-3xl font-black text-primary mb-2">{{ $sampleCampaign['participants'] }}</div>
                        <div class="text-sm font-medium text-[#61897c] dark:text-gray-400">Expected Participants</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-black text-primary mb-2">{{ $sampleCampaign['duration'] }}</div>
                        <div class="text-sm font-medium text-[#61897c] dark:text-gray-400">Days Duration</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-black text-primary mb-2">100%</div>
                        <div class="text-sm font-medium text-[#61897c] dark:text-gray-400">Free to Join</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-black text-primary mb-2">24/7</div>
                        <div class="text-sm font-medium text-[#61897c] dark:text-gray-400">Support</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Sidebar -->
        <div class="lg:col-span-1">
            <div class="sticky top-24 space-y-8">

                <!-- Sample Campaign Notice -->
                <div class="bg-gradient-to-br from-orange-100 to-yellow-100 dark:from-orange-900/50 dark:to-yellow-900/50 rounded-2xl p-6 border border-orange-200 dark:border-orange-800">
                    <h3 class="text-lg font-bold text-orange-800 dark:text-orange-200 mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined">preview</span>
                        Sample Campaign
                    </h3>
                    <p class="text-sm text-orange-700 dark:text-orange-300 mb-4">
                        This is a preview of what real campaigns will look like. Actual campaigns will be launching soon!
                    </p>
                    <div class="space-y-3">
                        <button onclick="showComingSoonToast()" class="w-full bg-orange-500 text-white py-3 rounded-xl font-semibold hover:bg-orange-600 transition-all duration-200 transform hover:scale-105">
                            Get Notified When Live
                        </button>
                        <a href="{{ route('campaigns.index') }}" class="w-full bg-white dark:bg-gray-800 border border-orange-200 dark:border-orange-700 text-orange-800 dark:text-orange-200 py-3 rounded-xl font-semibold hover:bg-orange-50 dark:hover:bg-orange-900/20 transition-all duration-200 text-center block">
                            Back to Campaigns
                        </a>
                    </div>
                </div>

                <!-- Campaign Features -->
                <div class="bg-white dark:bg-gray-800/50 rounded-2xl p-6 shadow-sm border border-[#f0f4f3] dark:border-gray-800">
                    <h3 class="text-lg font-bold text-[#111816] dark:text-white mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">star</span>
                        Campaign Features
                    </h3>
                    <div class="space-y-4">
                        @foreach($sampleCampaign['features'] as $feature)
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-primary/20 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="material-symbols-outlined text-primary !text-sm">{{ $feature['icon'] }}</span>
                            </div>
                            <div>
                                <div class="font-medium text-[#111816] dark:text-white text-sm">{{ $feature['title'] }}</div>
                                <div class="text-xs text-[#61897c] dark:text-gray-400">{{ $feature['description'] }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Share Sample -->
                <div class="bg-white dark:bg-gray-800/50 rounded-2xl p-6 shadow-sm border border-[#f0f4f3] dark:border-gray-800">
                    <h3 class="text-lg font-bold text-[#111816] dark:text-white mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">share</span>
                        Share Preview
                    </h3>
                    <div class="space-y-3">
                        <button onclick="shareToTwitter()" class="flex items-center gap-3 w-full p-3 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-colors text-sm font-medium">
                            <span class="material-symbols-outlined !text-lg">share</span>
                            Share on Twitter
                        </button>
                        <button onclick="copyLink()" class="flex items-center gap-3 w-full p-3 bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors text-sm font-medium">
                            <span class="material-symbols-outlined !text-lg">link</span>
                            Copy Preview Link
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* Smooth animations */
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
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
</style>
@endpush

@push('scripts')
<script>
// Sample campaign specific functions
function showComingSoonToast() {
    showToast('We\'ll notify you when real campaigns launch! 🚀', 'info');
}

// Share functionality
function shareToTwitter() {
    const text = encodeURIComponent('Check out this sample campaign from WellPath Hub - {{ $sampleCampaign["title"] }}');
    const url = encodeURIComponent(window.location.href);
    window.open(`https://twitter.com/intent/tweet?text=${text}&url=${url}`, '_blank');
    showToast('Opening Twitter...', 'info');
}

function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        showToast('Preview link copied to clipboard! 📋', 'success');
    }).catch(() => {
        showToast('Failed to copy link', 'error');
    });
}

// Toast notification system
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    const bgColor = {
        'success': 'bg-green-500',
        'error': 'bg-red-500',
        'info': 'bg-blue-500',
        'warning': 'bg-yellow-500'
    }[type] || 'bg-primary';
    
    toast.className = `fixed top-24 right-4 z-50 px-6 py-4 rounded-2xl shadow-2xl text-white font-semibold ${bgColor} transform translate-x-full transition-transform duration-300 max-w-sm`;
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
    
    // Slide in
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 100);
    
    // Auto remove after 4 seconds
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            if (document.body.contains(toast)) {
                document.body.removeChild(toast);
            }
        }, 300);
    }, 4000);
    
    // Click to dismiss
    toast.addEventListener('click', () => {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            if (document.body.contains(toast)) {
                document.body.removeChild(toast);
            }
        }, 300);
    });
}

// Intersection Observer for animations
document.addEventListener('DOMContentLoaded', function() {
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
    
    // Observe content sections for fade-in animation
    document.querySelectorAll('.bg-white, .bg-gradient-to-br').forEach(element => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';
        element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(element);
    });
});
</script>
@endpush