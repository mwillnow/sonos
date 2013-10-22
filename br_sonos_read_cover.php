<?
require ("functions.inc.php");

$ParentID=br_objParent($IPS_VARIABLE);

$id_CoverURI = br_objGetVarID( $ParentID ,"CoverURI");

$arronlysearched=array();
$arrallt=array();
$arrzoneplayers=array();

$arrall = IPS_GetVariableList();
foreach ($arrall as &$cur){
	if (strstr(IPS_GetName($cur),"SONOS_Zones")){
	$ParentIDsearch = br_objParent($cur);	}
}

$arrzoneplayers= unserialize(br_objGetVar($ParentIDsearch, "SONOS_Zones"));


// $arrzoneplayers[$ParentID]['Name']


// Sender??
if($IPS_SENDER=="Variable"){

	$CoverSize     = 150;
	$filename = IPS_GetKernelDir() . "\\webfront\\user\\Album_cover_"
	. $arrzoneplayers[br_objGetVar($ParentID,"SONOS_IP")]['CurrentZoneName'] . ".jpg";

	if (function_exists('IPSLogger_Dbg'))
		{ IPSLogger_Dbg(__file__ , "== Line ".__line__." == " .
		"Getting cover " . GetValue($id_CoverURI) . " \n... saving to: " . $filename
		); }
		
	getSonosCover($id_CoverURI,$filename, $CoverSize);

}
?>