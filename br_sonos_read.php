<?

require ("functions.inc.php");

/* br_ips br_sonos_read.php
based on http://www.ip-symcon.de/forum/f53/php-sonos-klasse-ansteuern-einzelner-player-7676/index4.html#post105587
*/


// 110209 corrected divsion by zero for progressbar
// 110209 moved out setup routines to br_sonos_setup.php (deleted them in in here)
// 110215 moved out br_sonos_read to br_sonos.inc.php

// ============================ Read SONOS Players  ==============================
IPS_Sleep(110); // Timing Prob. MERKER_BR
	if (function_exists('IPSLogger_Dbg'))
		{ IPSLogger_Dbg(__file__ , "== Line ".__line__." == " .
		" call to read_all from: " . $IPS_SELF
		); }

br_sonos_read_all();
IPS_Sleep(70);// Timing Prob. MERKER_BR
unset($arrzonegroups);
$arrzonegroups = br_sonos_GetSONOS_Groups();

	// DEBUG
	  		if (function_exists('IPSLogger_Trc'))
		{ IPSLogger_Trc(__file__ , "== Line ".__line__." == " .
		"SonosGroups: " . print_r ($arrzonegroups, true)
		);}
// To stdout for intensive DEBUG
 //print_r ($arrzonegroups, false)
?>