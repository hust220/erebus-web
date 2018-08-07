<?php
require('config/config.inc.php');
pagesetup(true);
require('config/emailNotification.inc.php');

$taskid=$_GET['taskid'];


#$sql="SELECT completed.query as query,ct,cq,cm,cla,clr,cne,cna,cwt,crmsd,clq,results.taskid,resid FROM results JOIN completed " .
#    "ON (results.taskid=completed.taskid AND completed.userid=$userid AND results.taskid=\"$taskid\" AND SUBSTR(results.ct FROM -14)=\"$ent\" AND results.resid=\"$resid\") LIMIT 1";

$sql="SELECT users.email as email, tcomplete, brief, taskname FROM completed JOIN users " .
    "ON (completed.taskid=\"$taskid\" AND completed.userid=users.userid)";

$result = sql_submit_task($sql, $row);
if (!$result) die("db error");
if ($row == 0) die("task or user not found.");

$email_address = $row['email'];
$tcomplete = $row['tcomplete'];
$brief = $row['brief'];
$taskname = $row['taskname'];

$text = "Task name: " . $taskname . "\nMatches found: $brief\n";
emailNotification($email_address, $text);
?>
