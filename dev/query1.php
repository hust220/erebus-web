<?php

require('config/config.inc.php');

?>
<?php
	if (empty($_SESSION['username'])){
		header("Location: login.php");
	}
?>
<html>
<head>
<?php echo $server_title; ?>
	<style type="text/css">
      <!--
        @import url(style/ifold.css);
      -->
    </style>
    <script src="style/js/greybox.js" language="javascript" type="text/javascript"></script>
    <script src="style/js/query.js" language="javascript" type="text/javascript"></script>
    <script src="style/js/ajex.js" language="javascript" type="text/javascript"></script>
</head>

<body>

<div id="main">
	<?php include("head.php") ?>
	<div id="meta" class="smallfont">
	<?php
		include('meta.php');
	?>
	</div>
	<div id="content">
		<?php include("menu.php");?>
		
		<div id="main_content">
			<div class="indexTitle"> Results </div>
			<div class="indexStatus">
			</div>
<?php
	#---last login time-----
//	$query = "SELECT lastlogin FROM $tableusers WHERE userid='$userid'";
//	$result = mysql_query($query) or die("cannot connect database for user login time");
//	$row = mysql_fetch_array($result);
//	if ($row) {
//		$tlogin = $row['tlogin'];
//	}else{
//		$tlogin = '0000-00-00 00:00:00';
//	}
	if (isset($_SESSION['lastlogin']) ) {
		$lastlogin = $_SESSION['lastlogin'];
	} else {
		$lastlogin = '0000-00-00 00:00:00';
	}
/*	$query="SELECT userid,pdbid,mutation,flex,relax,ddg,status,message FROM $tablejobs ".
	"WHERE created_by='$userid' AND tsubmit >= '$lastlogin' AND status < '2' AND status >= '0' AND flag = '0'".
	" ORDER by id DESC  ";
*/
#	$query="SELECT userid,tsubmit,query,w,z,symatoms,status,taskname,taskid FROM $table_submitted WHERE userid=$userid;";
#	$query="SELECT userid,tsubmit,query,w,z,symatoms,@qr:=@qr+1 AS qrank,taskname,taskid FROM $table_submitted, (SELECT @qr:=0) r WHERE userid=$userid ORDER BY tindex";
#	myshowsubmitted($query,0,20,"index.php?page");

	$userid = $_SESSION['userid'];
	$taskid=$_GET['taskid'];
	$query="SELECT ct,cq,cm,cla,clr,cne,cna,cwt,crmsd,clq,results.taskid,resid FROM results JOIN completed " .
	    "ON (results.taskid=completed.taskid AND completed.userid=$userid AND results.taskid=\"$taskid\") ORDER BY crmsd LIMIT 20;";
#	echo $query;
	myshowresults($query,0,20,"query.php?page");
	mysql_close();
?>
		</div>


	</div>
</div>
</body>
</html>
