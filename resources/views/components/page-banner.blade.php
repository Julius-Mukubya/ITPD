@props(['title', 'subtitle' => '', 'badge' => '', 'badgeIcon' => '', 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBaei4zVm6LMjCzOVeGiCrhI7yoToYFSZ67NFRSOpSi2mS78a4OlW5SUWJ6pb6uehKbKJYkyLdYuWxLOLcYqgTxhJDdOV5-TGjhJGRIC6Mw6f0BpUtqOf2WUzvouDx1C-cX7IZq5sTR_0tZQY81G8hmA7w609vHtY53hIjl_Z7uKMuJtcfu9xj_w-h5h-tQzhnl1SKW4blx_rDkSirm7BB0IdRYU1p10v-DVIT3Qqi_xtXuBK_86-uuVTLeC4WFxj7_2DutIbO4XA'])

<div class="relative w-full h-screen flex items-center">
    @if($image)
        <img alt="Banner background" class="absolute inset-0 h-full w-full object-cover" src="{{ $image }}"/>
        <div class="absolute inset-0 bg-black/30"></div>
    @endif
    
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="flex flex-col gap-6 items-center justify-center text-center {{ $image ? 'text-white' : 'text-[#111816] dark:text-white' }}">
            @if($badge)
                <div class="inline-flex items-center gap-2 {{ $image ? 'bg-white/20 backdrop-blur-sm text-white' : 'bg-primary/20 dark:bg-primary/30 text-primary' }} px-6 py-3 rounded-full text-sm font-semibold shadow-sm">
                    @if($badgeIcon)
                        <span class="material-symbols-outlined !text-lg">{{ $badgeIcon }}</span>
                    @endif
                    {{ $badge }}
                </div>
            @endif
            
            <div class="flex flex-col gap-4 max-w-3xl">
                <h1 class="text-4xl font-black leading-tight tracking-tighter sm:text-5xl md:text-6xl">{{ $title }}</h1>
                @if($subtitle)
                    <p class="{{ $image ? 'text-gray-200' : 'text-[#61897c] dark:text-gray-400' }} text-base font-normal leading-normal sm:text-lg">{{ $subtitle }}</p>
                @endif
            </div>
            
            @if(isset($actions))
                <div class="flex flex-col sm:flex-row gap-4 mt-6">
                    {{ $actions }}
                </div>
            @endif
        </div>
    </div>
</div>
