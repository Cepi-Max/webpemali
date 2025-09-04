<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name'))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('style')
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div class="w-full py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registrationForm');
            const nikInput = document.getElementById('nik');
            const phoneInput = document.getElementById('number_phone');
            const passwordInput = document.getElementById('password');
            const passwordConfirmInput = document.getElementById('password_confirmation');

            // Fungsi untuk menampilkan pesan error
            function showError(field, message) {
                const fieldWrapper = field.closest('.field-wrapper');
                const errorContainer = fieldWrapper.querySelector('.error-message-container');
                const inputContainer = fieldWrapper.querySelector('.input-container');
                
                // Hapus pesan error sebelumnya
                errorContainer.innerHTML = '';
                
                // Tambahkan border merah
                field.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
                field.classList.remove('border-gray-300', 'focus:border-sky-500', 'focus:ring-sky-500');
                
                // Tampilkan pesan error
                const errorDiv = document.createElement('div');
                errorDiv.className = 'text-red-500 text-sm font-medium';
                errorDiv.textContent = message;
                errorContainer.appendChild(errorDiv);
            }

            // Fungsi untuk menghapus pesan error
            function clearError(field) {
                const fieldWrapper = field.closest('.field-wrapper');
                const errorContainer = fieldWrapper.querySelector('.error-message-container');
                
                // Hapus pesan error
                errorContainer.innerHTML = '';
                
                // Kembalikan border normal
                field.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
                field.classList.add('border-gray-300', 'focus:border-sky-500', 'focus:ring-sky-500');
            }

            // Validasi NIK - hanya angka, maksimal 16 digit
            function validateNIK(value) {
                const nikPattern = /^[0-9]+$/;
                
                if (!value) {
                    return 'NIK tidak boleh kosong';
                }
                
                if (!nikPattern.test(value)) {
                    return 'NIK hanya boleh berisi angka';
                }
                
                if (value.length !== 16) {
                    return 'NIK harus terdiri dari 16 digit angka';
                }
                
                return null;
            }

            // Validasi nomor telepon - hanya angka, maksimal 13 digit
            function validatePhone(value) {
                const phonePattern = /^[0-9]+$/;
                
                if (!value) {
                    return 'Nomor telepon tidak boleh kosong';
                }
                
                if (!phonePattern.test(value)) {
                    return 'Nomor telepon hanya boleh berisi angka';
                }
                
                if (value.length < 10 || value.length > 13) {
                    return 'Nomor telepon harus terdiri dari 10-13 digit angka';
                }
                
                return null;
            }

            // Validasi password - harus mengandung angka, huruf kecil, huruf besar, dan karakter khusus
            function validatePassword(value) {
                if (!value) {
                    return 'Password tidak boleh kosong';
                }
                
                if (value.length < 8) {
                    return 'Password minimal 8 karakter dan harus mengandung: angka, huruf besar, karakter khusus';
                }
                
                const hasNumber = /[0-9]/.test(value);
                const hasLowerCase = /[a-z]/.test(value);
                const hasUpperCase = /[A-Z]/.test(value);
                const hasSpecialChar = /[^a-zA-Z0-9]/.test(value);
                
                // Cek semua syarat sekaligus dan berikan pesan yang spesifik
                const missingRequirements = [];
                
                if (!hasNumber) {
                    missingRequirements.push('angka');
                }
                
                if (!hasLowerCase) {
                    missingRequirements.push('huruf kecil');
                }
                
                if (!hasUpperCase) {
                    missingRequirements.push('huruf besar');
                }
                
                if (!hasSpecialChar) {
                    missingRequirements.push('karakter khusus');
                }
                
                if (missingRequirements.length > 0) {
                    return `Password harus mengandung: ${missingRequirements.join(', ')}`;
                }
                
                return null;
            }

            // Validasi konfirmasi password
            function validatePasswordConfirmation(value, originalPassword) {
                if (!value) {
                    return 'Konfirmasi password tidak boleh kosong';
                }
                
                if (value !== originalPassword) {
                    return 'Konfirmasi password tidak cocok';
                }
                
                return null;
            }

            // Event listener untuk input NIK
            nikInput.addEventListener('input', function() {
                // Hanya izinkan angka dan batasi maksimal 16 karakter
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16);
                
                const error = validateNIK(this.value);
                if (error) {
                    showError(this, error);
                } else {
                    clearError(this);
                }
            });

            // Event listener untuk input nomor telepon
            phoneInput.addEventListener('input', function() {
                // Hanya izinkan angka dan batasi maksimal 13 karakter
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13);
                
                const error = validatePhone(this.value);
                if (error) {
                    showError(this, error);
                } else {
                    clearError(this);
                }
            });

            // Event listener untuk input password
            passwordInput.addEventListener('input', function() {
                const error = validatePassword(this.value);
                if (error) {
                    showError(this, error);
                } else {
                    clearError(this);
                }
                
                // Validasi ulang konfirmasi password jika sudah diisi
                if (passwordConfirmInput.value) {
                    const confirmError = validatePasswordConfirmation(passwordConfirmInput.value, this.value);
                    if (confirmError) {
                        showError(passwordConfirmInput, confirmError);
                    } else {
                        clearError(passwordConfirmInput);
                    }
                }
            });

            // Event listener untuk konfirmasi password
            passwordConfirmInput.addEventListener('input', function() {
                const error = validatePasswordConfirmation(this.value, passwordInput.value);
                if (error) {
                    showError(this, error);
                } else {
                    clearError(this);
                }
            });

            // Event listener untuk validasi saat form di-submit
            form.addEventListener('submit', function(e) {
                let hasError = false;

                // Validasi NIK
                const nikError = validateNIK(nikInput.value);
                if (nikError) {
                    showError(nikInput, nikError);
                    hasError = true;
                }

                // Validasi nomor telepon
                const phoneError = validatePhone(phoneInput.value);
                if (phoneError) {
                    showError(phoneInput, phoneError);
                    hasError = true;
                }

                // Validasi password
                const passwordError = validatePassword(passwordInput.value);
                if (passwordError) {
                    showError(passwordInput, passwordError);
                    hasError = true;
                }

                // Validasi konfirmasi password
                const confirmError = validatePasswordConfirmation(passwordConfirmInput.value, passwordInput.value);
                if (confirmError) {
                    showError(passwordConfirmInput, confirmError);
                    hasError = true;
                }

                // Jika ada error, prevent form submission
                if (hasError) {
                    e.preventDefault();
                    
                    // Scroll ke error pertama
                    const firstError = document.querySelector('.text-red-500');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            });

            // Event listener untuk menghapus error saat user mulai mengetik di field lain
            const allInputs = form.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]');
            allInputs.forEach(input => {
                input.addEventListener('focus', function() {
                    clearError(this);
                });
            });
        });
        </script>
    </body>
</html>
