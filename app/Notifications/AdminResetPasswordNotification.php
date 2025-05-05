<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AdminResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    // OBLIGATOIRE : cette méthode indique via quels canaux la notification sera envoyée
    public function via($notifiable)
    {
        return ['mail'];
    }

    // Crée le contenu de l’e-mail
    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Réinitialisation du mot de passe Admin')
            ->line('Vous recevez ce mail car nous avons reçu une demande de réinitialisation du mot de passe pour votre compte.')
            ->action('Réinitialiser le mot de passe', $url)
            ->line('Si vous n’avez pas demandé de réinitialisation du mot de passe, aucune action n’est requise.');
    }
}
