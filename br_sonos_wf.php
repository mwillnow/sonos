<?
//Script zum WERTEZUWEISEN aus dem Webfrontend

if($IPS_SENDER == "WebFront")
{
    SetValue($IPS_VARIABLE, $IPS_VALUE);
}

?>
