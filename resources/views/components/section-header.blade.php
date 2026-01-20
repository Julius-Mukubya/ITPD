@props(['title', 'description'])

<div class="flex flex-col items-center gap-4 text-center">
    <h2 class="text-[#111816] dark:text-white text-3xl font-bold leading-tight tracking-tight sm:text-4xl max-w-2xl">{{ $title }}</h2>
    <p class="text-gray-600 dark:text-gray-400 text-base font-normal leading-normal max-w-3xl">{{ $description }}</p>
</div>