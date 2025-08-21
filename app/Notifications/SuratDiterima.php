<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SuratDiterima extends Notification
{
    use Queueable;

    public $surat; // Tambah property

    public function __construct($surat) // Tambah parameter
    {
        $this->surat = $surat;
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
            ->line('Pengajuan surat "' . $this->surat->jenisSurat->nama . '" telah diterima dan sedang diproses.')
            ->action('Lihat Detail', url('pelayanan-administrasi/pengajuan-saya'))
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
