<?php
require('simple_html_dom.php');

function scrapeServerID() 
{
	// Create DOM from URL or file
	$html = file_get_html('https://battlefieldtracker.com/bf1/servers?platform=pc&name=nwg');
	$serverURL = $html->find('a.name')[0]->href;//$server->href;
	$serverID = str_replace("/bf1/servers/pc/", "", $serverURL);
	if (is_numeric($serverID) && strlen($serverID) == 13)
	{
		return $serverID;
	}
	return false;
}

function getCurrentScriptServerID()
{
	$file = fopen("sig.php","r"); 
	while (!feof($file))
	{
		$line = fgets($file);
		if (strpos($line, 'nwgServerID='))
		{
			//echo "***FOUND***";
			$line = str_replace('$nwgServerID=',"",$line);
			$line = str_replace(';',"",$line);
			//echo $i . $line . "<br />";
			return $line;
		}
	}
}

function updateServerIDinPHP($newServerID)
{	// https://stackoverflow.com/questions/3004041/how-to-replace-a-particular-line-in-a-text-file-using-php;
	if($newServerID)
	{
		$data = file('sig.php'); // reads an array of lines
		function replace_a_line($data) {
		   if (stristr($data, '$nwgServerID=')) { 
				$serverID = scrapeServerID();
			 return "\$nwgServerID=$serverID;\n";
		   }
		   return $data;
		}
		$data = array_map('replace_a_line',$data);
		file_put_contents('sig.php', implode('', $data));	
	}
}

$serverID_scraper = scrapeServerID();
if ($serverID_scraper && getCurrentScriptServerID() != $serverID_scraper)
	updateServerIDinPHP($serverID_scraper);

?>