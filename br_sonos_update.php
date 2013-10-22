<?
require ("functions.inc.php");

// echo $IPS_SENDER;
$ParentID=br_objParent($IPS_VARIABLE);

// Get Zone Information
$arrzoneplayers = br_sonos_GetSONOS_Zones();
// Read in Group Topo
$arrzonegroups = br_sonos_GetSONOS_Groups();


// echo("DEBUG: PId: " . $ParentID . "\n");
if (br_objGetVar( $ParentID ,"SONOS_IP")!=true){
// echo ("DEBUG:" . $ParentID); // DEBUG
$ParentID=(int)br_objParent ($IPS_SENDER);

// echo "DEBUG:" . $ParentID; // DEBUG
}

// TODO_BR && TODO_BUG damit das aktualisieren der Cover Info Bilder sofort klappt, muss die Datei als media registriert sein!!
// Dies wird aktuell nicht vom Setup gemacht !!!!


//---------

$id_Volume = br_objGetVarID( $ParentID ,"Volume");
$id_Mute = br_objGetVarID( $ParentID ,"Mute");
$id_Shuffle = br_objGetVarID( $ParentID ,"Shuffle");
$id_Repeat = br_objGetVarID( $ParentID ,"Repeat");
$id_Control = br_objGetVarID( $ParentID ,"Control");
$id_Status = br_objGetVarID( $ParentID ,"Status");
$id_Position = br_objGetVarID( $ParentID ,"Position");
$id_Duration = br_objGetVarID( $ParentID ,"Duration");
$id_Artist = br_objGetVarID( $ParentID ,"Artist");
$id_Title = br_objGetVarID( $ParentID ,"Title");
$id_Album = br_objGetVarID( $ParentID ,"Album");
$id_AlbumArtist = br_objGetVarID( $ParentID ,"AlbumArtist");
$id_AlbumTrackNum = br_objGetVarID( $ParentID ,"AlbumTrackNum");
$id_CoverURI = br_objGetVarID( $ParentID ,"CoverURI");
$id_Info = br_objGetVarID($ParentID ,"Info");

// Actual Sonos device
$SONOS_IP=br_objGetVar($ParentID,"SONOS_IP");
$sonos = new PHPSonos($SONOS_IP); //Sonos ZP IPAdresse

// Get Zone Informations
$ZoneAttributes = $sonos->GetZoneAttributes();

// TODOBR Candidate for Zone-Routines /* this is only a notice for myself to work on the following routines when integrating the routines as class */
// TODOBR ZoneMaster Routines ****************************************************
$posInfo = $sonos->GetPositionInfo();                     // gibt ein Array mit den Informationen zum aktuellen Titel zurück (Keys: position, duration, artist, title, album, albumArtist, albumTrackNumber)
if (strstr($posInfo["trackURI"],"x-rincon:")){ // Detection Zone Master or not

	// TrackUri to ZoneplayerIP
	preg_match("/^x-rincon:(?P<Rincon>\w+)/i", $posInfo["trackURI"], $match); //Got real RIncon
	// print_r($match);
   //echo $arrzoneplayers[$match['Rincon']]['IPAddress']."!!!!!!!!!!!!"; // DEBUG
	$curCoord=$match['Rincon'];

	

	} else $curCoord=$arrzoneplayers[$SONOS_IP]['Rincon'];
	
		if (function_exists('IPSLogger_Dbg'))
		{ IPSLogger_Dbg(__file__ , "== Line ".__line__." == " .
		"curCoord=" . $curCoord
		); }
// ********************** / ZoneMaster *******************************************/

// Sender??
if($IPS_SENDER=="Variable"){

	switch($IPS_VARIABLE){
	
		case $id_Volume:
	    	echo "Volume set to: " . $IPS_VALUE . "\n\n";
	   	$sonos->SetVolume($IPS_VALUE); //0-100 in %
			break;
		case $id_Mute:
	   	 echo "Volume set to: " . $IPS_VALUE . "\n\n";
	   	$sonos->SetMute($IPS_VALUE); // true / false
			break;
			
		// Control via Coord
		case $id_Shuffle:
			$sonos = new PHPSonos($arrzoneplayers[$curCoord]['IPAddress']);
			$shuffleRepeat = $sonos->GetTransportSettings();
			
	    	echo "Shuffle set to: " . $IPS_VALUE . "\n\n";
			if ($IPS_VALUE==1) {
				
			         if($shuffleRepeat['repeat']){
			            $sonos->SetPlayMode("SHUFFLE"); // true / false

						} else {
							$sonos->SetPlayMode("SHUFFLE_NOREPEAT"); // true / false
						 br_objSetVar( $ParentID ,"Repeat",0);
						}
	
							
			} else {
         			 if($shuffleRepeat['repeat']){
			         	$sonos->SetPlayMode("REPEAT_ALL"); // true / false


						} else {
	         			$sonos->SetPlayMode("NORMAL"); // true / false

						}

			}
			break;
		case $id_Repeat:
 
		$sonos = new PHPSonos($arrzoneplayers[$curCoord]['IPAddress']);
			$shuffleRepeat = $sonos->GetTransportSettings();

	    	echo "Repeat set to: " . $IPS_VALUE . "\n\n";
			if ($IPS_VALUE==1) {

			         if($shuffleRepeat['shuffle']){
									$sonos->SetPlayMode("SHUFFLE");
						} else {
							$sonos->SetPlayMode("REPEAT_ALL"); 
							br_objSetVar( $ParentID ,"Repeat",1);
						}
			} else {
         			if($shuffleRepeat['shuffle']){
			         	$sonos->SetPlayMode("SHUFFLE_NOREPEAT");
						} else {
	         			$sonos->SetPlayMode("NORMAL");
						}

			}
			break;
		case $id_Control:
		// Play Control via Coord
	   $sonos = new PHPSonos($arrzoneplayers[$curCoord]['IPAddress']);

	   
				switch($IPS_VALUE){
					case -99:
				      // Nothing
					break;
					case 0: // zurück
						 $sonos->Previous();
			
					break;
					case 1: // play
               	 if ($sonos->GetTransportInfo()!=1)$sonos->Play();
			//	echo ("!!!!!!!!!!!" . $sonos->GetTransportInfo());
					break;
					case 2: // pause
				   	  if ($sonos->GetTransportInfo()!=2)$sonos->Pause();
				
					break;
					case 3: // stop
					    if ($sonos->GetTransportInfo()!=3)$sonos->Stop();
			
					break;
					case 4: // next
						$sonos->Next();
				
				
					break;

				}
				// Commented out call to br_sonos to only call necessary updates 110923 br
				//	br_sonos_read_all();

				// Read Current Player
				//	br_sonos_read($arrzoneplayers[$SONOS_IP]['IPSId']);
				
				// Read coord
				//	DEBUG print_r($arrzoneplayers);
					br_sonos_read($arrzoneplayers[ $arrzoneplayers[$curCoord]['IPAddress'] ]['IPSId']);

   			// Ask Members
	    		if (isset($arrzonegroups[$arrzoneplayers[$curCoord]['Rincon']])){
						foreach ($arrzonegroups[$arrzoneplayers[$curCoord]['Rincon']] as $curzonegroup) {
								if (is_string($curzonegroup)) {
									// nothing for now

								}else{
								// Jscript link to user page
									  foreach ( $curzonegroup as $curmember) {
											if($curmember['Rincon']!=$curCoord) {
											//DEBUG	print_r($curmember);
											br_sonos_read($curmember['IPSId']);

											}
									  }
								}
					}
				}


			break;



	}
}


?>
