<!-- Toast Container -->
<div id="toast-container" class="fixed top-20 right-4 z-[9999] space-y-2 max-w-sm"></div>

@push('styles')
<style>
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
// Global Toast Notification System
window.showToast = function(message, type = 'info', duration = 4000) {
    const container = document.getElementById('toast-container');
    if (!container) return;
    
    const toast = document.createElement('div');
    const toastId = 'toast-' + Date.now();
    toast.id = toastId;
    
    // Define colors and icons for different types
    const config = {
        'success': {
            bg: 'bg-green-500',
            icon: 'check_circle',
            textColor: 'text-white'
        },
        'error': {
            bg: 'bg-red-500',
            icon: 'error',
            textColor: 'text-white'
        },
        'warning': {
            bg: 'bg-yellow-500',
            icon: 'warning',
            textColor: 'text-white'
        },
        'info': {
            bg: 'bg-blue-500',
            icon: 'info',
            textColor: 'text-white'
        }
    };
    
    const typeConfig = config[type] || config['info'];
    
    toast.className = `${typeConfig.bg} ${typeConfig.textColor} px-6 py-4 rounded-2xl shadow-2xl font-semibold toast-enter cursor-pointer transform translate-x-full transition-transform duration-300`;
    
    toast.innerHTML = `
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined !text-xl flex-shrink-0">${typeConfig.icon}</span>
            <span class="flex-1">${message}</span>
            <button onclick="removeToast('${toastId}')" class="ml-2 opacity-70 hover:opacity-100 transition-opacity">
                <span class="material-symbols-outlined !text-lg">close</span>
            </button>
        </div>
    `;
    
    container.appendChild(toast);
    
    // Slide in
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 100);
    
    // Auto remove after duration
    setTimeout(() => {
        removeToast(toastId);
    }, duration);
    
    // Click to dismiss (except close button)
    toast.addEventListener('click', (e) => {
        if (!e.target.closest('button')) {
            removeToast(toastId);
        }
    });
};

// Remove toast function
window.removeToast = function(toastId) {
    const toast = document.getElementById(toastId);
    if (!toast) return;
    
    toast.classList.add('toast-exit');
    setTimeout(() => {
        if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
    }, 300);
};

// Show session flash messages as toasts on page load
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        showToast('{{ session('success') }}', 'success');
    @endif
    
    @if(session('error'))
        showToast('{{ session('error') }}', 'error');
    @endif
    
    @if(session('warning'))
        showToast('{{ session('warning') }}', 'warning');
    @endif
    
    @if(session('info'))
        showToast('{{ session('info') }}', 'info');
    @endif
});
</script>
@endpush