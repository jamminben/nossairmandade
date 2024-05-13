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

    'failed' => 'Essas credenciais não correspondem aos nossos registros.',
    'throttle' => 'Muitas tentativas de login. Por favor, tente novamente em :seconds segundos.',

    'register' => [
        'form' => [
            'name' => 'Nome',
            'email' => 'Email',
            'password' => 'Senha',
            'password-confirm' => 'O Mesmo Senha',
            'submit' => 'Inscrever-se',
        ]
    ],

    'login' => [
        'form' => [
            'email' => 'Email',
            'password' => 'Senha',
            'remember' => 'Mantenha-me conectado',
            'submit' => 'Conecte-se',
        ]
    ],

    'email' => [
        'form' => [
            'email' => 'Email',
            'submit' => 'Enviar Senha Redefinir Email',
        ],
    ],

    'reset' => [
        'form' => [
            'email' => 'Email',
            'password' => 'Senha',
            'password-confirm' => 'O Mesmo Senha',
            'submit' => 'Redefinir a Sua Senha',
        ],
    ],

];
