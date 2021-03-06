<?php
function secure_smtp_mail($to, $subject, $content, $attach=false)
{
  global $error;

  require_once('/home/trigger/php/smtp_config.php');                  // config file
  require_once('/home/trigger/php/phpmailer/class.phpmailer.php');    // PHPMailer class path
  $mail = new PHPMailer();                          // new instance
 
  $mail->IsSMTP();                                  // enable SMTP instance

  $mail->Host       = $__smtp['host'];
  $mail->SMTPDebug  = $__smtp['debug'];
  $mail->SMTPAuth   = $__smtp['auth'];
  $mail->Port       = $__smtp['port'];
  if ($__smtp['port'] == '465') {
    $mail->SMTPSecure = 'ssl';
  } else {
    $mail->SMTPSecure = '';
  }
   $mail->Username   = $__smtp['addreply'];
  $mail->Password   = $__smtp['password'];
  $mail->SetFrom($__smtp['addreply'], $__smtp['username']);       // from email and from username from config file
  $mail->AddReplyTo($__smtp['addreply'], $__smtp['username']);    // reply-to email
  $mail->AddAddress($to);                                         // send to
  $mail->Subject = htmlspecialchars($subject);
  $mail->Body = $content;
  if($attach) {
    $mail->AddAttachment($attach);
  }
  
  if(!$mail->Send()) {
    $error = 'Mail error: '.$mail->ErrorInfo; 
    return false;
  } else {
    $error = 'ok';
    return true;
  }

}
$usermail=$_SERVER['argv'][1];
$name=$_SERVER['argv'][2];
$pass=$_SERVER['argv'][3];
$_mail = secure_smtp_mail($usermail,'Trigger password recovery', 'Hi '.$name.'! Your new password:'.$pass.' Welcome back to http://trigger.fm!');
var_dump($error);
?>