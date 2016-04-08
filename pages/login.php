<?php
switch ($_GET['do']) {
    default:
	header("location: ?p=front");
	break;
	
    case 'off':
	if($login->log_out()) 
	{
            echo error::return_error("Thank you for your visit, hope to see you again soon.<br /><br />Please wait...<meta http-equiv='refresh' content='3;URL=?p=front'>", "Logging off", "loginimage.png");
	}
	break;
    
    case 'in':
	if($login->check_login(1)) 
	{
            $stats = new stats();
            $stats->store_session($_SESSION['user_id']);
            $equiptment = new equiptment($_SESSION['user_id']);
            $equiptment->build_equiptment();
	    header("location: ?p=home");
	} 
	else 
	{
            switch($login->show_error()) {
                case 'invalid_form':
                    echo error::return_error("The form input was invalid.");
                    break;
                case 'invalid_data':
                    echo error::return_error("The form input was invalid.");
                    break;
                case 'empty_form':
                    echo error::return_error("You need to enter the username and password to login.");
                    break;
                case 'login_exists':
                    echo error::return_error("You are allready logged in.");
                    break;
                case 'invalid_info':
                    echo error::return_error("The login information you entered was invalid <br /> If you are having trouble remembering your password:<br /><a href='?p=login&d=forgot'>Forgotten password</a>");
                    break;
                case 'require_activation':
                    echo error::return_error("This user haven't been activated yet.<br>Please check your email on how to activate your account.");
                    break;
                default:
                    break;
            }
	}
	break;
}
?>