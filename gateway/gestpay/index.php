<?php
	include "GestPayCrypt.inc.php";
	
	$crypt = new GestPayCryptHS();
	$crypt->DomainName = 'testecomm.sella.it';
	
	$crypt->SetShopLogin("GESPAY55770"); // Es. 9000001
	$crypt->SetShopTransactionID("prova"); // Identificativo transazione. Es. "34az85ord19"
	$crypt->SetAmount("10"); // Importo. Es.: 1256.50
	$crypt->SetCurrency("242"); // Codice valuta. 242 = euro
	
	if ($crypt->Encrypt()) {
		$url = "https://testecomm.sella.it/gestpay/pagam.asp"."?a=".$crypt->GetShopLogin()."&b=".$crypt->GetEncryptedString();
		header("Location: ".$url);
	}
	else
		die("Errore: ".$crypt->GetErrorCode().": ".$crypt->GetErrorDescription()."\n");




?>
