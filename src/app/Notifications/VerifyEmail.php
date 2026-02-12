<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class VerifyEmail extends Notification implements ShouldQueue
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

        // Log email sending attempt
        Log::info('Sending email verification notification', [
            'user_id' => $notifiable->id,
            'email' => $notifiable->email,
            'timestamp' => now()->toDateTimeString()
        ]);

        return (new MailMessage)
            ->subject('Confirme seu endereço de email - CamUp')
            ->greeting('Olá, ' . $notifiable->name . '!')
            ->line('Obrigado por se cadastrar no CamUp! Para começar a usar sua conta, precisamos verificar seu endereço de email.')
            ->line('**Email:** ' . $notifiable->email)
            ->line('Clique no botão abaixo para confirmar seu endereço de email e ativar sua conta:')
            ->action('Verificar Meu Email', $verificationUrl)
            ->line('Este link é válido por **24 horas** e só pode ser usado uma vez.')
            ->line('**Importante:** Se você não criou uma conta no CamUp, ignore este email. Nenhuma ação adicional é necessária.')
            ->salutation('Atenciosamente, Equipe CamUp');
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        return \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'verification.verify',
            \Illuminate\Support\Carbon::now()->addMinutes(1440), // 24 horas
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
