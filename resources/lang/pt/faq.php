<?php

return [

    'intro' => 'Aqui estão algumas informações que podem ser úteis ao navegar no site:',

    'questions' => [
        1 => [
            'question' => 'O que aconteceu com o site!?',
            'answer' => 'Após 10 anos sem atualizações, decidi fazer o all in e fazer uma revisão completa. Eu sei que pode ser
                desconfortável fazer as coisas mudarem drasticamente. Eu sinto Muito. Espero que, depois que você se acostume,
                ache o site mais utilizável e que alguns dos novos recursos o façam valer a pena. E se você está se perguntando
                o que há de novo no site, vá para a <a href="'. url('/whats-new').'">A nova página</a> .',
        ],

        2 => [
            'question' => 'Como faço para baixar os arquivos de música?',
            'answer' => '
                Existem algumas maneiras de baixar os arquivos de música do hino:
                <ul class = "list2">
                    <li>
                        Para hinários inteiros, você pode fazer o download de um zip dos arquivos na página de listagem do hinário, clicando no link
                        botão no reprodutor de áudio: <br> <img src = "'. url ('/images/faq/hinario_download_button.jpg ').'" class = "faq-image"> <br> * Se houver
                        Se houver apenas um hino listado no player, você fará o download do arquivo descompactado.
                    </li>
                    <li>
                        Para hinos individuais, você pode baixar o mp3 diretamente clicando no botão de download no reprodutor de áudio
                        na página desse hino: <br> <img src = "'. url ('/images/faq/hymn_download_button.jpg ').'" class = "faq-image">
                    </li>
                </ul>
            ',
        ],

        3 => [
            'question' => 'Quando faço o download dos arquivos zip, eles estão vazios',
            'answer' => '
                Alguns navegadores têm dificuldade com arquivos zip. Se estiver com problemas para baixar os zips, tente usar um navegador diferente.
                Em particular, o navegador Safari parece ter muitos problemas para baixar zips. O Chrome parece funcionar consistentemente bem.
            ',
        ],

        4 => [
            'question' => 'Onde estão as partituras de um certo hinario?',
            'answer' => '
                Eu prometo a você, se eu tiver alguma mídia ou recursos para um hino ou hinário do Daime, ele já está no site.
                Se você está procurando algo e não está no site, é porque eu não o tenho. Se você o encontrar e ele não estiver no site,
                por favor envie para mim! Este site é para todos e preciso da sua ajuda para torná-lo o mais completo possível.
            '
        ],

        5 => [
            'question' => 'Meu login não funciona mais!',
            'answer' => '
                Como parte da revisão do site, perdi todas as contas antigas. Então você terá que criar um novo. As boas notícias
                é que agora você pode criar uma conta por conta própria. Chega de me enviar e-mails e perguntar. Você pode apenas se inscrever!<br>
                <img src="' . url('/images/faq/sign_up_' . \App\Services\GlobalFunctions::getCurrentLanguage() . '.jpg') . '" class="faq-image">
            '
        ],
    ]

];
