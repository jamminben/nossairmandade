<?php

return [
    'feedback_form' => [
        'header' => 'Feedback',
        'description' => 'Is there something wrong with the content of this page?',
        'message_placeholder' => 'Enter your message here',
        'submit' => 'Send',
        'response' => 'Thanks!',
        'login' => '<a href="' . url('/login') .'">Log In</a> to leave us feedback right here.',
    ],

    'footer' => [
        'more' => 'More...',
        'churches' => 'Daime Churches',
        'official' => 'Official Sites',
        'copyright' => '&copy; Copyright 2010 - ' . date('Y') . '. All Rights Reserved.',
        'donate_title' => 'Donate',
        'donate_text' => 'This site will always be free.  If you would like to support the site, please visit the<br><strong><a href="' . url('/donate') .'">Donation Page</a></strong>'
    ],

    'add_hymn_form' => [
        'header' => 'Add to personal hinário',
        'add_tooltip' => 'You can create your own personal hinários, add hymns to them, and share them with others.',
        'new_name_placeholder' => "New Hinario Name",
        'create_new_hinario' => "Create New Hinario",
        'enter_name' => 'Please enter a name',
        'hinario_missing' => 'Sorry!  Something went wrong.',
        'added' => 'Added!',
        'create_header_multiple' => 'or create new hinário',
        'create_header' => 'Create new hinário',
    ],

    'close' => 'Close'
];
