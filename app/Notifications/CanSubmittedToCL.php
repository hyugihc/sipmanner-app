<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
//define report
use App\Can;

class CanSubmittedToCL extends Notification
{
    use Queueable;
    private $can;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Can $can)
    {
        $this->can = $can;
        //
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
            ->subject('Data Change Agent Network Perlu di Review')
            ->greeting('Yth, ' . $notifiable->name)
            ->line('Data Change Agent Network telah diajukan oleh Change Champion anda dan perlu approval anda.')
            ->action('Review Data', "https://webapps.bps.go.id/manner/cans/" . $this->can->id)
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
