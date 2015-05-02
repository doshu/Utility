<?php

	header('Content-Type: text/event-stream');
	header('Cache-Control: no-cache');
	
	$i = 0;
	while(1) {
		echo 'data: '.$i.PHP_EOL.PHP_EOL;
		ob_flush();
		flush();
		$i++;
		sleep(1);
	}
	
	
?>
