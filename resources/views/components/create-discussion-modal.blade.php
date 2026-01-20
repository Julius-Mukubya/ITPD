<!-- Create Discussion Modal -->
<div id="createDiscussionModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-lg max-h-[85vh] overflow-y-auto transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-gradient-to-br from-primary to-green-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                    @auth
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    @else
                        ?
                    @endauth
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Start Discussion</h3>
            </div>
            <button onclick="closeCreateDiscussionModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors p-1">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-4">
            <form id="createDiscussionForm" action="{{ route('public.forum.store') }}" method="POST" class="space-y-4">
                @csrf
                
                <!-- Category & Title Row -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="modal_category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id" id="modal_category_id" required class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-700 dark:text-white">
                            <option value="">Select category</option>
                            @if(isset($categories))
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    
                    <div>
                        <label for="modal_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" id="modal_title" required maxlength="255" value="{{ old('title') }}"
                               class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-700 dark:text-white"
                               placeholder="Discussion title">
                    </div>
                </div>
                
                <!-- Character Counter -->
                <div id="titleCounter" class="text-xs text-gray-500 dark:text-gray-400 -mt-2">0/255 characters</div>
                
                <!-- Content -->
                <div>
                    <label for="modal_content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Content <span class="text-red-500">*</span>
                    </label>
                    <textarea name="content" id="modal_content" rows="4" required 
                              class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-700 dark:text-white resize-none"
                              placeholder="Share your thoughts, experiences, or questions...">{{ old('content') }}</textarea>
                </div>
                
                <!-- Anonymous Option & Guidelines -->
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_anonymous" id="modal_is_anonymous" value="1" {{ old('is_anonymous') ? 'checked' : '' }}
                               class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary dark:focus:ring-primary dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="modal_is_anonymous" class="text-sm text-gray-700 dark:text-gray-300 cursor-pointer">
                            Post anonymously
                        </label>
                    </div>
                    <div class="flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400">
                        <span class="material-symbols-outlined text-sm">info</span>
                        <span>Be respectful</span>
                    </div>
                </div>
            </form>
        </div>

        <!-- Modal Footer -->
        <div class="flex items-center justify-end gap-3 p-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
            <button type="button" onclick="closeCreateDiscussionModal()" 
                    class="px-4 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 font-medium transition-colors">
                Cancel
            </button>
            <button type="submit" form="createDiscussionForm" 
                    class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg text-sm font-semibold hover:bg-primary/90 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                <span class="material-symbols-outlined text-sm">send</span>
                Post
            </button>
        </div>
    </div>
</div>

<script>
function openCreateDiscussionModal(categoryId = null) {
    const modal = document.getElementById('createDiscussionModal');
    const modalContent = document.getElementById('modalContent');
    const categorySelect = document.getElementById('modal_category_id');
    
    // Pre-select category if provided
    if (categoryId && categorySelect) {
        categorySelect.value = categoryId;
    }
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Animate modal in
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
    
    // Focus on title input
    setTimeout(() => {
        document.getElementById('modal_title')?.focus();
    }, 150);
}

function closeCreateDiscussionModal() {
    const modal = document.getElementById('createDiscussionModal');
    const modalContent = document.getElementById('modalContent');
    
    // Animate modal out
    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        
        // Reset form
        document.getElementById('createDiscussionForm').reset();
        document.getElementById('titleCounter').textContent = '0/255 characters';
        document.getElementById('titleCounter').className = 'text-xs text-gray-500 dark:text-gray-400 mt-1';
    }, 200);
}

// Close modal when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('createDiscussionModal');
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeCreateDiscussionModal();
        }
    });
    
    // Auto-open modal if there are validation errors
    @if($errors->any() && old('title'))
        openCreateDiscussionModal();
    @endif
    
    // Character counter for title
    const titleInput = document.getElementById('modal_title');
    const titleCounter = document.getElementById('titleCounter');
    
    if (titleInput && titleCounter) {
        titleInput.addEventListener('input', function() {
            const length = this.value.length;
            const maxLength = 255;
            titleCounter.textContent = `${length}/${maxLength} characters`;
            
            if (length > maxLength * 0.9) {
                titleCounter.className = 'text-xs text-orange-500 dark:text-orange-400 mt-1';
            } else {
                titleCounter.className = 'text-xs text-gray-500 dark:text-gray-400 mt-1';
            }
        });
    }
    
    // Auto-resize textarea
    const contentTextarea = document.getElementById('modal_content');
    if (contentTextarea) {
        contentTextarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 200) + 'px';
        });
    }
    
    // Handle ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeCreateDiscussionModal();
        }
    });
});
</script>