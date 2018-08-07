<?php
    require('config/config.inc.php');
    pagesetup(true);

    if (empty($_SESSION['username'])){
	header("Location: login.php");
	die("");
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<?php echo $server_title; ?>
    <style type="text/css">
    <!--
        @import url(style/erebus.css);
    -->
    </style>
    <script src="style/js/ajex.js" language="javascript" type="text/javascript"></script>
    <script src="style/js/animatediv.js" language="javascript" type="text/javascript"></script>
    <script src="style/js/query.js" language="javascript" type="text/javascript"></script>
    <script src="style/js/utils.js" language="javascript" type="text/javascript"></script>
    <script language="javascript" type="text/javascript">function onwload() { setbwidth(); document.getElementById("footer").style.display="none"; } window.addEventListener("load", onwload, false); </script>
    <script src="style/js/sortable.js" language="javascript" type="text/javascript"></script>
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
	    <div style="padding-bottom:2em;">
		<div class="indexTitle">
			Completed tasks
		</div>
<?php
	$userid = $_SESSION['userid'];
	#---last login time-----

	if (isset($_SESSION['lastlogin']) ) {
		$lastlogin = $_SESSION['lastlogin'];
	} else {
		$lastlogin = '0000-00-00 00:00:00';
	}

	$query="SELECT userid,tsubmit,tcomplete,query,w,z,symatoms,brief,stats,taskname,taskid from $table_completed WHERE userid=$userid;";
	$nrow = myshowcompleted($query,0,20,"index.php?page");

?>
	<span class=info>This table shows up to 20 most recently completed tasks.
		<br class=space>Go to the <a href=query.php>Results</a> page to see the full list of your search results.<br class=space>
		You have total of <strong><?php echo $nrow?></strong> completed searches.
		<?php  if ($nrow) {echo "<h2>Control symbols</h2>$docstrtaskctrl";}?>
	</span></div>
	    <div>
		<div class="indexTitle">
			Submitted tasks
		</div>
<?php
#	$query="SELECT userid,tsubmit,query,w,z,symatoms,@qr:=@qr+1 AS qrank,taskname,taskid FROM $table_submitted, (SELECT @qr:=0) r WHERE userid=$userid ORDER BY tindex";
	$query="SELECT * FROM (SELECT userid,tsubmit,query,w,z,symatoms,@qr:=@qr+1 AS qrank,taskname,taskid FROM submitted, (SELECT @qr:=0) r ORDER BY tindex) q WHERE userid=$userid;";
	$nrow = myshowsubmitted($query,0,20,"index.php?page");

	mysql_close();
?>
	<span class=info>This table shows your search tasks that have been scheduled for execution on Erebus server.
	    <br class=space>Currently you have <?php echo $nrow ? "total of <strong>$nrow" : "<strong>no"; ?></strong> pending search tasks.</span>

	    </div>
	    <div  id="footer">
	    <table border=0>
	    <tr><th style="padding-right:3em;">&nbsp;</th><th style="border-bottom-width:1;border-bottom-style:dotted;">Abbreviations:</th></tr>
	    <tr><td>&sigma;</td><td> Average permitted deviation of an atom pair distance from a corresponding distance in the query structure.</td></tr>
	    <tr><td>W<sub>min</sub></td><td> Minimum weight of the substructure to include into search.</td></tr>
	    <tr><td>S.A.</td><td>Treat symmetric atoms as identical.</td></tr>
	    </table>
	<?php 
	    echo $docstrtaskctrl;
	?>
	    </div>
	<?php 
#	<div class='navi infobox'>
#	    <span id="infodebug"></span>
#	</div>
	?>
	</div>
	</div>
	<div id="rightColumn">
		<?php include("info.php");?>
	</div>
    </div>
</div>
</body>
</html>
