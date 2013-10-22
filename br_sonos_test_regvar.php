<?
// br_ips: br_sonos_test
// Test / Example script for PHPSonos

// Include br_ips Libs- here for IPSLogger
require ("functions.inc.php");

$RegVarID = $IPS_INSTANCE;
$newdata = $IPS_VALUE;


// fetch data in buffer
$data = RegVar_GetBuffer ( $RegVarID );

// add received data
$data .= $newdata;
$notify = $data;
// wrte back data to variable for use in other scripts
// RegVar_SetBuffer($RegVarID, $data);

$notify = substr($notify, stripos($notify, '&lt;'));
$notify = substr($notify, 0, strrpos($notify, '&gt;') + 4);
$notify = str_replace(array("&lt;", "&gt;", "&quot;", "&amp;", "%3a", "%2f", "%25"), array("<", ">", "\"", "&", ":", "/", "%"), $notify);
$notify = str_replace(array("&lt;", "&gt;", "&quot;", "&amp;", "%3a", "%2f", "%25"), array("<", ">", "\"", "&", ":", "/", "%"), $notify);
$search = preg_match('/(.+)<item id="-1" parentID="-1" restricted="true">(.*?)<\/item><\/DIDL-Lite>(.+)"\/><r:EnqueuedTransportURI/is', $notify,$gefundenes_wort);
$ergebnis = '<DIDL-Lite xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:upnp="urn:schemas-upnp-org:metadata-1-0/upnp/" xmlns:r="urn:schemas-rinconnetworks-com:metadata-1-0/" xmlns="urn:schemas-upnp-org:metadata-1-0/DIDL-Lite/">'.$gefundenes_wort[2].'</DIDL-Lite>';


	// DEBUG
	//  		if (function_exists('IPSLogger_Trc'))
	//	{ IPSLogger_Trc(__file__ , "== Line ".__line__." == " .
	//	"CallbackData: " . print_r ($ergebnis, true)
	//	);}
// To stdout for intensive DEBUG
print_r ($ergebnis, false);
/*
$xml = new SimpleXMLElement($notify);
            $title = $xml->xpath("dc:title");
            $cover = $xml->xpath("upnp:albumArtURI");
            $album = $xml->xpath("upnp:album");
            $artist = $xml->xpath("dc:creator");
            $file = $xml->res;
            $nextsong['title'] = (string)$title[0];
            $nextsong['albumArtURI'] = "http://".$_SESSION[$aktuell]['IP'].":1400".(string)$cover[0];
            $nextsong['artist'] = (string)$artist[0];
            $nextsong['album'] = (string)$album[0];
            $nextsong['file'] = (string)$file;
print_r($nextsong, false);
*/
?>