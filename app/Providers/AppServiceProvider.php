<?php

namespace App\Providers;

use App\Models\Notifikasi;
use App\Models\SocialMediaProfile;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    
    public function boot(): void
    {
        if (Schema::hasTable('social_media_profiles')) {
        $profiles = SocialMediaProfile::first(); // karena hanya 1 baris data
        View::share('profiles', $profiles);
        }
        if (request()->is('admin/*')) {
            Paginator::useBootstrapFive();
        } else {
            Paginator::defaultView('default');
        }
        
        Carbon::setLocale('id');
        View::composer('*', function ($view) {
            // Ambil semua notifikasi (maksimal 5 untuk dropdown)
            $notifikasi = Notifikasi::orderBy('created_at', 'desc')
                ->take(5)
                ->get();
            
            // Hitung notifikasi yang belum dibaca oleh operator hari ini
            $notifikasiBaru = Notifikasi::where('dibaca', false)
                ->count();
            
            $view->with([
                'notifikasi' => $notifikasi,
                'notifikasiBaru' => $notifikasiBaru
            ]);
        });
        
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            // Nama aplikasi dari config
            $appName = Config::get('app.name');

            return (new MailMessage)
                ->subject(__('auth.verify_email_subject', ['app_name' => $appName]))
                // Teks Hello! dan instruksi lainnya
                ->line(__('auth.verify_email'))
                // Tombol aksi
                ->action(__('auth.verify_email_button'), $url)
                // Pesan jika tidak membuat akun
                ->line(__('auth.verify_email_no_account'))
                // Salam penutup
                ->salutation(__('auth.verify_email_regards'));
        });
    }

}
