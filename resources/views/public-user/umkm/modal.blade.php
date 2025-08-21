{{-- Modal Komentar --}}
<div id="modalKomentar" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white dark:bg-gray-900 w-full max-w-2xl rounded-xl shadow-xl flex flex-col max-h-[90vh]">
        
        {{-- Header --}}
        <div class="flex justify-between items-center p-4 border-b dark:border-gray-700">
            <h4 class="text-lg font-bold text-gray-700 dark:text-gray-200">Semua Komentar</h4>
            <button onclick="document.getElementById('modalKomentar').classList.add('hidden')" 
                    class="text-gray-500 hover:text-gray-800 text-xl">&times;</button>
        </div>

        {{-- Komentar-komentar scrollable --}}
        <div class="px-6 py-4 overflow-y-auto flex-1">
            @foreach ($allComments as $comment)
                <div class="flex px-2 py-1 mb-4 border-b dark:border-gray-700 pb-3">
                    <div>
                    <img src="{{ asset('storage/images/publicImg/umkm/umkmImg/'. $detailumkm->image) }}" class="w-8 h-8 rounded-full me-3" alt="xd">
                    </div>
                    <div>
                        <div class="bg-white dark:bg-gray-800 dark:text-gray-200 rounded-lg max-w-64 p-2"> 
                            <div class="flex flex-col justify-center ml-3">
                            <h6 class="mb-0 text-sm font-semibold">{{ $comment->user->name }}</h6>
                            <p class="text-sm text-sky-950 dark:text-gray-200">{{ $comment->content }}</p>
                            </div>
                        </div>
                        <div class="flex gap-4 ml-3">
                            <p class="text-sm text-sky-950 dark:text-gray-200">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>      
            @endforeach
        </div>

        {{-- Form input sticky --}}
        @auth
        <form action="{{ route('comments.store') }}" method="POST" class="p-4 border-t dark:border-gray-700 bg-gray-50 dark:bg-gray-900 rounded-xl">
            @csrf
            <input type="hidden" name="umkm_id" value="{{ $detailumkm->id }}">
            <label for="content" class="block text-sm text-gray-600 mb-1">Tulis Komentar</label>
            <textarea name="content" id="content" rows="3"
            class="w-full bg-gray-200 dark:bg-gray-700 border border-gray-400 dark:border-gray-500 text-gray-900 dark:text-gray-100 text-sm rounded-xl p-3 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200 resize-none"
            placeholder="Tulis komentar..."></textarea>        
            <div class="mt-2 text-right">
                <button type="submit" 
                        class="bg-sky-950 text-white px-4 py-2 rounded hover:bg-sky-900 transition">
                    Kirim
                </button>
            </div>
        </form>
        @endauth
    </div>
</div>
