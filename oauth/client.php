<?php
	$o = new OAuth('aaaa', 'bbbbbbbbbb');
	$o->enableDebug();
	
	$rtoken = $o->getRequestToken('http://127.0.0.1/utility/oauth/request.php', 'http://127.0.0.1/utility/oauth/client.php');
	
	//qui andrebbe fatto il redirect alla pagine che garantisce le permission
	//tutto ciò che segue dovrebbe/potrebbe essere nella pagina del redirect
	//imposto il token tornato dal redirect e il secret token
	$o->setToken($rtoken['oauth_token'], $rtoken['oauth_token_secret']);
	
	
   	$atoken = $o->getAccessToken("http://127.0.0.1/utility/oauth/access.php");
   
   	//dopo si fa un set token dei token tornati e si può partire con le richieste.
    
	$o->setToken($atoken['oauth_token'], $atoken['oauth_token_secret']);
	
	try {
		$o->fetch("http://127.0.0.1/utility/oauth/api.php?action=prova");
		$response = $o->getLastResponse();
		print_r($response);
	}
	catch(Exception $e) {
		echo $e->getMessage();
		
	}
    
    
?>
