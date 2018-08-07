<?php
function emailConfirm($email_address, $link){
global $guesttimeout;
  $eol = "\n"; # for unix
# Boundry for marking the split & Multitype Headers
  $mime_boundary=md5(time());
  
  $headers .= 'From: erebus@unc.edu '.$eol;
  $headers .= 'Reply-To: erebus@unc.edu'.$eol;
  $headers .= "Message-ID: <".$now." TheSystem@".$_SERVER['SERVER_NAME'].">".$eol;
  $headers .= "X-Mailer: PHP v".phpversion().$eol;          // These two to help avoid spam-filters
  $headers .= 'MIME-Version: 1.0'.$eol;
  $headers .= "Content-Type: multipart/related; boundary=\"".$mime_boundary."\"".$eol;

  $mail_subject = "Erebus user email confirmation";
  

  $msg = "";
  $msg .= "--".$mime_boundary.$eol;
  $msg .= "Content-Type: text/html; charset=iso-8859-1".$eol;
  $msg .= "\nThanks for using Erebus!<br/><br/>\n" .
        "\nPlease click on the following link to confirm your email address:<br/>" .
        "\n\n<a href=\"$link\">$link</a><br/><br/>\n\nThanks!\n\n<br/><br/>" . 
	"\nNote: this link will expire after $guesttimeout hours.<br\><br>Erebus Administrators".$eol.$eol;
#Text version
  $msg .= "--".$mime_boundary.$eol;
  $msg .= "Content-Type: text/plain; charset=iso-8859-1".$eol;
  $msg .= "\nThanks for using Erebus!\n" .
        "\nPlease copy and paste the following link to web browser confirm your email address:" .
        "\n\n$link\n\nThanks!\n\nNote: this link will expire after $guesttimeout hours.\n\nErebus Administrators".$eol.$eol;
  mail($email_address, $mail_subject, $msg, $headers);
}  
?>
