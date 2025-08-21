<header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800" x-text="getPageTitle()"></h2>
                        <p class="text-gray-600 text-lg font-semibold mt-1">Pelayanan Desa Pemali</p>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Notification Dropdown Component -->
                        <div class="relative inline-block">
                            <button id="notificationBtn" class="relative p-3 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors shadow-sm border border-gray-200">
                                <i class="fas fa-bell text-lg"></i>
                                @if ($notifikasiBaru > 0)
                                    <span id="notificationBadge" class="absolute -top-1 -right-1 bg-orange-500 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center pulse-animation font-semibold">
                                        {{ $notifikasiBaru }}
                                    </span>
                                @endif
                            </button>
                            
                            <!-- Dropdown Notification Panel -->
                            <div id="notificationDropdown" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50 hidden">
                                <!-- Header -->
                                <div class="p-4 border-b border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-semibold text-gray-800">Notifikasi</h3>
                                    </div>
                                </div>
                                
                                <!-- Notification Items -->
                                <div class="max-h-64 overflow-y-auto notification-scroll" id="notificationList">
                                    @forelse ($notifikasi as $notification)
                                        <div class="notification-item {{ !$notification->dibaca ? 'unread' : '' }} p-4 border-b border-gray-100 cursor-pointer hover:bg-gray-50 transition-colors" 
                                            data-id="{{ $notification->id }}"
                                            data-link="{{ url('/admin/surat/' . $notification->id) }}">
                                            <div class="flex items-start space-x-3">
                                                <!-- Status Indicator -->
                                                <div class="flex-shrink-0 mt-1">
                                                    <div class="w-2 h-2 rounded-full {{ !$notification->dibaca ? 'bg-orange-500' : 'bg-gray-300' }}"></div>
                                                </div>
                                                
                                                <!-- Notification Content -->
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm text-gray-800 leading-relaxed line-clamp-2">
                                                        {{ $notification->pesan }}
                                                    </p>
                                                    <p class="text-xs text-gray-500 mt-1">
                                                        {{ $notification->created_at->diffForHumans() }}
                                                    </p>
                                                    @if($notification->pengajuan_surat_id)
                                                        <p class="text-xs text-blue-600 mt-1">
                                                            ID Pengajuan: #{{ $notification->pengajuan_surat_id }}
                                                        </p>
                                                    @endif
                                                </div>
                                                
                                                <!-- Mark as Read Button -->
                                                @if (!$notification->dibaca)
                                                    <button class="mark-read-btn flex-shrink-0 text-xs text-blue-600 hover:text-blue-800 p-1 rounded transition-colors" 
                                                            data-id="{{ $notification->id }}"
                                                            title="Tandai sebagai dibaca">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <div class="p-8 text-center text-gray-500">
                                            <i class="fas fa-bell-slash text-3xl mb-3 text-gray-300"></i>
                                            <p class="text-sm">Tidak ada notifikasi</p>
                                        </div>
                                    @endforelse
                                </div>
                                
                                <!-- Footer -->
                                <div class="p-3 border-t border-gray-200 bg-gray-50">
                                    <a href="{{ route('show.notifikasi' )}}" class="block text-center text-sm text-blue-600 hover:text-blue-800 font-medium transition-colors">
                                        Lihat Semua Notifikasi
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">Admin</p>
                                <p class="text-xs text-gray-500">Administrator</p>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <script>
    document.addEventListener('DOMContentLoaded', function () {
        const notificationBtn = document.getElementById('notificationBtn');
        const notificationDropdown = document.getElementById('notificationDropdown');

        // Sembunyikan dropdown saat pertama
        notificationDropdown.style.display = 'none';

        // Toggle dropdown ketika tombol ditekan
        notificationBtn.addEventListener('click', function (e) {
            e.stopPropagation(); // Biar gak langsung ketutup
            const isVisible = notificationDropdown.style.display === 'block';
            notificationDropdown.style.display = isVisible ? 'none' : 'block';
        });

        // Tutup dropdown kalau klik di luar
        document.addEventListener('click', function (e) {
            if (!notificationDropdown.contains(e.target) && e.target !== notificationBtn) {
                notificationDropdown.style.display = 'none';
            }
        });

        // (Opsional) Klik item notifikasi -> redirect
        document.querySelectorAll('.notification-item').forEach(item => {
            item.addEventListener('click', function () {
                const link = this.getAttribute('data-link');
                if (link) {
                    window.location.href = link;
                }
            });
        });

        // (Opsional) Klik tombol tandai dibaca
        document.querySelectorAll('.mark-read-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.stopPropagation(); // biar tidak trigger redirect
                const id = this.getAttribute('data-id');

                // Kirim request ke server (AJAX jika ingin)
                fetch(`/notifikasi/${id}/read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id })
                }).then(() => {
                    this.closest('.notification-item').classList.remove('unread');
                    this.remove(); // hapus tombol centang
                });
            });
        });

        // (Opsional) Tombol tandai semua dibaca
        const markAllBtn = document.getElementById('markAllRead');
        if (markAllBtn) {
            markAllBtn.addEventListener('click', function () {
                fetch('/notifikasi/read-all', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    }
                }).then(() => {
                    document.querySelectorAll('.notification-item.unread').forEach(item => {
                        item.classList.remove('unread');
                        item.querySelector('.mark-read-btn')?.remove();
                    });
                });
            });
        }
    });
</script>
