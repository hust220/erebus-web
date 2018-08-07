<?php

$servername = "localhost";
$username = "erebus_svc";
$password = "third-S3cr3t";
$dbname = "erebus";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully<br>";

$username = 'jianopt';
$password = md5('Kang1994$');
$email = 'jianopt@ad.unc.edu';
$level = 10;
$approved = 1;
$emailConfirmed = 1;
$sql = "insert into users(username, password, email, level, emailApproved, emailConfirmed) values('$username', '$password', '$email', $level, $approved, $emailConfirmed)";
$conn->query($sql);

$conn->close();

