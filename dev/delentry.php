<?php
require('config/config.inc.php');
pagesetup(true);
?>
<?php
	if (empty($_SESSION['username'])){
		header("Location: login.php");
	}
?>

<?php 
#print_r($_GET);
#--------save the form data-------------------------#

#-------get sumitted data and check format--------#
$taskid = $_GET['taskid'];
#$pdbname = $_GET['pdbname'];
#if ( eregi('[^0-9]',$taskid)) {
#	die("invalid jobid");
#}
#$ip=$_SERVER['REMOTE_ADDR'];
#-----------set delete flag in the database--#
$userid = $_SESSION['userid'];
#$query  = "UPDATE $tablejobs SET flag='1' WHERE created_by='$userid' AND id='$jobid'" ;
$sql="DELETE FROM completed WHERE taskid LIKE \"$taskid%\" AND userid='$userid';";
$result = mysql_query($sql) or die("");
$sql="DELETE FROM submitted WHERE taskid LIKE \"$taskid%\" AND userid='$userid';";
$result = mysql_query($sql) or die("");
die("ok");
?>
