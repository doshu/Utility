<?php

	class CoordDistance
	{
		protected static $_earthRadius = 6371000;	
	
		public static function haversineGreatCircleDistance ($lat1, $lon1, $lat2, $lon2)
		{
  			$lat1 = deg2rad($lat1);
  			$lon1 = deg2rad($lon1);
  			$lat2 = deg2rad($lat2);
  			$lon2 = deg2rad($lon2);

  			$latDelta = $lat2 - $lat1;
  			$lonDelta = $lon2 - $lon1;

  			$angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($lonDelta / 2), 2)));
  			return $angle * static::$_earthRadius;
		}
		
		
		public static function vincentyGreatCircleDistance ($lat1, $lon1, $lat2, $lon2)
		{
		  	// convert from degrees to radians
	  		$lat1 = deg2rad($lat1);
  			$lon1 = deg2rad($lon1);
  			$lat2 = deg2rad($lat2);
  			$lon2 = deg2rad($lon2);

		  	$lonDelta = $lon2 - $lon1;
		  	
		  	$a = pow(cos($lat2) * sin($lonDelta), 2) + pow(cos($lat1) * sin($lat2) - sin($lat1) * cos($lat2) * cos($lonDelta), 2);
		  	$b = sin($lat1) * sin($lat2) + cos($lat1) * cos($lat2) * cos($lonDelta);

		  	$angle = atan2(sqrt($a), $b);
		  	return $angle * static::$_earthRadius;
		}
		
		
		function humanReadable($distance, $decimals = 2) {
    		$size = array('M','Km');
    		$factor = min(count($size) - 1, floor((strlen($distance) - 1) / 3));
    		return sprintf("%.{$decimals}f", $distance / pow(1000, $factor)) . $size[$factor];
		}
	}
	
	$method1 = CoordDistance::haversineGreatCircleDistance(45.562683, 8.057072, 45.542113, 8.111189);
	$method2 = CoordDistance::vincentyGreatCircleDistance(45.562683, 8.057072, 45.542113, 8.111189);
	
	echo "Distanza metodo 1: ".CoordDistance::humanReadable($method1);
	echo "\n";
	echo "Distanza metodo 2: ".CoordDistance::humanReadable($method2);
