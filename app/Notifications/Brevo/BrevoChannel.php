<?php

namespace App\Notifications\Brevo;

use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\Configuration;
use Brevo\Client\Model\SendSmtpEmail;
use Brevo\Client\Model\SendSmtpEmailAttachment;
use Brevo\Client\Model\SendSmtpEmailBcc;
use Brevo\Client\Model\SendSmtpEmailCc;
use Brevo\Client\Model\SendSmtpEmailReplyTo;
use Brevo\Client\Model\SendSmtpEmailSender;
use Brevo\Client\Model\SendSmtpEmailTo;
use GuzzleHttp\Client;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class BrevoChannel
{
    /**
     * Send the given notification.
     */
    public function send(object $notifiable, SendsToBrevo $notification): void
    {
        /** @var array|string|null $to */
        $to = $notifiable->routeNotificationFor('brevo', $notification);
        if (! $to) {
            return;
        }

        $message = $notification->toBrevo($notifiable);

        $smptEmail = (new SendSmtpEmail)
            ->setTemplateId($message->template_id)
            ->setTo(
                Collection::wrap($to)
                    ->map(function (string $value, int|string $key) {
                        $to = new SendSmtpEmailTo;

                        $name = is_numeric($key) ? null : $value;
                        $email = is_numeric($key) ? $value : $key;

                        if ($name) {
                            $to->setName($name);
                        }

                        return $to->setEmail($email);
                    })
                    ->values()
                    ->toArray(),
            )
            ->setSender(
                (new SendSmtpEmailSender)
                    ->setEmail($message->from->address)
                    ->setName($message->from->name),
            );

        if ($message->replyTo) {
            $smptEmail->setReplyTo(
                (new SendSmtpEmailReplyTo)
                    ->setEmail($message->replyTo->address)
                    ->setName($message->replyTo->name),
            );
        }
        if (! empty($message->cc)) {
            $smptEmail
                ->setCc(
                    collect($message->cc)
                        ->map(
                            fn (Address $cc) => (new SendSmtpEmailCc)
                                ->setEmail($cc->address)
                                ->setName($cc->name),
                        )
                        ->values()
                        ->toArray(),
                );
        }
        if (! empty($message->bcc)) {
            $smptEmail
                ->setBcc(
                    collect($message->bcc)
                        ->map(
                            fn (Address $bcc) => (new SendSmtpEmailBcc)
                                ->setEmail($bcc->address)
                                ->setName($bcc->name),
                        )
                        ->values()
                        ->toArray(),
                );
        }
        if (! empty($message->attachments)) {
            $smptEmail
                ->setAttachment(
                    collect($message->attachments)
                        ->map(
                            fn (array $attachment) => isset($attachment['content'])
                               ? (new SendSmtpEmailAttachment)
                                   ->setName($attachment['name'])
                                   ->setContent($attachment['content'])
                               : (new SendSmtpEmailAttachment)
                                   ->setName($attachment['name'])
                                   ->setUrl($attachment['url']),
                        )
                        ->values()
                        ->toArray(),
                );
        }
        if (! empty($message->parameters)) {
            $smptEmail
                ->setParams($message->parameters);
        }

        if (Notification::isFake()) {
            return;
        }

        if (App::hasDebugModeEnabled()) {
            Log::debug('New Brevo email', (array) $message);

            $debugEmail = config('mail.debug.address');
            if (! $debugEmail) {
                return;
            }

            $debugTo = new SendSmtpEmailTo;
            $debugTo->setEmail($debugEmail);

            $smptEmail->setTo([$debugTo]);
        }

        $api = new TransactionalEmailsApi(
            new Client,
            Configuration::getDefaultConfiguration()->setApiKey('api-key', config('services.brevo.api_key')),
        );
        $api->sendTransacEmail($smptEmail);
    }
}
