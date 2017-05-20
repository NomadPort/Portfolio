<?php
// Variable to check
$email = $_POST["email"];
$message = filter_var($_POST["message"],FILTER_SANITIZE_STRING);
$name= filter_var($_POST["name"],FILTER_SANITIZE_STRING);
$subject= filter_var($_POST["subject"],FILTER_SANITIZE_STRING);

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    echo("$email is a valid email address");
} else {
    echo("$email is not a valid email address");
    // need to display message in field showing invalid email
    exit();
}

require_once('email_config.php');
require('phpMailer/phpMailer/PHPMailer/PHPMailerAutoload.php');
$mail = new PHPMailer;
$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication


$mail->Username = EMAIL_USER;                 // SMTP username
$mail->Password = EMAIL_PASS;                 // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to
$options = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
$mail->smtpConnect($options);
$mail->From = $email;//your email sending account
$mail->FromName = $name;//your email sending account name
$mail->addAddress("jasonwelch4172@yahoo.com", "Jason Welch"/*your email address, or the email the sender if you are sending confirmation*//*email address user name*/);     // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
$mail->addReplyTo($_POST["email"]/*email address of the person sending the message, so you can reply*/);
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = $subject;
$mail->Body    = $message;
$mail->AltBody = $message ;

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}