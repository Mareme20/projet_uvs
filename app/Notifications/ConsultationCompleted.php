<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Consultation;

class ConsultationCompleted extends Notification
{
    use Queueable;

    protected $consultation;

    public function __construct(Consultation $consultation)
    {
        $this->consultation = $consultation;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Clinique IIBS - Ordonnance et compte-rendu disponibles')
            ->greeting('Bonjour ' . $this->consultation->patient->prenom . ',')
            ->line('Votre consultation avec le Dr. ' . ($this->consultation->medecin->user->name ?? 'N/A') . ' est terminée.')
            ->line('Vous pouvez consulter votre ordonnance et les détails de votre consultation sur votre espace patient.')
            ->action('Voir mon dossier', route('patient.dashboard'))
            ->line('Merci de nous faire confiance pour votre santé.');
    }

    public function toArray($notifiable): array
    {
        return [
            'consultation_id' => $this->consultation->id,
            'message' => 'Ordonnance et détails disponibles pour votre consultation du ' . $this->consultation->date_consultation->format('d/m/Y'),
        ];
    }
}
