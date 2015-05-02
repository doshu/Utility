<?php


	function lookupConsumer($provider) {
		//questa non viene passata quindi devo ricaricarla per decodificare i dati
		$provider->consumer_secret = 'bbbbbbbbbb'; 
        return OAUTH_OK;
    }
    
    function tokenHandler($provider) {
    	//qui arrivano sia i request e gli access token. anche in questo caso devo rifornire la secret key
    	$provider->token_secret = '20611eb77804e4ee8c1f997f'; 
        return OAUTH_OK;
    }
    
    function timestampNonceChecker($provider) {
        return OAUTH_OK;
    }

	try {
		$o = new OAuthProvider();
	 	$o->consumerHandler('lookupConsumer');
	 	$o->timestampNonceHandler('timestampNonceChecker');
		$o->tokenHandler('tokenHandler');
		
		$o->checkOAuthRequest();

		//$access_token = bin2hex($o->generateToken(4));
		//$access_token_secret = bin2hex($o->generateToken(12));
		//uso queste sempre perchè non salvo nel db
		$access_token = '4f1f1503';
		$access_token_secret = '25489eb77804e4ee8c1f987a';

		echo 'oauth_token='.$access_token."&".'oauth_token_secret='.$access_token_secret;
		
	}
	catch(OAuthException $e) {
		file_put_contents('/var/www/utility/oauth/oauth', OAuthProvider::reportProblem($e));
		echo OAuthProvider::reportProblem($e);
	}
	
	//la pagina che gestisce le richieste è simile a questa, ma nel tokenHandler, viene fatta tutta la gestione 
	//per le credenziali del token ricevuto.
	
?>
