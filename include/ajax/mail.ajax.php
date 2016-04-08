<?php
session_start();
require "functions.include.php";
$login = new login();
$mail = new mail($_SESSION['user_id']);

function switch_error($error) {
    switch($error) {
        case 'invalid_mail':
            echo "Invalid mail";
            break;
        default:
            echo "An error as occoured!";
            break;
    }
}
if($login->check_login()) {
    $mail = new mail($_SESSION['user_id']);
    if(isset($_POST['checkbox'])) {
        switch($_POST['action']) {
            case 'delete':
                if($mail->delete_mail($_POST['checkbox'])){
                    echo "Mails successfully deleted";
                } else {
                    switch_error($mail->show_error());
                }
                break;
            case 'read':
                if($mail->mark_mail($_POST['checkbox'], "read")) {
                    echo "Mails successfully marked as read";
                } else {
                    switch_error($mail->show_error());
                }
                break;
            case 'unread':
                if($mail->mark_mail($_POST['checkbox'], "unread")) {
                    echo "Mails successfully marked as unread";
                } else {
                    switch_error($mail->show_error());
                }
                break;

            default:
                break;
        }
    }
}
?>
