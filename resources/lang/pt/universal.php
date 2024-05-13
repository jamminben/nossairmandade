<?php

return [
    'feedback_form' => [
        'header' => 'Feedback',
        'description' => 'Há algo de errado com o conteúdo desta página?',
        'message_placeholder' => 'Digite sua mensagem aqui',
        'submit' => 'Enviar',
        'response' => 'Obrigado!',
        'login' => '<a href="' . url('/login') .'">Faça login</a> para nos deixar um feedback aqui.',
    ],

    'footer' => [
        'more' => 'Mais...',
        'churches' => 'Igrajas do Daime',
        'official' => 'Sites Oficiais',
        'copyright' => '&copy; Direito Autoral 2010 - ' . date('Y') . '. Todos os direitos reservados.',
        'donate_title' => 'Doar',
        'donate_text' => 'Este site será sempre gratuito. Se você deseja apoiar o site, visite o <br><strong><a href="' . url('/donate') .'">Página de Doação</a></strong>'
    ],

    'add_hymn_form' => [
        'header' => 'Adicionar ao hinário pessoal',
        'add_tooltip' => 'Você pode criar seus próprios hinários pessoais, adicionar hinos a eles e compartilhá-los com outras pessoas.',
        'new_name_placeholder' => "Nome do Hinario Novo",
        'create_new_hinario' => "Criar um Hinario Novo",
        'enter_name' => 'Por favor insira um nome',
        'hinario_missing' => 'Desculpa! Algo deu errado.',
        'added' => 'Foi adicionado!',
        'create_header_multiple' => 'ou criar um hinário novo',
        'create_header' => 'Criar um hinário novo',
    ],

    'close' => 'Fechar'
];
