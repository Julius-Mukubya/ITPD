<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="p-6">
            <!-- Header -->
            <div class="flex items-center gap-3 mb-4">
                <div class="flex-shrink-0 w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                    <span class="material-symbols-outlined text-red-600 dark:text-red-400">warning</span>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Confirm Deletion</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">This action cannot be undone</p>
                </div>
            </div>

            <!-- Content -->
            <div class="mb-6">
                <p id="deleteMessage" class="text-gray-700 dark:text-gray-300">
                    Are you sure you want to delete this item?
                </p>
            </div>

            <!-- Actions -->
            <div class="flex gap-3 justify-end">
                <button 
                    type="button" 
                    onclick="closeDeleteModal()" 
                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors"
                >
                    Cancel
                </button>
                <button 
                    type="button" 
                    id="confirmDeleteBtn"
                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors flex items-center gap-2"
                >
                    <span class="material-symbols-outlined text-sm">delete</span>
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let deleteForm = null;

function showDeleteModal(form, message = 'Are you sure you want to delete this item?') {
    deleteForm = form;
    document.getElementById('deleteMessage').textContent = message;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
    
    // Prevent body scroll
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
    deleteForm = null;
    
    // Restore body scroll
    document.body.style.overflow = '';
}

function confirmDelete() {
    if (deleteForm) {
        deleteForm.submit();
    }
    closeDeleteModal();
}

// Bind confirm delete button
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('confirmDeleteBtn').addEventListener('click', confirmDelete);
});

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && !document.getElementById('deleteModal').classList.contains('hidden')) {
        closeDeleteModal();
    }
});

// Close modal on backdrop click
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>