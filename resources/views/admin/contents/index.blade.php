@extends(auth()->user()->role === 'counselor' ? 'layouts.counselor' : 'layouts.admin')

@section('title', 'Manage Content')
@section('page-title', 'Educational Content')

@section('content')
<div class="flex flex-wrap justify-between items-center gap-3 mb-6">
    <div class="flex flex-col gap-1">
        <p class="text-gray-900 dark:text-white text-3xl font-bold tracking-tight">Educational Content</p>
        <p class="text-gray-500 dark:text-gray-400 text-base font-normal">Manage articles, videos, and learning materials</p>
    </div>
    <a href="{{ route('admin.contents.create') }}" class="bg-primary text-white text-sm font-medium px-4 py-2 rounded-lg flex items-center gap-2 hover:opacity-90">
        <span class="material-symbols-outlined" style="font-size: 20px;">add</span>
        Create Content
    </a>
</div>



<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
    <!-- Filter Section -->
    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Content Library</h2>
            
            <!-- Mobile Filter Toggle Button -->
            <button id="contentMobileFilterToggle" class="md:hidden flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                <span class="material-symbols-outlined text-base">tune</span>
                <span>Filters</span>
                <span id="contentFilterToggleIcon" class="material-symbols-outlined text-sm transition-transform">expand_more</span>
            </button>
        </div>
        
        <!-- Filter Section -->
        <div id="contentFilterSection" class="hidden md:block">
            <div class="flex flex-col md:flex-row gap-3">
                <input type="text" id="contentSearch" placeholder="Search by title..." 
                    class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-primary focus:border-transparent">
                <select id="contentCategory" class="flex-1 md:min-w-[150px] px-3 py-2 pr-8 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-primary focus:border-transparent appearance-none">
                    <option value="">All Categories</option>
                    @foreach($categories ?? [] as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <select id="contentType" class="flex-1 md:min-w-[120px] px-3 py-2 pr-8 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-primary focus:border-transparent appearance-none">
                    <option value="">All Types</option>
                    <option value="article">Article</option>
                    <option value="video">Video</option>
                    <option value="infographic">Infographic</option>
                    <option value="podcast">Podcast</option>
                </select>
                <select id="contentStatus" class="flex-1 md:min-w-[120px] px-3 py-2 pr-8 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-primary focus:border-transparent appearance-none">
                    <option value="">All Status</option>
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                </select>
            </div>
        </div>
    </div>
    
    <!-- Desktop Table View -->
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3">Title</th>
                    <th scope="col" class="px-6 py-3">Category</th>
                    <th scope="col" class="px-6 py-3">Type</th>
                    <th scope="col" class="px-6 py-3">Stats</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Date</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody id="contentTableBody">
                @forelse($contents as $content)
                <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 content-row"
                    data-title="{{ strtolower($content->title) }}"
                    data-category="{{ $content->category_id ?? '' }}"
                    data-type="{{ $content->type }}"
                    data-status="{{ $content->is_published ? 'published' : 'draft' }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($content->featured_image)
                            <img src="{{ asset('storage/' . $content->featured_image) }}" alt="{{ $content->title }}" class="w-12 h-12 rounded object-cover">
                            @else
                            <div class="w-12 h-12 rounded bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                <span class="material-symbols-outlined text-gray-400">article</span>
                            </div>
                            @endif
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ Str::limit($content->title, 40) }}</p>
                                @if($content->is_featured)
                                <span class="text-xs text-yellow-600 dark:text-yellow-400">⭐ Featured</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">
                            {{ $content->category->name ?? 'N/A' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300">
                            {{ ucfirst($content->type) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col gap-1 text-xs">
                            <div class="flex items-center gap-1.5 text-gray-600 dark:text-gray-400">
                                <span class="material-symbols-outlined !text-sm">visibility</span>
                                <span class="font-medium">{{ number_format($content->views) }}</span>
                                <span class="text-gray-400">views</span>
                            </div>
                            <div class="flex items-center gap-1.5 text-gray-600 dark:text-gray-400">
                                <span class="material-symbols-outlined !text-sm">bookmark</span>
                                <span class="font-medium">{{ number_format($content->bookmarks_count ?? 0) }}</span>
                                <span class="text-gray-400">saves</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($content->is_published)
                        <span class="px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-300">
                            Published
                        </span>
                        @else
                        <span class="px-2 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full dark:bg-yellow-900 dark:text-yellow-300">
                            Draft
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $content->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.contents.edit', $content) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                <span class="material-symbols-outlined text-sm">edit</span>
                            </a>
                            <form action="{{ route('admin.contents.destroy', $content) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="showDeleteModal(this.closest('form'), 'Are you sure you want to delete this content? This action cannot be undone.')" class="text-red-600 hover:text-red-800 dark:text-red-400">
                                    <span class="material-symbols-outlined text-sm">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        <div class="flex flex-col items-center gap-2">
                            <span class="material-symbols-outlined text-4xl">article</span>
                            <p>No content found</p>
                            <a href="{{ route('admin.contents.create') }}" class="text-primary hover:underline">Create your first content</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile Card View -->
    <div id="contentMobileCards" class="md:hidden divide-y divide-gray-200 dark:divide-gray-700">
        @forelse($contents as $content)
        <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 content-card"
            data-title="{{ strtolower($content->title) }}"
            data-category="{{ $content->category_id ?? '' }}"
            data-type="{{ $content->type }}"
            data-status="{{ $content->is_published ? 'published' : 'draft' }}">
            <div class="flex gap-3 mb-3">
                @if($content->featured_image)
                <img src="{{ asset('storage/' . $content->featured_image) }}" alt="{{ $content->title }}" class="w-16 h-16 rounded object-cover flex-shrink-0">
                @else
                <div class="w-16 h-16 rounded bg-gray-200 dark:bg-gray-600 flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-gray-400">article</span>
                </div>
                @endif
                <div class="flex-1 min-w-0">
                    <h3 class="font-medium text-gray-900 dark:text-white mb-1 line-clamp-2">{{ $content->title }}</h3>
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        <span class="px-2 py-0.5 text-xs font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">
                            {{ $content->category->name ?? 'N/A' }}
                        </span>
                        <span class="px-2 py-0.5 text-xs font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300">
                            {{ ucfirst($content->type) }}
                        </span>
                        @if($content->is_published)
                        <span class="px-2 py-0.5 text-xs font-medium text-green-800 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-300">
                            Published
                        </span>
                        @else
                        <span class="px-2 py-0.5 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full dark:bg-yellow-900 dark:text-yellow-300">
                            Draft
                        </span>
                        @endif
                        @if($content->is_featured)
                        <span class="text-xs text-yellow-600 dark:text-yellow-400">⭐ Featured</span>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="flex items-center justify-between text-xs text-gray-600 dark:text-gray-400 mb-3">
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-1">
                        <span class="material-symbols-outlined !text-sm">visibility</span>
                        <span>{{ number_format($content->views) }}</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="material-symbols-outlined !text-sm">bookmark</span>
                        <span>{{ number_format($content->bookmarks_count ?? 0) }}</span>
                    </div>
                </div>
                <span class="text-gray-500 dark:text-gray-400">{{ $content->created_at->format('M d, Y') }}</span>
            </div>
            
            <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('admin.contents.edit', $content) }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/50 transition-colors">
                    <span class="material-symbols-outlined text-xl">edit</span>
                </a>
                <form action="{{ route('admin.contents.destroy', $content) }}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="showDeleteModal(this.closest('form'), 'Are you sure you want to delete this content? This action cannot be undone.')" class="w-10 h-10 flex items-center justify-center rounded-full bg-red-100 text-red-600 hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50 transition-colors">
                        <span class="material-symbols-outlined text-xl">delete</span>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
            <div class="flex flex-col items-center gap-2">
                <span class="material-symbols-outlined text-4xl">article</span>
                <p>No content found</p>
                <a href="{{ route('admin.contents.create') }}" class="text-primary hover:underline">Create your first content</a>
            </div>
        </div>
        @endforelse
    </div>
    
    @if($contents->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
        {{ $contents->links() }}
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile filter toggle
    const mobileToggle = document.getElementById('contentMobileFilterToggle');
    const filterSection = document.getElementById('contentFilterSection');
    const toggleIcon = document.getElementById('contentFilterToggleIcon');
    
    if (mobileToggle) {
        mobileToggle.addEventListener('click', function() {
            filterSection.classList.toggle('hidden');
            toggleIcon.classList.toggle('rotate-180');
        });
    }
    
    // Filter functionality
    const searchInput = document.getElementById('contentSearch');
    const categorySelect = document.getElementById('contentCategory');
    const typeSelect = document.getElementById('contentType');
    const statusSelect = document.getElementById('contentStatus');
    
    function filterContent() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedCategory = categorySelect.value;
        const selectedType = typeSelect.value;
        const selectedStatus = statusSelect.value;
        
        // Filter desktop table rows
        const tableRows = document.querySelectorAll('.content-row');
        tableRows.forEach(row => {
            const title = row.dataset.title;
            const category = row.dataset.category;
            const type = row.dataset.type;
            const status = row.dataset.status;
            
            const matchesSearch = !searchTerm || title.includes(searchTerm);
            const matchesCategory = !selectedCategory || category === selectedCategory;
            const matchesType = !selectedType || type === selectedType;
            const matchesStatus = !selectedStatus || status === selectedStatus;
            
            if (matchesSearch && matchesCategory && matchesType && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        
        // Filter mobile cards
        const mobileCards = document.querySelectorAll('.content-card');
        mobileCards.forEach(card => {
            const title = card.dataset.title;
            const category = card.dataset.category;
            const type = card.dataset.type;
            const status = card.dataset.status;
            
            const matchesSearch = !searchTerm || title.includes(searchTerm);
            const matchesCategory = !selectedCategory || category === selectedCategory;
            const matchesType = !selectedType || type === selectedType;
            const matchesStatus = !selectedStatus || status === selectedStatus;
            
            if (matchesSearch && matchesCategory && matchesType && matchesStatus) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }
    
    // Attach event listeners
    if (searchInput) searchInput.addEventListener('input', filterContent);
    if (categorySelect) categorySelect.addEventListener('change', filterContent);
    if (typeSelect) typeSelect.addEventListener('change', filterContent);
    if (statusSelect) statusSelect.addEventListener('change', filterContent);
});
</script>
@endsection
