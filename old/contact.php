<?php
require('config/config.inc.php');
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
  $query = "SELECT email,firstname,namelast FROM $tableusers WHERE username='$name'";
  $result = mysql_query($query);
  $row = mysql_fetch_array($result);
  $useremail = $row['email'];
  $firstname = $row['firstname'];
  $lastname = $row['lastname'];

  $username = $_SESSION['username'];
  $mail_message.="\r\nfrom:".$username; 
  $mail_headers = "From:eris server\r\nReply-To:\"$firstname $lastname\" <$useremail>\r\nX-Mailer: eris PHP script" . phpversion ();
#  mail("shir@email.unc.edu,syin@unc.edu,dokh@med.unc.edu", $mail_subject, $mail_message, $mail_headers);
  mail("shir@email.unc.edu", $mail_subject, $mail_message, $mail_headers);
  
  header("Location: contact_confirm.php");
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
    <style>
    </style>
</head>

<body>
<div id="main">
	<div id="header">
		<div style="float:left"><img src="style/img/head.jpg" alt="Eris" border="0" /></div>
		<div style="float:left"><img src="style/img/pstability.jpg" alt="protein stability prediction" border="0" /></div>
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
		</div>
		
		<div id="main_content">

<div class="indexTitle" id="step"> Questions and comments </div>
<form action="contact.php" method="post">
	subject: <input type="text" name="subject" style="width:400"> <br>
	 <br>
	<textarea name="body" rows="12" cols="80" style="width:500;height:200"> </textarea> <br>
	<br>
	<input type="submit" value="send"> &nbsp;

</form>
		</div>

		<div id="rightbar">
			<div id="ataglance">
				your infomration at a glance.
			</div>
		</div>

	</div>
</div>
</body>
</html>
