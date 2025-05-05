<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AdminResetPasswordNotification extends Notification
{
    public $token;

    public function toMail($notifiable)
    {
        $resetUrl = url("/admin/reset-password/{$this->token}?email={$notifiable->email}");

        return (new MailMessage)
            ->subject('Admin Password Reset Notification')
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', $resetUrl)
            ->line('If you did not request a password reset, no further action is required.');
    }    
}
