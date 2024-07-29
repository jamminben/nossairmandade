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

    'add_media' => [
        'add_media' => 'Add media',
        'choose_file' => 'Choose file',
        'new_source_name' => 'Media Source Name',
        'new_source_url' => 'Media Source URL',
        'add_new_source_label' => 'Media source:',
        'add_media_tooltip_text' => 'If you add a file with the extension .mp3 or .mpeg, it will be playable in the music player.  Any other file type will appear as a file but not be playable.',
        'add_media_source_tooltip_text' => "The Media Source is the name of the place you got the recording (your name if you recorded it, unknown if you don't know where it came from, Youtube, etc.  The URL is optional - if you add it, it will create a link to the source (i.e. www.youtube.com, etc.) connected to the recording you are uploading.",
    ],

    'close' => 'Close'
];
