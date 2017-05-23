<?php
header('Content-type: image/png');

// Platform = 3 for PC; NWG BF1 server ID=2014701010051
function getData($pPlatform="3", $pID="2014701010051"){  
	$API_KEY = "XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX";
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, "https://battlefieldtracker.com/bf1/api/quick-server-info?platform=". $pPlatform . "&id=" . $pID);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.73 Safari/537.36"); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_TIMEOUT, 10); 
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('TRN-Api-Key: ' . $API_KEY));
	$response = curl_exec($ch);
	curl_close($ch);
	return json_decode($response, true);
}

function setCanvas($map) {
	if(strcmp($map, "Amiens") == 0)	return imagecreatefromjpeg('media/img_canvas/Amiens.jpg');
	elseif(strcmp($map, "Argonne Forest") == 0)	return imagecreatefromjpeg('media/img_canvas/Argonne Forest.jpg');
	elseif(strcmp($map, "Ballroom Blitz") == 0)	return imagecreatefromjpeg('media/img_canvas/Ballroom Blitz.jpg');
	elseif(strcmp($map, "Empire's Edge") == 0)	return imagecreatefromjpeg('media/img_canvas/Empire\'s Edge.jpg');
	elseif(strcmp($map, "Fao Fortress") == 0)	return imagecreatefromjpeg('media/img_canvas/Fao Fortress.jpg');
	elseif(strcmp($map, "Fort De Vaux") == 0)	return imagecreatefromjpeg('media/img_canvas/Fort De Vaux.jpg');
	elseif(strcmp($map, "Giant's Shadow") == 0)	return imagecreatefromjpeg('media/img_canvas/Giant\'s Shadow.jpg');
	elseif(strcmp($map, "Monte Grappa") == 0)	return imagecreatefromjpeg('media/img_canvas/Monte Grappa.jpg');
	elseif(strcmp($map, "Rupture") == 0)	return imagecreatefromjpeg('media/img_canvas/Rupture.jpg');
	elseif(strcmp($map, "Sinai Desert") == 0)	return imagecreatefromjpeg('media/img_canvas/Sinai Desert.jpg');
	elseif(strcmp($map, "Soissons") == 0)	return imagecreatefromjpeg('media/img_canvas/Soissons.jpg');
	elseif(strcmp($map, "St Quentin Scar") == 0)	return imagecreatefromjpeg('media/img_canvas/St Quentin Scar.jpg');
	elseif(strcmp($map, "Suez") == 0)	return imagecreatefromjpeg('media/img_canvas/Suez.jpg');
	elseif(strcmp($map, "Verdun Heights") == 0)	return imagecreatefromjpeg('media/img_canvas/Verdun Heights.jpg');
	else	return imagecreatefromjpeg('media/img_canvas/_default.jpg');
	
}
function displayImage($d) {
	$serverName = $d["serverInfo"]["name"];
	$map = $d["activityInfo"]["currentMap"];
	$mode = $d["activityInfo"]["currentMode"];
	$players = $d["slots"]["Soldier"]["current"];
	$playersMax = $d["slots"]["Soldier"]["max"];
	$queue = $d["slots"]["Queue"]["current"];
	$spectators = $d["slots"]["Spectator"]["current"];

	$img = setCanvas($map);	// set canvas image (300x154)
	$font = 'media/fonts/Vera.ttf';
	$fontB = 'media/fonts/VeraBd.ttf';
	$color_white = imagecolorallocate($img, 255, 255, 255);
	$color_legend = imagecolorallocate ($img , 217, 96, 19);
	  
	imagettftext($img, 9, 0, 2, 15, $color_white, $fontB, $serverName);
	imagettftext($img, 6, 0, 90, 40, $color_legend, $font, "Map:");	
	imagettftext($img, 12, 0, 135, 40, $color_white, $fontB, $map);
	imagettftext($img, 6, 0, 90, 60, $color_legend, $font, "Mode:");

	imagettftext($img, 6, 0, 135, 60, $color_white, $fontB, $mode);

	imagettftext($img, 6, 0, 90, 80, $color_legend, $font, "Players:");
	imagettftext($img, 12, 0, 135, 80, $color_white, $fontB, $players . " / " . $playersMax);

	imagettftext($img, 6, 0, 270, 60, $color_legend, $font, "Spectators:");
	imagettftext($img, 6, 0, 320, 60, $color_white, $fontB, $spectators);

	imagettftext($img, 6, 0, 270, 80, $color_legend, $font, "Queue:");
	imagettftext($img, 8, 0, 320, 80, $color_white, $fontB, $queue);

	imagepng($img);
	imagedestroy($img);
}

displayImage(getData());

?>
