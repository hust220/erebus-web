<?php
require('config/config.inc.php');
pagesetup(true);
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
        @import url(style/erebus.css);
      -->
    </style>
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
		<div class="indexTitle"> Update Profile Information. </div>

		Please fill in the new user information and submit.
		<br/>
		<br/>

		<?php
			$varlist=array('firstname','lastname','email','organization','notifyCompleted');
			if (!isset($_SESSION['loginerror'])) { #first visit to the page
				$userid = $_SESSION['userid'];
				$query = "SELECT username,firstname,lastname,email,organization,notifyCompleted ".
				" FROM $tableusers WHERE userid='$userid' LIMIT 1";
				$result = mysql_query($query) or die("cannot connet to database");
				$row = mysql_fetch_array($result);
				foreach ($varlist as $var) {
					$_SESSION["save_$var"] = $row[$var];
				}
			}
			
		?>
		<?php  if ($_SESSION['loginerror'] != '0') {  ?>
		
			<div class=subformblock>
			<form action="profile_check.php" method="post" >
				<table id="frmRegister" border="0" cellpadding="0" cellspacing="0" width="80%">
					<tr>
						<td width='150px'>Username:</td>
						<td><input id="username" type="text" name="username" maxlength="10" disabled
						value="<?php  print($_SESSION['username']); ?>"/></td>
					</tr>
					<?php  if (isset($_SESSION["error_username"])) {echo("<tr><td></td>");myerror('username');echo("</tr>"); } ?>
						<td>First Name:</td>
						<td><input id="firstname" type="text" name="firstname"  maxlength="15" value="<?php myform("firstname")?>" /></td>
					</tr>
					<?php  if (isset($_SESSION["error_firstname"])) {echo("<tr><td></td>");myerror('firstname');echo("</tr>"); } ?>
					<tr>
						<td>Last Name:</td>
						<td><input id="lastname" type="text" name="lastname"  maxlength="15" value="<?php myform("lastname")?>" /></td>
					</tr>
					<?php  if (isset($_SESSION["error_lastname"])) {echo("<tr><td></td>");myerror('lastname');echo("</tr>"); } ?>
					<tr>
						<td>Email:</td>
						<td><input id="email" type="text" name="email" maxlength="100"  value="<?php myform("email")?>" /></td>
					</tr>
					<?php  if (isset($_SESSION["error_email"])) {echo("<tr><td></td>");myerror('email');echo("</tr>"); } ?>
					<tr>
						<td>Organization:</td>
						<td><input id="organization" type="text" name="organization" maxlength="20"  value="<?php myform("organization")?>" /></td>
					</tr>
					<?php  if (isset($_SESSION["error_organization"])) {echo("<tr><td></td>");myerror('organization');echo("</tr>"); } ?>
					<tr><td></td></tr>
					<tr>
						<td colspan=2><label for=notifyCompleted>Always notify me upon task completion:</label>
						<input id="notifyCompleted" type="checkbox" name="notifyCompleted" value="1" "<?php myformbtn("notifyCompleted")?>" />
						</td>
					</tr>
					<?php  if (isset($_SESSION["error_notifyCompleted"])) {echo("<tr><td></td>");myerror('Task notification');echo("</tr>"); } ?>
					<tr><td></td></tr>
					<tr> <td></td>
						<td colspan="1" align="left"><input type="Submit"  value="Update" class=subbtn style="margin-bottom:1em";/></td>
					</tr>
					</table>


			</form>
		<?php  unset($_SESSION['loginerror']);
		} ?>
			<?php  if ($_SESSION['loginerror'] == '0' ) { #successful update 
				unset ($_SESSION['loginerror']);
			?>	
					<p>
					<font color="green">	User information updated  successfully! </font>
					<?php  if ($_SESSION['emailconfirm'] == '1') { 
						unset($_SESSION['emailconfirm']);
					?>
						<br>
						<font color="red">Email address needs to be confirmed. </font>
					<?php  } ?>
			
			<?php   } ?>
			</div>
			<div class="indexTitle" style="border:0px"> Change Password. </div>
			<div class=subformblock>
			<form action="password_check.php" method="post" >
				<table id="frmRegister" border="0" cellpadding="0" cellspacing="0" width="80%">
					<tr>
						<td width='150px'>Old password:</td>
						<td><input id="oldpassword" type="password" name="oldpassword" maxlength="15" /></td>
					</tr>
					<?php  if (isset($_SESSION["error_oldpassword"])) {echo("<tr><td></td>");myerror('oldpassword');echo("</tr>"); } ?>
					<tr>
						<td>New Password:</td>
						<td><input id="newpassword" type="password" name="newpassword" maxlength="15" /></td>
					</tr>
					<?php  if (isset($_SESSION["error_newpassword"])) {echo("<tr><td></td>");myerror('newpassword');echo("</tr>"); } ?>
	
					<tr>
						<td>Confirm New Pass:</td>
						<td><input id="confirm_pass" type="password" name="confirm_pass" maxlength="15" /></td>
					</tr>
					<?php  if (isset($_SESSION["error_confirm_pass"])) {echo("<tr><td></td>");myerror('confirm_pass');echo("</tr>"); } ?>
					<tr><td></td></tr>
					<tr> <td></td>
						<td colspan="1" align="left"><input type="Submit"  value="Change Password" class=subbtn style="margin-bottom:1em"; /></td>
					</tr>
					</table>


			</form>

			<?php  if ($_SESSION['changepasserror'] == '0' ) { #successful login 
				unset ($_SESSION['changepasserror']);
			?>	
					<p>
					<font color="green">Password changed successfully! </font>

			
			<?php   } ?>
	
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
