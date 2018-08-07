<?php
require('config/config.inc.php');
pagesetup(true);

if (empty($_SESSION['username'])){
	header("Location: login.php");
	die("");
}

$userid = $_SESSION['userid'];
$taskid=$_GET['taskid'];
?>
<html>
<head>
<?php echo $server_title; ?>
	<style type="text/css">
      <!--
        @import url(style/erebus.css);
        @import url(style/pm.css);
      -->
    </style>
    <script src="style/js/utils.js" language="javascript" type="text/javascript"></script>
    <script src="style/js/query.js" language="javascript" type="text/javascript"></script>
    <script language="javascript" type="text/javascript">function onwload() { setbwidth(); document.getElementById("submitbtn").style.display="none"; } window.addEventListener("load", onwload, false); </script>
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
		<div class="indexTitle">
		    Search results
		</div>

<?php
    $query="SELECT tcomplete,taskname,taskid from $table_completed WHERE userid=$userid;";
    $result = mysql_query($query);
    $nrow = 0;
    if ($result) {
	$nrow = mysql_num_rows($result);
	if ($nrow > 0) {
	    $allrows = array();
	    $maxlen = 0;
	    while ( $row = mysql_fetch_array($result)) {
		$allrows[] = array($row['taskid'], $row['tcomplete'], $row['taskname']);
		$len = strlen($row['taskname']);
		if ($len > $maxlen) $maxlen = $len;
	    }
	    echo "<form mathod=get action=\"\">
	    <span class=info>Select one of your saved tasks to retrieve the results.<br>You have total of <strong>$nrow</strong> saved tasks.</span>
	    <label for=\"taskid\" class=\"formLabel\">Select task results to display: </label>
	    <select id=\"taskid\" name=\"taskid\" onchange=\"javascript:this.form.submit();\">";
	    foreach ($allrows as $row) {
		$selected = ($row[0] == $taskid) ? " selected=\"selected\"" : "";
		$taskname = $row[2] . str_repeat("&nbsp;", $maxlen - strlen($row[2]) + 5);
		$timefmt = date("g:i a F j, Y ", strtotime($row[1]));
		echo "\n<option$selected value=\"" . $row[0] . "\">$taskname&nbsp;$timefmt</option>";
	    }
	    if (empty($taskid)) $taskid = $allrows[0][0];
	    unset($allrows);
	    echo "\n</select><input type=\"submit\" id=\"submitbtn\" value=\"Display\" class=\"subbtn\"></form>";
	} else {
	    echo "<span class=\"formLabel\">There are currently no finished tasks.</span>";
	}
    }
?>
		<div class="subformblock">
<?php
	$query="SELECT ct,cq,cm,cla,clr,cne,cna,cwt,crmsd,clq,results.taskid,resid FROM results JOIN completed " .
	    "ON (results.taskid=completed.taskid AND completed.userid=$userid AND results.taskid=\"$taskid\") ORDER BY crmsd;";
#	echo $query;
	if ($nrow > 0) {
	    $nres = myshowresults($query,0,20,"query.php?page");
	    echo "<span class=info>This table lists all matches found for your query in the Protein Data Bank.<br>
	    Click one of the links in the rightmost column to download results in the format of your choice.<br><br>
	    There are total of $nres matches for this query.";
	    if ($nres >= 10000) echo "<br><br><strong>Note</strong>, that your query produced too many results and the
	    search was stopped after the first 10000 matches. These may not be the best matches.<br>
	    You may try to make your search crteria more stringent and re-run the <strong>Erebus</strong>.";
	    echo "</span>";
	}
?>
		</div>
	    </div>
	</div>
	<div id="rightColumn">
		<?php include("info.php");?>
	</div>
    </div>
</div>
</body>
</html>
