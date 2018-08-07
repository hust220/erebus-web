<?php
require('config/config.inc.php');
pagesetup(true);
?>
<?php
	if (empty($_SESSION['username'])){
	    die("no username");
	}
?>

<?php 
$taskid = $_GET['taskid'];
$userid = $_SESSION['userid'];
#$query  = "UPDATE $tablejobs SET flag='1' WHERE created_by='$userid' AND id='$jobid'" ;
$sql="SELECT brief,stats from $table_completed WHERE taskid=\"$taskid\" AND userid=\"$userid\";";
#echo "$userid $taskid<p>$sql";
$result = mysql_query($sql) or die("db error");
$brief="";
$stat="";
if ($result) {
    $nrow = mysql_num_rows($result);
    if ($nrow) {
	 $rows = mysql_fetch_array($result);
	 $brief = $rows["brief"];
	 $stats = $rows["stats"];
	 if (empty($stats)) {
	    echo $brief;
	 } else {
	    echo "%";
	 }
    }
} else {
    die("task has no results");
}
?>
