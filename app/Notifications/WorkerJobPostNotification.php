<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WorkerJobPostNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $jobPost;
    public function __construct($jobPost)
    {
        $this->jobPost = $jobPost;
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
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Job Post: ' . ($this->jobPost->title ?? 'Job Opportunity'))
            ->greeting('Hello!')
            ->line('A new job post has been created on Instrabaho.')
            ->line("Title: " . ($this->jobPost->title ?? 'No Title'))
            ->line("Description: " . ($this->jobPost->description ?? 'No Description'))
            ->line("Address: " . ($this->jobPost->address ?? 'No Address'))
            ->action('View Details', url('/'))
            ->line('Thank you for using Instrabaho!');
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
