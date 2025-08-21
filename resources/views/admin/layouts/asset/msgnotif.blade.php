@if (session('success'))
    <div id="notif" class="border-start border-5 border-success d-flex align-items-center justify-content-between shadow rounded-3 p-3 position-fixed bottom-0 end-0 me-3 mb-3 show z-index-3" role="alert" style="min-width: 200px; max-width: 350px; max-height: 100px; transform: translateX(150%); transition: transform 0.5s ease; background-color: rgb(205, 255, 205);" data-bs-theme="dark">
        <div class="text-dark">{{ session('success') }}</div>
        <button type="button" class="btn-close ms-3" aria-label="Close" onclick="closeNotif()" style="transform: scale(0.8);"></button>
    </div>
@endif

@if (session('error'))
    <div id="notif" class="border-start border-5 border-danger d-flex align-items-center justify-content-between shadow rounded-3 p-3 position-fixed bottom-0 end-0 me-3 mb-3 show z-index-3" role="alert" style="min-width: 200px; max-width: 350px; max-height: 100px; transform: translateX(150%); transition: transform 0.5s ease; background-color: rgb(255, 216, 216);" data-bs-theme="dark">
        <div class="text-dark">{{ session('error') }}</div>
        <button type="button" class="btn-close ms-3" aria-label="Close" onclick="closeNotif()" style="transform: scale(0.8);"></button>
    </div>
@endif

@if (session('warning'))
    <div id="notif" class="border-start border-5 border-warning d-flex align-items-center justify-content-between shadow rounded-3 p-3 position-fixed bottom-0 end-0 me-3 mb-3 show z-index-3" role="alert" style="min-width: 200px; max-width: 350px; max-height: 100px; transform: translateX(150%); transition: transform 0.5s ease; background-color: rgb(254, 255, 212);" data-bs-theme="dark">
        <div class="text-dark">{{ session('warning') }}</div>
        <button type="button" class="btn-close ms-3" aria-label="Close" onclick="closeNotif()" style="transform: scale(0.8);"></button>
    </div>
@endif

