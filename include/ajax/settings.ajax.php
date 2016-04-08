<?php
session_start();
require "functions.include.php";
$login = new login();

if($login->check_login()) {
    switch(isset($_POST['direction']) ? $_POST['direction'] : null) {
        default:
            echo "An error has occoured!";
            break;
        
        case 'avatar':
            $avatar = new avatar($_SESSION['user_id']);
            if($avatar->set_avatar(isNumber($_POST['avatar']))) {
               echo $avatar->return_avatar(isNumber($_POST['avatar']));
            } else {
                echo "You haven't achieved that avatar yet";
            }
            break;
        
        case 'preferences':
            if(!isset($_POST['value'])) {
                $input_array[0] = 0;
                $input_array[1] = 0;
                $input_array[2] = 0;
                $input_array[3] = 0;
                $input_array[4] = 0;
                $input_array[5] = 0;
            } else {
                $input_array = $_POST['value'];
            }
                for($i=0; $i<6; $i++) {
                    $temp_input[$i] = (array_key_exists($i, $input_array) ? ($input_array[$i] > 0 ? 1 : 0) : 0);
                }
                $stats = new stats($_SESSION['user_id']);
                $stats->set_stat("blockmail", $temp_input[0]);
                $stats->set_stat("blockfmail", $temp_input[1]);
                $stats->set_stat("blockfc", $temp_input[2]);
                $stats->set_stat("blockrequest", $temp_input[3]);
                $stats->set_stat("online", $temp_input[4]);
                $stats->set_stat("blockitems", $temp_input[5]);
            echo "Your preferences has been updated!";
            break;
            
        case 'profile':
            $cPassword = md5($_POST['currentpassword']);
            $nPassword = md5($_POST['newpassword']);
            $rPassword = md5($_POST['repeatpassword']);
            if (empty($_POST['currentpassword']) || empty($_POST['newpassword']) || empty($_POST['repeatpassword'])) {
                echo "You must fill out all the password fields!";
            } elseif($cPassword != $_SESSION['password']) {
                echo "The current password you entered is incorrect!";
            } elseif($nPassword != $rPassword) {
                echo "The passwords you entered doesn't match!";
            } else {
                $gender = ($_POST['gender'] == "Female" ? "Female" : "Male");
                $query = db_core::getInstance()->conn->prepare("UPDATE `users` SET password = :password, description = :description, country = :country, sex = '".$gender."' WHERE id = '".$_SESSION['user_id']."'");
                $query->bindValue(":password", $rPassword, PDO::PARAM_STR);
                $query->bindValue(":description", substr($_POST['description'], 0, 500), PDO::PARAM_STR);
                $query->bindValue(":country", $_POST['country'], PDO::PARAM_STR);
                $query->execute();
                echo "true";
            }
            break;
            
        case 'email':
            $email = $_POST['email'];
            $confirm_email = $_POST['confirm_email'];
            $password = md5($_POST['password']);
            $requre1 = strpos($email, "@");
            $requre2 = strpos($email, ".");
            if (empty($confirm_email) || empty($email) || empty($_POST['password'])) {
                echo "You must fill out all the fields!";
            } elseif ($requre1 && $requre2 != true || $requre1 != true || $requre2 != true){
                echo "Please use a valid email.";
            } elseif($confirm_email != $email) {
                echo "The emails you entered doesn't match!";
            } elseif($password != $_SESSION['password']) {
                echo "The password you entered is incorrect!";
            } else {
                $query = db_core::getInstance()->conn->prepare("SELECT id FROM `users` WHERE email = :email");
                $query->bindValue(":email", $email, PDO::PARAM_STR);
                $query->execute();
                if($query->rowCount() > 0) {
                    echo "That email is allready in use!";
                } else {
                    $query = db_core::getInstance()->conn->prepare("UPDATE `users` SET email = :email WHERE id = '".$_SESSION['user_id']."'");
                    $query->bindValue(":email", $email, PDO::PARAM_STR);
                    $query->execute();
                    echo "true";
                }
            }
            break;
    }
}
?>
