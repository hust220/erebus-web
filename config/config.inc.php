<?php

#echo("We are sorry, the Eris server is temporarily down for maintaning purpose. Please check back later. <p> --Eris Team\n"); die;

/********************************************************************
*********************************************************************/
#    require_once('para.inc.php');
#    require_once('connect.inc.php');
#    require_once('myutils.php');
require_once('para.inc.php');
require_once('myutils.php');
require_once('connect.inc.php');

function pagesetup($sql_connect)
{
    global $erebus_session;
    if ($sql_connect) sql_connect();
    session_name($erebus_session);
    session_start();

#if ($_SESSION['level'] < 3){
#	header("Location: login.php");
#}
}

?>
