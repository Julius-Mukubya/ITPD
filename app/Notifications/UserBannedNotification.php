<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserBannedNotification extends Notification
{
    use Queueable;

    protected $reason;
    protected $bannedBy;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $reason, string $bannedBy)
    {
        $this->reason = $reason;
        $this->bannedBy = $bannedBy;
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
            'type' => 'user_banned',
            'title' => 'Account Suspended',
            'message' => "Your account has been suspended. Reason: {$this->reason}",
            'data' => [
                'reason' => $this->reason,
                'banned_by' => $this->bannedBy,
                'banned_at' => now()->toDateTimeString(),
            ],
        ];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Account Suspended',
            'type' => 'user_banned',
            'reason' => $this->reason,
            'banned_by' => $this->bannedBy,
            'banned_at' => now()->toDateTimeString(),
        ];
    }
}
