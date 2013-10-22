<?
/* br_ips br_sonos_setup.php
	 My Code, if not overwise statet is free software: you can redistribute it and/or modify
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

    based on http://www.ip-symcon.de/forum/f53/php-sonos-klasse-ansteuern-einzelner-player-7676/index4.html#post105587
*/
define("BR_IPS_SONOS_ZONESETUP_TAG", "fidelity");
require ("functions.inc.php");

// 110209 moved out setup routines; created setup routines as seperate br_sonos.setup.php
// ============================ Setup ==============================
echo "\nbr_sonos_zonesetup (ScriptID: " . $IPS_SELF . "):\n";
$ParentID=(int)br_objParent ($IPS_SELF);

	if (function_exists('IPSLogger_Inf'))
		{ IPSLogger_Inf(__file__ , "== Line ".__line__." == " .
"====== Zonesetup for  " . $ParentID . " is ongoing ...\n"
		); }


echo "- ... checking ... for need of running Sonos setup routines....\n";
 if (br_objGetVarID( $ParentID ,"Repeat")!=true){

	$position=5;

	echo ("====== Zonesetup for Sonos " . $ParentID . " is ongoing ...\n");

		$ScriptName="br_sonos.inc.php";
	if (@IPS_GetScriptIDByName($ScriptName, $ParentID)){
			die("\n!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!\n
				     ERROR: This is NOT the RIGHT IPS category to execute a zonesetup (you executed it in the administrative br_sonos area instead \n
					  of the zones category of the device)!!\n
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!\n");
	}

	if(!br_objGetVar($ParentID,"SONOS_IP")){

		$id = CreateVariableByName($ParentID, "SONOS_IP",  VAR_TYPE_STRING);
		IPS_SetVariableCustomProfile($id, "~String");
	   IPS_SetHidden($id,true);
	   SetValueString($id, "192.168.0.115"); // DEBUG set my devel device as default
		die ("... You did not create and/or fill SONOS_IP. Please fill it an rerun this script!\n\n");

	}
    // BRIPS editted to find current SONOS
    $sonos = new PHPSonos(br_objGetVar($ParentID,"SONOS_IP")); //Sonos ZP IPAdresse


		// Get Zone Informations
		$ZoneAttributes = $sonos->GetZoneAttributes();
		if (!$ZoneAttributes) die("ATTENTION: Connection failure");
		
		echo "ATTENTION: If >>>" . $ZoneAttributes['CurrentZoneName'] . " <<< is not the name of your SONOS device you either didn´t fill or create SONOS_IP,
yet or there is general problem!\n
Please fill or correct SONOS_IP, delete all Variables and Scripts except SONOS_IP und the SETUP, then RE-RUN this script!!!\n\n
If your correct zonename showed up above you everything is ok!!\n";
	

	
	
	# Variablenprofile anlegen
// fixed 20110308

// fixed 20110817
	$VarProfileName="Media_Transport";
	if (IPS_VariableProfileExists($VarProfileName)==False) {
	IPS_CreateVariableProfile($VarProfileName,1);
			IPS_SetVariableProfileAssociation($VarProfileName, 0, "|<","",-1);
		   IPS_SetVariableProfileAssociation($VarProfileName, 1, "Play","",-1);
		   IPS_SetVariableProfileAssociation($VarProfileName, 2, "Pause","",-1);
		   IPS_SetVariableProfileAssociation($VarProfileName, 3, "Stop","",-1);
			IPS_SetVariableProfileAssociation($VarProfileName, 4, "|>","",-1);
	}

   IPS_DeleteVariableProfile("SONOS_Volume");
//TODOBR redundant?
	if (IPS_VariableProfileExists("SONOS_Volume")==False) {
	IPS_CreateVariableProfile('SONOS_Volume',1);
	IPS_SetVariableProfileValues("SONOS_Volume", 0, 100, 2);
	IPS_SetVariableProfileText("SONOS_Volume", "", "%");


	}
	# Script IDs suchen


	$id_sonos_wf = @IPS_GetScriptID("br_sonos_wf.php");
	if (!$id_sonos_wf) die ("br_sonos_wf.php not found - Run br_sonos_setup!");
	
	$id_sonos_update = @IPS_GetScriptID("br_sonos_update.php");
	if (!$id_sonos_wf) die ("br_sonos_update.php not found - Run br_sonos_setup!");

	$id_sonos_read_cover = @IPS_GetScriptID("br_sonos_read_cover.php");
	if (!$id_sonos_read_cover) die ("br_sonos_read_cover.php not found - Run br_sonos_setup!");

	#Variablen anlegen
	// Look at br_obj.handling.inc.php for CreateVariableByName and VAR_TYPE defs
	$id = CreateVariableByName($ParentID, "SONOS_IP",  VAR_TYPE_STRING);
	IPS_SetVariableCustomProfile($id, "~String");
	IPS_SetPosition($id, ++$position);
   IPS_SetHidden($id,true);
 

	$id = CreateVariableByName($ParentID, "SONOS_ID",  VAR_TYPE_STRING);
	IPS_SetVariableCustomProfile($id, "~String");
	IPS_SetPosition($id, ++$position);
   IPS_SetHidden($id,true);

   $id = CreateVariableByName($ParentID, "SONOS_NAME",  VAR_TYPE_STRING);
	IPS_SetVariableCustomProfile($id, "~String");
	IPS_SetPosition($id, ++$position);
   IPS_SetHidden($id,true);


	$id = CreateVariableByName($ParentID, "Info",  VAR_TYPE_STRING);
	IPS_SetVariableCustomProfile($id, "~HTMLBox");
	IPS_SetPosition($id, ++$position);

	$id = CreateVariableByName($ParentID, "Control",  VAR_TYPE_INTEGER);
	IPS_SetVariableCustomProfile($id, "Media_Transport");
	IPS_SetPosition($id, ++$position);
   $test=IPS_SetVariableCustomAction($id, $id_sonos_wf); // Set Sonos wf skript
	echo "------------------".$test."--------------";
	IPS_SetHidden($id,false);
   /* ^^^^^^^^ Event */
	$eid = IPS_CreateEvent(0); //Ausgelöstes Ereignis
	IPS_SetEventTrigger($eid, 1, $id); //Bei Änderung von Variable
	IPS_SetParent($eid, $id_sonos_update); //Ereignis zuordnen
	IPS_SetEventActive($eid, true); //Ereignis aktivieren

	$id = CreateVariableByName($ParentID, "CoverURI",  VAR_TYPE_STRING);
	IPS_SetVariableCustomProfile($id, "~String");
	IPS_SetPosition($id, ++$position);
   IPS_SetHidden($id,true);
   	/* ^^^^^^^^ Event */
	$eid = IPS_CreateEvent(0); //Ausgelöstes Ereignis
	IPS_SetEventTrigger($eid, 1, $id); //Bei Änderung von Variable
	IPS_SetParent($eid, $id_sonos_read_cover); //Ereignis zuordnen
	IPS_SetEventActive($eid, true); //Ereignis aktivieren

	$id = CreateVariableByName($ParentID, "Artist", VAR_TYPE_STRING);
	IPS_SetVariableCustomProfile($id, "~String");
	IPS_SetPosition($id, ++$position);
  IPS_SetHidden($id,true);

	$id = CreateVariableByName($ParentID, "Title",  VAR_TYPE_STRING);
	IPS_SetVariableCustomProfile($id, "~String");
	IPS_SetPosition($id, ++$position);
  IPS_SetHidden($id,true);

	$id = CreateVariableByName($ParentID, "Album",  VAR_TYPE_STRING);
	IPS_SetVariableCustomProfile($id, "~String");
	IPS_SetPosition($id, ++$position);
  IPS_SetHidden($id,true);


	$id = CreateVariableByName($ParentID, "AlbumArtist",  VAR_TYPE_STRING);
	IPS_SetVariableCustomProfile($id, "~String");
	IPS_SetPosition($id, ++$position);
  IPS_SetHidden($id,true);

	$id = CreateVariableByName($ParentID, "AlbumTrackNum",  VAR_TYPE_INTEGER);
//	IPS_SetVariableCustomProfile($id, "Integer");
	IPS_SetPosition($id, $position=$position+5);
  IPS_SetHidden($id,true);



   $id = CreateVariableByName($ParentID, "Position", VAR_TYPE_STRING);
	IPS_SetVariableCustomProfile($id, "~String");
	IPS_SetPosition($id, ++$position);
   IPS_SetHidden($id,true);

	$id = CreateVariableByName($ParentID, "Duration", VAR_TYPE_STRING);
	IPS_SetVariableCustomProfile($id, "~String");
	IPS_SetPosition($id, ++$position);
	IPS_SetHidden($id,true);

	$id = CreateVariableByName($ParentID, "Volume", VAR_TYPE_INTEGER);
	IPS_SetVariableCustomProfile($id, "SONOS_Volume");
	IPS_SetPosition($id, ++$position);
	IPS_SetVariableCustomAction($id, $id_sonos_wf); // Set Sonos wf skript
	/* ^^^^^^^^ Event */
	$eid = IPS_CreateEvent(0); //Ausgelöstes Ereignis
	IPS_SetEventTrigger($eid, 1, $id); //Bei Änderung von Variable
	IPS_SetParent($eid, $id_sonos_update); //Ereignis zuordnen
	IPS_SetEventActive($eid, true); //Ereignis aktivieren

	$id = CreateVariableByName($ParentID, "Mute", VAR_TYPE_BOOLEAN);
	IPS_SetVariableCustomProfile($id, "~Switch");
	IPS_SetVariableCustomProfile($id, "SWITCH");

		IPS_SetPosition($id, ++$position);
	IPS_SetVariableCustomAction($id, $id_sonos_wf); // Set Sonos wf skript
	/* ^^^^^^^^ Event */
	$eid = IPS_CreateEvent(0); //Ausgelöstes Ereignis
	IPS_SetEventTrigger($eid, 1, $id); //Bei Änderung von Variable
	IPS_SetParent($eid, $id_sonos_update); //Ereignis zuordnen
	IPS_SetEventActive($eid, true); //Ereignis aktivieren

	$id = CreateVariableByName($ParentID, "Shuffle", VAR_TYPE_BOOLEAN);
	IPS_SetVariableCustomProfile($id, "~Switch");
	IPS_SetVariableCustomProfile($id, "SWITCH");
	IPS_SetPosition($id, ++$position);
	IPS_SetVariableCustomAction($id, $id_sonos_wf); // Set Sonos wf skript
	/* ^^^^^^^^ Event */
	$eid = IPS_CreateEvent(0); //Ausgelöstes Ereignis
	IPS_SetEventTrigger($eid, 1, $id); //Bei Änderung von Variable
	IPS_SetParent($eid, $id_sonos_update); //Ereignis zuordnen
	IPS_SetEventActive($eid, true); //Ereignis aktivieren

	$id = CreateVariableByName($ParentID, "Repeat", VAR_TYPE_BOOLEAN);
	IPS_SetVariableCustomProfile($id, "~Switch");
	IPS_SetVariableCustomProfile($id, "SWITCH");
	IPS_SetPosition($id, ++$position);
	IPS_SetVariableCustomAction($id, $id_sonos_wf); // Set Sonos wf skript
	/* ^^^^^^^^ Event */
	$eid = IPS_CreateEvent(0); //Ausgelöstes Ereignis
	IPS_SetEventTrigger($eid, 1, $id); //Bei Änderung von Variable
	IPS_SetParent($eid, $id_sonos_update); //Ereignis zuordnen
	IPS_SetEventActive($eid, true); //Ereignis aktivieren

	$id = CreateVariableByName($ParentID, "Status", VAR_TYPE_INTEGER);
//	IPS_SetVariableCustomProfile($id, "SONOS.Status");
	IPS_SetPosition($id, ++$position);
   IPS_SetHidden($id,true);



	echo "===== Finished! ";
} else echo "... Repeat is found: Nothing to do! - You did a setup in past (and I skipped it now!).\n";

// ============================ Check ==============================

 // BRIPS editted to find current SONOS
    $sonos = new PHPSonos(br_objGetVar($ParentID,"SONOS_IP")); //Sonos ZP IPAdresse
    
echo "If you are unsure watch your ZonePlayer while starting this skript again! - it should switch OFF and ON it´s white LED if everything is correct!\n";
echo "\n LED (status before): " . $sonos->GetLEDState() . "\n";
echo "\nExecuting SetLEDState(true)";
$sonos->SetLEDState(true);
echo "\n LED: " . $sonos->GetLEDState() . "\n";
echo "\nExecuting IPS_Sleep(2000) - look at your SONOS device!\n";
IPS_Sleep(2000);
echo "\nExecuting SetLEDState(false)";
$sonos->SetLEDState(false);
echo "\n LED: " . $sonos->GetLEDState() . "\n";
echo "\nExecuting IPS_Sleep(2000) - look at your SONOS device!\n";
IPS_Sleep(2000);
echo "\nExecuting SetLEDState(true)";
$sonos->SetLEDState("On");
echo "\n LED: " . $sonos->GetLEDState() . "\n";
echo "\n\n If your LED did not switch on and off please review the settings!\n";

echo "\n\nNOTICE: I hided this script in webfront. If you need it in webfront for testing purposes, please unhide it and / or comment out this lines in the script!!\n";
IPS_SetHidden($IPS_SELF,true);
echo "\n\nATTENTION: If this an update and you did not yet ran br_sonos_setup - EXECUTE it now!\n";
?>