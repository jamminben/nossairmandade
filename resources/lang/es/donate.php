<?php

return [
    'donateButton' => '
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_donations" />
<input type="hidden" name="business" value="B8DXJ8SRNG49Q" />
<input type="hidden" name="currency_code" value="USD" />
<input type="image" src="http://64.90.58.190/images/donate.png" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
</form>
',
];
