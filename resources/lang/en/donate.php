<?php

return [
    'donateButton' => '
<p>&nbsp;</p>
<h4>
<a target="blank" href="https://www.patreon.com/nossairmandade">Click here to visit my new Patreon page</a>
</h4>
<p>&nbsp;</p>

<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_donations" />
<input type="hidden" name="business" value="B8DXJ8SRNG49Q" />
<input type="hidden" name="currency_code" value="USD" />
<input type="image" src="https://nossairmandade.com/images/donate.png" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
</form>

',

    'body' => '
        <h3>Why donate?</h3>
        <p>Hello.  My name is Ben Tobias and I am the creator of nossairmandade.com.  I need your help.</p>
        <p>
            I have never sought to profit from the hymns of the Santo Daime.  My goal has always been to make them available for anyone
            in the Daime community who wishes to study and learn them.  That\'s why I will never charge a fee for membership to the site.
        </p>
        <p>
            And running a website has costs.  Because I will never charge anyone for using the site, I mostly pay for it out of pocket.
            Small donations make a big difference each month as I pay for the servers, licenses, and services that keep the site going.
            If you feel called to donate, please know that your gift will go to pay for the site to stay up&#42; and not for my profit.
        </p>
        <h3>Church donations</h3>
        <p>
            If your church would like to make a larger donation on behalf of its members, please contact me through the
            <a href="{{ url(\'contact\') }}">Contact</a> page for further information.  This kind of gift helps tremendously.
        </p>
        <h3>
            Thank you
        </h3>
        <p>
            Whether or not you can donate, I really appreciate you being here.  This site exists for you and it means the world to me that you\'re using it.
        </p>
        <h3>
            Ben
        </h3>
        ',
];
