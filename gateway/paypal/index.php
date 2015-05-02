<form method="post" name="paypal_form" action="https://www.sandbox.paypal.com/cgi-bin/webscr">
<input type="hidden" name="business" value="thomas_1351507132_biz@gmail.com" />
<input type="hidden" name="cmd" value="_xclick" />
     
<!-- informazioni sulla transazione -->
<input type="hidden" name="return" value="<?php echo "http://".$_SERVER['HTTP_HOST']; ?>/gateway/paypal/conferma_pagamento.php" />
<input type="hidden" name="cancel_return" value="<?php echo "http://".$_SERVER['HTTP_HOST']; ?>/gateway/paypal/cancel.php" />
<input type="hidden" name="notify_url" value="<?php echo "http://".$_SERVER['HTTP_HOST']; ?>gateway/paypal/ipn.php" />
<input type="hidden" name="rm" value="2" />
<input type="hidden" name="currency_code" value="EUR" />
<input type="hidden" name="lc" value="IT" />
<input type="hidden" name="cbt" value="Continua" />
     
<!-- informazioni sul pagamento -->
<input type="hidden" name="shipping" value="0" />
<input type="hidden" name="cs" value="1" />
     
<!-- informazioni sul prodotto -->
<input type="hidden" name="item_name" value="Prova oggetto" />
<input type="hidden" name="amount" value="100.00" />
     
<!-- informazioni sulla vendita -->
<input type="hidden" name="custom" value="ABR24" />
     
<!-- informazioni sull'acquirente -->
Nome<input type="text" name="first_name" /><br/>
Cognome<input type="text" name="last_name" /><br/>
Indirizzo<input type="text" name="address1" /><br/>
Città<input type="text" name="city" /><br/>
Stato<input type="text" name="state" /><br/>
Zip<input type="text" name="zip" /><br/>
Email<input type="text" name="email" /><br/>
 
<!-- pulsante pagamento -->
<input type="image" src="http://www.paypal.com/it_IT/i/btn/x-click-but01.gif" border="0" name="submit" alt="Paga subito con PayPal" />
</form>
