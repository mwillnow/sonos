<?
/*   My Code, if not overwise statet is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    br_IPSLibaries is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this Library.  If not, see <http://www.gnu.org/licenses/>.

 	 Please contact me at br@con8.de and use "br_IPS" anywhere in your email-subject.

		Changes:
		200110426 br fixed bug for unlinking zones
		no date br under dev no change log

Note: 110914 br changed routines to display correct radio information

*/
define("BR_IPS_SONOS_MAJOR", "1");
define("BR_IPS_SONOS_MINOR", "1");
define("BR_IPS_SONOS_TAG", "fiddledItOut");

require ("PHPSonos.inc.php");

/***************** br_sonos_GetSONOS_Zones *********************************************************
* Gets SONOS_Zones Variable
* Return: array
****************************************************************************************************/
function br_sonos_GetSONOS_Zones()
{
$arronlysearched=array();
$arrallt=array();
$arrzoneplayers=array();

$arrall = IPS_GetVariableList();
foreach ($arrall as &$cur){
	if (strstr(IPS_GetName($cur),"SONOS_Zones")){
	$ParentID = br_objParent($cur);	}
}

$arrzoneplayers = unserialize(br_objGetVar($ParentID, "SONOS_Zones"));
return ($arrzoneplayers);
}

/***************** br_sonos_SetSONOS_Zones *********************************************************
* Sets SONOS_Zones Variable
* Input: Array for SONOS_Zones (normally written only by br_sonos_setup)
* Return: NONE
****************************************************************************************************/
function br_sonos_SetSONOS_Zones($arrzoneplayers)
{
$arronlysearched=array();
$arrallt=array();


$arrall = IPS_GetVariableList();
foreach ($arrall as &$cur){
	if (strstr(IPS_GetName($cur),"SONOS_Zones")){
	$ParentID = br_objParent($cur);	}
}

br_objSetVar($ParentID, "SONOS_Zones" , serialize($arrzoneplayers));

return;
}
/***************** br_sonos_GetSONOS_Groups *********************************************************
* Gets SONOS_Groups Variable
* Return: array
****************************************************************************************************/
function br_sonos_GetSONOS_Groups()
{
$arronlysearched=array();
$arrallt=array();
$arrgroups=array();

$arrall = IPS_GetVariableList();
foreach ($arrall as &$cur){
	if (strstr(IPS_GetName($cur),"SONOS_Groups")){
	$ParentID = br_objParent($cur);	}
}

$arrgroups = unserialize(br_objGetVar($ParentID, "SONOS_Groups"));
return ($arrgroups);
}

/***************** br_sonos_SetSONOS_Groups *********************************************************
* Sets SONOS_Groups Variable
* Input: Array for SONOS_Groups
* Return: NONE
****************************************************************************************************/
function br_sonos_SetSONOS_Groups($arrgroups)
{
$arronlysearched=array();
$arrallt=array();


$arrall = IPS_GetVariableList();
foreach ($arrall as &$cur){
	if (strstr(IPS_GetName($cur),"SONOS_Groups")){
	$ParentID = br_objParent($cur);	}
}

br_objSetVar($ParentID, "SONOS_Groups" , serialize($arrgroups));

return;
}

/***************** br_sonos_read_all *********************************************************
* Reads Infos from all zone players and fills IPs category vars
* Input: NONE
* Return: NONE
**********************************************************************************************/
function br_sonos_read_all(){

$arrzoneplayers= br_sonos_GetSONOS_Zones();
	if (function_exists('IPSLogger_Trc'))
		{ IPSLogger_Trc(__file__ , "== Line ".__line__." == " .
		"arrzoneplayers=" . print_r($arrzoneplayers, true)
		); }
	for($i=1; isset($arrzoneplayers[$i]); $i++) {
		   br_sonos_read(	$arrzoneplayers[$i]['IPSId']);

	}

}

/***************** br_sonos_read_all *********************************************************
* Reads Infos from a specific zone player and fills IPs category vars
* Input: IPSId of a Zoneplayer
* Return: NONE
**********************************************************************************************/
function br_sonos_read($curzoneplayerid){  // Input is the IPSId

// Get Zone Information TODOBR
$arrzoneplayers = br_sonos_GetSONOS_Zones();

$ParentID=(int)br_objParent ($curzoneplayerid);
if (br_objGetVarID( $ParentID ,"Repeat")!=true)	echo("\nbr_sonos_read: NOTICE Execution of zonesetup in this category is needed!\n");
	if (function_exists('IPSLogger_Dbg'))
		{ IPSLogger_Dbg(__file__ , "== Line ".__line__." == " .
		"ParentID=" . $ParentID
		); }
// Read in Group Topo
$arrzonegroups = br_sonos_GetSONOS_Groups();
	if (function_exists('IPSLogger_Trc'))
		{ IPSLogger_Trc(__file__ , "== Line ".__line__." == " .
		print_r($arrzonegroups, true)
		); }

// ID's
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

//-------------------------------------------------------------



$sonos = new PHPSonos(br_objGetVar($ParentID,"SONOS_IP")); //Sonos ZP IPAdresse
	if (function_exists('IPSLogger_Dbg'))
		{ IPSLogger_Dbg(__file__ , "== Line ".__line__." == " .
		 "CurrentZP=" . br_objGetVar($ParentID,"SONOS_IP")
		); }

// Get Zone Informations
$ZoneAttributes = $sonos->GetZoneAttributes();

// TODOBR Candidate for Zone-Routines /* this is only a notice for myself to work on the following routines when integrating the routines as class */
// TODOBR ZoneMaster Routines ****************************************************
$posInfo = $sonos->GetPositionInfo();                     // gibt ein Array mit den Informationen zum aktuellen Titel zurück (Keys: position, duration, artist, title, album, albumArtist, albumTrackNumber)
if (strstr($posInfo["trackURI"],"x-rincon:")){ // Detection Zone Master or not
	if (function_exists('IPSLogger_Dbg'))
		{ IPSLogger_Dbg(__file__ , "== Line ".__line__." == " .
		"We are slave of coord: " . $posInfo["trackURI"]
		); }


	// TrackUri to ZoneplayerIP
	preg_match("/^x-rincon:(?P<ID>\w+)/i", $posInfo["trackURI"], $match); //Got real RIncon





// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//  We are slave and save to coord rincon

   $curCoord=$match[1];
	$arrzonegroups[$curCoord]['Coordinator']=(string) $curCoord;

	$arrzonegroups[$curCoord]['Member'][$arrzoneplayers[$curzoneplayerid]['Rincon']]['ID'] = $arrzoneplayers[$curzoneplayerid]['ID'];
  	$arrzonegroups[$curCoord]['Member'][$arrzoneplayers[$curzoneplayerid]['Rincon']]['Rincon'] = $arrzoneplayers[$curzoneplayerid]['Rincon'];
 	$arrzonegroups[$curCoord]['Member'][$arrzoneplayers[$curzoneplayerid]['Rincon']]['CurrentZoneName'] = $arrzoneplayers[$curzoneplayerid]['CurrentZoneName'];
 	$arrzonegroups[$curCoord]['Member'][$arrzoneplayers[$curzoneplayerid]['Rincon']]['CurrentIcon'] = $arrzoneplayers[$curzoneplayerid]['CurrentIcon'];
 	$arrzonegroups[$curCoord]['Member'][$arrzoneplayers[$curzoneplayerid]['Rincon']]['IPSId'] = $arrzoneplayers[$curzoneplayerid]['IPSId'];

	// So unset our Master entry
   unset($arrzonegroups[$arrzoneplayers[$curzoneplayerid]['Rincon']]);

	if (function_exists('IPSLogger_Dbg'))
		{ IPSLogger_Dbg(__file__ , "== Line ".__line__." == " .
		"We are slave " . $arrzoneplayers[$curzoneplayerid]['Rincon'] . " and save to coord " .  $curCoord
		); }
	} else {

   $curCoord=$arrzoneplayers[$curzoneplayerid]['Rincon'];
	$arrzonegroups[$curCoord]['Coordinator']=$curCoord;

	$arrzonegroups[$curCoord]['Member'][$curCoord]['ID'] = $arrzoneplayers[$curzoneplayerid]['ID'];
  	$arrzonegroups[$curCoord]['Member'][$curCoord]['Rincon'] = $arrzoneplayers[$curzoneplayerid]['Rincon'];
 	$arrzonegroups[$curCoord]['Member'][$curCoord]['CurrentZoneName'] = $arrzoneplayers[$curzoneplayerid]['CurrentZoneName'];
 	$arrzonegroups[$curCoord]['Member'][$curCoord]['CurrentIcon'] = $arrzoneplayers[$curzoneplayerid]['CurrentIcon'];
 	$arrzonegroups[$curCoord]['Member'][$curCoord]['IPSId'] = $arrzoneplayers[$curzoneplayerid]['IPSId'];
		// We are master so delete our slave entries
		
// br fixed bug for unlinking zones
	foreach ($arrzonegroups as $curzonegroup) {
			$thisCoord=$curzonegroup['Coordinator'];
					foreach ($curzonegroup['Member'] as $curmember) {
						if (is_string($curzonegroup)) {
						//	echo "\n====\n  Coord:" . $curzonegroup;
						} else {
							
				  			if($curmember['Rincon']==$curCoord){
							//	echo "Should unset now!\n\n";
							   unset($arrzonegroups[$thisCoord]['Member'][$arrzoneplayers[$curzoneplayerid]['Rincon']]);
							}
						}
					}
	}

		if (function_exists('IPSLogger_Dbg'))
		{ IPSLogger_Dbg(__file__ , "== Line ".__line__." == " .
		"We are coord " . $curzoneplayerid . "AKA " . $curCoord
		);}
	}
// ********************** / ZoneMaster *******************************************/
// Get from actual player
$volume = $sonos->GetVolume();                             // gibt die Lautstärke als Integer zurück
$mute = $sonos->GetMute();                                 // gibt ein bool zurück: TRUE -> MUTE an, FALSE -> MUTE aus

//Get from Coord
$sonos = new PHPSonos($arrzoneplayers[$curCoord]['IPAddress']);
$shuffleRepeat = $sonos->GetTransportSettings();     // gibt ein Array zurück mit den keys "shuffle" und "repeat", welche jewils bool-Werte enthalten

$control = GetValue($id_Control);
$status = $sonos->GetTransportInfo();                     // gibt den aktuellen Status des Sonos-Players als Integer zurück, 1: PLAYING, 2: PAUSED, 3: STOPPED

$posInfo = $sonos->GetPositionInfo();
$MediaInfo = $sonos->GetMediaInfo();               // gibt den Namen der Radiostation zurück. Der key ist "title"

// Save for actual player
SetValueInteger($id_Volume, $volume);
SetValueBoolean($id_Mute, $mute);
// DEBUG print_r($shuffleRepeat);

// Save for actual from other player
SetValueBoolean($id_Shuffle, $shuffleRepeat["shuffle"]);
SetValueBoolean($id_Repeat, $shuffleRepeat["repeat"]);
SetValueInteger($id_Status, $status);
SetValueString($id_Position, $posInfo["position"]);
SetValueString($id_Duration, $posInfo["duration"]);

// Wenn es keine "duration" gibt läuft ein Radiosender
// in diesem Fall ist der Interpret die Radiostation
if ($posInfo["duration"] != "")
{
    SetValueString($id_Artist, $posInfo["artist"]);
    SetValueString($id_Title, $posInfo["title"]);
}
else
{

   
		if (isset($MediaInfo["title"])&&($MediaInfo["title"]!="")
		){
   		if (function_exists('IPSLogger_Dbg'))
			{ IPSLogger_Dbg(__file__ , "== Line ".__line__." == " .
				"detected radio broadcast"
			); }
			// echo (GetValueString($id_Artist)!="Station: " ." !!! ". $MediaInfo["title"]);
    		if(GetValueString($id_Artist)!="Station: ". $MediaInfo["title"]){
				// only ask tunein if there is a change in radio tune in
			 	SetValueString($id_Artist, "Station: " . $MediaInfo["title"]);
			 	SetValueString($id_Title, "");
				$ar=$sonos->RadiotimeGetNowPlaying();
				if($ar['logo']!="") {
					// Intune Return
					$posInfo['albumArtURI']=$ar['logo'];
				}else{
					// No return
						$posInfo['albumArtURI']="";
				}
			}

			// do not set Buffering Info
			if($posInfo["streamContent"]!="ZPSTR_BUFFERING" &&
				$posInfo["streamContent"]!="ZPSTR_CONNECTING"
				&& $posInfo["streamContent"]!="")
				{
			 SetValueString($id_Title, 	preg_replace('#(.*?)\|(.*)#is','$1',$posInfo["streamContent"])); // Tunein sends additional Information which could be sperated by a |
			} 
		}else{
		// No radio broadcast
      	// SetValueString($id_Artist, "");
    		SetValueString($id_Title, "");
// 20110922 br
		 $posInfo["albumArtURI"]="";
		}
}



SetValueString($id_Album, $posInfo["album"]);
SetValueString($id_AlbumArtist, $posInfo["albumArtist"]);
SetValueInteger($id_AlbumTrackNum, intval($posInfo["albumTrackNumber"]));
// NOTE_BR WORKAROUND
if (isset($MediaInfo["title"])){
	if (($posInfo["albumArtURI"]!="")||($MediaInfo["title"]=="")){
	SetValueString($id_CoverURI, $posInfo["albumArtURI"]);
   } else {
					 // 20110926 br Test
		// Radio broadcast but not intune
		if( GetValueString($id_Artist)!="" && strstr($MediaInfo["CurrentURI"],"x-rincon-mp3radio") ) SetValueString($id_CoverURI, "");
   }
} else {
	if (($posInfo["albumArtURI"]!="")){
		SetValueString($id_CoverURI, $posInfo["albumArtURI"]);
	} else {
					 // 20110922 br Test
			//	if( GetValueString($id_Artist)!="" && GetValueString($id_Title)=="" ) SetValueString($id_CoverURI, "");
   }
}
// Calculate Percent Played Bar
// TAG_TODO_BR: Auslagern in Function ;-)
if(
(!time_to_sec(br_objGetVar($ParentID ,"Position"))) || (!isset($MediaInfo["title"]))
){
$Percent_Played=1;
} else {
	@$Percent_Played= (int) (time_to_sec(br_objGetVar($ParentID ,"Position")) / time_to_sec(br_objGetVar($ParentID ,"Duration")) *100);
}
$PercentBar= "[";
for ($i=1; $i<=(0.25*$Percent_Played-1);$i++) $PercentBar=$PercentBar. "-";
$PercentBar=$PercentBar. "|";
for ($i=(0.25*$Percent_Played-1); $i<=25;$i++) $PercentBar=$PercentBar. "-";
$PercentBar=$PercentBar . "]";

IPS_Sleep (30);

// Create HTML ZoneGroup Status

$ZoneStatus = "<a href=\"Remove Switch Coord " . utf8_encode($arrzoneplayers[$curCoord]['CurrentZoneName'])."\"  style=\"text-decoration:none; color:white;\" onclick=\"new Image().src = '/user/sonoscmd.php?Name=" . utf8_encode($arrzoneplayers[$curCoord]['CurrentZoneName']) . "&sonosip=" . $arrzoneplayers[$curCoord]['IP'] . "&sonosid=" . $arrzoneplayers[$curCoord]['Rincon'] .
							"&cmd=RemoveMember&memberip=" . $arrzoneplayers[$curCoord]['IP'] . "&memberid=".$arrzoneplayers[$curCoord]['Rincon']."'; return false;\"><b>" . utf8_encode($arrzoneplayers[$curCoord]['CurrentZoneName']) .
							"</b><img src='/user/icons/fixed/minus.png' height='10' width='10' border='0'> </a>";

// Add actual Players
if (isset($arrzonegroups[$arrzoneplayers[$curCoord]['Rincon']])){
	foreach ($arrzonegroups[$arrzoneplayers[$curCoord]['Rincon']] as $curzonegroup) {
			if (is_string($curzonegroup)) {
				// nothing for now
				
			}else{
			// Jscript link to user page
				  foreach ( $curzonegroup as $curmember) {
						if($curmember['Rincon']!=$curCoord) {
							$ZoneStatus = $ZoneStatus . "<a href=\"RemoveMember " . utf8_encode($curmember['CurrentZoneName'])."\"  style=\"text-decoration:none; color:white;\" onclick=\"new Image().src = '/user/sonoscmd.php?Name=" . utf8_encode($curmember['CurrentZoneName']) . "&sonosip=" . $arrzoneplayers[$curCoord]['IP'] . "&sonosid=" . $arrzoneplayers[$curCoord]['Rincon'] .
							"&cmd=RemoveMember&memberip=".$arrzoneplayers[$curmember['Rincon']]['IP']."&memberid=".$curmember['Rincon']."'; return false;\">".utf8_encode($curmember['CurrentZoneName']) .
							"<img src='/user/icons/fixed/minus.png' height='10' width='10' border='0'> </a> ";

						}
				  }
			}
}

// Add not linked Players
 $ZoneStatus = $ZoneStatus. "</tr><tr></td><td colspan=\"2\">";
	for($i=1; isset($arrzoneplayers[$i]); $i++) {

						if(($arrzoneplayers[$i]['Rincon']!=$curCoord)&&(!isset($curzonegroup[$arrzoneplayers[$i]['Rincon']]))) {
						// echo $curzonegroup;
							$ZoneStatus = $ZoneStatus . "<a href=\"AddMember ". utf8_encode($arrzoneplayers[$i]['CurrentZoneName'])."\" style=\"text-decoration:none; color:white;\"
							onclick=\"new Image().src = '/user/sonoscmd.php?Name=" . utf8_encode($arrzoneplayers[$i]['CurrentZoneName']) . "&sonosip=" . $arrzoneplayers[$curCoord]['IP']
							
							. "&sonosid=" . $arrzoneplayers[$curCoord]['Rincon']

							. "&cmd=AddMember&memberip=" . $arrzoneplayers[$i]['IP']

							 . "&memberid=" . $arrzoneplayers[$i]['Rincon']."'; return false;\"> "
							 . utf8_encode($arrzoneplayers[$i]['CurrentZoneName'])

							. "<img src='/user/icons/fixed/plus.png' height='10' width='10' border='0'> </a>";

						}


	}
}

	if (function_exists('IPSLogger_Trc'))
		{ IPSLogger_Trc(__file__ , "== Line ".__line__." == " .
		"ZoneStatus=" . $ZoneStatus
		); }

// Set HTMl info

$HTMLInfo = "<table bgcolor=\"273f57\" border=\"0\" width=\"100%\"><tr><td colspan=\"2\">"
. "<img src='/user/Album_cover_"
. utf8_encode($ZoneAttributes['CurrentZoneName']) . ".jpg?"
. filemtime(IPS_GetKernelDir() . "\\webfront\\user\\Album_cover_" . $ZoneAttributes['CurrentZoneName'] . ".jpg")
. "'></img></td><td>"

. "<table><tr></td colspan=\"2\">"
. "[". br_objGetVar($ParentID ,"AlbumTrackNum"). "]  <b>" . br_objGetVar($ParentID ,"Title") . "</b> "
. "</td>"

. "<td>"
. br_objGetVar($ParentID ,"Artist") . " </td><td width=\"50%\"> " . br_objGetVar($ParentID ,"Album")
. "</td></tr><tr><td>"
.  sec_to_time(time_to_sec(br_objGetVar($ParentID ,"Position"))). "/" . sec_to_time(time_to_sec(br_objGetVar($ParentID ,"Duration"))) . " " // Look at br_timeanddate.inc.php
. "</td></tr>"
. "<tr><td colspan=\"2\">"

. $PercentBar
. "<td></tr>"
. "<tr><td colspan=\"2\">"

. $ZoneStatus
. "<td></tr>"
. "</table>"


. "</tr><td><table>"
. "</td></tr><tr><td>"
. "</td> <td>"

. "</td></tr></table> <br>";

// MERKER_BR
/*
if (isset($arrzonegroups[$arrzoneplayers[$curzoneplayerid]['Rincon']])){
	foreach ($arrzonegroups[$arrzoneplayers[$curzoneplayerid]['Rincon']] as $curzonegroup) {
			if (is_string($curzonegroup)) {echo "\n====\n  Coord:" . $curzonegroup;
				echo "\nMembers:\n";
				}else{
				  foreach ($curzonegroup as $curmember) {
						echo $curmember['CurrentZoneName'] . " - ";
				  }
				}
	}
	echo "\n====\n";
}
*/
SetValueString($id_Info, utf8_decode($HTMLInfo));
// Onlyupdate if needed to not trigger update event

if ($control!=$status ) SetValueInteger($id_Control,$status);

// SetSONOS_Groups (write off data to IPS var)
br_sonos_SetSONOS_Groups($arrzonegroups);

//---------------------- Main Ende ----------------------------
/* NOTE_BR: http://www.ip-symcon.de/forum/f53/php-sonos-klasse-ansteuern-einzelner-player-7676/index4.html */
}

/***************** getSonosCover *********************************************************
* Reads cover from sonos
* Input: IPS_ID_of_a_Var_with_a_coverURI, Filename_to_save_thecover_to, Size
* Return: NONE for now
******************************************************************************************/
function getSonosCover($id_CoverURI, $filename, $CoverSize)
{
/*=============================================
getSonosCover - Martin Heinzel - 19.11.2010
Version: 1.0

Beschreibung:
Mit dieser Funktion wird ein Cover mit Hilfe der von Sonos gelieferten URI
geladen und normiert auf jpg mit der in $CoverSize angegebenen Größe.
Das Cover wird dann unter "$filename" abgelegt.


Änderungen
----------

tt.mm.yyyy von Version x.x -> x.x

Berschreibung:

================================================*/

//--------------------------- Main ----------------------------

$URI=GetValue($id_CoverURI);

	if (function_exists('IPSLogger_Trc'))
		{ IPSLogger_Trc(__file__ , "== Line ".__line__." == " .
		"id_CoverURI = " . $id_CoverURI . "; URI = " .$URI
 		); }
		


    $im                 = imagecreatetruecolor($CoverSize, $CoverSize);
// edit br
    $back_color     = ImageColorAllocate($im, 0, 0, 0);
    $text_color             = ImageColorAllocate($im, 70  , 130  , 180  );
    $border_color             = ImageColorAllocate($im, 70  , 130  , 180  );


    $end_xy        = $CoverSize -10;
    	
//Wenn die URI leer ist wird ein leeres Cover erzeugt
if ($URI == "")
{
    ImageString($im, 3, 80, 80, "???", $text_color);
	 imagefill($im , 0,0 , $back_color);
    ImageJPEG($im, $filename);
    return;
}

// Zwischenspeicher für das Cover "png"
$Cover_Stack_png = IPS_GetKernelDir()."\\media\\Cover_Stack_".$id_CoverURI. ".png";

// Zwischenspeicher für das Cover "jpg"
$Cover_Stack_jpg = IPS_GetKernelDir()."\\media\\Cover_Stack_".$id_CoverURI. ".jpg";

// Auslösen der Extension "png" oder "jpg"
$ImageEx = substr ($URI, -3 );

// Hat die URI einen Dateinamen muss die Adresse zerlegt werden
// sonst nicht
if ($ImageEx == "png" or $ImageEx == "jpg")
{
    // Bei der URI des Albumcovers wird die Adresse des Players mitgesendet.
    // das Trennzeichen für die Playeradresse und die Coveradresse ist ":1400"
// edited br 110828 for radiotimecover
 //   $CoverURI_arr = explode(":1400", $URI);
    // Die Adresse des Covers ist im zweiten Arrayelement also "1"
//    $remoteImage = $CoverURI_arr[1];
	 $remoteImage = $URI;
    // zusammenstellen des lokalen Dateinamens
    $localImage = IPS_GetKernelDir()."\\media\\Cover_Stack_".$id_CoverURI. "." . $ImageEx;
}
else
{
   $remoteImage = $URI;
    // zusammenstellen des lokalen Dateinamens
    $localImage = $Cover_Stack_jpg;
}

// Bild Downloaden
$content = @file_get_contents($remoteImage);
if((strpos($http_response_header[0], "200") === false))
{
     return;
}
file_put_contents( $localImage, $content );

// Informationen des geladenen Covers lesen
$picinfos=getimagesize($localImage);

// Einlesen des Covers als Image
if($ImageEx == "png")
{
    $oldpic = ImageCreateFromPNG($localImage);
}
else
{
    $oldpic = ImageCreateFromJPEG($localImage);
}
      $x = $CoverSize;
     
      $y = $x / ($picinfos[0] / $picinfos[1]);
      imagecopyresampled ($im, $oldpic, ($CoverSize/2)-($x/2),($CoverSize/2)-($y/2),0,0,$x,$y,$picinfos[0],$picinfos[1]);


/*

    // Erzeuge ein neues Image von 174 x 174
    $newpic=imagecreatetruecolor($CoverSize, $CoverSize);

    // Resize das Image
    ImageCopyResized($newpic,$oldpic,0,0,0,0,$CoverSize,$CoverSize,$picinfos[0],$picinfos[1]);
*/
    // Und ablegen
    ImageJPEG($im, $filename);




}


?>