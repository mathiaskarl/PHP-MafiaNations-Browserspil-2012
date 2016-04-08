<?php
if($login->check_login()) {
    echo error::return_error("You are allready logged into Mafia Nations.");
} else {
    switch (isset($_GET['do']) ? $_GET['do'] : null) {
        
        case '1':
            if(isset($_COOKIE['mnreg']) && $_COOKIE['mnreg'] == 1) {
                echo error::return_error("You have registered withing the past 10mins<br />Please wait before registering again.");
            } else {
                $username = safe($_POST['username']);
                $password1 = safe($_POST['password1']);
                $password2 = safe($_POST['password2']);
                $email = safe($_POST['email']);
                $terms = (isset($_POST['terms']) ? safe($_POST['terms']) : null);
                $adress = $_SERVER['REMOTE_ADDR'];
                $date = date("Y/m/d H:i:s");
                $requre1 = strpos($email, "@");
                $requre2 = strpos($email, ".");
                $code_one = ($_SESSION['CaptchaImage'] == null ? "abdj88" : strtolower($_SESSION['CaptchaImage']));
                $code_two = safe(strtolower($_POST['validateCode']));

		
		if (empty($username) || empty($password1) || empty($password2) || empty($email)) {
                    echo error::return_error("You must fill all the fields.");
		} elseif ($password1 != $password2) {
                    echo error::return_error("The passwords you wrote, doesn't match.");
		} elseif ($requre1 && $requre2 != true || $requre1 != true || $requre2 != true) {
                    echo error::return_error("Please use a correct email adress.<br>You will need it to activate your account.");
		} elseif ($code_one != $code_two) {
                    echo error::return_error("The validation code you entered, doesn't match the one on the image.");
		} elseif ($terms != 1) {
                    echo error::return_error("You must read and agree to our Terms of use and private policy on Mafia Nations.");
		} else {
		
                    $c_query = db_core::getInstance()->conn->prepare("SELECT id FROM `users` WHERE username = :username");
                    $c_query->bindValue(":username", $username, PDO::PARAM_STR);
                    $c_query->execute();
                    if($c_query->rowCount() > 0) {
                        echo error::return_error("There is allready an account with that username.");
                    } else {
                       $e_query = db_core::getInstance()->conn->prepare("SELECT id FROM `users` WHERE email = :email");
                       $e_query->bindValue(":email", $email, PDO::PARAM_STR);
                       $e_query->execute(); 
                       if($e_query->rowCount() > 0 ) {
                           echo error::return_error("There is allready an account attached to that email adress.");
                       } else {
                           echo error::return_error("Your account has been created.<br />An email has been sent to <b>".$email."</b> with the activation link.", "Congratulations", "starimage.png");
                           $random = makeRandomPassword();
                           unset($_SESSION['captcha']);
                           setcookie("mnreg", 1, time()+600);
                           db_core::getInstance()->conn->query("INSERT INTO `users` (username, password, email, created_ip, register_time, activate, avatar) VALUES ('".$username."', '".md5($password1)."', '".$email."', '".$adress."', '".$date."', '".$random."', '1')");
                           include("include/registermail.php");
                       }
                    }
                }
            }
        break;
	
	case '2':
        if(!isset($_POST['submit']) && !isset($_GET['u']) && !isset($_GET['k'])) {
            echo "
            <form name='submit' method='post' action='?p=register&do=2'>
            <div id='registercontainer'>
                <div id='registerspacer'>
                </div>

                <div id='registercontent'>
                    <div id='italicheader'>
                    Activate account
                    </div>
                    <div id='italicgrey'>
                    On this page you can manually activate your account.<br>
                    You have received an email with the activation key included.<br>
                    Write this key with your username, in the fields below and you should be activated within seconds.
                    </div>
                    <div id='normalblack' style='width:100%;'>
                    <table width='100%'>
                            <tr>
                            <td width='35%'>Username:</td>
                            <td><input type='text' id='registerinput' name='username'></td>
                            </tr>
                            <tr>
                            <td width='35%'>Activation key:</td>
                            <td><input type='text' id='registerinput' name='key'></td>
                            </tr>
                            <td width='35%'></td>
                            <td align='left'><input type='submit' name='submit' value='&nbsp;' class='activate' size='10'> <input type='reset' name='reset' value='&nbsp;' class='reset' size='10'></td>
                            </tr>
                    </table>
                    </div>
                    <div id='italicgrey' style='padding-top:20px;'>
                    If you experience any problems during this process, then please contact us through our contact form. We will make sure to activate your account, if you are unable to do so yourself.
                    </div>
                </div>

                <div id='registerspacer'>
                </div>
                <div style='clear:both;'></div>
            </div>
            </form>";
        } else {
            $username = (isset($_POST['submit']) ? safe($_POST['username']) : safe($_GET['u']));
            $key = (isset($_POST['submit']) ? safe($_POST['key']) : safe($_GET['k']));
            if(empty($username) && empty($key)) {
                echo error::return_error("You must fill both fields.");
            } else {
                $query = db_core::getInstance()->conn->prepare("SELECT id, username, password, activate FROM `users` WHERE username = :username");
                $query->bindValue(":username", $username, PDO::PARAM_STR);
                $query->execute();
                if($query->rowCount() < 1) {
                    echo error::return_error("No user found with this username.");
                } else {
                    $fetch = $query->fetch(PDO::FETCH_ASSOC);
                    if($fetch['activate'] != $key) {
                        echo error::return_error("The activation key is incorrect.");
                    } else {
                        db_core::getInstance()->conn->query("UPDATE `users` SET activate = '1' WHERE id = '". $fetch['id'] ."'");
                        echo error::return_error("Your account is currently being activated.<br /><br />Please wait..", "Activating..", "loginimage.png");
                        $amountArray[1] = "0"; // Experience
                        $amountArray[2] = "1000"; // Mafia Coins
                        $amountArray[3] = "100"; // Health
                        $amountArray[4] = "100"; // Max Health
                        $amountArray[5] = "100"; // Energy
                        $amountArray[6] = "100"; // Max Energy
                        $amountArray[7] = "50"; // Mail Space
                        $amountArray[8] = "1"; // Level
                        $amountArray[9] = "0"; // Gold bank
                        $amountArray[10] = "50"; // Inventory Space
                        $amountArray[11] = "0"; // Event
                        $amountArray[12] = "0"; // Mafia
                        $amountArray[13] = "0"; // Fight Id
                        $amountArray[14] = "0"; // Gold Bank Interest
                        $amountArray[15] = "1"; // Mafia Rank
                        $amountArray[16] = "0"; // Fightclub: Frozen
                        $amountArray[17] = "0"; // Block Mails
                        $amountArray[18] = "0"; // Block Friend Mails
                        $amountArray[19] = "0"; // Block Fightclub 
                        $amountArray[20] = "0"; // Block Friend Request
                        $amountArray[21] = "1"; // Online status
                        $amountArray[22] = "0"; //Unused
                        $amountArray[23] = "0"; // Block Sent Items
                        $amountArray[24] = "0"; // Forum Posts
                        $amountArray[25] = "0"; // Hide Font Effects
                        $amountArray[26] = "0"; // Hide Signatures
                        $amountArray[27] = "#2c2b2b"; // Font Color
                        $amountArray[28] = "0"; // Font Size
                        $amountArray[29] = "0"; // Font Style
                        $amountArray[30] = "Tahoma"; // Font Type
                        $amountArray[31] = "0"; // Font Align
                        $amountArray[32] = "0"; // Signature Align
                        $amountArray[101] = "1"; // Damage
                        $amountArray[102] = "1"; // Defense
                        $amountArray[105] = "0"; // Healing used
                        $amountArray[106] = "5"; // Attack bonus
                        $amountArray[107] = "5"; // Defense bonus
                        $amountArray[108] = "5"; // Dodge chance
                        $amountArray[109] = "0"; // Freeze used
                        $amountArray[110] = "0"; // Bomb used
                        
                        foreach($amountArray as $key => $value) {
                            db_core::getInstance()->conn->query("INSERT INTO `user_stats` (user_id, stat_id, value) VALUES ('".$fetch['id']."', '".$key."', '".$value."')");
                        }
                        equiptment::create_sql($fetch['id']);
                        $avatar = new avatar($fetch['id']);
                        $avatar->add_avatar("1");
                        $items = new items();
                        $items->handle_item("add", 2, $fetch['id']); // Glock
                        $items->handle_item("add", 3, $fetch['id']); // Small Healing Pot
                        $items->handle_item("add", 7, $fetch['id']); // Small Energy Pot
                        $items->handle_item("add", 8, $fetch['id']); // Small Experience Pot
                        $m_query = db_core::getInstance()->conn->query("SELECT * FROM `monsters` WHERE start_status = 'open' ");
                        while($m_fetch = $m_query->fetch(PDO::FETCH_ASSOC)) {
                            db_core::getInstance()->conn->query("INSERT INTO `user_monsters` (user_id, monster_id, monster_health, won, lost, draw) VALUES ('".$fetch['id']."', '".$m_fetch['id']."', '".$m_fetch['health']."', '0', '0', '0')");
                        }
                        mail::send_mail_admin($fetch['username'], "Hello ".$fetch['username'].".\n\nThank you registering at Mafia Nations.\nBefore playing, we recommend reading our tutorial to the game, aswell as the game rules :)\n\nEnjoy your stay\nAdministrator.", "Welcome to Mafia Nations!");
                        echo "<meta http-equiv='refresh' content='4;URL=?p=front'>";
                    }
                }
            }
	}
	break;
	
	case '3':
            if(isset($_POST['submit'])) {
                $email = safe($_POST['email']);
                if(empty($email)) {
                    echo error::return_error("You must fill out the email field.");
                } else {
                    $query = db_core::getInstance()->conn->prepare("SELECT id FROM `users` WHERE email = :email");
                    $query->bindValue(":email", $email, PDO::PARAM_STR);
                    $query->execute();
                    if($query->rowCount() < 1) {
                        echo error::return_error("There is no account on Mafia Nations with that email.");
                    } elseif (isset($_COOKIE['request_pswd']) && $_COOKIE['request_pswd'] == $email) {
                        echo error::return_error("You have allready requested a password reset.<br>You must wait 5 minuts before doing so again.");
                    } else {
                        echo error::return_error("We have sent you an email, with a confirmation link.<br />Once you've clicked this link, you will be able to reset your password.", "Password request sent", "loginimage.png");
                        $confirm_code = makeRandomPassword();
                        $u_query = db_core::getInstance()->conn->prepare("UPDATE `users` SET emailrequest='". $confirm_code ."' WHERE email = :email");
                        $u_query->bindValue(":email", $email, PDO::PARAM_STR);
                        $u_query->execute();
                        setcookie("request_pswd", $email, time()+300);
                        include("include/passwordmail.php");
                    }
                }
            } else {
                echo "
                <form method='post' action='?p=register&do=3'>
                <div id='registercontainer'>
                    <div id='registerspacer'>
                    </div>

                    <div id='registercontent'>
                        <div id='italicheader'>
                        Forgotten password
                        </div>
                        <div id='italicgrey'>
                        Did you forget your password and can't acces your account? Don't worry.<br>
                        You're a few clicks away from gaining acces to your account again.<br><br>
                        Fill out the form, and you will receive an email containing the information to reset your password.
                        </div>
                        <div id='normalblack' style='width:100%;'>
                        <table width='100%'>
                            <tr>
                            <td width='35%'>Registered email:</td>
                            <td><input type='text' id='registerinput' name='email'></td>
                            </tr>
                            <td width='35%'></td>
                            <td align='left'><input type='submit' name='submit' value='&nbsp;' class='passwordbutton' size='10'> <input type='reset' name='reset' value='&nbsp;' class='reset2' size='10'></td>
                            </tr>
                        </table>
                        </div>
                        <div id='italicgrey' style='padding-top:20px;'>
                        If you experience any problems during this process, then please contact us through our contact form.
                        </div>
                    </div>

                    <div id='registerspacer'>
                    </div>
                    <div style='clear:both;'></div>
                </div>
                </form>";
            }
	break;
	
	case '4':
            if(isset($_POST['submit'])) {
                $password1 = safe($_POST['password1']);
                $password2 = safe($_POST['password2']);
                    if(empty($password1) || empty($password2)) {
                        echo error::return_error("You must fill out both password fields.");
                    } elseif ($password1 != $password2) {
                        echo error::return_error("The passwords you've entered doesn't match.");
                    } else {
                        $query = db_core::getInstance()->conn->prepare("SELECT id FROM `users` WHERE id = :id AND emailrequest = :code");
                        $query->bindValue(":id", safe($_POST['id']), PDO::PARAM_STR);
                        $query->bindValue(":code", safe($_POST['code']), PDO::PARAM_STR);
                        $query->execute();
                        if($query->rowCount() < 1) {
                            echo error::return_error("There was an error with the password change.<br />Please contact the Mafia Nations administrator");
                        } else {
                            echo error::return_error("Your password has been changed<br />You can now log in to Mafia Nations.", "Congratulations", "starimage.png");
                            $u_query = db_core::getInstance()->conn->prepare("UPDATE `users` SET password = :password, emailrequest = '' WHERE id = :id");
                            $u_query->bindValue(":password", safe(md5($_POST['password'])), PDO::PARAM_STR);
                            $u_query->bindValue(":id", safe($_POST['id']), PDO::PARAM_STR);
                            $u_query->execute(); 
                        }
                    }
		} else {
                    if(isset($_GET['i']) && isset($_GET['c'])) {
                        $id = safe($_GET['i']);
                        $code = safe($_GET['c']);
                        $query = db_core::getInstance()->conn->prepare("SELECT id FROM `users` WHERE id = :id AND emailrequest = :code");
                        $query->bindValue(":id", safe($_GET['i']), PDO::PARAM_STR);
                        $query->bindValue(":code", safe($_GET['c']), PDO::PARAM_STR);
                        $query->execute();
                        if($query->rowCount() < 1) {
                            echo error::return_error("The confirmation link you followed is incorrect.");
                        } else {
                            echo "
                            <form method='post' action='?p=register&do=4'>
                            <input type='hidden' name='id' value='".$id."'>
                            <input type='hidden' name='code' value='".$code."'>
                            <div id='registercontainer'>
                                <div id='registerspacer'>
                                </div>

                                <div id='registercontent'>
                                    <div id='italicheader'>
                                    Reset password
                                    </div>
                                    <div id='italicgrey'>
                                    Your password reset has been confirmed. You will be able to choose a new password in the form below.<br>
                                    Remember to allways keep your password safe and strong.
                                    </div>
                                    <div id='normalblack' style='width:100%;'>
                                    <table width='100%'> 
                                        <tr>
                                        <td width='35%'>New password:</td>
                                        <td><input type='password' id='registerinput' name='password1'></td>
                                        </tr>
                                        <tr>
                                        <td width='35%'>Repeat password:</td>
                                        <td><input type='password' id='registerinput' name='password2'></td>
                                        </tr>
                                        <td width='35%'></td>
                                        <td align='left'><input type='submit' name='submit' value='&nbsp;' class='submitbutton' size='10'> <input type='reset' name='reset' value='&nbsp;' class='reset' size='10'></td>
                                        </tr>
                                    </table>
                                    </div>
                                    <div id='italicgrey' style='padding-top:20px;'>
                                    If you experience any problems during this process, then please contact us through our contact form.
                                    </div>
                                </div>

                                <div id='registerspacer'>
                                </div>
                                <div style='clear:both;'></div>
                            </div>
                            </form>";
                        }
                    } else {
                        echo error::return_error("The confirmation link you followed is incorrect.");
                    }
                }
	break;
        
        default:
            $_SESSION['CaptchaImage'] = randomString();
            $CaptchaImage = $_SESSION['CaptchaImage'];

            $getImage           = imagecreatetruecolor(65,22);
            $colorBackground    = imagecolorallocate($getImage, 0, 0, 0);
            $colorString        = imagecolorallocate($getImage, 125, 125, 125);
            $fontImage          = imagestring($getImage, 9, 6, 3, $CaptchaImage, $colorString);

            ob_start();
            imagepng($getImage);
            $data = ob_get_clean();

            echo "
            <form name='submit' method='post' action='?p=register&do=1'>
            <div style='margin:0px auto;width:800px;'>
                <div style='width:390px;float:left;'>
                    <div id='italicheader' style='padding-left:20px;'>
                    Register to Mafia Nations
                    </div>
                    <div id='italicgrey' style='padding-left:20px;'>
                    Become one of the top gangsters of our world.<br>
                    Upgrade your skills, buy weapons and equiptment.<br>
                    Rule the dark streets of Mafia Nations.
                    </div>
                    <div style='padding-left:19px;padding-top:5px;font-family:tahoma, arial, serif;font-size:14px;color:#000;'>
                    <table width='100%'>
                        <tr>
                        <td width='35%'>Username:</td>
                        <td><input type='text' id='registerinput' name='username'></td>
                        </tr>
                        <tr>
                        <td width='35%'>Your email:</td>
                        <td><input type='text' id='registerinput' name='email'></td>
                        </tr>
                        <tr>
                        <td width='35%'>Password:</td>
                        <td><input type='password' id='registerinput' name='password1'></td>
                        </tr>
                        <tr>
                        <td width='35%'>Repeat password:</td>
                        <td><input type='password' id='registerinput' name='password2'></td>
                        </tr>
                        <tr>
                        <td width='35%'>Validation code:</td>
                        <td><img src='data:image/png;base64,".base64_encode($data)."' style='padding-top:10px;margin-left:2px;'></td>
                        </tr>
                        <tr>
                        <td width='35%'>Repeat code:</td>
                        <td><input type='text' id='registerinput2' name='validateCode'></td>
                        </tr>
                        <tr>
                        <td></td>
                        </tr>
                        <tr>
                        <td width='35%'></td>
                        <td><input type='checkbox' name='terms' value='1'>
                         <font id='italicblack'>I agree to the <a href='?p=#'>Terms of Use</a> & <br><a href='?p=#'>Privacy Policy</a></font></td>
                        </tr>
                        <td width='35%'></td>
                        <td align='left'><input type='submit' name='submit' value='' class='create' size='10'> <input type='reset' name='reset' value='' class='reset' size='10'></td>
                        </tr>
                    </table>
                    </div>
                </div>
                <div id='registerspacer'>
                </div>
                <div id='italicgrey' style='width:375px;float:left;padding-left:20px;padding-top:5px;'>
                    After registrating to Mafia Nations, there will be sent an activation link to your email.
                    You will have to click this link, before you  can log in to Mafia Nations.<br><br>
                    It is suggested that you put @mafianations.com, on your trusted sender list in your email, before creating your account.<br>
                    This way you are 100% certain that you will receive the activation link.<br><br>
                </div>
                <div style='clear:both;'></div>
            </div>
            </form>";
        break;
	}
}
?>