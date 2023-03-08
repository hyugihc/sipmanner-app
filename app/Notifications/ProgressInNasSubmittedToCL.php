<?php

namespace App\Notifications;

use App\IntervensiNasionalProvinsi;
use App\ProgressIntervensiNasional;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;




class ProgressInNasSubmittedToCL extends Notification
{
    use Queueable;
    private $intervensi;
    private $cc;
    private $progressIntervensiNasional;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(IntervensiNasionalProvinsi $intervensiNasionalProvinsi, ProgressIntervensiNasional $progressIntervensiNasional, User $cc)
    {
        //
        $this->intervensi = $intervensiNasionalProvinsi;
        $this->cc = $cc;
        $this->progressIntervensiNasional = $progressIntervensiNasional;
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
            ->subject('Progres Rencana Aksi ' . $this->intervensi->nama . ' perlu di review')
            ->greeting('Yth, ' . $notifiable->name)
            ->line('Progres Rencana Aksi ' . $this->intervensi->nama . ' telah diajukan oleh ' . $this->cc->name . ' dan perlu approval anda.')
            ->action('Review Progres', "https://webapps.bps.go.id/manner/progress/intervensi-nasionals/" . $this->intervensi->intervensiNasional->id . "/progress-intervensi-nasionals/" . $this->progressIntervensiNasional->id)
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
