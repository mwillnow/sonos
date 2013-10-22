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
    along with br_IPS.  If not, see <http://www.gnu.org/licenses/>.


 	 Please contact me at br@con8.de and use "br_IPS" anywhere in your email-subject.

		Changes:
		20110427 br if second paremeter is empty all instances are returned
		

*/

define("BR_IPS_SI_MAJOR", "2");
define("BR_IPS_SI_MINOR", "2");
define("BR_IPS_SI_EDIT_DATE", "20110203");
define("BR_IPS_SI_TAG", "justonlyfs20fornowandthefun");


// searchinst:
// developed to be independend of ids
// parent: id of parent object for search
// searchinname: textual Filter





function br_searchinst($parent=0, $searchinname="noarg"){
global $cfg_br_ips;

// DEBUG
// echo "---".$searchinname."---";
$arronlysearchedinst=array();
$arrallinst=array();
$arronlysandchild=array();


$arrallinst = IPS_GetInstanceListByModuleType(3);

if ($searchinname!="noarg"){
	foreach ($arrallinst as &$curinst){

		if (strstr(IPS_GetName($curinst),$searchinname)){
		$arronlysearchedinst[] = $curinst;


		}
	}
} else {
	$arronlysearchedinst = $arrallinst;
}

foreach ($arronlysearchedinst as &$curinst){
	if ( IPS_IsChild ( $curinst,  $parent, true )){
	$arronlysandchild[] = $curinst;

	}
}

return $arronlysandchild;


} // function
?>