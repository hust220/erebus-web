<?php
require('config/config.inc.php');
pagesetup(false);
	session_destroy();
	header("Location: login.php");
?>
