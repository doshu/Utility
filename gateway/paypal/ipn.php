<?php

	$fp = fopen('ipn', 'w');
	fwrite($fp, json_encode($_POST));

?>
