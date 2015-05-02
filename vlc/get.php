<?php

	require "vlc.php";
	
	$stream = new VlcStream();
	$stream->setInput('rtsp://viewer:viewer@10.0.100.60:554/sub');
	$stream->setOutputFormat('ogg');
	//$stream->setOpt('-vcodec libtheora');
	$stream->setOutput('/dev/stdout');

	$stream->getStream();
?>
