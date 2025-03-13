<?php

namespace App\Notifications\Brevo;

use Illuminate\Contracts\Queue\ShouldQueue;

interface SendsToBrevo extends ShouldQueue
{
    public function toBrevo(object $notifiable): BrevoMessage;
}
