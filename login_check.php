<?php
require('config/config.inc.php');
pagesetup(true);

$user=$_POST['user'];
$pass=$_POST['pass'];

$ip=$_SERVER['REMOTE_ADDR'];

if (!$user) {
	$_SESSION['error_login'] = $error['login'];
	header("Location: login.php");
}

if ( $user ) {
    if ($pass && strcasecmp($user, "guest")) {
	$error = array();

	if (  eregi('[^0-9a-zA-Z_.]',$user)) {
#	die("Invalid userid\n");
	    $valid_login = 0;
	} else {
	    $passmd5 = md5($pass);	
	    $query = "SELECT userid,username,emailApproved,lastlogin,level,notifyCompleted FROM $tableusers WHERE username='$user' AND password='$passmd5' ";
	    $result = mysql_query($query) or die("user database connection failed.");
	    $row = mysql_fetch_array($result);
	    $valid_login = mysql_num_rows($result);
	}
	if ($valid_login == 0) {
		$error['login'] = 'The supplied username and/or password was incorrect.<br />';
	} else {
		if ($row['emailApproved'] == '0') {
			$error['login']= 'This user account has not been emailApproved. Please try again later<br />';
		}
		if ($row['emailApproved'] == '2') {
			$error['login']= 'This user account has been suspended. Please contact us for any questions<br />';
		}
		if ($row['emailApproved'] == '3') {
			$error['login']= 'Registration of this user account has been rejected. Please register again<br />';
		}
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
		$_SESSION['level'] = $row['level'];
		$_SESSION['save_notifyCompleted'] = $row['notifyCompleted'];
		$userid = $row['userid'];
		#-------set the login time---------------#
		$query = "UPDATE $tableusers SET lastlogin =NOW()  WHERE userid = '$userid' ";
		mysql_query($query) or die("cannot access user database");
		
		header("Location: index.php");
	}else{
		$_SESSION['error_login'] = $error['login'];
		header("Location: login.php");
	}
    } else { /* guest login */
	$username="guest";
	$pass="";
	$level=0;

#	$query="INSERT INTO $tableguests (username,email,secret,lastlogin) VALUES('$username','$secret',NOW())";
#	$result = mysql_query($query) or die("failed to insert into guest database");
#	$id = mysql_insert_id();

	session_name($erebus_session);
	session_start();
	$_SESSION['username'] = $username;
	$_SESSION['userid'] = -1;
	$_SESSION['lastlogin'] = date("D M j G:i:s T Y");
	$_SESSION['level'] = 0;
	header("Location: index.php");
    }
}

?>
<html>
<?php echo $server_title; ?>
<body>

</body>
</html>
