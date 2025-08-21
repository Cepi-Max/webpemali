<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SuratDitolak extends Notification
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
            ->subject('Pengajuan Surat Anda Ditolak')
            ->greeting('Halo, ' . $notifiable->name)
            ->line('Kami informasikan bahwa pengajuan surat "' . $this->surat->jenisSurat->nama . '" belum dapat kami proses.')
            ->line('Alasan penolakan:')
            ->line($this->surat->pesan ?? 'Tidak ada keterangan.')
            ->line('Jangan khawatir, Anda dapat memperbaiki pengajuan dan mencoba kembali.')
            ->line('Silakan periksa kembali kelengkapan dokumen atau informasi yang dibutuhkan sesuai catatan di atas.')
            ->action('Ajukan Ulang atau Lihat Detail', url('pelayanan-administrasi/pengajuan-saya'))
            ->line('Terima kasih telah menggunakan layanan digital Desa Pemali.')
            ->line('Salam hangat,')
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
