<?

/*
    This file is the Main Include anbd part of br_IPSLibaries for IP-Symcon.

    Foobar is free software: you can redistribute it and/or modify
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

define("BR_IPS_PIRI_MAJOR", "0");
define("BR_IPS_PIRI_MINOR", "8");
define("BR_IPS_PIRI_TAG","gotthatlight");

/* TAG_BR_CONFIG Candidate for config.inc.php or br_libs_config.inc.php
This tag only helps me to find configuration options for consolidation in a central file
NAME_LIGHT=Search for this to switch off a complete room aka category
NAME_PIRI=Search for this to find the central PIRI in a category aka room
***** Name your lights and piris like this or edit the folowwing config variables ****
*/

$NAME_LIGHT="Licht";
$NAME_PIRI="PIRI";


/*
	br_piri_handle(...) Handle gerneral Priri and or status handling for the category
	$IDVar= Id der Aufrufenden Variable
	$PIRI_AUTOMATIK=Automatisches Einschalten von $ID_LIGHT _AUTO (boolean)
	$ID_LIGHT_AUTO= wenn o.g. true die ID der Lampe, welche beim betreten eingeschaltet wird
	$EINSCHALTDAUER=wie lange soll diese eingeschaltet werden bei Automatik?
	$ABSCHALTUNG=Falls $PIRI_AUTOMATIK==false, wann soll die Lampe dann trotzdem in jedem FAll bei Inaktivität ausgeschaltet werden?
*/

function br_piri_handle ($IDVar, $PIRI_AUTOMATIK, $ID_LIGHT_AUTO, $EINSCHALTDAUER, $ABSCHALTUNG)
{
	$VarValue=GetValue($IDVar);

	// Aufruf über Variablen Ereignis
	print " - Trigger: Var, Var: " . $IDVar . ", ";
	$objVar = IPS_GetObject($IDVar);
	if ($objVar['ObjectName']=="Status"){
			Print " Value:" .$VarValue;
			$objVar= IPS_GetObject($objVar['ParentID']);
      if ($VarValue){

			if(strstr($objVar['ObjectName'],"Licht")&&(!$PIRI_AUTOMATIK)){

				// Lichtschalter betätigt: Nur Abschaltautomatik bei manuell
					FS20_SwitchDuration($objVar['ObjectID'],true,$ABSCHALTUNG*60);

			} else {
				// PIRI hat ausgelöst: wenn automatik dann lichter an
				// dann licht auf einschaltdauer an, sonst auf abschaltung nach an
				if ($PIRI_AUTOMATIK) {
				Print "PIRI ausgelöst; Automatik an; ";
					FS20_SwitchDuration($ID_LIGHT_AUTO,true,$EINSCHALTDAUER*60);
				} else {
					// Suche angeschaltetes Licht und verlängere
               Print "PIRI ausgelöst; Automatik AUS; Verlängere einschaltdauer nur; ";

					$objVar= IPS_GetObject($objVar['ParentID']);
               $arrLights=br_searchinst((int)$objVar['ObjectID'],$NAME_LIGHT);
					Print "Suche Parent mit String $Name_Light im Namen; ";
					foreach ($arrLights as &$curinst){
						$arrStatusvar=IPS_GetStatusVariable($curinst, "StatusVariable");
						Print "Found " . $curinst ."; ";
						Print "Status is: " . GetValueBoolean($arrStatusvar['VariableID']) . "; ";
						if (GetValueBoolean($arrStatusvar['VariableID'])){
							Print " Switching thingie on; ";
							FS20_SwitchDuration($ID_LIGHT_AUTO,true,$ABSCHALTUNG*60);

						}
					}

				}

			}
		} // Ende Value = true = an/ ausgelöst
	}


/*
if($IPS_SENDER == "TimerEvent")    {
	// Aufruf über Timer - AKTUELL NICHT benutzt
	print " - Trigger: TimerEvent, Timer ". $IPS_EVENT . ", ";
	$objVar = IPS_GetObject($IPS_EVENT);
	$objVar= IPS_GetObject($objVar['ParentID']);
   $arrPIRI= br_searchinst((int)$objVar['ParentID'],$NAME_PIRI);

	if ($arrPIRI[0]){
	// Alle Lichter im Raum aus, wenn PIRI  false
	print "Switching off Licht due to inactivity";
	br_switch(br_searchinst((int)$objVar['ParentID'],$NAME_LIGHT),false);
	IPS_SetScriptTimer($IPS_SELF,0);
	} else {
	print "There is still activity";
	}

}
*/
}
?>