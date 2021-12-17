<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IntervensiNasionalProvinsiSubmitted extends Notification
{
    use Queueable;
    public $intervensiNasionalProvinsi;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($intervensiNasionalProvinsi)
    {
        //
        $this->intervensiNasionalProvinsi = $intervensiNasionalProvinsi;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Ada Program Intervensi Nasional yang disesuaikan oleh Change Champion anda dan perlu persetujuan anda')
            ->action('Lihat Program yang diajukan', url('/programs/intervensi-nasionals-provinsi' . '/' . $this->intervensiNasionalProvinsi->id))
            ->line('Terima kasih telah menggunakan Sipmanner');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
