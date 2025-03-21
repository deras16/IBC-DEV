<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

class TempPasswordNotification extends Notification
{
    use Queueable;
    protected string $tempPassword;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        $this->tempPassword = Str::random(12);
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
        $notifiable->update(['password' => Hash::make($this->tempPassword)]);

        return (new MailMessage)
            ->subject('Your Temporary Password')
            ->greeting(Lang::get('Hello') . ' '  . $notifiable->name . ',')
            ->line('You have been assigned a temporary password to access your account.')
            ->line("**Temporary Password:** `{$this->tempPassword}`")
            ->line('For security reasons, please change your password immediately after logging in.')
            ->line('This is an automatically generated email. Please do not reply.');
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
