<?php

	function getext($filename) {   
		$pos = strrpos($filename,'.');   
		$str = substr($filename, $pos);   
		return $str;   
	}   
	 
	$image = '/home/thomas/Scrivania/tata.jpg';  
	$ext = getext($image);   
	if($ext == ".jpg"){   
		$img = ImageCreateFromJpeg($image);   
	}   
	else{   
		echo'Wrong File Type';   
	}   
	$width = imagesx($img);   
	$height = imagesy($img);   
	 
	for($h=0;$h<$height;$h++){   
		for($w=0;$w<=$width;$w++){   
		    $rgb = ImageColorAt($img, $w, $h);   
		    $r = ($rgb >> 16) & 0xFF;   
		    $g = ($rgb >> 8) & 0xFF;   
		    $b = $rgb & 0xFF;   
		    if($w == $width){   
		        echo '<br>';   
		    }else{   
	        	echo '<span style="color:rgb('.$r.','.$g.','.$b.');">#</span>';  
		    }   
		}   
	}
?>
