<?php
namespace App\Services;

use App\Mail\ContactSubmit;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;

class ContactService
{
    public function handleContact($name, $email, $subject, $text)
    {
        $contact = new Contact();
        $contact->name = $name;
        $contact->email = $email;
        $contact->subject = $subject;
        $contact->message = $text;
        $contact->save();

        try {
            $result = Mail::to('ben.tobias@gmail.com')->send(
                new ContactSubmit(
                    $name,
                    $email,
                    $subject,
                    $text
                )
            );
        } catch (\Exception $exception) {
            return view('contact')->with('message', 'Uh oh, something went wrong: ' . $exception->getMessage());
        }
    }
    
    public function handleGoodbye($name, $email, $subject, $text)
    {
        try {
            $result = Mail::to('ben.tobias@gmail.com')->send(
                new ContactSubmit(
                    $name,
                    $email,
                    $subject,
                    $text
                )
            );
        } catch (\Exception $exception) {
            return view('contact')->with('message', 'Uh oh, something went wrong: ' . $exception->getMessage());
        }
    }
}
