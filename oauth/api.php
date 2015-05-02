<?php


	function lookupConsumer($provider) {
		//questa non viene passata quindi devo ricaricarla per decodificare i dati
		$provider->consumer_secret = 'bbbbbbbbbb'; 
        return OAUTH_OK;
    }
    
    function tokenHandler($provider) {
    	//return OAUTH_TOKEN_EXPIRED;
    	//qui arrivano sia i request e gli access token. anche in questo caso devo rifornire la secret key
    	$provider->token_secret = '25489eb77804e4ee8c1f987a'; 
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

		echo 'responso=ok';
		
	}
	catch(OAuthException $e) {
		//se si fa reportProblem OAuth gestisce da solo gli errori altrimenti si fa un echo dell'errore che si vuole dare
		//echo OAuthProvider::reportProblem($e);
		echo $e->getMessage();
	}
	
	//la pagina che gestisce le richieste è simile a questa, ma nel tokenHandler, viene fatta tutta la gestione 
	//per le credenziali del token ricevuto.
	
?>
