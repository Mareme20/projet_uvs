<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Prestation;

class PrestationResultReady extends Notification
{
    use Queueable;

    protected $prestation;

    public function __construct(Prestation $prestation)
    {
        $this->prestation = $prestation;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Clinique IIBS - Résultats disponibles')
            ->greeting('Bonjour ' . $this->prestation->patient->prenom . ',')
            ->line('Les résultats de votre prestation (' . $this->prestation->type . ') effectuée le ' . $this->prestation->date_prestation->format('d/m/Y') . ' sont désormais disponibles.')
            ->action('Voir mes résultats', route('patient.dashboard'))
            ->line('Merci de nous faire confiance pour votre santé.');
    }

    public function toArray($notifiable): array
    {
        return [
            'prestation_id' => $this->prestation->id,
            'type' => $this->prestation->type,
            'message' => 'Résultats disponibles pour : ' . $this->prestation->type,
        ];
    }
}
