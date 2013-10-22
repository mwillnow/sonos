
<?
/*
    This file is part of br_IPSLibaries for IP-Symcon.

    Foobar is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    br_IPSLibaries is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Foobar.  If not, see <http://www.gnu.org/licenses/>.

 	 Please contact me at br@con8.de and use "br_IPS" anywhere in your email-subject.

*/

define("BR_IPS_TTS_MAJOR", "0");
define("BR_IPS_TTS_MINOR", "2");
define("BR_IPS_TTS_TAG", "jstWrkdArnd");
// Wrapper zur Umgehung der Systemtechnischen Begrenzungen des Servers
 $IDMediaPlayer=52709;



 //umgehe Server Begrenzung von tts speak
 
function br_TTS_Speak ($IDMediaPlayer, $strSay, $intWait) {

	if (function_exists('IPSLogger_Inf')){ IPSLogger_Inf(__file__, "I said (on ID: " . $IDMediaPlayer . ") " . $strSay); }

$IDTTSpeak=(int) 27473;
			
			if(TTS_GenerateFile($IDTTSpeak, $strSay, IPS_GetKernelDir()."media\Meldung.wav",6)){
				WAC_PlayFile($IDMediaPlayer,IPS_GetKernelDir()."media\Meldung.wav");
				IPS_Sleep ($intWait); return TRUE;
				} else return FALSE;
}

?>