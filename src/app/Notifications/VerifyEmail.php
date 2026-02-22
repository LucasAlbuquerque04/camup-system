<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class VerifyEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
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
        $verificationUrl = $this->verificationUrl($notifiable);
        $expiresInHours = (int) ceil(((int) config('auth.verification.expire', 1440)) / 60);

        // Log email sending attempt
        Log::info('Sending email verification notification', [
            'user_id' => $notifiable->id,
            'email' => $notifiable->email,
            'timestamp' => now()->toDateTimeString()
        ]);

        return (new MailMessage)
            ->subject('Confirme seu endereço de email - CamUp')
            ->view([
                'html' => 'emails.verify-email',
                'text' => 'emails.verify-email-text',
            ], [
                'userName' => $notifiable->name,
                'userEmail' => $notifiable->email,
                'verificationUrl' => $verificationUrl,
                'expiresInHours' => $expiresInHours,
                'appName' => config('app.name', 'CamUp'),
                'logoUrl' => config('mail.logo_url'),
            ]);
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        $expirationMinutes = (int) config('auth.verification.expire', 1440);

        return \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'verification.verify',
            \Illuminate\Support\Carbon::now()->addMinutes($expirationMinutes),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
