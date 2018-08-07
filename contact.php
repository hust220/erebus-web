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
if ($_POST['subject'] && $_POST['body']){

  $mail_subject=$_POST['subject'];
  $mail_message=$_POST['body'];
  $name = ($_SESSION['username']);
  $query = "SELECT email,firstname,lastname FROM $tableusers WHERE username='$name'";
  $result = mysql_query($query);
  $row = mysql_fetch_array($result);
  $useremail = $row['email'];
  $firstname = $row['firstname'];
  $lastname = $row['lastname'];

  $username = $_SESSION['username'];
  $mail_message.="\r\nfrom:".$username; 
  $mail_headers = "From:Erebus server\r\nReply-To:\"$firstname $lastname\" <$useremail>\r\nX-Mailer: erebus PHP script" . phpversion ();
#  mail("shir@email.unc.edu,syin@unc.edu,dokh@med.unc.edu", $mail_subject, $mail_message, $mail_headers);
  mail("rbjacob@email.unc.edu,dokh@med.unc.edu", $mail_subject, $mail_message, $mail_headers);
  
  header("Location: contact_confirm.php");
}
?>


<html>
<head>
<?php echo $server_title; ?>
	<style type="text/css">
      <!--
        @import url(style/erebus.css);
      -->
    </style>
    <style>
    </style>
</head>

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

	    <div class="indexTitle" id="step"> Questions and comments </div>
	    <div class="subformblock">
		<form action="contact.php" method="post">
		    Subject: <input type="text" name="subject" style="width:400"> <br>
		 <br>
		<textarea name="body" rows="12" cols="80" style="width:500;height:200"> </textarea> <br>
		<br>
		<input type="submit" class=subbtn value="send"> &nbsp;

	    </form>
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
