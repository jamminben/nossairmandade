<?php

return [
    'title' => 'Formulario de Mensaje',
    'formElements' => [
            'fullName' => 'Nombre completo',
            'email' => 'Email',
            'subject' => 'Asunto del Mensaje',
            'text' => 'Mensaje de Texto',
            'submit' => 'Enviar Mensaje',
    ],

    'disclaimer' => [
            'header' => 'Tenga en Cuenta',
            'text' => 'No podemos ponerlo en contacto con ninguna iglesia del Santo Daime. Este sitio web es una organización independiente y no está conectado
             con cualquier iglesia en particular Para conectarse con otras iglesias, visite nuestra <a href="' . url('friends') .'">página de enlaces</a>.',
    ],

    'message_received' => 'Mensaje recibido. ¡Gracias!',
];
