<?php

namespace App\Notifications;

use App\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReportUnsubmittedToCL extends Notification
{
    use Queueable;
    //define intervensiKhusus variable
    private $report;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Report $report)
    {
        $this->report = $report;
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
            ->subject('Laporan Manajemen Perubahan Semester ' . $this->report->semester . ' diubah kembali menjadi draft')
            ->greeting('Yth, ' . $notifiable->name)
            ->line('Laporan Manajemen Perubahan Semester ' . $this->report->semester  . ' yang telah diajukan sebelumnya oleh ' . $this->report->user->name . ' dikembalikan menjadi draft .')
            ->line('Tidak ada tindakan yang diperlukan, Terima kasih atas kerjasamanya.');
        //customisasi regards
        $mailMessage->salutation('Email ini digenerate otomatis oleh aplikasi SIPMANNER, tidak perlu dibalas.');

        //return mail message
        return $mailMessage;


        // return (new MailMessage)
        //             ->line('The introduction to the notification.')
        //             ->action('Notification Action', url('/'))
        //             ->line('Thank you for using our application!');
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