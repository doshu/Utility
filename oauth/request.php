<?php

	function lookupConsumer($provider) {
		//questa non viene passata quindi devo ricaricarla per decodificare i dati
		$provider->consumer_secret = 'bbbbbbbbbb'; 
        return OAUTH_OK;
    }
    
    function tokenHandler($provider) {
    	//qui arrivano sia i request e gli access token. anche in questo caso devo rifornire la secret key
    	//$provider->token_secret = '20611eb77804e4ee8c1f997f'; 
        return OAUTH_OK;
    }
    
    function timestampNonceChecker($provider) {
        return OAUTH_OK;
    }
    
    
    try {
    	//il request handler imposta se stesso come request token path
    	//
		$o = new OAuthProvider();
		$o->setRequestTokenPath('/utility/oauth/request.php');
	 	$o->consumerHandler('lookupConsumer');
	 	$o->timestampNonceHandler('timestampNonceChecker');
		$o->tokenHandler('tokenHandler');
		
		$o->checkOAuthRequest();
		
		
		//$request_token = bin2hex($o->generateToken(4));
		//$request_token_secret = bin2hex($o->generateToken(12));
		//genero sempre le stesse perchè non salvo nel database
		$request_token = '3f1f1708';
		$request_token_secret = '20611eb77804e4ee8c1f997f';
	
		echo 'oauth_token='.$request_token."&".'oauth_token_secret='.$request_token_secret;
		
	}
	catch(OAuthException $e) {
		file_put_contents('/var/www/utility/oauth/oauth', OAuthProvider::reportProblem($e));
		echo OAuthProvider::reportProblem($e);
	}

?>
