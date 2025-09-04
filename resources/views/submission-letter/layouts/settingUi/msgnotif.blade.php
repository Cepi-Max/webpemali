@if (session('success'))
    <div id="notif" class="fixed bottom-4 right-4 z-50 flex items-center justify-between gap-4 min-w-[200px] max-w-[350px] max-h-[100px] bg-green-100 text-green-800 border-l-4 border-green-500 shadow-lg rounded-xl p-4 translate-x-full transition-transform duration-500 ease-in-out">
        <div>{{ session('success') }}</div>
        <button type="button" onclick="closeNotif()" class="text-green-800 hover:text-green-600 text-xl font-bold">&times;</button>
    </div>
@endif

@if (session('error'))
    <div id="notif" class="fixed bottom-4 right-4 z-50 flex items-center justify-between gap-4 min-w-[200px] max-w-[350px] max-h-[100px] bg-red-100 text-red-800 border-l-4 border-red-500 shadow-lg rounded-xl p-4 translate-x-full transition-transform duration-500 ease-in-out">
        <div>{{ session('error') }}</div>
        <button type="button" onclick="closeNotif()" class="text-red-800 hover:text-red-600 text-xl font-bold">&times;</button>
    </div>
@endif

@if (session('warning'))
    <div id="notif" class="fixed bottom-4 right-4 z-50 flex items-center justify-between gap-4 min-w-[200px] max-w-[350px] max-h-[100px] bg-yellow-100 text-yellow-800 border-l-4 border-yellow-500 shadow-lg rounded-xl p-4 translate-x-full transition-transform duration-500 ease-in-out">
        <div>{{ session('warning') }}</div>
        <button type="button" onclick="closeNotif()" class="text-yellow-800 hover:text-yellow-600 text-xl font-bold">&times;</button>
    </div>
@endif
