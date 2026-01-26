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
    <div class="overflow-x-auto">
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
            <tbody>
                @forelse($contents as $content)
                <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
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
    
    @if($contents->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
        {{ $contents->links() }}
    </div>
    @endif
</div>
@endsection
