<?php

namespace App\Notifications;

use App\Models\UserWarning;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContentWarningNotification extends Notification
{
    use Queueable;

    protected $warning;

    /**
     * Create a new notification instance.
     */
    public function __construct(UserWarning $warning)
    {
        $this->warning = $warning;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'user_id' => $notifiable->id,
            'type' => 'content_warning',
            'title' => 'Content Warning Issued',
            'message' => $this->warning->message,
            'data' => [
                'warning_id' => $this->warning->id,
                'reason' => $this->warning->reason,
                'issued_by' => $this->warning->issuer->name,
                'issued_at' => $this->warning->created_at->toDateTimeString(),
            ],
        ];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Content Warning Issued',
            'type' => 'content_warning',
            'warning_id' => $this->warning->id,
            'reason' => $this->warning->reason,
            'message' => $this->warning->message,
            'issued_by' => $this->warning->issuer->name,
            'issued_at' => $this->warning->created_at->toDateTimeString(),
        ];
    }
}
