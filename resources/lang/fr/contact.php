<?php

return [
    'title' => 'Message Form',
    'formElements' => [
            'fullName' => 'Full Name',
            'email' => 'Email',
            'subject' => 'Message Subject',
            'text' => 'Message Text',
            'submit' => 'Send Message',
    ],

    'disclaimer' => [
            'header' => 'Please Note',
            'text' => 'We cannot put you in touch with any churches of the Santo Daime.  This website is an independent organization and not connected
            with any particular church.  To connect with other churches, please visit our <a href="' . url('friends') .'">page of links</a>.',
    ],

    'message_received' => 'Message received.  Thanks!',
];
