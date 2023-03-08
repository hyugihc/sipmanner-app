<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IntervensiNasionalProvinsiSubmitted extends Notification
{
    use Queueable;
    private $intervensiNasionalProvinsi;
    private $cc;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($intervensiNasionalProvinsi, $cc)
    {
        //
        $this->cc = $cc;
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
        //construct mail message
        $mailMessage = (new MailMessage)
            ->subject('Program Intervensi Nasional Perlu di Review')
            ->greeting('Yth, ' . $notifiable->name)
            ->line('Program ' . $this->intervensiNasionalProvinsi->intervensiNasional->name . ' telah diajukan oleh ' . $this->cc->name . ' dan perlu approval anda.')
            ->action('Review Program',  "https://webapps.bps.go.id/manner/programs/intervensi-nasionals-provinsi/" . $this->intervensiNasionalProvinsi->id)
            ->line('Terima kasih atas kerjasamanya.');
        //customisasi regards
        $mailMessage->salutation('Email ini digenerate otomatis oleh aplikasi SIPMANNER, tidak perlu dibalas.');

        //return mail message
        return $mailMessage;
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
