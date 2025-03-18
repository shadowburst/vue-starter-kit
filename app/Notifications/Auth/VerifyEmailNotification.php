<?php

namespace App\Notifications\Auth;

use App\Notifications\Brevo\BrevoChannel;
use App\Notifications\Brevo\BrevoMessage;
use App\Notifications\Brevo\SendsToBrevo;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use SensitiveParameter;

class VerifyEmailNotification extends Notification implements SendsToBrevo
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        #[SensitiveParameter] protected string $code,
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [BrevoChannel::class];
    }

    public function toBrevo(object $notifiable): BrevoMessage
    {
        return BrevoMessage::template(1)
            ->parameter('code', $this->code);
    }
}
