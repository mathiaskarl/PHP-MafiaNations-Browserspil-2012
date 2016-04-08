<script type="text/javascript">
    function alert_check(check) {
        if(check) {
            return true;
        }
        return false;
    }
$(document).ready(function() {
    $('#loading_header').append("Processing..");
    $('#loading_text').append("Your action is currently being processed.");
    $('#submit_button').click(function() {
        $('#submit_button').attr('disabled','disabled');
        var form = $(this.form);
        var direction = $('input[name=direction]').val();
        $('#event').empty();
        switch(direction) {
            default:
                alert("default");
                break;
            case 'preferences':
                $('#loading_box').fadeIn('fast');
                $.ajax({
                type: "POST",
                url: "include/ajax/settings.ajax.php",
                data: $(this.form).serialize(),
                success: function(data) {
                    $('#loading_box').fadeOut('fast');
                    $('#event').append(data);
                    $('#event').fadeIn();
                    enable_button($('#submit_button'), null);
                }
                });
                break;
                
            case 'profile':
                var box = confirm("Are you sure you wish to do this?");
                if(alert_check(box)) {
                    $('#loading_box').fadeIn('fast');
                    $.ajax({
                    type: "POST",
                    url: "include/ajax/settings.ajax.php",
                    data: $(this.form).serialize(),
                    success: function(data) {
                        $('#loading_box').fadeOut('fast');
                        if(data === "true") {
                            $('#event').append("Your profile has been updated!");
                            $('input[name=currentpassword]').val("");
                            $('input[name=newpassword]').val("");
                            $('input[name=repeatpassword]').val("");
                            enable_button($('#submit_button'), null);
                        } else {
                            $('#event').append(data);
                            enable_button($('#submit_button'), 2000);
                        }
                        $('#event').fadeIn();
                    }
                    });
                } else {
                    enable_button($('#submit_button'), 2000);
                }
                break;
                
             case 'email':
                var box = confirm("Are you sure you wish to change your email?");
                if(alert_check(box)) {
                    $('#loading_box').fadeIn('fast');
                    $.ajax({
                    type: "POST",
                    url: "include/ajax/settings.ajax.php",
                    data: $(this.form).serialize(),
                    success: function(data) {
                        $('#loading_box').fadeOut('fast');
                        if(data === "true") {
                            $('#event').append("Your email has succesfully been changed!");
                            $('.current_email').empty();
                            $('.current_email').append($('input[name=email]').val());
                            $('input[name=email]').val("");
                            $('input[name=confirm_email]').val("");
                            $('input[name=password]').val("");
                            enable_button($('#submit_button'), null);
                        } else {
                            $('#event').append(data);
                            enable_button($('#submit_button'), 2000);
                        }
                        $('#event').fadeIn();
                    }
                    });
                } else {
                    enable_button($('#submit_button'), 2000);
                }
                break;
                
            case 'avatar':
                $('#loading_box').fadeIn('fast');
                    $.ajax({
                    type: "POST",
                    url: "include/ajax/settings.ajax.php",
                    data: $(this.form).serialize(),
                    success: function(data) {
                        $('#loading_box').fadeOut('fast');
                        if(data.substring(0, 3) === "You") {
                            $('#event').append(data);
                            $('#event').fadeIn();
                            enable_button($('#submit_button'), 2000);
                        } else {
                            $('#avatar_image').attr("src", "images/avatars/"+data);
                            $('#event').append("Your avatar has been updated!");
                            $('#event').fadeIn();
                            enable_button($('#submit_button'), null);
                        }
                    }
                    });
                break;
        }
    });
    
    $('#loading_box').click(function() {
        $('#loading_box').fadeOut('fast');
    });
});
</script>
<?php
if($login->check_login()) {
    echo ajax::overlay_loading()."
    <div style='margin:0px auto;width:800px;'>
    <div style='width:24px;height:24px;float:left;background:url(images/icons/settings2.png) 0 0 no-repeat;margin-left:20px;margin-top:3px;'></div>
            <div id='italicheadersmall' style='padding-left:10px;margin-bottom:5px;float:left;'>
            Settings
            </div>
    <div style='float:'right;'></div>
            <div id='normalblack2' style='padding-left:10px;margin-top:5px;margin-right:45px;float:right;'>
            <a href='?p=settings&do=profile'>My profile</a> | <a href='?p=settings&do=avatar'>Avatar settings</a> | <a href='?p=settings&do=preferences'>Site preferences</a> | <a href='?p=settings&do=email'>Change your email</a>
            </div>
    <div style='clear:both;'></div>";
    switch(isset($_GET['do']) ? $_GET['do'] : null) {
        default:
            $show_array = array();
            $temp_array[] = session::get_stat("blockmail");
            $temp_array[] = session::get_stat("blockfmail");
            $temp_array[] = session::get_stat("blockfc");
            $temp_array[] = session::get_stat("blockrequest");
            $temp_array[] = session::get_stat("online");
            $temp_array[] = session::get_stat("blockitems");
            for($i=0; $i<6; $i++) {
                $show_array[$i] = ($temp_array[$i] > 0 ? "checked" : null);
            }
            echo "
            <form name='submit' method='post' action=''>
            <input name='direction' value='preferences' type='hidden'>
            <div style='margin-bottom:5px;width:100%;font-family: Times New Roman, arial, serif;font-size:25px;color:#000;font-style:italic;'>
                <center>Site preferences</center>
            </div>
            ". ajax::event_center() ."
            <div style='margin:0px auto;width:550px;background:url(images/settingsbg.png) repeat-y;'>
                <div id='italicblack' style='font-size:14px;padding:10px 5px 5px 10px;width:480px;float:left;'>
                <b>Block incoming mails</b><br>
                <font style='font-size:12px;color:#636363;'>Check this to block all incoming mails, except from friends.</font>
                </div>
                <div style='width:51px;float:right;padding-top:16px;'>
                        <center><input type='checkbox' name='value[0]' value='1' ".$show_array[0]."></center>
                </div>
                <div style='clear:both;'></div>

                <div id='italicblack' style='font-size:14px;padding:5px 5px 5px 10px;width:480px;float:left;'>
                <b>Block friend mails</b><br>
                <font style='font-size:12px;color:#636363;'>Check this to block mails incoming from friends.</font>
                </div>
                <div style='width:51px;float:right;padding-top:11px;'>
                        <center><input type='checkbox' name='value[1]' value='1' ".$show_array[1]."></center>
                </div>
                <div style='clear:both;'></div>

                <div id='italicblack' style='font-size:14px;padding:5px 5px 5px 10px;width:480px;float:left;'>
                <b>Block fightclub challenges</b><br>
                <font style='font-size:12px;color:#636363;'>Check this to block all challenges to the fightclub.</font>
                </div>
                <div style='width:51px;float:right;padding-top:11px;'>
                        <center><input type='checkbox' name='value[2]' value='1' ".$show_array[2]."></center>
                </div>
                <div style='clear:both;'></div>

                <div id='italicblack' style='font-size:14px;padding:5px 5px 5px 10px;width:480px;float:left;'>
                <b>Block friend requests</b><br>
                <font style='font-size:12px;color:#636363;'>Check this to block all friend requests.</font>
                </div>
                <div style='width:51px;float:right;padding-top:11px;'>
                        <center><input type='checkbox' name='value[3]' value='1' ".$show_array[3]."></center>
                </div>
                <div style='clear:both;'></div>

                <div id='italicblack' style='font-size:14px;padding:5px 5px 5px 10px;width:480px;float:left;'>
                <b>Block sent items</b><br>
                <font style='font-size:12px;color:#636363;'>Check this to block anyone from sending you items.</font>
                </div>
                <div style='width:51px;float:right;padding-top:11px;'>
                        <center><input type='checkbox' name='value[5]' value='1' ".$show_array[5]."></center>
                </div>
                <div style='clear:both;'></div>

                <div id='italicblack' style='font-size:14px;padding:5px 5px 5px 10px;width:480px;float:left;'>
                <b>Show online status</b><br>
                <font style='font-size:12px;color:#636363;'>This allows visitors to see if you are currently online.</font>
                </div>
                <div style='width:51px;float:right;padding-top:11px;'>
                        <center><input type='checkbox' name='value[4]' value='1' ".$show_array[4]."></center>
                </div>
                <div style='clear:both;'></div>
            </div>
            <div>
            <center><input id='submit_button' type='button' name='button' class='savesettings' value='&nbsp;' size='10'> <input type='reset' name='reset' class='reset' value='&nbsp;' size='10'></center>
            </div>
            </form>";
        break;
			
        case 'profile':
            $user = new user($_SESSION['user_id']);
            $show = $user->get_user();
            $sex = ($show["sex"] == "Female" ? "selected" : null);
            echo "
            <form name='submit' method='post' action=''>
            <input name='direction' value='profile' type='hidden'>
                <div style='margin-bottom:5px;width:100%;font-family: Times New Roman, arial, serif;font-size:25px;color:#000;font-style:italic;'>
                    <center>My profile</center>
                </div>
                ". ajax::event_center() ."
                <div style='padding-top:10px;padding-bottom:10px;margin:0px auto;width:550px;background:url(images/settingsbg2.png) repeat-y;'>
                    <table align='center' id='italicblack'>
                    <tr>
                        <td width='200' style='text-align:right;'>
                        <font style='font-size:11px;'>(Required)</font> <b>Current Password:</b></td>
                        <td width='5'></td>
                        <td>
                        <input type='password' class='registerinputnew' style='height:18px;width:170px;' name='currentpassword'></td>
                    </tr>
                    <tr>
                    </tr>
                    <tr>
                        <td width='200' style='text-align:right;'>
                        <b>New password:</b></td>
                        <td width='5'></td>
                        <td>
                        <input type='password' class='registerinputnew' style='height:18px;width:170px;' name='newpassword'>
                        </td>
                    </tr>
                    <tr>
                    </tr>
                    <tr>
                        <td width='200' style='text-align:right;'>
                        <b>Repeat new password:</b></td>
                        <td width='5'></td>
                        <td>
                        <input type='password' class='registerinputnew' style='height:18px;width:170px;' name='repeatpassword'>
                        </td>
                    </tr>
                    <tr>
                    </tr>
                    <tr>
                        <td width='200' style='text-align:right;'>
                        <b>Country of Residence:</b></td>
                        <td width='5'></td>
                        <td>
                        <input type='text' class='registerinputnew' style='height:18px;width:170px;' name='country' value='" . $show['country'] . "'>
                        </td>
                    </tr>
                    <tr>
                    </tr>
                    <tr>
                        <td width='200' style='text-align:right;' valign='top'>
                        <b>Gender:</b></td>
                        <td width='5'></td>
                        <td>
                        <select name='gender' id='registerinput' style='margin:0px;width:100px;'>
                                <option value='Male'>Male</option>
                                <option value='Female' " . $sex . ">Female</option>
                        </select>
                        </td>
                    </tr>
                    <tr>
                    </tr>
                    <tr>
                        <td width='200' style='text-align:right;' valign='top'>
                        <b>Profile description:</b></td>
                        <td width='5'></td>
                        <td>
                        <textarea rows='9' cols='30' name='description' id='mailtext' style='width:300px;height:170px;' onkeyup='subChar(this)'>" . $show['description'] . "</textarea>
                        </td>
                    </tr>
                    </table>
                </div>
                <div>
                    <center><input id='submit_button' type='button' name='button' class='savechanges' value='&nbsp;' size='10'> <input type='reset' name='reset' class='reset' value='&nbsp;' size='10'></center>
                </div>
                <div style='margin:0px auto;width:550px;padding-top:20px;padding-bottom:20px;padding-left:3px;' id='italicblack'>
                - The Mafia Headquarter will <b>never</b> ask for your password.<br>
                - Your personal information is encrypted and will never be brought to a 3rd party.
                </div>
            </form>";
            break;
			
        case 'email':
            echo "
            <form name='submit' method='post' action=''>
            <input name='direction' value='email' type='hidden'>
                <div style='margin-bottom:5px;width:100%;font-family: Times New Roman, arial, serif;font-size:25px;color:#000;font-style:italic;'>
                    <center>Change your email</center>
                </div>
                ". ajax::event_center() ."
                <div style='padding-top:10px;padding-bottom:10px;margin:0px auto;width:550px;background:url(images/settingsbg2.png) repeat-y;'>
                    <table align='center' id='italicblack'>
                    <tr>
                        <td width='150' style='text-align:right;'>
                        <b>Current email:</b></td>
                        <td width='5'></td>
                        <td>
                        <div class='current_email'>".user::get_user_info("email", $_SESSION['user_id'])."</div></td>
                    </tr>
                    <tr>
                    </tr>
                    <tr>
                        <td width='150' style='text-align:right;'>
                        <b>New email:</b></td>
                        <td width='5'></td>
                        <td>
                        <input type='text' class='registerinputnew' style='height:18px;width:220px;' name='email'>
                        </td>
                    </tr>
                    <tr>
                    </tr>
                    <tr>
                        <td width='150' style='text-align:right;'>
                        <b>Repeat new email:</b></td>
                        <td width='5'></td>
                        <td>
                        <input type='text' class='registerinputnew' style='height:18px;width:220px;' name='confirm_email'>
                        </td>
                    </tr>
                    <tr>
                    </tr>
                    <tr>
                        <td width='150' style='text-align:right;'>
                        <b>Your password:</b></td>
                        <td width='5'></td>
                        <td>
                        <input type='password' class='registerinputnew' style='height:18px;width:220px;' name='password'>
                        </td>
                    </tr>
                    </table>
                </div>
                <div>
                        <center><input id='submit_button' type='button' name='button' class='changeemail' value='&nbsp;' size='10'> <input type='reset' name='reset' class='reset' value='&nbsp;' size='10'></center>
                </div>
                <div style='margin:0px auto;width:550px;padding-top:20px;padding-left:3px;' id='italicblack'>
                - Your email will <b>never</b> be visible to any other users, at any point.<br>
                - The Mafia Headquarter will <b>never</b> ask for your email or password.<br>
                - Allways remove @mafianations.com from spamfilters, to ensure you will receive our mails.
                </div>
            </form>";
            break;
			
        case 'avatar':
            $avatar = new avatar($_SESSION['user_id']);
            echo "
            <form name='submit' method='post' action=''>
            <input name='direction' value='avatar' type='hidden'>
                <div style='margin-bottom:5px;width:100%;font-family: Times New Roman, arial, serif;font-size:25px;color:#000;font-style:italic;'>
                    <center>Avatar settings</center>
                </div>
                ". ajax::event_center() ."
                <div style='padding-top:10px;padding-bottom:10px;margin:0px auto;width:550px;background:url(images/settingsbg2.png) repeat-y;'>
                    <div style='width:340px;height:70px;background:url(images/avatarbar.png) 0 0 no-repeat;margin:0px auto;'>
                        <div id='italicblack' style='color:#FFF;text-align:center;float:left;width:180px;text-align:right;padding-top:8px;'>
                            <b>Current avatar:</b>
                        </div>
                        <div id='italicblack' style='float:right;width:154px;color:#FFF;text-align:left;padding-top:8px;'>
                            <img id='avatar_image' src='images/avatars/" . $avatar->return_avatar() . "'>
                        </div>
                        <div style='clear:both;'></div>
                    </div>
                    <table align='center' id='italicblack'>
                    <tr>
                        <td width='150' style='text-align:right;'>
                        <b>Change avatar:</b></td>
                        <td width='5'></td>
                        <td>
                        <select name='avatar' id='registerinput' style='width:120px;'>";
                        $query = db_core::getInstance()->conn->query("SELECT avatar.name, avatar.id FROM avatar
                                                                     INNER JOIN user_avatars ON user_avatars.avatar_id = avatar.id
                                                                     WHERE user_avatars.user_id = '".$_SESSION['user_id']."'");
                        $total_avatars = $query->rowCount();
                        while($fetch = $query->fetch(PDO::FETCH_ASSOC)) {
                            $select = ($fetch['id'] == user::get_user_info("avatar", $_SESSION['user_id']) ? "selected" : null);
                            echo "<option value='" . $fetch['id'] . "' ".$select.">" . $fetch['name'] . "</option>";
                        }
                        echo "
                        </select>
                        </td>
                    </tr><tr>
                    </tr><tr>
                    <td width='150' style='text-align:right;'>
                    <b>Avatar Collection:</b></td>
                    <td width='5'></td>
                    <td>";
                    echo 
                        $total_avatars . " avatars
                        </td>
                            </tr>
                            </table>
                        </div>
                        <div>
                                <center><input id='submit_button' type='button' name='button' class='savesettings' value='&nbsp;' size='10'> <input type='reset' name='reset' class='reset' value='&nbsp;' size='10'></center>
                        </div>
                        <div style='margin:0px auto;width:550px;padding-top:20px;padding-left:3px;' id='italicblack'>
                        - You can earn new avatars in different ways, Below is a list of ways to obtain new avatars:<br>
                        <div style='margin-left:12px;font-weight:bold;'>
                        - Gaining levels<br>
                        - Earning speciel achievements<br>
                        - Reaching topscores on games.<br>
                        - Random events.<br>
                        - Being active in the community<br>
                        </div>
                        - Your avatar will be shown to the community through the forums, and profiles so pick a nice one!
                        </div>
                    </form>";
            break;
    }
    echo "
    </div>";
} else {
    echo error::return_error("You have to be logged in to view this page!");
}
?>