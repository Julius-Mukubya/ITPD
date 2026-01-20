<!-- Crisis Support Modal Component -->
<div id="emergencyModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4" onclick="closeCrisisModal(event)">
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 max-w-lg w-full shadow-2xl max-h-[85vh] overflow-y-auto" onclick="event.stopPropagation()">
        <div class="text-center mb-4">
            <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-3">
                <span class="material-symbols-outlined text-2xl text-red-600 dark:text-red-400">emergency</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">Crisis Support</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">If you're experiencing a mental health emergency, please reach out immediately.</p>
        </div>
        
        <div class="space-y-3 mb-4">
            <!-- Mental Health Uganda Helpline -->
            <div class="bg-gradient-to-br from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-sm text-red-600 dark:text-red-400">call</span>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-red-900 dark:text-red-100 text-sm">Mental Health Uganda - Toll Free</h4>
                    </div>
                </div>
                
                <div class="bg-white/60 dark:bg-white/5 rounded-lg p-3 mb-2">
                    <a href="tel:0800212121" class="flex items-center justify-center gap-2 text-xl font-black text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition-colors">
                        <span class="material-symbols-outlined text-2xl">phone_in_talk</span>
                        0800 21 21 21
                    </a>
                    <p class="text-center text-xs text-red-700 dark:text-red-300 mt-1">Free on all networks</p>
                </div>
                
                <div class="text-xs text-red-800 dark:text-red-200 space-y-1">
                    <p><span class="font-semibold">Hours:</span> Mon-Fri, 8:30 AM - 5:00 PM</p>
                    <p><span class="font-semibold">Languages:</span> English & local languages</p>
                </div>
            </div>
            
            <!-- Campus Support -->
            @if(Route::has('public.counseling.request') || Route::has('student.counseling.create'))
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-sm text-blue-600 dark:text-blue-400">school</span>
                    </div>
                    <h4 class="font-semibold text-blue-800 dark:text-blue-300 text-sm">Campus Counseling</h4>
                </div>
                <p class="text-xs text-blue-700 dark:text-blue-400 mb-2">
                    Request an urgent counseling session through our platform.
                </p>
                @if(Route::has('public.counseling.request'))
                <button onclick="closeCrisisModal(); @if(isset($openRequestModal) && $openRequestModal) openRequestModal(); @else window.location.href='{{ route('public.counseling.request') }}?priority=urgent'; @endif" class="w-full bg-blue-600 text-white px-3 py-2 rounded-lg font-semibold hover:bg-blue-700 transition-all text-xs flex items-center justify-center gap-1">
                    <span class="material-symbols-outlined text-sm">add_circle</span>
                    Request Urgent Session
                </button>
                @elseif(Route::has('student.counseling.create'))
                <a href="{{ route('student.counseling.create') }}?priority=urgent" onclick="closeCrisisModal()" class="w-full bg-blue-600 text-white px-3 py-2 rounded-lg font-semibold hover:bg-blue-700 transition-all text-xs flex items-center justify-center gap-1">
                    <span class="material-symbols-outlined text-sm">add_circle</span>
                    Request Urgent Session
                </a>
                @endif
            </div>
            @endif
            
            <!-- Important Note -->
            <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-lg p-3">
                <div class="flex items-start gap-2">
                    <span class="material-symbols-outlined text-purple-600 dark:text-purple-400 text-sm flex-shrink-0">info</span>
                    <div>
                        <p class="text-xs text-purple-800 dark:text-purple-200 font-semibold mb-1">#ConversationsChangeLives</p>
                        <p class="text-xs text-purple-700 dark:text-purple-300 leading-relaxed">
                            You are not alone, and help is just a call away. All services are completely confidential.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="flex gap-2">
            <a href="tel:0800212121" class="flex-1 bg-gradient-to-r from-red-600 to-orange-600 text-white px-4 py-2.5 rounded-lg font-bold hover:shadow-lg transition-all text-center flex items-center justify-center gap-2 text-sm">
                <span class="material-symbols-outlined text-lg">call</span>
                Call Helpline Now
            </a>
            <button onclick="closeCrisisModal()" class="px-4 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition-all text-sm">
                Close
            </button>
        </div>
    </div>
</div>

<script>
function closeCrisisModal(event) {
    // Close modal if clicking on backdrop or called directly
    if (!event || event.target === event.currentTarget) {
        document.getElementById('emergencyModal').classList.add('hidden');
    }
}

// Close modal on Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeCrisisModal();
    }
});
</script>
