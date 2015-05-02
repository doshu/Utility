<?php

	$ch = curl_init();
	
	$data = array(
		'USER' => urlencode('thomas_1351507132_biz_api1.gmail.com'),
		'PWD' => urlencode('1351507157'),
		'SIGNATURE' => urlencode('ADS2PiQg5hNbpO-bef9uiuheIT1HAvwQXxILrpWits.a-Axg2Dv9aycW'),
		'METHOD' => urlencode('DoDirectPayment'),
		'IPADDRESS' => urlencode('127.0.0.1'),
		'VERSION' => urlencode('86'),
		'PAYMENTACTION' => urlencode('Authorization'),
		'AMT' => urlencode('100'),
		'ACCT' => urlencode('4052881249535586'),
		'CREDITCARDTYPE' => urlencode('VISA'),
		'CCV2' => urlencode('586'),
		'EXPDATE' => urlencode('102017'),
		'CURRENCYCODE' => urlencode('EUR'),
		'FIRSTNAME' => urlencode('James'),
		'LASTNAME' => urlencode('Smith'),
		'STREET' => urlencode('FirstStreet'),
		'CITY' => urlencode('SanJose'),
		'STATE' => urlencode('IT'),
		'ZIP' => urlencode('13900'),
		'COUNTRYCODE' => urlencode('IT')
	);
	
	$post = "";
	foreach($data as $k => $v)
		$post[] = $k.'='.$v;
	$post = implode('&', $post);
	

	curl_setopt($ch, CURLOPT_URL, 'https://api-3t.sandbox.paypal.com/nvp');
	curl_setopt($ch, CURLOPT_POST, 1);
	//curl_setopt($ch,CURLOPT_HTTPGET ,true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	print_r(explode('&', urldecode(curl_exec($ch))));
?>
