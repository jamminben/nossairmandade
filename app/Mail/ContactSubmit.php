<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactSubmit extends Mailable
{
    use Queueable, SerializesModels;

    private $name;
    private $email;
    private $mailsubject;
    private $mailmessage;

    /**
     * ContactSubmit constructor.
     * @param $name
     * @param $email
     * @param $subject
     * @param $message
     */
    public function __construct($name, $email, $mailsubject, $mailmessage)
    {
        $this->name = $name;
        $this->email = $email;
        $this->mailsubject = $mailsubject;
        $this->mailmessage = $mailmessage;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('contact@nossairmandade.com')
            ->view(
                '_mail.contact_submit',
                [
                    'name' => $this->name,
                    'email' => $this->email,
                    'mailsubject' => $this->mailsubject,
                    'mailmessage' => $this->mailmessage
                ])
            ->subject("[ nossairmandade Contact ] " . $this->mailsubject);
    }
}
