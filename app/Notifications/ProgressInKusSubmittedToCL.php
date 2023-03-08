<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
//define intervensi khusus
use App\IntervensiKhusus;
use App\ProgressIntervensiKhusus;


class ProgressInKusSubmittedToCL extends Notification
{
    use Queueable;
    private $intervensiKhusus;
    private $progressIntervensiKhusus;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(IntervensiKhusus $intervensiKhusus, ProgressIntervensiKhusus $progressIntervensiKhusus)
    {
        //
        $this->intervensiKhusus = $intervensiKhusus;
        $this->progressIntervensiKhusus = $progressIntervensiKhusus;
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
            ->subject('Progres Rencana Aksi ' . $this->intervensiKhusus->nama . ' perlu di review')
            ->greeting('Yth, ' . $notifiable->name)
            ->line('Progres Rencana Aksi ' . $this->intervensiKhusus->nama . ' telah diajukan oleh ' . $this->intervensiKhusus->user->name . ' dan perlu approval anda.')
            ->action('Review Progres', "https://webapps.bps.go.id/manner/progress/intervensi-khususes/" . $this->intervensiKhusus->id . "/progress-intervensi-khususes/" . $this->progressIntervensiKhusus->id)
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
