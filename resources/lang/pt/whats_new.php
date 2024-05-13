<?php

return [

    'body' => '
        <p>
            Como você deve ter notado, houve algumas mudanças por aqui ...
        </p>
        <p>
            Aqui está uma lista das principais alterações que fiz no site recentemente. À medida que adiciono novos
            recursos e atualizações, tentarei manter essa lista atualizada.</p>
        <p>
            Se você pensa em algo que gostaria que o site tivesse, não hesite em <a href="{{ url(\'/contact\') }}"> me
            avise</a>.
        </p>
        <ul class = "list1">
            <li>
                <h4>
                    PDFs imprimíveis para todos os hinários
                </h4>
                <p>
                    No topo de cada página do hinário existe um link chamado "Versão para impressão". Clicar neste botão renderizará um PDF do
                    hinário inteiro.
                </p>
            </li>
            <li>
                <h4>
                    Hinários pessoais
                </h4>
                <p>
                    Se você estiver logado, poderá criar seus próprios hinários. Todo hino deve ter um pequeno menu ao lado do nome que permite
                    você adiciona o hino a qualquer um dos seus hinários pessoais. Você pode compartilhar links para seus hinários, imprimir PDFs e ouvi-los apenas
                    como qualquer outro hinário.
                </p>
            </li>
            <li>
                <h4>
                    Reprodutores de áudio incorporados
                </h4>
                <p>
                    Agora existem reprodutores de áudio incorporados em qualquer página de hino ou hinario para a qual eu tenho gravações.
                </p>
            </li>
            <li>
                <h4>
                    Gravações "Curtir"
                </h4>
                <p>
                    Usuários conectados podem gostar de gravações. As gravações com mais curtidas serão exibidas na parte superior.
                </p>
            </li>
            <li>
                <h4>
                    Novo sistema de contas
                </h4>
                <p>
                    Até agora, a criação de uma nova conta tem sido um processo manual para mim. Há algum tempo, perdi a capacidade de criar novas contas, o que deixou todo o sistema no Limbo.
                    Peço desculpas a quem quer uma conta e não conseguiu uma. Agora você pode fazer o seu próprio, sem ter que esperar.
                </p>
            </li>
            <li>
                <h4>
                    Feedback
                </h4>
                <p>
                    Agora, os usuários conectados podem deixar comentários para qualquer página de hino, hinario ou pessoa.
                    Se vir algo que não está certo, informe-me com o pequeno formulário no canto inferior direito da página.
                </p>
            </li>
            <li>
                <h4>
                    Pesquisa
                </h4>
                <p>
                    A função de pesquisa - que costumava estar disponível apenas para usuários logados - agora está disponível
                    para todos.
                </p>
            </li>
            <li>
                <h4>
                    Localização
                </h4>
                <p>
                    Acontece que muitos dos meus visitantes vêm do Brasil. Estou tentando tornar o máximo possível do site acessível
                    em inglês e português. Está configurado para adicionar outros idiomas com muita facilidade. Se você gostaria de contribuir com esse esforço
                    com alguma ajuda nas traduções, <a href="{{ url(\'/contact\') }}"> entre em contato!</a>
                </p>
            </li>
            <li>
                <h4>
                    Novo logotipo
                </h4>
                <p>
                    Eu usei um novo logotipo para o site. Aqui está um olhar mais atento:
                </p>
                <img src = "/images/nossairmandade_logo.png" alt = "Novo logotipo">
            </li>
            <li>
                <h4>
                    Mais a caminho
                </h4>
                <p>
                    Trabalharei no novo site, sempre tentando melhorá-lo. Mantenha os olhos abertos para novos recursos.
                </p>
            </li>
        </ul>',

];
