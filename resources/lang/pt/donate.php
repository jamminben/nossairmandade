<?php

return [
    'donateButton' => '
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_donations" />
<input type="hidden" name="business" value="B8DXJ8SRNG49Q" />
<input type="hidden" name="currency_code" value="USD" />
<input type="image" src="http://64.90.58.190/images/donate_portuguese.png" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Faça doações com o botão do PayPal" />
<img alt="" border="0" src="https://www.paypal.com/pt_BR/i/scr/pixel.gif" width="1" height="1" />
</form>
',

    'body' => '
        <h3>Por que doar?</h3>
        <p>Olá. Meu nome é Ben Tobias e sou o criador do nossairmandade.com. Preciso da tua ajuda.</p>
        <p>
            Eu nunca procurei lucrar com os hinos do Santo Daime. Meu objetivo sempre foi disponibilizá-los para qualquer
            pessoa da comunidade Daime que desejasse estudá-los e aprendê-los. É por isso que nunca cobrarei uma taxa pela
            associação ao site.
        </p>
        <p>
            E administrar um site tem custos. Como nunca cobrarei ninguém por usar o site, pago principalmente pelo próprio
            bolso. Pequenas doações fazem uma grande diferença a cada mês, pois pago pelos servidores, licenças e serviços
            que mantêm o site funcionando. Se você se sente chamado a doar, saiba que seu presente será pago para que o
            site continue funcionando&#42; e não para o meu lucro.
        </p>
        <h3>Doações da igreja</h3>
        <p>
            Se sua igreja quiser fazer uma doação maior em nome de seus membros, entre em contato comigo através da página
            <a href="' . url('contact') . '">Entre em contato</a> para obter mais informações. Esse tipo de presente
            ajuda tremendamente.
        </p>
        <h3>
            Muito Obrigado
        </h3>
        <p>
            Quer você doe ou não, eu realmente aprecio você estar aqui. Este site existe para você e significa para mim o
            mundo que você está usando.
        </p>
        <h4>
            Ben
        </h4>
        <p>
            * Se eu receber mais doações do que os custos de manutenção do site, o excesso será atribuído a uma causa importante
            para o Santo Daime. Eu adoraria ver isso acontecer e, se acontecer, atualizarei esta página com mais informações.
        </p>',
];
