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
*/

/* Fs20 relevant wrapper for switch
// id: of fs20 device
// job: 99 = toogle
// job: true = switch on
// job: false = switch off
*/

define("BR_IPS_FS20_MAJOR", "2");
define("BR_IPS_FS20=_MINOR", "1");
define("BR_IPS_FS20_TAG", "shoutOutLoud");

function br_switch ($id, $job=99){

	foreach( $id as &$curid){

		if((int) $job==99){
				
				// mit alter Helligkeit ein oder ausschalten
				$status=GetValue(IPS_GetStatusVariableID((int)$curid, "StatusVariable"));
				FS20_SwitchMode($curid, !$status);
		
		}else{
				if ($job==1){
				FS20_SwitchMode($curid, true);

				}else {
				FS20_SwitchMode($curid, false);

				}
			}
 }

}
function br_setIntensity ($id, $job="99", $time=4){

	foreach( $id as &$curid){
  if(( (int) $job==99)||($job==false) ) {
			if("$job"=="99"){
				// mit alter Helligkeit ein oder ausschalten
				FS20_SwitchMode($curid, !$status);
			} else {
				// false ausschalten
				FS20_SwitchMode($curid, false);

			}
	}else{
			if ($job){
			FS20_SetIntensity($curid, (int) $job, $time);
			}else {
			// redundant -> false ausschalten
			FS20_SwitchMode($curid, false);
			}
	}
 }

}

?>