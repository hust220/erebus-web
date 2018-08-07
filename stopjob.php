<?php
require('config/config.inc.php');
pagesetup(true);

if (empty($_SESSION['username'])){
	header("Location: login.php");
	die("");
}

$newquery='';

#if (0) {
if (!empty($_REQUEST['stoptaskid']))
{




} else {


}

if (empty($newquery)) {
    $_SESSION['query_error'] = "Error occured while submitting the task. Query structure can not be read. Please try again.";
    header("Location: submit.php");
    die("");
}


#stop the task

$_SESSION['stoptask'] = "";
$_SESSION['query_error'] = '';

if (isset($_REQUEST['taskname']))
{


} else {
    $_SESSION['query_error'] = "Undefined task.";
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
