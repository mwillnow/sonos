<?

// br_ips: br_sonos_test
// Test / Example script for PHPSonos

// Include br_ips Libs - PHPSonos still works without this lib!
require ("functions.inc.php"); // use PHPSonos.inc.php here
// Get Script Parent
$ParentID=(int)br_objParent ($IPS_SELF);
// Talk to Coord
$sonos = new PHPSonos("192.168.0.115"); //Sonos ZP IPAdresse


/******************************* LEDSTATE EXAMPLE *******************************************
echo "\n LED: " . $sonos->GetLEDState() . "\n";
$sonos->SetLEDState(true);
 echo "\n LED: " . $sonos->GetLEDState() . "\n";
IPS_Sleep(600);
$sonos->SetLEDState(false);
echo "\n LED: " . $sonos->GetLEDState() . "\n";
IPS_Sleep(600);
$sonos->SetLEDState("On");
echo "\n LED: " . $sonos->GetLEDState() . "\n";
// ******************************* /LEDSTATE EXAMPLE *********************************************/


/* ****************************** ZONEATTR AND INFO EXAMPLE ***********************************
$ZoneAttributes = $sonos->GetZoneAttributes();
print_r( $ZoneAttributes);
$ZoneInfo = $sonos->GetZoneInfo();
print_r( $ZoneInfo);
// ******************************* /ZONEATTR AND INFO EXAMPLE ************************************/


/* ****************************** AddMember and RemoveMember EXAMPLE****************************

$AddMember = $sonos->AddMember("RINCON_000E5825411201400");
echo "\nDEBUG AddMember:\n";
print_r( $AddMember);

// Talk to slave
$sonos = new PHPSonos("192.168.0.111"); //Slave Sonos ZP IPAddress
echo "\n";
$ret = $sonos->SetAVTransportURI("x-rincon:" . "RINCON_000E5832FB5C01400");
echo "\nDEBUG SetAVTransportURI to "."x-rincon:" . "RINCON_000E5832FB5C01400" ."\n";
// Playing starts

IPS_Sleep(1000);

// Talk to Coord
$sonos = new PHPSonos("192.168.0.115"); //Sonos ZP IPAdresse
$RemoveMember = $sonos->RemoveMember("RINCON_000E5825411201400");
echo "\nDEBUG RemoveMember:\n";
print_r( $RemoveMember);

// Talk to slave
$sonos = new PHPSonos("192.168.0.111"); //Slave Sonos ZP IPAddress
// needed for stop of playback on Slave
$sonos->SetAVTransportURI("");
echo "\nDEBUG SetAVTransportURI to NONE \n";
//Playing stops
// ****************************** /AddMember and RemoveMember EXAMPLE****************************/


$sonos = new PHPSonos("192.168.0.115"); //Sonos ZP IPAdresse

// ****************************** Volume Ramp EXAMPLE****************************/

// echo "RampTime: ". $sonos->RampToVolume("SLEEP_TIMER_RAMP_TYPE",40) . "\n";

// ****************************** /Volume Ramp EXAMPLE****************************/

/****************************** Crossfade EXAMPLE****************************

 echo "GetCrossfadeMode: ". $sonos->GetCrossfadeMode() . "\n";
IPS_Sleep(1000);
echo "SetCrossfadeMode true: ". $sonos->SetCrossfadeMode(true) . "\n";
echo "GetCrossfadeMode: ". $sonos->GetCrossfadeMode() . "\n";
IPS_Sleep(1000);
echo "SetCrossfadeMode false: ". $sonos->SetCrossfadeMode(false) . "\n";
echo "GetCrossfadeMode: ". $sonos->GetCrossfadeMode() . "\n";
// ****************************** /Crossfade EXAMPLE****************************/

/****************************** SaveQueue EXAMPLE****************************

 echo "SaveQueue as TEST (SONOS Playlist): ". $sonos->SaveQueue("Test") . "\n";

// ****************************** /SaveQueue EXAMPLE****************************/
$sonoslists=$sonos->GetSONOSPlaylists();
print_r($sonoslists);
foreach($sonoslists as $sonoslist)
{
	if ($sonoslist['title']=='Test') $id=$sonoslist['id'];
}
echo $id . "\n";
	$sonos->SaveQueue("Test",$id);

echo "\n====================\n";
$arrpl=$sonos->GetImportedPlaylists();
print_r($arrpl);

?>