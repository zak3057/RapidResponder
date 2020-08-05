<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactSendmail extends Mailable
{
    use Queueable, SerializesModels;

    private $name;
    private $mail;
    private $tel;
    private $item;
    private $body;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $inputs )
    {
        $this->name = $inputs['name'];
        $this->mail = $inputs['mail'];
        $this->tel  = $inputs['tel'];
        $this->item  = $inputs['item'];
        $this->body  = $inputs['body'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('example@example.com')
            ->subject('自動送信メール')
            ->view('emails.contact.index')
            ->with([
                'name' => $this->name,
                'mail' => $this->mail,
                'tel'  => $this->tel,
                'item'  => $this->item,
                'body'  => $this->body,
            ]);
    }
}