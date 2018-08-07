<?php
function emailNotification($email_address,$text){
# $link = "http://eris.dokhlab.org/";
  $link = "http://redshift.med.unc.edu/erebus/";
  $eol = "\n"; # for unix
# Boundry for marking the split & Multitype Headers
  $mime_boundary=md5(time());
  
  $headers .= 'From: Erebus: protein substructure search server '.$eol;
  $headers .= 'Reply-To: erebus@unc.edu'.$eol;
  $headers .= "Message-ID: <".$now." TheSystem@".$_SERVER['SERVER_NAME'].">".$eol;
  $headers .= "X-Mailer: PHP v".phpversion().$eol;          // These two to help avoid spam-filters
  $headers .= 'MIME-Version: 1.0'.$eol;
  $headers .= "Content-Type: multipart/related; boundary=\"".$mime_boundary."\"".$eol;

  $mail_subject = "Erebus task notification";
  

  $msg = "";
  $msg .= "--".$mime_boundary.$eol;
  $msg .= "Content-Type: text/html; charset=iso-8859-1".$eol;
  $msg .= "\nThanks for using Erebus!<br/><br/>\n" .
  	"One of your recently tasks has finished.<br/>\n".
	$text .
        "<br/>\nPlease login to Erebus server to check the results:<br/>" .
        "\n\n<a href=\"$link\">$link</a><br/><br/>\n\nThanks!\n\n<br/><br/>Erebus Administrators".$eol.$eol;
#Text version
  $msg .= "--".$mime_boundary.$eol;
  $msg .= "Content-Type: text/plain; charset=iso-8859-1".$eol;
  $msg .= "\nThanks for using Erebus!\n One of your recent jobs has finished.\n" .
	$text .
        "\nPlease login to Erebus server to check the results:" .
        "\n\n$link\n\nThanks!\n\nEris Administrators".$eol.$eol;
  
  if (mail($email_address, $mail_subject, $msg, $headers)) {
    echo $headers . "\n" . $msg;
    echo "<br>To:".$email_address.":";
  }
} 

function emailNotification1($email_address,$link,$jobid,$guestFlag){
	if(empty($link)) {
		$link = "http://chiron.dokhlab.org/";
	}
	$eol = "\r\n"; # for unix
# Boundary for marking the split & Multitype Headers
	$mime_boundary=md5(date('r',time()));

	$send_to  = $email_address;
	$send_from= "chiron@dokhlab.org";
	$reply_to = "no-reply@email-notification";
	$subject  = "Chiron job status notification";
		
	$headers .= 'From: '.$send_from.$eol;
	$headers .= 'Reply-To: '.$reply_to.$eol;
	$headers .= "Message-ID: <".$now." TheSystem@".$_SERVER['SERVER_NAME'].">".$eol;
	$headers .= "X-Mailer: PHP v".phpversion().$eol;          // These two to help avoid spam-filters
	$headers .= 'MIME-Version: 1.0'.$eol;
	$headers .= "Content-Type: multipart/related; boundary=\"".$mime_boundary."\"".$eol;
	ob_start(); //Turn on output buffering

	$msg = "";
#HTML version
	/*$msg .= "--".$mime_boundary.$eol;
	$msg .= 'Content-Type: "text/html"; charset="iso-8859-1"'.$eol;
	$msg .= "\nThanks for using Chiron!<br><br>\n" .
		"Your job - $jobid - has been processed.\n".
		"Please click the following link to check the results:<br>" .
		"\n\n<a href=\"$link\">$link</a><br><br>\n\ncheers!\n\n<br><br>Chiron Administrators".$eol.$eol;*/
#Text version
	$msg .= "--".$mime_boundary.$eol;
	$msg .= "Content-Type: text/plain; charset=iso-8859-1".$eol;
	$msg .= "\nThanks for using Chiron!\n" .
		"Your job - $jobid - has been processed.\n".
		"Please click the link below or copy and paste the address in a web browser to retrieve results.\n".
		"Address : $link\n\ncheers!\n\nChiron Administrators\n\n";
	if(!empty($guestFlag)) {
		$msg .= "WARNING : Please retrieve your results in the next 48 hours. Your job will be lost after 48 hours.\n\n";
	}
	$msg .=	"NOTE : This e-mail is automatically generated. Replies to this e-mail do not reach the administrator. Use the contact page on the http://chiron.dokhlab.org to contact the administrators.".$eol.$eol;
	$msg .= "--".$mime_boundary.$eol;
	
	$mail_sent = @mail($send_to, $subject, $msg, $headers);
}  

function emailConfirm($email_address, $link) {
  $eol = "\n"; # for unix
# Boundry for marking the split & Multitype Headers
  $mime_boundary=md5(time());
  
  $headers .= 'From: Chiron - Rapid Protein Energy Minimization Server '.$eol;
  $headers .= 'Reply-To: no-reply@email-notification'.$eol;
  $headers .= "Message-ID: <".$now." TheSystem@".$_SERVER['SERVER_NAME'].">".$eol;
  $headers .= "X-Mailer: PHP v".phpversion().$eol;          // These two to help avoid spam-filters
  $headers .= 'MIME-Version: 1.0'.$eol;
  $headers .= "Content-Type: multipart/related; boundary=\"".$mime_boundary."\"".$eol;

  $mail_subject = "Chiron user email confirmation";
  

  $msg = "";
  $msg .= "--".$mime_boundary.$eol;
  $msg .= "Content-Type: text/html; charset=iso-8859-1".$eol;
  $msg .= "\nThanks for using Chiron!<br/><br/>\n" .
        "\nPlease click on the following link to confirm your email address:<br/>" .
        "\n\n<a href=\"$link\">$link</a><br/><br/>\n\nThanks!\n\n<br/><br/>Chiron Administrators".$eol.$eol;
#Text version
  $msg .= "--".$mime_boundary.$eol;
  $msg .= "Content-Type: text/plain; charset=iso-8859-1".$eol;
  $msg .= "\nThanks for using Chiron!\n" .
        "\nPlease copy and paste the following link to web browser confirm your email address:" .
        "\n\n$link\n\nThanks!\n\nChiron Administrators".$eol.$eol;
  mail($email_address, $mail_subject, $msg, $headers);
}
 
?>

