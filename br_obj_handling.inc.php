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
 	 
Comment:
1.3. Added obj creation routines by BBbernhard from the German Ip-symcon.de Forum (Chromoflex Thread/ Release)


*/

// Object handling Routines - copied routines from saschahb @ ip-symcon.de Forum
// released with no restriction in use in his posting! Saschahb, please contact me, if i got it wrong.

define("BR_IPS_OBJH_MAJOR", "1");
define("BR_IPS_OBJH_MINOR", "3");
define("BR_IPS_OBJH_TAG", "objcreatebb");

// Get Value of Objects Var
function br_objGetVarID($objid, $variable)
{
    $obj = IPS_GetObject($objid);

    foreach ( $obj['ChildrenIDs'] as $item )
    {
       if ( IPS_GetName($item) == $variable )
       {
            return $item;
       }
    }

	if (function_exists('IPSLogger_Trc'))
		{ IPSLogger_Trc(__file__ , "== Line ".__line__." == " .
		"br_objGetVarID: Var " .$variable. " not found under " .$objid . " !; "
		); }
    

    return null;
}


// Get Value of Objects Var
function br_objGetVar($objid, $variable)
{
    $obj = IPS_GetObject($objid);

    foreach ( $obj['ChildrenIDs'] as $item )
    {
       if ( IPS_GetName($item) == $variable )
       {
            return GetValue($item);
       }
    }
 	if (function_exists('IPSLogger_Trc'))
		{ IPSLogger_Trc(__file__ , "== Line ".__line__." == " .
		"br_objGetVar: Var " .$variable. " not found under " .$objid . " !; "
		); }
    return null;
}

// Set Objects var
function br_objSetVar($objid, $variable, $value)
{
    $obj = IPS_GetObject($objid);

    foreach ( $obj['ChildrenIDs'] as $item )
    {
       if ( IPS_GetName($item) == $variable )
       {
            return SetValue($item, $value);
       }
    }

 	if (function_exists('IPSLogger_Trc'))
		{ IPSLogger_Trc(__file__ , "== Line ".__line__." == " .
		"br_objSetVar: Var " .$variable. " not found under " .$objid . " !; "
		); }
		
    return null;
}
// Exists
function br_objVarExists($objid, $variable)
{
    $obj = IPS_GetObject($objid);

    foreach ( $obj['ChildrenIDs'] as $item )
    {
       if ( IPS_GetName($item) == $variable )
       {
            return true;
       }
    }
    return false;
}

function br_objParent($item)
{
    $obj = IPS_GetObject($item);
    return $obj['ParentID'];
}

function GetUpdateTime($id){
  $v = IPS_GetVariable($id);
  $Update= (int) $v['VariableUpdated'];
  return ($Update);
}
// written by bbernhard
/*
VariablenTyp
 Wert
 Beschreibung

0
 legt eine Variable vom Typ Boolean an

1
 legt eine Variable vom Typ Integer an

2
 legt eine Variable vom Typ Float an

3
 legt eine Variable vom Typ String an


*/
define("VAR_TYPE_BOOLEAN", '0');
define("VAR_TYPE_INTEGER", '1');
define("VAR_TYPE_FLOAT", '2');
define("VAR_TYPE_STRING", '3');


function CreateVariableByName($id, $name, $type)
{
global $IPS_SELF;
   $vid = @IPS_GetVariableIDByName($name, $id);
   if($vid===false) {
      $vid = IPS_CreateVariable((int) $type);
        IPS_SetParent($vid, $id);
      IPS_SetName($vid, $name);
      IPS_SetInfo($vid, "This Variable was created by Script #$IPS_SELF");
    }
   return $vid;
}
// written by bbernhard
function getId($name) {
   global $IPS_SELF;
   $ParentID = IPS_GetObject($IPS_SELF);
    $ParentID = $ParentID['ParentID'];

    $ID = @IPS_GetObjectIDByName($name, $ParentID);
    if ($ID == 0) {
          $dummy=IPS_CreateInstance("{485D0419-BE97-4548-AA9C-C083EB82E61E}");  #Dummy Instance
        IPS_ApplyChanges($dummy);
        IPS_SetName($dummy,$name);
        IPS_SetParent($dummy,$ParentID);
   $ID = @IPS_GetObjectIDByName($name, $ParentID);
    }
return $ID;
}

?>