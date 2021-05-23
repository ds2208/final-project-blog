<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable {

    use Queueable,
        SerializesModels;

    protected $message;
    protected $name;
    protected $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email, $message) {
        $this->setName($name);
        $this->setEmail($email);
        $this->setMessage($message);
    }

    public function getMessage() {
        return $this->message;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        $this->from($this->getEmail(), $this->getName())
                ->replyTo($this->getEmail())
                ->subject('New message on contact form!');

        return $this->view('front.emails.contact_form', [
                    'contact_name' => $this->getName(),
                    'contact_message' => $this->getMessage()
        ]);
    }

}
