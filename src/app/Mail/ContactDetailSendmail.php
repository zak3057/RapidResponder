<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactDetailSendmail extends Mailable
{
    use Queueable, SerializesModels;

    private $title;
    private $body;
    private $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($inputs, $email)
    {
        $this->title = $inputs['title'];
        $this->body = $inputs['body'];
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from($this->email)
            ->subject($this->title)
            ->view('emails.contact.detail.index')
            ->with([
                'body'  => $this->body,
            ]);
    }
}