<?php
require('config/config.inc.php');
pagesetup(true);

if (empty($_SESSION['username'])){
	header("Location: login.php");
	die("");
}

function tdwrap(&$value, $index) {
	if ($index == 4) {
	    $value = '<td class="iresname">' . $value . '</td>';
	} else {
	    $value = '<td class="noresname">' . $value . '</td>';
	}
}

$newquery='';

#if (0) {
if (!empty($_REQUEST['query']) || (($_FILES["filename"]["size"] > 0)))
{
#    echo "--" . $_FILES["filename"]["size"] . " " . sizeof($_FILES["filename"]) . "--";
    $newquery="";
    $query=trim($_REQUEST["query"]);
    if (empty($query)) {
	$res = prepare_pdb(file_get_contents($_FILES["filename"]["tmp_name"]), $max_query_atoms, $newquery);
    } else {
	$res = prepare_pdb($query, $max_query_atoms, $newquery);
    }
    if (empty($_REQUEST['querymod'])) {
# save query to the table for temporary data, send parsed data and quit
	if ($res) {
	    $userid = $_SESSION['userid'];
	    $sessionid = session_id();

	    $sql="INSERT INTO $table_uploads (userid,sessionid,query) VALUES($userid, \"$sessionid\", \"$newquery\") ON DUPLICATE KEY UPDATE query=VALUES(query);";
	    $res = mysql_query($sql);
	    if ($res) { 
		parse_pdb($newquery, $ppdb);
		$iestr = "<script type=\"text/javascript\"> function init() {if(top.uploadcomplete) top.uploadcomplete(top); } window.onload=init;</script>";
		$str = "<html><head>$iestr</head><body><table><tbody id=\"subInnerTableBody\">";
		foreach ($ppdb as $p) {
		    array_walk($p, 'tdwrap');
		    $str .= '<tr>' . implode('', $p) . '</tr>';
		}
		echo $str . '</tbody></table></body></html>';
	    } else {
		$newquery = mysql_error();
	    }
	}
	if (!$res) {
	    echo "<span id=error class=error>$newquery</span>";
	}
	die("");
    }
    if (!$res) {
	$_SESSION['query_error'] = $newquery;
    }
} else {
    $sessionid = session_id();
    $sql = "SELECT query FROM $table_uploads where sessionid=\"$sessionid\";";
    $res = sql_submit_task($sql, $out);
    if ($res) {
	$newquery = $out["query"];
    } else {
	$newquery = "";
    }
#    echo "++" . $newquery . "++";
}

if (empty($newquery)) {
    $_SESSION['query_error'] = "Error occured while submitting the task. Query structure can not be read. Please try again.";
    header("Location: submit.php");
    die("");
}

$sessionid = session_id();
$sql = "DELETE FROM $table_uploads WHERE sessionid=\"$sessionid\";";
$res = mysql_query($sql);
if (!$res) $_SESSION['query_error'] = mysql_error();

#submit the task
$varlist = array('taskname', 'qwidth','qminweight','symatoms', 'notifyCompleted');

$formvalue= array();
$formvalue["taskname"] = '';
$formvalue["qwidth"] = $defqwidth;
$formvalue["qminweight"] = $defqminweight;
$formvalue["symatoms"] = $defsymatoms;

$_SESSION['upload'] = "";
$_SESSION['query_error'] = '';

if (isset($_REQUEST['taskname']))
{
    $formvalue["symatoms"] = 0;

    foreach ($varlist as $var) {
	if (isset($_REQUEST["$var"])){
		$formvalue["$var"] = $_REQUEST["$var"];
	}
    }

    if (empty($_SESSION['query_error'])) {
	$userid = $_SESSION['userid'];

	if ($userid == -1) { /* guest user without account saved - create id now */
	    for ($s = '', $i = 0, $z = strlen($a = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')-1; $i != 32; $x = rand(0,$z), $s .= $a{$x}, $i++);
	    $secret = $s;

	    $username=$_SESSION['username'];
	    $query="INSERT INTO $tableguests (username,secret,lastlogin) VALUES('$username','$secret',NOW())";
	    $result = mysql_query($query) or die("failed to insert into guest database. uid=".$userid . mysql_error());
	    $userid = mysql_insert_id();
	    $_SESSION['userid'] = $userid;
	    $_SESSION['guestlink'] = "http://" . $_SERVER['HTTP_HOST'] . "/erebus/guest.php?key=$secret";
	}

	$w = $formvalue["qwidth"];
	$z = $formvalue["qminweight"];
	if (!is_numeric(trim($z))) $z = "NULL";
	$sa = $formvalue["symatoms"];
	$notify = (int)$formvalue["notifyCompleted"];

	$taskname = $formvalue["taskname"];

	$sql="INSERT INTO submitted (userid,tsubmit,query,w,z,symatoms,notifyCompleted,taskname,taskid)" .
	    "VALUES ($userid, NOW(), \"$newquery\", $w, $z, $sa, $notify, \"$taskname\", UUID() );";
	$res = mysql_query($sql);
	if ($res) {
	    $_SESSION['upload'] = "1";
	} else {
	    $_SESSION['query_error'] = mysql_error();
	}
    }
} else {
    $_SESSION['query_error'] = "Task name is left blank.";
}

foreach ($varlist as $var) {
	if (!isset($_SESSION["save_$var"])){
		$_SESSION["save_$var"] = $formvalue[$var];
	}
}
#}
#$_SESSION['query_error'] = "Sample error message.";
?>
<html>
<head>
<?php echo $server_title; ?>
	<style type="text/css">
      <!--
        @import url(style/erebus.css);
      -->
    </style>
    <script src="style/js/utils.js" language="javascript" type="text/javascript"></script>
    <script language="javascript" type="text/javascript">function onwload() { setbwidth(); } window.addEventListener("load", onwload, false); </script>
</head>

<body>
<div id="main">
	<?php
	    include("head.php")
	?>
    <div id="content">
	<div id="leftColumn">
		<?php include("menu.php");?>
		<?php include("user.php");?>
	</div>
	<div id="middleColumn">
	    <div class="textcontent">
		<?php if (empty($_SESSION['query_error'])): ?>
		    <div class="indexTitle">
			Task submitted <span class=noerror>successfully</span>.
		    </div>
		    <div class=message>
		    Your search task has been successfully submitted and will be processed as soon as previously submitted tasks are finished.<br>
		    <span>Thank you for using <strong>Erebus</strong>.</span>
		    </div>
		    <div class=message>
			<div class="button"><a href="submit.php">Submit another task</a></div>
			<div class="button"><a href="index.php">See recently submitted tasks</a></div>
		    </div>
		<?php else : ?>
		    <div class="indexTitle">
			Error occured.
		    </div>
		    <div class=message><span class=error><?php  echo $_SESSION['query_error']; $_SESSION['query_error']=''; ?></span></div>
		    <div class=message>
		    Due to an unfortunate accident your job has not been submitted. An email about this accident has been sent to the server administrators.
		    We apologize for the inconvinience. You may try to submit another task or go to the start page.
		    </div>
		    <div class=message>
			<div class="button"><a href="submit.php">Submit another task</a></div>
			<div class="button"><a href="index.php">Go to the start page</a></div>
		    </div>
		<?php endif ?>
	    </div>
	</div>
	<div id="rightColumn">
		<?php include("info.php");?>
	</div>
    </div>
</div>
</body>
</html>
