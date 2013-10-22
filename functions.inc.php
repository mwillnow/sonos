<?
/*
    This file is the Main Include and part of br_IPSLibaries for IP-Symcon.

    My Code if not overwise statet, is free software: you can redistribute it and/or modify
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


// Main include for br_Libs
define("BR_IPS", true);
define("BR_IPS_MAJOR", "1");
define("BR_IPS_MINOR", "5");
define("BR_IPS_FIX", "7");
define("BR_IPS_TAG", "PRE March for SONOS and Logger #PRE!!!NORELEASEandDISTRIBUTION");
define("BR_IPS_EDIT_DATE", "20110329");
define("BR_IPS_DEBUG", false);


// Read Config
require ("config.inc.php");

// Time and Date Helpers
require ("br_timeanddate.inc.php");
// Handle fs20
require ("br_fs20.inc.php");
// Handle Searches to be indepentend of ids
require ("br_searchinst.inc.php");
// Handle Objects to be independent of IDs
require ("br_obj_handling.inc.php");
// Handle Dim Requests
require ("br_dim.inc.php");
/// Handle TTS
require ("br_tts.inc.php");
// scene Handling
require ("br_scene.inc.php");
// Piri Handling *new in 1.5.0*
require ("br_piri.inc.php");
/* PHPSonos by Andre and Paresy
http://www.ip-symcon.de/forum/f53/php-sonos-klasse-ansteuern-einzelner-player-7676/
*/
require ("br_sonos.inc.php");



?>