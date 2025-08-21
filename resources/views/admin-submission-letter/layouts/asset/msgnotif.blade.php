{{-- Success Notification --}}
@if (session('success'))
<div id="notif-success" 
     class="fixed bottom-4 right-4 z-50 min-w-80 max-w-96 bg-white border-l-4 border-green-500 rounded-xl shadow-lg transform translate-x-full transition-transform duration-500 ease-in-out"
     role="alert">
    <div class="flex items-center justify-between p-4">
        <div class="flex items-center">
            <div class="bg-green-100 p-2 rounded-lg mr-3">
                <i class="fas fa-check-circle text-green-600 text-lg"></i>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-gray-800">Berhasil!</h4>
                <p class="text-sm text-gray-600">{{ session('success') }}</p>
            </div>
        </div>
        <button type="button" 
                class="text-gray-400 hover:text-gray-600 transition-colors duration-200 ml-4"
                onclick="closeNotif('notif-success')"
                aria-label="Close">
            <i class="fas fa-times text-lg"></i>
        </button>
    </div>
    <div class="bg-green-500 h-1 rounded-b-lg animate-shrink"></div>
</div>
@endif

{{-- Error Notification --}}
@if (session('error'))
<div id="notif-error" 
     class="fixed bottom-4 right-4 z-50 min-w-80 max-w-96 bg-white border-l-4 border-red-500 rounded-xl shadow-lg transform translate-x-full transition-transform duration-500 ease-in-out"
     role="alert">
    <div class="flex items-center justify-between p-4">
        <div class="flex items-center">
            <div class="bg-red-100 p-2 rounded-lg mr-3">
                <i class="fas fa-exclamation-circle text-red-600 text-lg"></i>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-gray-800">Error!</h4>
                <p class="text-sm text-gray-600">{{ session('error') }}</p>
            </div>
        </div>
        <button type="button" 
                class="text-gray-400 hover:text-gray-600 transition-colors duration-200 ml-4"
                onclick="closeNotif('notif-error')"
                aria-label="Close">
            <i class="fas fa-times text-lg"></i>
        </button>
    </div>
    <div class="bg-red-500 h-1 rounded-b-lg animate-shrink"></div>
</div>
@endif

{{-- Warning Notification --}}
@if (session('warning'))
<div id="notif-warning" 
     class="fixed bottom-4 right-4 z-50 min-w-80 max-w-96 bg-white border-l-4 border-secondary-500 rounded-xl shadow-lg transform translate-x-full transition-transform duration-500 ease-in-out"
     role="alert">
    <div class="flex items-center justify-between p-4">
        <div class="flex items-center">
            <div class="bg-secondary-100 p-2 rounded-lg mr-3">
                <i class="fas fa-exclamation-triangle text-secondary-600 text-lg"></i>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-gray-800">Peringatan!</h4>
                <p class="text-sm text-gray-600">{{ session('warning') }}</p>
            </div>
        </div>
        <button type="button" 
                class="text-gray-400 hover:text-gray-600 transition-colors duration-200 ml-4"
                onclick="closeNotif('notif-warning')"
                aria-label="Close">
            <i class="fas fa-times text-lg"></i>
        </button>
    </div>
    <div class="bg-secondary-500 h-1 rounded-b-lg animate-shrink"></div>
</div>
@endif

{{-- Info Notification --}}
@if (session('info'))
<div id="notif-info" 
     class="fixed bottom-4 right-4 z-50 min-w-80 max-w-96 bg-white border-l-4 border-primary-500 rounded-xl shadow-lg transform translate-x-full transition-transform duration-500 ease-in-out"
     role="alert">
    <div class="flex items-center justify-between p-4">
        <div class="flex items-center">
            <div class="bg-primary-100 p-2 rounded-lg mr-3">
                <i class="fas fa-info-circle text-primary-600 text-lg"></i>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-gray-800">Informasi</h4>
                <p class="text-sm text-gray-600">{{ session('info') }}</p>
            </div>
        </div>
        <button type="button" 
                class="text-gray-400 hover:text-gray-600 transition-colors duration-200 ml-4"
                onclick="closeNotif('notif-info')"
                aria-label="Close">
            <i class="fas fa-times text-lg"></i>
        </button>
    </div>
    <div class="bg-primary-500 h-1 rounded-b-lg animate-shrink"></div>
</div>
@endif

{{-- Custom Styles --}}
<style>
    @keyframes shrink {
        from {
            width: 100%;
        }
        to {
            width: 0%;
        }
    }
    
    .animate-shrink {
        animation: shrink 5s linear forwards;
    }
    
    /* Custom notification animations */
    .notification-enter {
        animation: slideInRight 0.5s ease-out forwards;
    }
    
    .notification-exit {
        animation: slideOutRight 0.3s ease-in forwards;
    }
    
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
    
    /* Hover effect for close button */
    .notification-close:hover {
        background-color: rgba(0, 0, 0, 0.1);
        border-radius: 50%;
        transform: scale(1.1);
    }
</style>

{{-- JavaScript for Notification Functionality --}}
<script>
    // Show notifications on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Get all notification elements
        const notifications = document.querySelectorAll('[id^="notif-"]');
        
        notifications.forEach(function(notification, index) {
            // Show notification with slight delay for multiple notifications
            setTimeout(function() {
                notification.classList.remove('translate-x-full');
                notification.classList.add('notification-enter');
            }, index * 200);
            
            // Auto hide after 5 seconds
            setTimeout(function() {
                closeNotif(notification.id);
            }, 5000 + (index * 200));
        });
    });
    
    // Close notification function
    function closeNotif(notifId) {
        const notification = document.getElementById(notifId);
        if (notification) {
            notification.classList.add('notification-exit');
            
            // Remove element after animation
            setTimeout(function() {
                notification.remove();
            }, 300);
        }
    }
    
    // Function to create dynamic notifications (for JavaScript usage)
    function showNotification(type, title, message, duration = 5000) {
        const colors = {
            success: {
                border: 'border-green-500',
                bg: 'bg-green-100',
                text: 'text-green-600',
                icon: 'fas fa-check-circle',
                progress: 'bg-green-500'
            },
            error: {
                border: 'border-red-500',
                bg: 'bg-red-100',
                text: 'text-red-600',
                icon: 'fas fa-exclamation-circle',
                progress: 'bg-red-500'
            },
            warning: {
                border: 'border-secondary-500',
                bg: 'bg-secondary-100',
                text: 'text-secondary-600',
                icon: 'fas fa-exclamation-triangle',
                progress: 'bg-secondary-500'
            },
            info: {
                border: 'border-primary-500',
                bg: 'bg-primary-100',
                text: 'text-primary-600',
                icon: 'fas fa-info-circle',
                progress: 'bg-primary-500'
            }
        };
        
        const color = colors[type] || colors.info;
        const notifId = 'notif-' + type + '-' + Date.now();
        
        const notificationHTML = `
            <div id="${notifId}" 
                 class="fixed bottom-4 right-4 z-50 min-w-80 max-w-96 bg-white ${color.border} border-l-4 rounded-xl shadow-lg transform translate-x-full transition-transform duration-500 ease-in-out"
                 role="alert">
                <div class="flex items-center justify-between p-4">
                    <div class="flex items-center">
                        <div class="${color.bg} p-2 rounded-lg mr-3">
                            <i class="${color.icon} ${color.text} text-lg"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-gray-800">${title}</h4>
                            <p class="text-sm text-gray-600">${message}</p>
                        </div>
                    </div>
                    <button type="button" 
                            class="text-gray-400 hover:text-gray-600 transition-colors duration-200 ml-4"
                            onclick="closeNotif('${notifId}')"
                            aria-label="Close">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
                <div class="${color.progress} h-1 rounded-b-lg animate-shrink"></div>
            </div>
        `;
        
        // Insert notification
        document.body.insertAdjacentHTML('beforeend', notificationHTML);
        
        const notification = document.getElementById(notifId);
        
        // Show notification
        setTimeout(function() {
            notification.classList.remove('translate-x-full');
            notification.classList.add('notification-enter');
        }, 100);
        
        // Auto hide
        setTimeout(function() {
            closeNotif(notifId);
        }, duration);
    }
    
    // Example usage:
    // showNotification('success', 'Berhasil!', 'Data telah disimpan dengan sukses');
    // showNotification('error', 'Error!', 'Terjadi kesalahan saat menyimpan data');
    // showNotification('warning', 'Peringatan!', 'Harap periksa kembali data yang dimasukkan');
    // showNotification('info', 'Informasi', 'Proses sedang berlangsung');
</script>