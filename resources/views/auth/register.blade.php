@section('title', 'Daftar Desa Pemali')
<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-sky-50 dark:from-gray-900 dark:to-gray-800 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <div class="inline-flex items-center justify-center p-3 bg-sky-100 dark:bg-sky-900 rounded-full mb-6">
                    <a href="/">
                        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                    </a>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    Daftar Akun Baru
                </h2>
                <p class="text-gray-600 dark:text-gray-400">
                    Bergabunglah dengan layanan digital Desa Pemali
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 p-8">
                <form method="POST" action="{{ route('register') }}" id="registrationForm" class="space-y-6">
                    @csrf
                    
                    <div class="field-wrapper">
                        <x-input-label for="name" :value="__('Nama Lengkap')" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2" />
                        <div class="relative input-container">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <x-text-input id="name" 
                                class="block w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white transition-all duration-300" 
                                type="text" 
                                name="name" 
                                :value="old('name')" 
                                required 
                                autofocus 
                                autocomplete="name" 
                                placeholder="Masukkan nama lengkap anda" />
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        <div class="error-message-container mt-2 min-h-[1.25rem]"></div>
                    </div>

                    <div class="field-wrapper">
                        <x-input-label for="nik" :value="__('No NIK')" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2" />
                        <div class="relative input-container">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <x-text-input id="nik" 
                                class="block w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white transition-all duration-300" 
                                type="text" 
                                name="nik" 
                                :value="old('nik')" 
                                required 
                                autofocus 
                                autocomplete="nik" 
                                placeholder="Masukkan nomor NIK anda" 
                                maxlength="16" />
                        </div>
                        <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                        <div class="error-message-container mt-2 min-h-[1.25rem]"></div>
                    </div>

                    <div class="field-wrapper">
                        <x-input-label for="email" :value="__('Alamat Email')" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2" />
                        <div class="relative input-container">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                            </div>
                            <x-text-input id="email" 
                                class="block w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white transition-all duration-300" 
                                type="email" 
                                name="email" 
                                :value="old('email')" 
                                required 
                                autocomplete="nik" 
                                placeholder="contoh@email.com" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        <div class="error-message-container mt-2 min-h-[1.25rem]"></div>
                    </div>

                    <div class="field-wrapper">
                        <x-input-label for="number_phone" :value="__('Nomor Telepon')" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2" />
                        <div class="relative input-container">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <x-text-input id="number_phone" 
                                class="block w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white transition-all duration-300" 
                                type="text" 
                                name="number_phone" 
                                :value="old('number_phone')" 
                                required 
                                autocomplete="tel" 
                                placeholder="08xxxxxxxxxx" />
                        </div>
                        <x-input-error :messages="$errors->get('number_phone')" class="mt-2" />
                        <div class="error-message-container mt-2 min-h-[1.25rem]"></div>
                    </div>

                    <div class="field-wrapper">
                        <x-input-label for="password" :value="__('Kata Sandi')" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2" />
                        <div class="relative input-container">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <x-text-input id="password" 
                                class="block w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white transition-all duration-300"
                                type="password"
                                name="password"
                                pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d]).{8,}"
                                required 
                                autocomplete="new-password" 
                                placeholder="Minimal 8 karakter" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        <div class="error-message-container mt-2 min-h-[1.25rem]"></div>
                    </div>

                    <div class="field-wrapper">
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2" />
                        <div class="relative input-container">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <x-text-input id="password_confirmation" 
                                class="block w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white transition-all duration-300"
                                type="password"
                                name="password_confirmation" 
                                required 
                                autocomplete="new-password" 
                                placeholder="Ulangi kata sandi" />
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        <div class="error-message-container mt-2 min-h-[1.25rem]"></div>
                    </div>

                    <div class="space-y-4">
                        <x-primary-button class="w-full justify-center py-3 px-4 border border-transparent rounded-lg text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 font-semibold transition-all duration-300 transform hover:scale-[1.02]">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-5-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            {{ __('Daftar Sekarang') }}
                        </x-primary-button>
                        
                        <div class="text-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Sudah punya akun? </span>
                            <a class="text-sm text-sky-600 dark:text-sky-400 hover:text-sky-700 dark:hover:text-sky-300 font-semibold transition-colors duration-300" href="{{ route('login') }}">
                                {{ __('Masuk di sini') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
