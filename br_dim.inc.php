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


Handle dimrequest and Reset Calling var to zero,
develeoped for webfront and non bidi devices
*/

define("BR_IPS_DIM_MAJOR", "1");
define("BR_IPS_DIM_MINOR", "2");
define("BR_IPS_DIM_TAG", "goUpandSeek");

function br_dimHandleVar($IDVar){


	$VarValue=GetValue($IDVar);

if ($VarValue==0) return;
	switch ($VarValue) {
	
	

	
		case 1:
			FS20_DimDown((int)br_objParent($IDVar));
			break;
	

		case 100:
		

			FS20_SetIntensity((int)br_objParent($IDVar),16,2);
  			IPS_Sleep(2);
			FS20_SetIntensity((int)br_objParent($IDVar),16, 1);

			IPS_Sleep(21);
			FS20_SetIntensity((int)br_objParent($IDVar),16, 0);


		

			break;

		case 101:
			FS20_DimUp((int)br_objParent($IDVar));
			break;

		default:
		
			FS20_SetIntensity((int)br_objParent($IDVar),(int) $VarValue/100*16 ,0);


			IPS_Sleep(21);
			FS20_SetIntensity((int)br_objParent($IDVar),(int) $VarValue/100*16 ,0);


	}
/* TAG_BR_CONFIG Candidate for config.inc.php or br_libs_config.inc.php
This tag only helps me to find configuration options for consolidation in a central file
*/
	br_objSetVar(br_objParent($IDVar),"Helligkeit",0);

}
?>