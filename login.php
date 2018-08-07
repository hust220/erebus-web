<?php
/********************************************************************
*********************************************************************/
require('config/config.inc.php');
pagesetup(false);
?>
<?php
//  $filename = 'logasdf';
//  $content = $_SERVER['REMOTE_HOST']." ".$_SERVER['REMOTE_ADDR']." ".date(DATE_RFC822)." ". $_SERVER['HTTP_USER_AGENT']."\n";
//  if (is_writable($filename)) {
//    if ($handle = fopen($filename, 'a')) {
//      fwrite($handle, $content);
//      fclose($handle);
//    }
//  }
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
    <script src="style/js/animatediv.js" language="javascript" type="text/javascript"></script>
    <script src="style/js/utils.js" language="javascript" type="text/javascript"></script>
    <script language="javascript" type="text/javascript">function onwload() { hidesignup(); setbwidth(); } window.onload=onwload;</script>
</head>

<body>
<div id="main">
	<?php include("head.php"); ?>
	<div id="leftColumn">
	<?php include("menu.php"); ?>
	<?php include("user.php"); ?>
	</div>

	<div id="middleColumn" class="loginpage" >
		<div class="textcontent">
			Welcome to <b>Erebus</b> server.<br> Please use your username and password to login or sign up
			a new account.
		<p class=space style="border-top-width:1px;border-top-style:dotted;padding-top:2em;">
		    <img src="style/img/i1_3.png" style="float:right;margin-left:15px;">
		<b>Erebus</b>, which takes the name of omnipresent Greek god of darkness and shadow, is a protein substructure search server.
		</p>
		<p class=space>
		<b>Erebus</b> searches the entire Protein Data Bank of known protein crystal structures for a substructure
		    specified by the list of atoms and their positions.
		</p>

		<div class=space>&nbsp;</div>
		<b>Erebus</b> produces the list of proteins containing the best matching substructures. The substructures
		may represent various conserved elements, such as metal ion scaffolds or small molecule binding pockets.

		<p class=space >
		Please read the following <a href="terms.html"> terms and conditions </a> of using Erebus server. Please contact erebus[put @ here]unc.edu for technical supports and comments.
		</p>
		<p class=space >
		If <b>Erebus</b> server has been useful to you in your research please
		cite it as <cite>Shirvanyants D, Alexandrova AN, Dokholyan NV, <em>Rigid substructure search.</em> Bioinformatics. (2011) 27(9):1327-9. doi: 10.1093/bioinformatics/btr129</cite>
		</p>
		</div>
	</div>

	<div id="rightColumn">
	    <div class="formBlock">
	    <?php 
		if (!empty($_SESSION['error_login'])){
#		echo '<div style="display: block;" class="errors_box" id="errors_login">'.
#		$_SESSION['error_login'].
#		'</div>	';
		echo '<span class="error">' . $_SESSION['error_login'] . '</span>';
		$_SESSION['error_login'] = "";
    		}
	    ?>

	    <form id="formLogin" method="post" action="login_check.php">
	    <div class="formSection">
	    <label for="user">Username </label>
	    <input id="user" type="text" name="user" class="text_field" style="float:right;"/>
	    </div>
	    <div class="formSection">
	    <label for="pass">Password </label>
	    <input id="pass" type="password" name="pass" class="text_field" style="float:right;"/>
	    </div>

	    <div class="formSection">
	    <input type="submit" value="Log in" id="submitbtn"  class=subbtn style="width:100%;">
	    </div>
	    <div class="formSection">
	    <input type="button" value="Log in as Guest" id="guestloginbtn"  class="subbtn" style="width:100%;" onClick="javascript:guestlogin(this);" />
	    </div>
	    </form>
	    </div>

	    <div class="formBlock" style="padding-top:0px;">
	        <div style="font:bold;margin-top:0.5em;">
		    <a href="#" onClick="javascript:toggleDiv('registerForm');" class=navlink id=linksignin> New account </a>
		</div>
		<div id="registerForm" style="overflow:hidden;visibility:hidden;">
		    <form action="register.php" method="post">
			<div class="formSection">
			<label for="username" class="btext"> Username: </label>
			<input id="username" type="text" name="username" maxlength="10" value="<?php myform("username")?>" class="text_field"/>
				<?php  if (isset($_SESSION["error_username"])) {echo("   ");myerror("username");echo(" "); } ?>
			</div>
			<div class="formSection">
			<label for="password" class="btext"> Password: </label>
				 <input id="password" type="password" name="password" maxlength="15" class="text_field" />
				<?php  if (isset($_SESSION["error_password"])) {echo("   ");myerror('password');echo(" "); } ?>
			</div>
			<div class="formSection">
			<label for="confirm_pass" class="btext"> Confirm Password: </label>
				 <input id="confirm_pass" type="password" name="confirm_pass" maxlength="15" class="text_field" /> 
				<?php  if (isset($_SESSION["error_confirm_pass"])) {echo("   ");myerror('confirm_pass');echo(" "); } ?>
			</div>
			<div class="formSection">
			<label for="firstname" class="btext"> First Name: </label>
				 <input id="firstname" type="text" name="firstname"  maxlength="15" value="<?php myform("firstname")?>" class="text_field" /> 
				<?php  if (isset($_SESSION["error_firstname"])) {echo("   ");myerror('firstname');echo(" "); } ?>
			</div>
			<div class="formSection">
			<label for="lastname"class="btext"> Last Name: </label>
				 <input id="lastname" type="text" name="lastname"  maxlength="15" value="<?php myform("lastname")?>" class="text_field"/>
				<?php  if (isset($_SESSION["error_lastname"])) {echo("   ");myerror('lastname');echo(" "); } ?>
			</div>
			<div class="formSection">
			<label for="email" class="btext"> Email address: </label>
				 <input id="email" type="text" name="email" maxlength="100"  value="<?php myform("email")?>" class="text_field" /> 
				<?php  if (isset($_SESSION["error_email"])) {echo("   ");myerror('email');echo(" "); } ?>
			</div>
			<div class="formSection">
			<label for="organization" class="btext"> Organization: </label>
				<input id="organization" type="text" name="organization" maxlength="20"  value="<?php myform("organization")?>" class="text_field" /> 
				<?php  if (isset($_SESSION["error_organization"])) {echo("   ");myerror('organization');echo(" "); } ?>

			</div>
			<div class="formSection">
			<input type="Submit" onClick="return validateRegister();" value="Register an Account" class=subbtn style="width:150px"/> 
			</div>
			</form>
		    </div>
		</div>
	    </div>
	</div>

</body>
</html>
