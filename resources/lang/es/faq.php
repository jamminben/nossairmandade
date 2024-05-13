<?php

return [

    'intro' => 'Here is some information that might be helpful when navigating the site:',

    'questions' => [
        1 => [
            'question' => 'What happened to the site!?',
            'answer' => 'After 10 years of no updates, I decided to go all in and do a complete overhaul.
            I know it can be uncomfortable to have things change so drastically.  I\'m sorry.  I hope once you get used to it
            that you find the site more usable and that some of the new features make it worthwhile.  And if you\'re wondering
            what\'s new on the site, head over to the <a href="' . url('/whats-new') . '">What\'s New page</a>.',
        ],

        2 => [
            'question' => 'How do I download the music files?',
            'answer' => 'There are a couple of ways to download the hymn music files:
            <ul class="list2">
                <li>
                    For entire hinários, you can download a zip of the files on the hinário listing page by clicking the download
                    button on the audio player:<br><img src="' . url('/images/faq/hinario_download_button.jpg') . '" class="faq-image"><br>* If there
                    is only one hymn listed in the player, you will download the file unzipped.
                </li>
                <li>
                    For individual hymns, you can download the mp3 directly by clicking the download button on the audio player
                    on the page for that hymn:<br><img src="' . url('/images/faq/hymn_download_button.jpg') . '" class="faq-image">
                </li>
            </ul>
            ',
        ],

        3 => [
            'question' => 'When I download the zip files they are empty',
            'answer' => 'Some browsers have a hard time with zip files.  If you are having trouble downloading the zips, try using a different browser.
                In particular, the Safari browser seems to have a lot of trouble downloading zips.  Chrome seems to consistently work well.',
        ],

        4 => [
            'question' => 'Where is the sheet music for a certain hinario?',
            'answer' => 'I promise you, if I have any media or resources for a hymn or hinário of the Daime, it is already on the site.
            If you are looking for something and it\'s not on the site, it\'s because I don\'t have it.  If you find it and it\'s not on the site,
            please send it to me!  This site is for everyone and I need your help to make it as complete as possible.'
        ],

        5 => [
            'question' => 'My login doesn\'t work anymore!',
            'answer' => 'As part of the site overhaul I have lost all old accounts.  So you\'ll have to create a new one.  The good news
            is that now you can create an account on your own.  No more emailing me and asking.  You can just sign up!<br>
            <img src="' . url('/images/faq/sign_up_' . \App\Services\GlobalFunctions::getCurrentLanguage() . '.jpg') . '" class="faq-image">'
        ],
    ]

];
