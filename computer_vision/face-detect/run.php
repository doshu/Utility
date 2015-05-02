<?php
	include "FaceDetector.php";
	
	/*
	$face_detect = new Face_Detector('detection.dat');
	$face_detect->face_detect('image.jpg');
	echo $face_detect->toJSON();
	*/
	
	$detector = new FaceDetector();
	//$detector->scan("image.jpg");
	$detector->cameraWidth = 320;
	$detector->cameraHeight = 240;
	$detector->scanDevice();
	$data = $detector->shoot();
	$detector->scanFromImageData($data);
	//$faces = $detector->getFaces();
	$detector->getImage('result.jpg', false, true);
	//print_r($faces);
?>
