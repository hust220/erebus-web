<?php

require('config/config.inc.php');

?>
<?php
	if (empty($_SESSION['username'])){
		header("Location: login.php");
	}
	if ($_SESSION['level'] < 3){
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
    <script src="style/js/useradmin.js" language="javascript" type="text/javascript"></script>
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
			<a href="useradmin.php" class="nav"><div class='navi'> <font color='red'> User Admin </font></div></a><br/>
			<a href="jobadmin.php" class="nav"><div class='navi'> <font color='red'> Job Admin </font></div></a><br/>
			<a href="pdbadmin.php" class="nav"><div class='navi'> <font color='red'>PDB Admin </font></div></a><br/>
		</div>
		
		<div id="main_content">
			<div class="indexTitle"> User Administration. </div>
			<div class="indexStatus">
				You recent submissions.
			</div>
			<div id='useradmin_table' name='useradmin_table'> 
<?php
$page=0;
$nlimit = 50;
$page = $_GET['page'];
if (preg_match('/[^0-9]/',$page)) { 
  $page = 0;
}
$offset = $page*$nlimit;

$sortorder= $_GET['sortorder'];
if (! isset($sortorder) || $sortorder != "ASC"){
  $sortorder = "DESC";
  $orderswitch = "ASC";
} else {
  $sortorder = "ASC";
  $orderswitch = "DESC";
}

$sortcol = $_GET['sortcol'];
if (! isset($sortcol)) {
  $sortcol = "id";
}
#may put some filter later $sortstr = "id";
$options = "";
$options[$sortcol] = $orderswitch;

$userid = $_SESSION['userid'];
$query="SELECT userid,created_on,username,firstname,lastname,organization,email,".
"emailConfirmed, emailApproved,level,".
"lastlogin, numtasks FROM $tableusers ".
"ORDER by $sortcol $sortorder  ";
require_once('config/admin/useradmintable.inc.php');
useradmintablesort($query,$page,$nlimit,"useradmin.php?sortorder=$sortorder&sortcol=$sortcol",$options);	
?>
			<div id='useradmin_bar' name='useradmin_bar'> 
			</div>
			</div>
	
	<br><br>


		</div>
		<div id="rightbar">
			<div id="ataglance">
				your infomration at a glance.
			</div>
		</div>
	</div>
</body>
</html>