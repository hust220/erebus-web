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
<title> Protein stability prediction server </title>
	<style type="text/css">
      <!--
        @import url(style/ifold.css);
        @import url(style/greybox.css);
      -->
    </style>
    <script src="style/js/greybox.js" language="javascript" type="text/javascript"></script>
    <script src="style/js/ifold.js" language="javascript" type="text/javascript"></script>
    <script src="style/js/ifolderrors.js" language="javascript" type="text/javascript"></script>
    <script src="style/js/query.js" language="javascript" type="text/javascript"></script>
    <script src="style/js/ajex.js" language="javascript" type="text/javascript"></script>
</head>

<body>

<div id="main">
	<div id="header">
		<div style="float:left"><img src="style/img/head.jpg" alt="Eris: protein stability prediction" border="0" /></div>
		<div style="float:left"><img src="style/img/pstability.jpg" alt="Eris: protein stability prediction" border="0" /></div>
		<div style="float:right"><a href="http://dokhlab.unc.edu/main.html"><img src="style/img/dokhlab.jpg" alt="Dokholyan Lab" border="0" /></a></div>
	</div>
	<div id="meta" class="smallfont">
	<?php
		include('meta.php');
	?>
	</div>
	<div id="content">
		<div id="nav">
			<a href="index.php" class="nav"><div class='navi'> Home/Overview </div></a><br/>
			<a href="submit.php" class="nav"><div class='navi'> Submit a Task </div></a><br/>
			<a href="query.php" class="nav"><div class='navi'> Your Activities </div></a><br/>
			<a href="profile.php" class="nav"><div class='navi'> User Profile </div></a><br/>
			<a href="help.php" class="nav"><div class='navi'> Help </div></a><br/>
			<a href="contact.php" class="nav"><div class='navi'> Contact Us</div></a><br/>
			<?php 
			if ($_SESSION['level'] >= 3) { # administration menu
			?>
			<a href="useradmin.php" class="nav"><div class='navi'> <font color='red'> User Admin </font></div></a><br/>
			<a href="jobadmin.php" class="nav"><div class='navi'> <font color='red'> Job Admin </font></div></a><br/>
			<a href="pdbadmin.php" class="nav"><div class='navi'> <font color='red'>PDB Admin </font></div></a><br/>
			<?php 
			}
			?>
		</div>
		
		<div id="main_content">
			<div class="indexTitle"> Overview. </div>
			<div class="indexStatus">
				You recent submissions.
			</div>
<?php
	$userid = $_SESSION['userid'];
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
	$query="SELECT userid,tsubmit,query,options,status,taskname,taskid from $table_submitted";
	myshowsubmitted($query,0,20,"index.php?page");

?>
	<br><br>
			<div class="indexStatus">
				You recent results.
			</div>
<?php
	#---last login time-----
#	$query="SELECT id,pdbid,mutation,flex,relax,ddg,status,message,!ISNULL(pdb)  FROM $tablejobs ".
#	"WHERE created_by='$userid' AND tsubmit >= '$lastlogin' AND status >= '2' and flag = '0' ORDER BY id DESC ";
	$query="SELECT userid,tcomplete,stats,brief,taskname,taskid from $table_completed";
	myshowcompleted($query,0,20,"index.php?page");

?>

   <br>
   <br>
		</div>
		<div id="rightbar">
			<div id="ataglance">
				your infomration at a glance.
			</div>
		</div>
	</div>
</body>
</html>
