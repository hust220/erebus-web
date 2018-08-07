<?php
function myerror($str){
	$errormessage = $_SESSION["error_$str"];
	echo "<td> <font color='red'> $errormessage </font> </td>";
	unset($_SESSION["error_$str"]);
}
function myform($str){
	$message = $_SESSION["save_$str"];
	echo "$message";
	unset($_SESSION["save_$str"]);
}
function formval($str){
	$message = $_SESSION["save_$str"];
//	unset($_SESSION["save_$str"]);
	echo "value=\"$message\"";
}
function myformbtn($str){
	$message = $_SESSION["save_$str"];
	if ((int)$message != 0) echo "checked";
//	unset($_SESSION["save_$str"]);
}
?>
