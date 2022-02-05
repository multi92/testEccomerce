<?php
require 'PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'mailcluster.loopia.se;mailcluster.loopia.se';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'milos.stosic@softart.rs';                 // SMTP username
$mail->Password = 'mik19591427';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('milos.stosic@softart.rs', 'Milos Softart');
$mail->addAddress('mimiklonet@hotmail.com');     // Add a recipient
$mail->addReplyTo('milos.stosic@softart.rs', 'Information');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Probni naslov poruke 2';
$mail->Body    = 'Ovo je telo poruke sa <b>HTML tagom</b>';
$mail->AltBody = 'Ovo je telo poruke bez HTML taga';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}

?>