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

    'failed' => 'Estas credenciales no coinciden con nuestros registros.',
    'throttle' => 'Demasiados intentos de inicio de sesión. Por favor intente nuevamente en :seconds segundos.',

    'register' => [
        'form' => [
            'name' => 'Nombre',
            'email' => 'Email',
            'password' => 'Contraseña',
            'password-confirm' => 'Misma contraseña',
            'submit' => 'Regístrate',
        ]
    ],

    'login' => [
        'form' => [
            'email' => 'Email',
            'password' => 'Contraseña',
            'remember' => 'Mantenme conectado',
            'submit' => 'Iniciar sesión',
        ]
    ],

    'email' => [
        'form' => [
            'email' => 'Email',
            'submit' => 'Enviar contraseña Restablecer correo electrónico',
        ],
    ],

    'reset' => [
        'form' => [
            'email' => 'Email',
            'password' => 'Contraseña',
            'password-confirm' => 'Misma contraseña',
            'submit' => 'Restablecer su contraseña',
        ],
    ],

];
