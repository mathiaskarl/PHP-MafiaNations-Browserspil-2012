<?php
session_start();
require "functions.include.php";
$login = new login();

function switch_error($error) {
    switch($error) {
        case 'unknown_user':
            echo "You must enter a correct username.";
            break;
        case 'send_self':
            echo "You can't send mails to yourself.";
            break;
        case 'no_message':
            echo "You must fill out the message.";
            break;
        case 'no_subject':
            echo "You must fill out the subject.";
            break;
        case 'mail_full':
            echo "This users mail inbox is full.";
            break;
        case 'mail_block':
            echo "This user has chosen not to receive any mails.";
            break;
        default:
            echo "An error as occoured!";
            break;
    }
}

if($login->check_login()) {
    $mail = new mail($_SESSION['user_id']);
  
    if(isset($_POST['reply_id']) && mail::allow_mail($_SESSION['user_id'], isNumber($_POST['reply_id']))) {
        if($mail->send_mail(safe($_POST['username']), substr($_POST['message'], 0, 500), $_POST['subject'], isNumber($_POST['reply_id']))) {
            echo "succes";
        } else {
            switch_error($mail->show_error());
        }
    } else {
        if($mail->send_mail(safe($_POST['username']), substr($_POST['message'], 0, 500), $_POST['subject'])) {
            echo "succes";
        } else {
            switch_error($mail->show_error());
        }
    }
}
?>
