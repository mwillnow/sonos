<?
/* br_sonos_setup.php
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
*/


define("BR_IPS_SONOS_SETUP_TAG", "milestonevsstepstone");
define("BR_IPS_SONOS_SETUP_DATE", "20110803");


require ("functions.inc.php");


// ============================ Setup ==============================
$ParentID=(int)br_objParent ($IPS_SELF);
echo "\nbr_sonos_setup (ScriptID: " . $IPS_SELF . "):\n";


	$position=5;
// ============================ Setup /Update ==============================
	echo ("====== SETUP/ Update for Sonos " . $ParentID . " is ongoing ...\n");


	if (function_exists('IPSLogger_Inf'))
		{ IPSLogger_Inf(__file__ , "== Line ".__line__." == " .
	"====== SETUP/ Update for Sonos " . $ParentID . " is ongoing ...\n"
		); }


	
	
	# Variablenprofile anlegen
	$VarProfileName="Media_Transport";
	if (IPS_VariableProfileExists($VarProfileName)==True) {
		echo ("- deleting VariableProfile ".$VarProfileName." for update!\n");
		IPS_DeleteVariableProfile($VarProfileName); // force for update
	}
//	if (IPS_VariableProfileExists($VarProfileName)==False) {
			echo ("- creating VariableProfile ". $VarProfileName ." for setup or update!\n");
			IPS_CreateVariableProfile($VarProfileName,1);
			IPS_SetVariableProfileAssociation($VarProfileName, 0, "|<","",-1);
		   IPS_SetVariableProfileAssociation($VarProfileName, 1, "Play","",-1);
		   IPS_SetVariableProfileAssociation($VarProfileName, 2, "Pause","",-1);
		   IPS_SetVariableProfileAssociation($VarProfileName, 3, "Stop","",-1);
			IPS_SetVariableProfileAssociation($VarProfileName, 4, "|>","",-1);

//	}

	$VarProfileName="SONOS_Volume";
	if (IPS_VariableProfileExists($VarProfileName)==True) {
		echo ("- deleting VariableProfile ".$VarProfileName." for update!\n");
		IPS_DeleteVariableProfile($VarProfileName); // force for update
	}

	if (IPS_VariableProfileExists($VarProfileName)==False) {
			echo ("- creating VariableProfile ". $VarProfileName ." for setup or update!\n");

			IPS_CreateVariableProfile($VarProfileName,1);
			IPS_SetVariableProfileValues($VarProfileName, 0, 100, 2);
			IPS_SetVariableProfileText($VarProfileName, "", "%");


	}
	
echo ("\nNOTICE: For your safety no delete/ update is done on your scripts!
If they don´t exist I will create them now (I will ouput one line for each script created; If you ever need to force recreation you should delete all variables and scripts in this category except br_sonos_setup).\n");

	# Scripte anlegen
	$ScriptName="br_sonos.inc.php";
	if (!@IPS_GetScriptIDByName($ScriptName, $ParentID)){
			echo ("- creating script ". $ScriptName ."\n");
	     $id = IPS_CreateScript(0);
        IPS_SetScriptFile($id, $ScriptName);
        IPS_SetName($id, $ScriptName);
		  IPS_SetParent($id,$ParentID);
		  IPS_SetHidden($id,true);
        IPS_SetPosition($id, ++$position);
   }
 	$ScriptName="PHPSonos.inc.php";
	if (!@IPS_GetScriptIDByName($ScriptName, $ParentID)){
			echo ("- creating script ". $ScriptName ."\n");
        $id = IPS_CreateScript(0);
        IPS_SetScriptFile($id, $ScriptName);
        IPS_SetName($id, $ScriptName);
		  IPS_SetParent($id,$ParentID);
		  IPS_SetHidden($id,true);
        IPS_SetPosition($id, ++$position);
   }
   $ScriptName="br_sonos_setup.php";
	if (!@IPS_GetScriptIDByName($ScriptName, $ParentID)){
				echo ("- creating script ". $ScriptName ."\n");
        $id = IPS_CreateScript(0);
        IPS_SetScriptFile($id, $ScriptName);
        IPS_SetName($id, $ScriptName);
		  IPS_SetParent($id,$ParentID);
		  IPS_SetHidden($id,true);
        IPS_SetPosition($id, ++$position);
   }

   $ScriptName="br_sonos_setup-template.php";
	if (!@IPS_GetScriptIDByName($ScriptName, $ParentID)){
				echo ("- creating script ". $ScriptName ."\n");
        $id = IPS_CreateScript(0);
        IPS_SetScriptFile($id, $ScriptName);
        IPS_SetName($id, $ScriptName);
		  IPS_SetParent($id,$ParentID);
		  IPS_SetHidden($id,true);
        IPS_SetPosition($id, ++$position);
   }

   $ScriptName="br_sonos_zonesetup.php";
	if (!@IPS_GetScriptIDByName($ScriptName, $ParentID)){
				echo ("- creating script ". $ScriptName ."\n");
        $id = IPS_CreateScript(0);
        IPS_SetScriptFile($id, $ScriptName);
        IPS_SetName($id, $ScriptName);
		  IPS_SetParent($id,$ParentID);
		  IPS_SetHidden($id,true);
        IPS_SetPosition($id, ++$position);
   }
   $ScriptName="br_sonos_zonesetup-template.php";
	if (!@IPS_GetScriptIDByName($ScriptName, $ParentID)){
				echo ("- creating script ". $ScriptName ."\n");
        $id = IPS_CreateScript(0);
        IPS_SetScriptFile($id, $ScriptName);
        IPS_SetName($id, $ScriptName);
		  IPS_SetParent($id,$ParentID);
		  IPS_SetHidden($id,true);
        IPS_SetPosition($id, ++$position);
   }
        
   $ScriptName="br_sonos_read.php";
	if (!@IPS_GetScriptIDByName($ScriptName, $ParentID)){
				echo ("- creating script ". $ScriptName ."\n");
        $id = IPS_CreateScript(0);
        IPS_SetScriptFile($id, $ScriptName);
        IPS_SetName($id, $ScriptName);
		  IPS_SetParent($id,$ParentID);
		  IPS_SetHidden($id,true);
        IPS_SetPosition($id, ++$position);

         $eid = IPS_CreateEvent(1); //Ausgelöstes Ereignis
         	echo ("	- event ". $eid ."\n");
	IPS_SetParent($eid, $id);
	IPS_SetEventActive($eid, true); //Ereignis aktivieren

	IPS_SetEventCyclic($eid, 0, 0, 0, 2, 2 ,1); //Alle 2 Minuten
   }
   
   $ScriptName="br_sonos_read_cover.php";
	if (!@IPS_GetScriptIDByName($ScriptName, $ParentID)){
				echo ("- creating script ". $ScriptName ."\n");
        $id = IPS_CreateScript(0);
        IPS_SetScriptFile($id, $ScriptName);
        IPS_SetName($id, $ScriptName);
		  IPS_SetParent($id,$ParentID);
		  IPS_SetHidden($id,true);
        IPS_SetPosition($id, ++$position);
   }

   $ScriptName="br_sonos_wf.php";
	if (!@IPS_GetScriptIDByName($ScriptName, $ParentID)){
				echo ("- creating script ". $ScriptName ."\n");
        $id = IPS_CreateScript(0);
        IPS_SetScriptFile($id, $ScriptName);
        IPS_SetName($id, $ScriptName);
		  IPS_SetParent($id,$ParentID);
		  IPS_SetHidden($id,true);
        IPS_SetPosition($id, ++$position);
   }
    $ScriptName="br_sonos_update.php";
	if (!@IPS_GetScriptIDByName($ScriptName, $ParentID)){
				echo ("- creating script ". $ScriptName ."\n");
        $id = IPS_CreateScript(0);
        IPS_SetScriptFile($id, $ScriptName);
        IPS_SetName($id, $ScriptName);
		  IPS_SetParent($id,$ParentID);
		  IPS_SetHidden($id,true);
        IPS_SetPosition($id, ++$position);
   }








echo "\nNOTICE: I hided this script in webfront. If you need it in webfront for testing purposes, please unhide it and / or comment out the lines in this script!\n";
echo "\nATTENTION: You need to rerun THIS script after each zonesetup run to add the zoneplayers to SONOS_Zones var!\n";
IPS_SetHidden($IPS_SELF,true);

		echo ("- creating / updating SONOS_Zones and SONOS_Groups (Variables) ...");
		#Variablen anlegen
	// Look at br_obj.handling.inc.php for CreateVariableByName and VAR_TYPE defs
 	$VarName="SONOS_Zones";
  	if (!@IPS_GetVariableIDByName($VarName, $ParentID)){
  		$id = CreateVariableByName($ParentID, $VarName,  VAR_TYPE_STRING);
		IPS_SetVariableCustomProfile($id, "~String");
		IPS_SetPosition($id, ++$position);
   	IPS_SetHidden($id,true);
   }

 	$VarName="SONOS_Groups";
  	if (!@IPS_GetVariableIDByName($VarName, $ParentID)){
  		$id = CreateVariableByName($ParentID, $VarName,  VAR_TYPE_STRING);
		IPS_SetVariableCustomProfile($id, "~String");
		IPS_SetPosition($id, ++$position);
   	IPS_SetHidden($id,true);
   }
	echo (" done!\n");
	
	echo ("- updating list of zoneplayers ....");
$arronlysearched=array();
$arrallt=array();
$arrzoneplayers=array();

$arrall = IPS_GetVariableList();
foreach ($arrall as &$cur){
	if (strstr(IPS_GetName($cur),"SONOS_IP")){
	$arronlysearched[] = $cur;	}
}
$count=1;
foreach ($arronlysearched as &$cur){

	$IP=GetValue($cur); // Key is IP
	$arrzoneplayers[$IP]['IP'] = $IP;
   $sonos = new PHPSonos($arrzoneplayers[$IP]['IP']); //Sonos ZP IPAdresse
   // Get Zone Informations
	$ZoneAttributes = $sonos->GetZoneAttributes();
	if (!$ZoneAttributes) die("ATTENTION: Connection failure");
	$arrzoneplayers[$IP]['CurrentZoneName']=$ZoneAttributes['CurrentZoneName'];
   $arrzoneplayers[$IP]['CurrentIcon']=$ZoneAttributes['CurrentIcon'];
	$ZoneInfo = $sonos->GetZoneInfo();
	if (!$ZoneInfo) die("ATTENTION: Connection failure");
	$arrzoneplayers[$IP]['SerialNumber']=$ZoneInfo['SerialNumber'];
	$arrzoneplayers[$IP]['SoftwareVersion']=$ZoneInfo['SoftwareVersion'];
	$arrzoneplayers[$IP]['DisplaySoftwareVersion']=$ZoneInfo['DisplaySoftwareVersion'];
	$arrzoneplayers[$IP]['HardwareVersion']=$ZoneInfo['HardwareVersion'];
	$arrzoneplayers[$IP]['IPAddress']=$ZoneInfo['IPAddress'];
	$arrzoneplayers[$IP]['MACAddress']=$ZoneInfo['MACAddress'];
	$arrzoneplayers[$IP]['CopyrightInfo']=$ZoneInfo['CopyrightInfo'];
	$arrzoneplayers[$IP]['ExtraInfo']=$ZoneInfo['ExtraInfo'];
	$arrzoneplayers[$IP]['Rincon']="RINCON_".implode("",explode(":",$ZoneInfo['MACAddress']))."01400";
   $arrzoneplayers[$IP]['ID']=$arrzoneplayers[$IP]['Rincon'];
   $arrzoneplayers[$IP]['IPSId']=$cur;


	$ID=$arrzoneplayers[$IP]['Rincon']; // Key is ID
   $arrzoneplayers[$ID]['IP'] = $IP;
	$arrzoneplayers[$ID]['CurrentZoneName']=$ZoneAttributes['CurrentZoneName'];
   $arrzoneplayers[$ID]['CurrentIcon']=$ZoneAttributes['CurrentIcon'];
	$arrzoneplayers[$ID]['SerialNumber']=$ZoneInfo['SerialNumber'];
	$arrzoneplayers[$ID]['SoftwareVersion']=$ZoneInfo['SoftwareVersion'];
	$arrzoneplayers[$ID]['DisplaySoftwareVersion']=$ZoneInfo['DisplaySoftwareVersion'];
	$arrzoneplayers[$ID]['HardwareVersion']=$ZoneInfo['HardwareVersion'];
	$arrzoneplayers[$ID]['IPAddress']=$ZoneInfo['IPAddress'];
	$arrzoneplayers[$ID]['MACAddress']=$ZoneInfo['MACAddress'];
	$arrzoneplayers[$ID]['CopyrightInfo']=$ZoneInfo['CopyrightInfo'];
	$arrzoneplayers[$ID]['ExtraInfo']=$ZoneInfo['ExtraInfo'];
	$arrzoneplayers[$ID]['Rincon']="RINCON_".implode("",explode(":",$ZoneInfo['MACAddress']))."01400";
   $arrzoneplayers[$ID]['ID']=$arrzoneplayers[$ID]['Rincon'];
   $arrzoneplayers[$ID]['IPSId']=$cur;

	$Name=$arrzoneplayers[$IP]['CurrentZoneName']; // Key is ZoneName
   $arrzoneplayers[$Name]['IP'] = $IP;
	$arrzoneplayers[$Name]['CurrentZoneName']=$ZoneAttributes['CurrentZoneName'];
   $arrzoneplayers[$Name]['CurrentIcon']=$ZoneAttributes['CurrentIcon'];
	$arrzoneplayers[$Name]['SerialNumber']=$ZoneInfo['SerialNumber'];
	$arrzoneplayers[$Name]['SoftwareVersion']=$ZoneInfo['SoftwareVersion'];
	$arrzoneplayers[$Name]['DisplaySoftwareVersion']=$ZoneInfo['DisplaySoftwareVersion'];
	$arrzoneplayers[$Name]['HardwareVersion']=$ZoneInfo['HardwareVersion'];
	$arrzoneplayers[$Name]['IPAddress']=$ZoneInfo['IPAddress'];
	$arrzoneplayers[$Name]['MACAddress']=$ZoneInfo['MACAddress'];
	$arrzoneplayers[$Name]['CopyrightInfo']=$ZoneInfo['CopyrightInfo'];
	$arrzoneplayers[$Name]['ExtraInfo']=$ZoneInfo['ExtraInfo'];
	$arrzoneplayers[$Name]['Rincon']="RINCON_".implode("",explode(":",$ZoneInfo['MACAddress']))."01400";
   $arrzoneplayers[$Name]['ID']=$arrzoneplayers[$Name]['Rincon'];
   $arrzoneplayers[$Name]['IPSId']=$cur;
// Key is IPSId
	$Name=$arrzoneplayers[$IP]['IPSId']; // Key is ZoneName
   $arrzoneplayers[$Name]['IP'] = $IP;
	$arrzoneplayers[$Name]['CurrentZoneName']=$ZoneAttributes['CurrentZoneName'];
   $arrzoneplayers[$Name]['CurrentIcon']=$ZoneAttributes['CurrentIcon'];
	$arrzoneplayers[$Name]['SerialNumber']=$ZoneInfo['SerialNumber'];
	$arrzoneplayers[$Name]['SoftwareVersion']=$ZoneInfo['SoftwareVersion'];
	$arrzoneplayers[$Name]['DisplaySoftwareVersion']=$ZoneInfo['DisplaySoftwareVersion'];
	$arrzoneplayers[$Name]['HardwareVersion']=$ZoneInfo['HardwareVersion'];
	$arrzoneplayers[$Name]['IPAddress']=$ZoneInfo['IPAddress'];
	$arrzoneplayers[$Name]['MACAddress']=$ZoneInfo['MACAddress'];
	$arrzoneplayers[$Name]['CopyrightInfo']=$ZoneInfo['CopyrightInfo'];
	$arrzoneplayers[$Name]['ExtraInfo']=$ZoneInfo['ExtraInfo'];
	$arrzoneplayers[$Name]['Rincon']="RINCON_".implode("",explode(":",$ZoneInfo['MACAddress']))."01400";
   $arrzoneplayers[$Name]['ID']=$arrzoneplayers[$Name]['Rincon'];
   $arrzoneplayers[$Name]['IPSId']=$cur;
	// Key is count
   $arrzoneplayers[$count]['IP'] = $IP;
	$arrzoneplayers[$count]['CurrentZoneName']=$ZoneAttributes['CurrentZoneName'];
   $arrzoneplayers[$count]['CurrentIcon']=$ZoneAttributes['CurrentIcon'];
	$arrzoneplayers[$count]['SerialNumber']=$ZoneInfo['SerialNumber'];
	$arrzoneplayers[$count]['SoftwareVersion']=$ZoneInfo['SoftwareVersion'];
	$arrzoneplayers[$count]['DisplaySoftwareVersion']=$ZoneInfo['DisplaySoftwareVersion'];
	$arrzoneplayers[$count]['HardwareVersion']=$ZoneInfo['HardwareVersion'];
	$arrzoneplayers[$count]['IPAddress']=$ZoneInfo['IPAddress'];
	$arrzoneplayers[$count]['MACAddress']=$ZoneInfo['MACAddress'];
	$arrzoneplayers[$count]['CopyrightInfo']=$ZoneInfo['CopyrightInfo'];
	$arrzoneplayers[$count]['ExtraInfo']=$ZoneInfo['ExtraInfo'];
	$arrzoneplayers[$count]['Rincon']="RINCON_".implode("",explode(":",$ZoneInfo['MACAddress']))."01400";
   $arrzoneplayers[$count]['ID']=$arrzoneplayers[$Name]['Rincon'];
   $arrzoneplayers[$count]['IPSId']=$cur;
	$count++;
}



	echo (" done!\n\nFound following SONOS devices via search for SONOS_IP ...\n");
	for($i=1; isset($arrzoneplayers[$i]); $i++) {
		print_r($arrzoneplayers[$i]);
	
	}
	
	echo ("\n\nOriginal SONOS_Zones array has redundant information and keys: IP, Name, Rincon-ID and an incremented Index starting with 1.\n");

	if(!isset($arrzoneplayers[$i]))

echo "\n - saving this to SONOS_Zones via serialize(..);...\n";
br_objSetVar($ParentID, "SONOS_Zones" , serialize($arrzoneplayers)); 
$arrafter= unserialize(br_objGetVar($ParentID, "SONOS_Zones"));
	for($i=1; isset($arrafter[$i]); $i++) {
		// print_r($arrafter[$i]); // DEBUG

	}
if ($i==$count) {
	echo "\n - (CHECK)\n - Count is the same after above write/serialize and another read (variable boundaries not reached)! ;-) - OK\n";
} else 	echo "\n - Count is NOT the same after above save/serialize and another read! ANYTHING WENT WRONG\n";


	echo "\n===== Finished (don´t forget to run zonesetup scripts after the Setup if this is the first run of br_setup_sonos)! \n";
?>