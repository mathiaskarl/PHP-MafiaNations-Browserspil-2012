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
    $('#submit_send').click(function() {
        $('#loading_header').empty();
        $('#submit_send').attr('disabled','disabled');
        var form = $(this.form);
        $('#event').empty();
        $('#loading_header').append("Sending..");
        $('#loading_box').fadeIn('fast');
        $.ajax({
        type: "POST",
        url: "include/ajax/sendmail.ajax.php",
        data: $(this.form).serialize(),
        success: function(data) {
            if(data === "succes") {
                $('#loading_header').empty();
                $('#loading_text').empty();
                $('#loading_header').append("Mail sent!");
                $('#loading_text').append("Your mail has been sent.");
                window.location.replace("?p=mail");
            } else {
                $('#loading_box').fadeOut('fast');
                $('#event').append(data);
                $('#event').fadeIn();
                enable_button($('#submit_send'), null);
            }
        }
        });
    });
    
    $('#submit_button').click(function() {
        var value = $(this.form).find('#select_action').val();
        if ($(".form_checkbox:checked").length > 0){
            $('#submit_button').attr('disabled','disabled');
            switch(value) {       
            case 'disabled':
                break;

            case 'delete':
                var box = confirm("Are you sure you wish to delete these mails?");
                if(alert_check(box)) {
                    $('#loading_box').fadeIn('fast');
                    $.ajax({
                    type: "POST",
                    url: "include/ajax/mail.ajax.php",
                    data: $(this.form).serialize(),
                    success: function(data) {
                        $(".form_checkbox:checked").each(function() {
                            $(this).closest("table").remove();
                        });
                        if($('#mail_table_check').length < 1) {
                            $('#no_mail_table').show();
                        }
                        $('#event').empty();
                        $('#loading_box').fadeOut('fast');
                        $('#event').append(data);
                        $('#event').fadeIn();
                        enable_button($('#submit_button'), 3000);
                    }
                    });
                } else {
                    enable_button($('#submit_button'), 2000);
                }
                break;

            default:
                $('#loading_box').fadeIn('fast');
                $.ajax({
                type: "POST",
                url: "include/ajax/mail.ajax.php",
                data: $(this.form).serialize(),
                success: function(data) {
                  $(".form_checkbox:checked").each(function() {
                      var set_font = (value === "read" ? "normal" : "bold");
                      var set_status = (value === "read" ? "Read" : "Unread");
                      var table = $(this).closest("table")
                      table.css("font-weight", set_font);
                      table.find(".read_status").empty();
                      table.find(".read_status").append(set_status);
                  });
                  $('#event').empty();
                  $('#loading_box').fadeOut('fast');
                  $('#event').append(data);
                  $('#event').fadeIn();
                  enable_button($('#submit_button'), 3000);
                }
                });
                break;
            }
        }
    });
    
    $('#loading_box').click(function() {
        $('#loading_box').fadeOut('fast');
    });
});

checked = false;
function checkedAll () {
if (checked == false){checked = true}else{checked = false}
for (var i = 0; i < document.getElementById('erase').elements.length; i++) {
    document.getElementById('erase').elements[i].checked = checked;
}
}
    </script>
<?php
if($login->check_login()) {
    $mail = new mail($_SESSION['user_id']);
	echo ajax::overlay_loading()."
	<div style='margin:0px auto;width:800px;'>
            <div style='width:24px;height:24px;float:left;background:url(images/icons/mail2.png) 0 0 no-repeat;margin-left:20px;margin-top:3px;'></div>
                <div id='italicheadersmall' style='padding-left:10px;margin-bottom:5px;float:left;'>
                Mailbox
                </div>
            <div style='float:'right;'></div>
                <div id='normalblack2' style='padding-left:10px;margin-top:5px;margin-right:45px;float:right;'>
                <a href='?p=mail'>Inbox</a> | <a href='?p=mail&do=send'>Send mail</a> | <a href='?p=mail'>Link here</a> | <a href='?p=mail'>Link here</a> | <a href='?p=mail'>Link here</a>
                </div>
            <div style='clear:both;'></div>";
        
	switch(isset($_GET['do']) ? $_GET['do'] : null) {
            default:
                $query = db_core::getInstance()->conn->query("SELECT id FROM `user_mail` WHERE sent_to = '".$_SESSION['user_id']."'");
                $numSql = ($query->rowCount() < 1 ? 0 : $query->rowCount());
                $rowsperpage = 10;
                $totalpages = ceil($numSql / $rowsperpage);
                $currentpage = (isset($_GET['s']) && is_numeric($_GET['s']) ? (int) $_GET['s'] : 1);
                $currentpage = ($currentpage > $totalpages ? $totalpages : $currentpage);
                $currentpage = ($currentpage < 1 ? 1 : $currentpage);
                $offset = ($currentpage - 1) * $rowsperpage;

                $query = db_core::getInstance()->conn->query("SELECT * FROM `user_mail` WHERE sent_to = '".$_SESSION['user_id']."' ORDER BY `id` DESC LIMIT $offset, $rowsperpage");
                $range = 2;
                $showPage = "";
                if ($currentpage > 1) {
                    $showPage .= " <a href='?p=mail&s=1'><img src='images/icons/backactive.gif' border='0'></a> ";
                    $prevpage = $currentpage - 1;
                    $showPage .= " <a href='?p=mail&s=$prevpage'><img src='images/icons/prevactive.gif' border='0'></a> ";
                } else {
                    $showPage .= " <img src='images/icons/previnactive.gif' border='0'> ";
                    $prevpage = $currentpage - 1;
                    $showPage .= " <img src='images/icons/backinactive.gif' border='0'> ";
                }
                for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
                    if (($x > 0) && ($x <= $totalpages)) {
                        if ($x == $currentpage) {
                            $showPage .= " [<b>$x</b>] ";
                        } else {
                            $showPage .= " <a href='?p=mail&s=$x'>$x</a> ";
                        } 
                    }
                }                  
                if ($currentpage != $totalpages && $rowsperpage < $numSql) {
                   $nextpage = $currentpage + 1;
                   $showPage .= " <a href='?p=mail&s=$nextpage'><img src='images/icons/nextactive.gif' border='0'> </a> ";
                   $showPage .= " <a href='?p=mail&s=$totalpages'><img src='images/icons/lastactive.gif' border='0'></a> ";
                } elseif ($rowsperpage >= $totalpages) {
                    $showPage .= " <img src='images/icons/nextinactive.gif' border='0'> ";
                    $showPage .= " <img src='images/icons/lastinactive.gif' border='0'> ";
                } else {
                    $showPage .= " <img src='images/icons/nextinactive.gif' border='0'> ";
                    $showPage .= " <img src='images/icons/lastinactive.gif' border='0'> ";
                }
                
                echo "
                <div id='normalblacksmall' style='padding-left:20px;margin-bottom:15px;margin-top:10px;width:100%;'>
                You are currently holding <b>".$numSql."</b> out of ".session::get_stat("mailspace")." mails.
                </div>
                ".ajax::event_center()."
                <form name='submit' method='post' id='erase' action='?p=mail'>
                <div style='width:100%;margin-top:30px;'>
                    <table class='mailcontainer' align='center'><tr>
                    <td width='30' align='center'></td>
                    <td width='270'>Subject:</td>
                    <td width='160'>From:</td>
                    <td width='160'>Received:</td>
                    <td width='80' style='text-align:right;'>Status:</td>
                    </tr></table>
                    <div style='width:720px;margin:0px auto;height:2px;background:url(images/mailspacer.png) repeat-x;margin-top:2px;margin-bottom:8px;'></div>";
                    $no_mail_table = null;  
                    if($query->rowCount() > 0) {
                        $no_mail_table = "style='display:none'";
                        while ($show = $query->fetch(PDO::FETCH_ASSOC)) {
                            $status = ($show['status'] > 0 ? ($show['status'] == 1 ? "Read" : "Replied") : "Unread");
                            echo "
                            <table id='mail_table_check' class='mailcontent' align='center' ". ($show['status'] < 1 ? "style='font-weight:bold'" : "")."><tr>
                            <td width='30' align='center'><input type='checkbox' name='checkbox[]' value='".$show['id']."' class='form_checkbox'></td>
                            <td width='270'><a href='?p=mail&do=read&id=".$show['id']."'>".$show['subject']."</a></td>
                            <td width='160'><a href='?p=user&id=".$show['sent_from']."'>".user::get_user_info("username", $show['sent_from'])."</td>
                            <td width='160'><a href='?p=mail&do=read&id=".$show['id']."'>".$show['time']."</a></td>
                            <td width='80' style='text-align:right;'><a href='?p=mail&do=read&id=".$show['id']."'><div class='read_status'>".$status."</div></a></td>
                            </tr></table>";
                        }
                    }
                    echo "
                    <table id='no_mail_table' class='mailcontent' align='center' ".$no_mail_table.">
                        <tr><td width='100%'><center>You don't have any mails in your inbox.</center></td></tr>
                    </table>
                    <div style='width:720px;margin:0px auto;padding-bottom:10px;height:2px;background:url(images/mailspacer.png) repeat-x;margin-top:11px;'></div>
                    <table class='mailcontent' style='color:#444343;font-style:italic;' align='center'><tr>
                    <td width='30' align='center'><input type='checkbox' name='checkall' onclick='checkedAll();'></td>
                    <td width='270'>Check all</td>
                    <td width='440' style='text-align:right;'>Selected mails:
                    <select name='action' class='registerinputnew' id='select_action' style='width:140px;'>
                    <option value='disabled' selected='' disabled>Choose an Action</option>
                    <option value='delete'>Delete mails</option>
                    <option value='read'>Mark as read</option>
                    <option value='unread'>Mark as unread</option>
                    </select>
                    <input type='button' name='button' id='submit_button' value='&nbsp;' class='gobutton' size='10'>
                    </td>
                    </tr></table>
                    </form>
                    <center>".$showPage."</center>
                    </div>";
                break;
		
		case 'read':
                    if(isset($_GET['id'])) {
                    $id = isNumber($_GET['id']);
                    $query = db_core::getInstance()->conn->prepare("SELECT subject FROM `user_mail` WHERE id = :id AND sent_to = '".$_SESSION['user_id']."'");
                    $query->bindValue(":id", $id, PDO::PARAM_STR);
                    $query->execute();
                    if($query->rowCount() > 0) {
                        $fetch = $mail->get_mail($id);
                        if($fetch['status'] < 1) {
                            $mail->set_status("1", $id);
                        }
                        echo "
                        <div style='width:100%;margin-top:30px;'>
                        <table style='width:550px;font-family:Georgia, arial, serif;font-size:14px;color:#444343;font-style:italic;' align='center'><tr>
                            <td width='50%'>
                            Sender: <a href='?p=user&id=".$fetch['sent_from']."'>".user::get_user_info("username", $fetch['sent_from'])."</a>
                            </td>
                            <td width='50%' style='text-align:right;'>".$fetch['time']."</td>
                        </tr></table>
                        
                        <div style='width:550px;margin:0px auto;height:2px;background:url(images/mailspacer.png) repeat-x;margin-top:2px;margin-bottom:8px;'>
                        </div>
                        <table style='width:550px;' align='center'>
                        <tr>
                            <td width='125' style='font-family:Georgia, arial, serif;font-size:14px;color:#444343;font-style:italic;' valign='top'>
                            Subject:
                            </td>
                            <td width='425'>
                            <div style='width:425px;height:17px;background:url(images/mailbg.png) 0 0 no-repeat;'>".$fetch['subject']."</div>
                            </td>
                        </tr>
                        <tr>
                        <td></td>
                        <td></td>
                        </tr>
                        <tr>
                            <td width='125' style='font-family:Georgia, arial, serif;font-size:14px;color:#444343;font-style:italic;' valign='top'>
                            Message:
                            </td>
                            <td width='425'>
                            <div style='width:425px;height: auto;background:url(images/mailbg.png) repeat-y;'>".nl2br($fetch['message'])."</div>
                            </td>
                        </tr>
                        </table>
                        <div style='width:250px;margin:0px auto;height:10px;margin-top:20px;'>
                        <a href='?p=mail&do=send&reply_id=".$id."'>Reply to this mail</a> | <a href='?p=mail&do=del&id=".$id."'>Delete this mail</a>
                        </div>
                        </div>";
                    } else {
                        echo error::return_error("You are not allowed to view this mail.");
                    }
                } else {
                    echo error::return_error("This mail could not be found.");
                }
		break;
		
		case 'send':
                    if(isset($_GET['reply_id']) && mail::allow_mail($_SESSION['user_id'], isNumber($_GET['reply_id']))) {
                        $reply_id = isNumber($_GET['reply_id']);
                        $fetch_mail = $mail->get_mail($reply_id);
                        $username_from = user::get_user_info("username", $fetch_mail['sent_from']);
                        echo "
                            <div id='ajax_div'>
                            <form name='submit' method='post' action=''>
                            <input type='hidden' value='".$username_from."' name='username'>
                                <input type='hidden' value='".$reply_id."' name='reply_id'>
                            <div style='width:100%;margin-top:30px;padding-bottom:10px;'>
                            <table id='italicgreybig' style='width:550px;' align='center'><tr>
                                <td width='50%'>
                                Replying to mail sent from <b>".$username_from."</b>.
                                </td>
                            </tr>
                            </table>
                            <div style='width:550px;margin:0px auto;height:2px;background:url(images/mailspacer.png) repeat-x;margin-top:2px;margin-bottom:4px;'>
                            </div>
                            <div id='event' style='margin-left:244px;margin-bottom:5px;display:none;font-family:Georgia, arial, serif;font-size:15px;color:#a22121;font-style:italic;'>
                            </div>
                            <table style='width:550px;' align='center'>
                            <tr>
                                <td width='125' id='italicgreybig' valign='top'><b>".$username_from."</b> wrote:</td>
                                <td width='425' valign='top'>
                                <div style='width:425px;height:auto;min-height:36px;background:url(images/mailbg.png) repeat-y;margin-top:2px;margin-bottom:10px;'>".nl2br($fetch_mail['message'])."</div>					
                                </td>
                            </tr><tr>
                            <td></td>
                            <td></td>
                            </tr><tr>
                                <td width='125' id='italicgreybig' valign='top'>Subject:</td>
                                <td width='425'><input type='text' value='Re: ".$fetch_mail['subject']."' id='mailinput'  style='width:200px' name='subject'></td>
                            </tr><tr>
                            <td></td>
                            <td></td>
                            </tr><tr>
                                <td width='125' id='italicgreybig' valign='top'>Message:</td>
                                <td width='425'><textarea rows='9' cols='30' name='message' id='mailtext' onkeyup='subChar(this)'></textarea></td>
                            </tr><tr>
                            <td></td>
                            <td></td>
                            </tr><tr>
                                <td width='125' valign='top'></td>
                                <td width='425'>
                                <input type='button' name='button' id='submit_send' class='sendmail' value='&nbsp;' size='10'> <input type='reset' name='reset' class='resetmail' style='margin-left:2px;' value='&nbsp;' size='10'>
                                </td>
                            </tr></table>
                            </div>
                            </form>
                            </div>";
                    } else {
                        $temp_username = null;
                        if(isset($_GET['user_id']) && user::get_user_info("username", isNumber($_GET['user_id']))) {
                            $temp_username = user::get_user_info("username", isNumber($_GET['user_id']));
                        }
                        echo "
                        <div id='ajax_div'>
                        <form name='submit' method='post' action=''>
                        <div style='width:100%;margin-top:30px;padding-bottom:10px;'>
                        <table id='italicgreybig' style='width:550px;' align='center'><tr>
                            <td width='50%'>You are about to send a mail. Please fill all the fields below.</td>
                        </tr></table>
                        <div style='width:550px;margin:0px auto;height:2px;background:url(images/mailspacer.png) repeat-x;margin-top:2px;margin-bottom:8px;'>
                        </div>
                        <div id='event' style='margin-left:244px;margin-bottom:5px;display:none;font-family:Georgia, arial, serif;font-size:15px;color:#a22121;font-style:italic;'>
                        </div>
                        <table style='width:550px;' align='center'><tr>
                            <td width='125' id='italicgreybig' valign='top'>Send to:</td>
                            <td width='425'>
                            <input type='text' value='". $temp_username ."' id='mailinput' name='username'> 
                            <select name='action' id='mailinput' style='width:140px;height:22px;margin-left:2px;'>
                            <option selected=''>Select a Friend</option>
                            <option value=''>Friend 1</option>
                            <option value=''>Friend two</option>
                            </select>					
                            </td>
                        </tr><tr>
                        <td></td>
                        <td></td>
                        </tr><tr>
                            <td width='125' id='italicgreybig' valign='top'>Subject:</td>
                            <td width='425'><input type='text' value='' id='mailinput'  style='width:200px' name='subject'></td>
                        </tr><tr>
                        <td></td>
                        <td></td>
                        </tr><tr>
                            <td width='125' id='italicgreybig' valign='top'>
                            Message:
                            </td>
                            <td width='425'>
                            <textarea rows='9' cols='30' name='message' id='mailtext' onkeyup='subChar(this)'></textarea>
                            </td>
                        </tr><tr>
                        <td></td>
                        <td></td>
                        </tr><tr>
                            <td width='125' valign='top'></td>
                            <td width='425'>
                            <input type='button' name='button' id='submit_send' class='sendmail' value='&nbsp;' size='10'> <input type='reset' name='reset' class='resetmail' style='margin-left:2px;' value='&nbsp;' size='10'>
                            </td>
                        </tr></table>
                        </div>
                        </form>
                        </div>";
                    }
		break;
		
		case 'del':
                    if(isset($_GET['id'])){
                        $id = isNumber($_GET['id']);
                        if($mail->delete_mail($id)) {
                            echo error::return_error("The mail is currently being deleted.<br /><br />Please wait..<meta http-equiv='refresh' content='1;URL=?p=mail'>", "Please wait", "loginimage.png");
                        } else {
                            echo error::return_error($mail->show_error());
                        }
                    } else {
                        echo error::return_error("This mail could not be found.");
                    }
		break;
	}
	echo "
	</div>";
} else {
    echo error::return_error("You have to be logged in to view this page!");
}
?>