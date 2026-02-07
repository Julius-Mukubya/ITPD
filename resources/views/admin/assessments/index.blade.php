@extends('layouts.admin')

@section('title', 'Manage Assessments')
@section('page-title', 'Assessments')

@section('content')
<div class="flex flex-wrap justify-between items-center gap-3 mb-6">
    <div class="flex flex-col gap-1">
        <p class="text-gray-900 dark:text-white text-3xl font-bold tracking-tight">Wellness Assessments</p>
        <p class="text-gray-500 dark:text-gray-400 text-base font-normal">Monitor self-evaluation tools and user engagement</p>
    </div>
    <a href="{{ route('admin.assessments.create') }}" class="bg-primary text-white text-sm font-medium px-4 py-2 rounded-lg flex items-center gap-2 hover:opacity-90">
        <span class="material-symbols-outlined" style="font-size: 20px;">add</span>
        Create Assessment
    </a>
</div>



<!-- Assessments Table -->
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
    <!-- Filter Section -->
    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Assessment Library</h2>
            
            <!-- Mobile Filter Toggle Button -->
            <button id="assessmentMobileFilterToggle" class="md:hidden flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                <span class="material-symbols-outlined text-base">tune</span>
                <span>Filters</span>
                <span id="assessmentFilterToggleIcon" class="material-symbols-outlined text-sm transition-transform">expand_more</span>
            </button>
        </div>
        
        <!-- Filter Section -->
        <div id="assessmentFilterSection" class="hidden md:block">
            <div class="flex flex-col md:flex-row gap-3">
                <input type="text" id="assessmentSearch" placeholder="Search by name or description..." 
                    class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-primary focus:border-transparent">
                <select id="assessmentType" class="flex-1 md:min-w-[180px] px-3 py-2 pr-8 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-primary focus:border-transparent appearance-none">
                    <option value="">All Types</option>
                    <option value="audit">AUDIT</option>
                    <option value="dudit">DUDIT</option>
                    <option value="phq9">PHQ-9</option>
                    <option value="gad7">GAD-7</option>
                    <option value="dass21">DASS-21</option>
                    <option value="pss">PSS</option>
                    <option value="cage">CAGE</option>
                </select>
            </div>
        </div>
    </div>
    
    <!-- Desktop Table View -->
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3">Assessment</th>
                    <th scope="col" class="px-6 py-3">Type</th>
                    <th scope="col" class="px-6 py-3">Questions</th>
                    <th scope="col" class="px-6 py-3">Attempts</th>
                    <th scope="col" class="px-6 py-3">Created</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody id="assessmentTableBody">
                @forelse($assessments as $assessment)
                <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 assessment-row"
                    data-name="{{ strtolower($assessment->full_name ?? $assessment->name) }}"
                    data-description="{{ strtolower($assessment->description ?? '') }}"
                    data-type="{{ $assessment->type }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center">
                                <span class="material-symbols-outlined text-primary">psychology</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $assessment->full_name ?? $assessment->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ Str::limit($assessment->description, 50) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">
                            {{ strtoupper($assessment->type) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">{{ $assessment->questions()->count() }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($assessment->attempts_count) }}</span>
                            @if($assessment->attempts_count > 0)
                            <span class="material-symbols-outlined text-green-500 text-sm">trending_up</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">{{ $assessment->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.assessments.show', $assessment) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400" title="View Details">
                                <span class="material-symbols-outlined text-sm">visibility</span>
                            </a>
                            <a href="{{ route('admin.assessments.edit', $assessment) }}" class="text-green-600 hover:text-green-800 dark:text-green-400" title="Edit">
                                <span class="material-symbols-outlined text-sm">edit</span>
                            </a>
                            <form action="{{ route('admin.assessments.destroy', $assessment) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="showDeleteModal(this.closest('form'), 'Are you sure you want to delete this assessment? This will delete the assessment and all its questions.')" class="text-red-600 hover:text-red-800 dark:text-red-400" title="Delete">
                                    <span class="material-symbols-outlined text-sm">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        <div class="flex flex-col items-center gap-2">
                            <span class="material-symbols-outlined text-4xl">psychology</span>
                            <p>No assessments found</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Mobile Card View -->
    <div id="assessmentMobileCards" class="md:hidden divide-y divide-gray-200 dark:divide-gray-700">
        @forelse($assessments as $assessment)
        <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 assessment-card"
            data-name="{{ strtolower($assessment->full_name ?? $assessment->name) }}"
            data-description="{{ strtolower($assessment->description ?? '') }}"
            data-type="{{ $assessment->type }}">
            <div class="flex items-start gap-3 mb-3">
                <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-primary text-xl">psychology</span>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-medium text-gray-900 dark:text-white mb-1">{{ $assessment->full_name ?? $assessment->name }}</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 mb-2">{{ $assessment->description }}</p>
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="px-2 py-0.5 text-xs font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">
                            {{ strtoupper($assessment->type) }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-3 gap-3 mb-3 text-sm">
                <div class="text-center">
                    <p class="text-gray-500 dark:text-gray-400 text-xs">Questions</p>
                    <p class="font-semibold text-gray-900 dark:text-white">{{ $assessment->questions()->count() }}</p>
                </div>
                <div class="text-center">
                    <p class="text-gray-500 dark:text-gray-400 text-xs">Attempts</p>
                    <p class="font-semibold text-gray-900 dark:text-white">{{ number_format($assessment->attempts_count) }}</p>
                </div>
                <div class="text-center">
                    <p class="text-gray-500 dark:text-gray-400 text-xs">Created</p>
                    <p class="font-semibold text-gray-900 dark:text-white text-xs">{{ $assessment->created_at->format('M d, Y') }}</p>
                </div>
            </div>
            
            <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('admin.assessments.show', $assessment) }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/50 transition-colors">
                    <span class="material-symbols-outlined text-xl">visibility</span>
                </a>
                <a href="{{ route('admin.assessments.edit', $assessment) }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-green-100 text-green-600 hover:bg-green-200 dark:bg-green-900/30 dark:text-green-400 dark:hover:bg-green-900/50 transition-colors">
                    <span class="material-symbols-outlined text-xl">edit</span>
                </a>
                <form action="{{ route('admin.assessments.destroy', $assessment) }}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="showDeleteModal(this.closest('form'), 'Are you sure you want to delete this assessment? This will delete the assessment and all its questions.')" class="w-10 h-10 flex items-center justify-center rounded-full bg-red-100 text-red-600 hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50 transition-colors">
                        <span class="material-symbols-outlined text-xl">delete</span>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
            <div class="flex flex-col items-center gap-2">
                <span class="material-symbols-outlined text-4xl">psychology</span>
                <p>No assessments found</p>
            </div>
        </div>
        @endforelse
    </div>
    
    @if($assessments->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
        {{ $assessments->links() }}
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile filter toggle
    const mobileToggle = document.getElementById('assessmentMobileFilterToggle');
    const filterSection = document.getElementById('assessmentFilterSection');
    const toggleIcon = document.getElementById('assessmentFilterToggleIcon');
    
    if (mobileToggle) {
        mobileToggle.addEventListener('click', function() {
            filterSection.classList.toggle('hidden');
            toggleIcon.classList.toggle('rotate-180');
        });
    }
    
    // Filter functionality
    const searchInput = document.getElementById('assessmentSearch');
    const typeSelect = document.getElementById('assessmentType');
    
    function filterAssessments() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedType = typeSelect.value;
        
        // Filter desktop table rows
        const tableRows = document.querySelectorAll('.assessment-row');
        tableRows.forEach(row => {
            const name = row.dataset.name;
            const description = row.dataset.description;
            const type = row.dataset.type;
            
            const matchesSearch = !searchTerm || name.includes(searchTerm) || description.includes(searchTerm);
            const matchesType = !selectedType || type === selectedType;
            
            if (matchesSearch && matchesType) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        
        // Filter mobile cards
        const mobileCards = document.querySelectorAll('.assessment-card');
        mobileCards.forEach(card => {
            const name = card.dataset.name;
            const description = card.dataset.description;
            const type = card.dataset.type;
            
            const matchesSearch = !searchTerm || name.includes(searchTerm) || description.includes(searchTerm);
            const matchesType = !selectedType || type === selectedType;
            
            if (matchesSearch && matchesType) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }
    
    // Attach event listeners
    if (searchInput) searchInput.addEventListener('input', filterAssessments);
    if (typeSelect) typeSelect.addEventListener('change', filterAssessments);
});
</script>
@endsection
