<?php
require('config/config.inc.php');
pagesetup(true);

$key=$_GET['key'];

$ip=$_SERVER['REMOTE_ADDR'];

if (!$key) {
	header("Location: login.php");
}

if ( $key ) {
	$error = array();
	if ( ! eregi('[^0-9a-zA-Z_.]',$key)) {
	    $query = "SELECT userid,username,email,lastlogin FROM $tableguests WHERE secret='$key'; ";
	    $result = mysql_query($query) or die("user database connection failed.");
	    $row = mysql_fetch_array($result);
	    $valid_login = mysql_num_rows($result);
	}
	if ($valid_login == 0) {
		$error['login'] = 'The supplied access key was incorrect.<br />';
	} else {
	}
	if (count($error) == 0){
		#---------delete the session informations and set new ones----------#
#		session_unset();
		session_destroy();
		session_name($erebus_session);
		session_start();
#		unset($_SESSION['error_login']);
		$_SESSION['username'] = $row['username'];
		$_SESSION['userid'] = $row['userid'];
		$_SESSION['lastlogin'] = $row['lastlogin'];
		$_SESSION['level'] = 0;
		$_SESSION['guestlink'] = "http://" . $_SERVER['HTTP_HOST'] . "/erebus/guest.php?key=$key";
		$userid = $row['userid'];
		#-------set the login time---------------#
		$query = "UPDATE $tableguests SET lastlogin =NOW()  WHERE userid = '$userid' ";
		mysql_query($query) or die("cannot access user database");
		
		header("Location: index.php");
	}else{
		$_SESSION['error_login'] = $error['login'];
		header("Location: login.php");
	}
}

?>
<html>
<?php echo $server_title; ?>
<body>

</body>
</html>
