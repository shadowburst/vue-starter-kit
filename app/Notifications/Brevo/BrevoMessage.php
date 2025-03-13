<?php

namespace App\Notifications\Brevo;

use Illuminate\Mail\Mailables\Address;

class BrevoMessage
{
    /**
     * Create a new Brevo message.
     *
     * @param  int  $template_id  The ID associated to the template on Brevo
     * @param  ?Address  $from  The from address, will be the app's default email address if null
     * @param  Address[]  $cc  Array of addresses that will be "CC"d the message
     * @param  Address[]  $bcc  Array of addresses that will be "BCC"d the message
     * @param  mixed[]  $attachments  Array of attachments to include with the message
     * @param  array<string, mixed>  $parameters  Array of parameters to send with the message
     */
    public function __construct(
        public int $template_id,
        public ?Address $from = null,
        public ?Address $replyTo = null,
        public array $cc = [],
        public array $bcc = [],
        public array $parameters = [],
        public array $attachments = [],
    ) {
        $this->from ??= new Address(config('mail.from.address'), config('mail.from.name'));
    }

    /**
     * Creates a new message for a template.
     */
    public static function template(int $templateId): static
    {
        return new static(template_id: $templateId,);
    }

    /**
     * Sets the address the message will be sent from.
     */
    public function from(string $email, ?string $name): self
    {
        $this->from = new Address($email, $name);

        return $this;
    }

    /**
     * Sets the address the message will be replied to.
     */
    public function replyTo(string $email, ?string $name): self
    {
        $this->from = new Address($email, $name);

        return $this;
    }

    /**
     * Adds an address to the CC list for the message.
     */
    public function cc(string $email, ?string $name): self
    {
        $this->cc[] = new Address($email, $name);

        return $this;
    }

    /**
     * Adds an address to the BCC list for the message.
     */
    public function bcc(string $email, ?string $name): self
    {
        $this->cc[] = new Address($email, $name);

        return $this;
    }

    /**
     * Adds a parameter to the message.
     */
    public function parameter(string $name, mixed $value): self
    {
        $this->parameters[$name] = $value;

        return $this;
    }

    /**
     * Adds a base64 attachment to the message.
     */
    public function base64Attachment(string $name, string $value): self
    {
        $this->attachments[] = [
            'name'    => $name,
            'content' => $value,
        ];

        return $this;
    }

    /**
     * Adds a url attachment to the message.
     */
    public function urlAttachment(string $name, string $value): self
    {
        $this->attachments[] = [
            'name' => $name,
            'url'  => $value,
        ];

        return $this;
    }
}
