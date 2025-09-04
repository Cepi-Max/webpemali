<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SuratSelesai extends Notification
{
    use Queueable;

    public $surat; 
    public $link; 

    public function __construct($surat, $link) 
    {
        $this->surat = $surat;
        $this->link = $link;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {

        return (new MailMessage)
            ->subject('Pengajuan Surat Anda Diterima')
            ->greeting('Halo, ' . $notifiable->name)
            ->line('Pengajuan surat "' . $this->surat->jenisSurat->nama . '" telah selesai dibuat, silahkan klik link dibawah untuk membuka dan mendownload surat yang anda ajukan.')
            ->action('Buka Surat', $this->link)
            ->line('Terima kasih, jika ada pertanyaan silakan hubungi admin kami.')
            ->line('Hormat Kami,')
            ->line('Pemerintah Desa Pemali');
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
