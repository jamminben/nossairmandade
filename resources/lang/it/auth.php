<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',

    'register' => [
        'form' => [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'password-confirm' => 'Same Password',
            'submit' => 'Sign Up',
        ]
    ],

    'login' => [
        'form' => [
            'email' => 'Email',
            'password' => 'Password',
            'remember' => 'Keep me logged in',
            'submit' => 'Log In',
        ]
    ],

    'email' => [
        'form' => [
            'email' => 'Email',
            'submit' => 'Send Password Reset Email',
        ],
    ],

    'reset' => [
        'form' => [
            'email' => 'Email',
            'password' => 'Password',
            'password-confirm' => 'Same Password',
            'submit' => 'Reset Your Password',
        ],
    ],

];
