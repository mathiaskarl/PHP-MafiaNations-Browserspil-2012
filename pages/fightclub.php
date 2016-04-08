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
        $('#event').hide();
        $('#event').empty();
        $('#attack_log').slideToggle('fast', function() {
            $('#loading_box').fadeIn('fast');
        });
        $('#submit_button').attr('disabled','disabled');
        var form = $(this.form);
        $.ajax({
        type: "POST",
        url: "include/ajax/fightclub_attack.ajax.php",
        data: $(this.form).serialize(),
        dataType: 'json',
        success: function(data) {
            if(data.status === "true") {
                $("#attack_log").load("include/ajax/fightclub_attacklog.ajax.php?val=1", function() {
                    $('#loading_box').fadeOut(100);
                    if(data.fight_complete > 0) {
                        $('#action_container').hide();
                        $('.complete_container').show();
                        switch(data.fight_complete) {
                            case 1:
                                $('#fight_lost').show();
                                break;
                            case 2:
                                $('#fight_draw').show();
                                break;
                            case 3:
                                $('#fight_won').show();
                                break;
                        }
                    } else {
                        enable_button($('#submit_button'), 2000);
                    }
                    $('#attack_log').slideToggle('fast');
                });
            } else if(data.flee === 1) {
                replace_header("You've escaped!");
                replace_text("Please wait while we transfer you.");
                window.location.replace("?p=fightclub");
            } else {
                $('#loading_box').fadeOut('fast');
                $('#attack_log').slideToggle('fast');
                $('#event').append(data.error);
                $('#event').fadeIn();
                enable_button($('#submit_button'), null);
            }
        }
        });
    });
    
    $('.continue').click(function() {
        replace_header("Claiming reward..");
        $('#loading_box').fadeIn('fast');
        window.location.replace("?p=fightclub&do=reward");
    });
    
    $('.add_weapon').click(function() {
        replace_header("How to equipt?");
        replace_text("You can equipt items through your inventory.");
        hide_load();
        $('#loading_box').fadeIn('fast');
    });
    
    $('.remove_weapon').click(function() {
        replace_header("Unequipting..");
        var weapon_id = $(this).attr("weapon_param");
        var this_element = $(this);
        var box = confirm("Are you sure you wish to unequipt this weapon?");
        if(alert_check(box)) {
            $('#loading_box').fadeIn('fast');
            $.ajax({
            type: "POST",
            url: "include/ajax/remove_weapon.ajax.php?id="+weapon_id,
            success: function(data) {
                if(data.substring(0, 11) === "You have un") {
                    $('#loading_box').fadeOut('fast');
                    var this_image = this_element.next('img');
                    this_image.fadeOut(function() {
                        this_image.attr('src', 'images/fightclub/no_item.png')
                    }).fadeIn();
                    this_element.fadeOut(function() {
                        this_element.attr('class', 'add_weapon')
                    }).fadeIn();
                } else {
                    replace_header("Error");
                    replace_text(data);
                    hide_load();
                }
            }
            });
        }
    });
    var step_taken;
    var monster_id;
    
    function make_active(element) {
        element.prop("disabled", false);
        element.css("background-position", "top center");
    }
    
    $('#1player').click(function() {
        if($('#1player_hover').is(":hidden")) {
            make_active($('#continue_button'));
            step_taken = 1;
            $('#2player_hover').hide();
            $('#1player_hover').show();
            $('#1player').bind("animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd", function(){
                $(this).removeClass("animated tada");
            }).addClass("animated tada");
        }
    });
    
    $('#2player').click(function() {
        if($('#2player_hover').is(":hidden")) {
            make_active($('#continue_button'));
            step_taken = 2;
            $('#1player_hover').hide();
            $('#2player_hover').show();
            $('#2player').bind("animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd", function(){
                $(this).removeClass("animated tada");
            }).addClass("animated tada");
        }
    });
    
    $('#continue_button').click(function() {
        if(step_taken > 0) {
            switch(step_taken) {
                case 1:
                    $('#step_1').fadeOut(250, function() {
                        $('#step_2').fadeIn(250);
                    });
                    break;
                case 2:
                    break;
            }
        }
    });
    
    $('.fight_icon').click(function() {
        $('.fight_icon').css("background-position", "top center");
        $(this).css("background-position", "bottom center");
        monster_id = $(this).closest('tr').attr('id');
        $("table#opponent_table > tbody > tr").css("background", "none");
        $(this).closest('tr').css("background", "#bcb8b7");
        make_active($('#fight_button'));
    });
    
    $('#fight_button').click(function() {
        if(monster_id > 0) {
            replace_header("Starting match...");
            $('#loading_box').fadeIn('fast');
            $.ajax({
            type: "POST",
            url: "include/ajax/fightclub_enter.ajax.php?monster_id="+monster_id,
            success: function(data) {
                if(data === "success") {
                    window.location.replace("?p=fightclub&do=fight");
                    replace_header("Fight created!");
                    replace_text("Please wait while we redirect you.");
                    
                } else {
                    replace_header("Error!");
                    replace_text(data);
                }
            }
            });
        }
    });
    
    $('#back_button').click(function() {
        $('#step_2').fadeOut(250, function() {
            $('#step_1').fadeIn(250);
        });
    });
    
    $('#loading_box').click(function() {
        $('#loading_box').fadeOut('fast', function() {
            replace_header("Processing..");
            replace_text("Your action is currently being processed.");
            show_load();
        });
    });
});
</script>
<?php
if($login->check_login()) {
    echo ajax::overlay_loading();
    echo "
        <div style='margin:0px auto;width:800px;'>
            <div style='width:24px;height:24px;float:left;background:url(images/icons/star2.png) 0 0 no-repeat;margin-left:20px;margin-top:3px;'></div>
            <div id='italicheadersmall' style='padding-left:10px;margin-bottom:5px;float:left;'>
            The Fightclub
            </div>
            <div style='clear:both;'></div>
            <div id='fightclub' style='height:auto;margin-top:10px;'>
                <div id='fightclub_menu'>
                    <div class='menu_bar'></div>
                    <a href='?p=fightclub&do=prepare_fight'><div class='fight'></div></a>
                    <a href='?p=fightclub&do=challenges'><div class='small challenges'></div></a>
                    <a href='?p=fightclub&do=stats'><div class='small stats'></div></a>
                    <div class='small abilities'></div>
                    <div class='small scores'></div>
                    <div style='clear:both;'></div>
                </div>";
    
    $fightclub = new fightclub((session::get_stat("fight") > 0 ? session::get_stat("fight") : null));
    switch(isset($_GET['do']) ? $_GET['do'] : null) {
    
    case 'prepare_fight':
        if(session::get_stat("fight") > 0 ) {
            header("Location: ?p=fightclub&do=challenges");
        }
        echo "<div id='fightclub_main_bg'>
                <div id='step_1'>
                <form name='submit' method='post' action=''>
                <div style='width:650px;padding-top:10px;margin-left:auto;margin-right:auto;'>
                    <img src='images/fightclub/text_choose.png' style='margin-top:-45px;margin-left:190px;'>
                    <div id='1player' class='square_box' style='float:left;text-align:center;'>
                        <div id='1player_hover' style='display:none;position:absolute;width:246px;height:233px;margin-left:12px;margin-top:4px;background:url(images/fightclub/square_box_hover.png) repeat;'></div>
                        <img src='images/fightclub/text_challenger.png' style='margin-top:200px;'>
                    </div>
                    <div class='italic' style='float:left;width:110px;text-align:center;font-size:24px;margin-top:100px;'>
                    or..
                    </div>
                    <div id='2player' class='square_box' style='float:right;text-align:center;'>
                        <div id='2player_hover' style='display:none;position:absolute;width:246px;height:233px;margin-left:12px;margin-top:4px;background:url(images/fightclub/square_box_hover.png) repeat;'></div>
                        <img src='images/fightclub/text_2player.png' style='margin-top:200px;'>
                    </div>
                    <div style='clear:both;'></div>
                </div>
                                    
                <div class='fightclub_gray_box italic'>
                    <div style='float:left;padding:15px 20px 0px 25px'><img src='images/fightclub/info.png'></div>
                    <div style='height:115px;width:560px;float:left;margin:15px 15px 15px 0px;padding-left:10px;border-left:1px solid #ebebeb'>
                    In the Fightclub, you are able to choose from two different game types.<br />
                    In the <b>Local challenger</b> mode, you can fight any of the well known local gangsters and earn experience aswell as mafia coins.<br />
                    In the <b>2 Player</b> mode, you can fight against other players and friends, to see which of you is the strongest gangster.
                    </div>
                    <div style='clear:both;'></div>
                    <input type='button' name='button' id='continue_button' class='fightclub_continue_big' value='&nbsp;'>
                </div>
                </form> 
                </div>
                
                <div id='step_2' style='display:none;'>
                    <form name='submit' method='post'>
                    <div style='width:710px;padding-top:10px;margin-left:auto;margin-right:auto;'>
                        <img src='images/fightclub/text_pick.png' style='margin-top:-45px;margin-left:244px;'>
                        <div  style='float:left;'>
                            
                        </div>
                        <div  style='float:right;'>
                            <div class='italic' style='font-size:16px;width:400px;border-bottom:1px solid #2a2727;'>
                                <table style='width:100%;' cellspacing='0' cellpadding='0' style='border-collapse:collapse;'>
                                <tr style='height:35px;'>
                                <td width='55%' style='padding-left:5px;'>Gangsters</td>
                                <td width='30%' style='text-align:center;'>Difficulty</td>
                                <td style='text-align:center;'>Fight</td>
                                </tr>
                                </table>
                            </div>
                            <div style='width:400px;border-bottom:1px solid #939090;'>
                                <table id='opponent_table' style='width:100%;' cellspacing='0' cellpadding='0' style='border-collapse:collapse;'>";
                                $query = db_core::getInstance()->conn->query("SELECT monsters.id, monsters.name, monsters.difficulty
                                                            FROM user_monsters INNER JOIN monsters ON monsters.id = user_monsters.monster_id
                                                            WHERE user_monsters.user_id = '".$_SESSION['user_id']."'");
                                while($fetch = $query->fetch(PDO::FETCH_ASSOC)) {
                                    echo "
                                        <tr id='".$fetch['id']."' class='borderbottom bordertop' style='height:35px;'>
                                        <td width='55%' style='padding-left:5px;'><b>".$fetch['name']."</b></td>
                                        <td width='30%' style='text-align:center;'>".$fetch['difficulty']."</td>
                                        <td style='text-align:center;'>
                                            <div class='fight_icon'></div>
                                        </td>
                                        </tr>";
                                }
                                echo "
                                </table>
                            </div>
                        </div>
                        <div style='clear:both;'></div>
                    </div>

                    <div class='fightclub_gray_box italic'>
                        <div style='float:left;padding:15px 20px 0px 25px'><img src='images/fightclub/info.png'></div>
                        <div style='height:115px;width:560px;float:left;margin:15px 15px 15px 0px;padding-left:10px;border-left:1px solid #ebebeb'>
                        Click on the opponent you wish to face in the Fightclub. Make sure to check the stats of your opponent, to prevent from yourself losing to a gangster perhabs much more powerfull than yourself.<br />
                        - If you win, you'll be granted some of the following rewards:<br />
                        <b>Mafia coins</b>, <b>experience</b>, <b>secret avatars</b> and much more.
                        </div>
                        <div style='clear:both;'></div>
                        <input type='button' name='button' id='back_button' class='fightclub_back' value='&nbsp;'>
                        <input type='button' name='button' id='fight_button' class='fightclub_fight_big' value='&nbsp;'>
                    </div>
                    </form> 
                </div>
              </div>";
        break;
    
    case 'stats':
        $items = new items();
        foreach($_SESSION['equiptment'] as $value) {
            if($value > 0) {
                $item_slot[] = $value;
                $item_name[] = $items->get_item_attr("name", $value);
                $item_image[] = $items->get_item_attr("image", $value);
            }
        }
        function return_item($id) {
            global $item_slot;
            global $item_name;
            global $item_image;
            if(isset($item_slot[$id])) {
                return "<div class='remove_weapon' weapon_param='".$item_slot[$id]."'></div>
                        <img width='70px' height='70px' src='images/items/".$item_image[$id]."' title='".$item_name[$id]."' alt='".$item_name[$id]."'>";
            } else {
                return "<div class='add_weapon'></div>
                        <img width='70px' height='70px' src='images/fightclub/no_item.png'>";
            }
        }
        echo "
            <div id='fightclub_main_bg'>
                <div style='width:740px;margin:auto;'>
                    <div class='large_box' style='float:left;'>
                        <div class='stats'></div>
                        <div style='width:172px;margin-top:45px;padding:0px 2px;margin-left:auto;margin-right:auto;'>
                            <div class='italic hp_text'>Health:</div>
                            <div class='italic hp_show'>".session::get_stat("hp")." <span style='color:#f8f8f8'>/</span> ".session::get_stat("maxhp")."</div>
                            <div style='clear:both;'></div>
                        </div>
                        <div class='hp_container'>
                        <div style='margin-left:2px;width:".$stats->stat_procent(session::get_stat("hp"), session::get_stat("maxhp"))."%;height:24px;background:url(images/fightclub/hp_bar.png) 0 0 no-repeat;'></div>
                        </div>
                        <div class='italic' style='color:#f8f8f8;width:220px;margin-top:20px;margin-left:auto;margin-right:auto;'>
                        <div style='width:110px;text-align:center;float:left;'>
                            Attack bonus
                            <div class='square'>".session::get_stat("attbonus")."%</div>
                        </div>
                        <div style='width:110px;text-align:center;float:right;'>
                            Defense bonus
                            <div class='square'>".session::get_stat("defbonus")."%</div>
                        </div>
                        <div style='clear:both;margin-bottom:10px;'></div>
                        <div style='width:110px;margin:auto;text-align:center;'>
                            Dodge chance
                            <div class='square'>".session::get_stat("dodge")."%</div>
                        </div>
                        </div>
                    </div>
                    <div class='mafia_guy' style='float:left;margin:35px 45px 0px 45px;'>
                        <div id='italicblack' style='font-size:14px;width:100%;text-align:center;'>
                        <p style='margin-top:-70px;font-size:20px;margin-bottom:370px;'>".$_SESSION['username']."</p>
                        <p style='margin-top:-10px;'>".rank::getRank(session::get_stat("lvl"))."<br />
                            Level: ".session::get_stat("lvl")."</p>
                        </div>
                    </div>
                    <div class='large_box' style='float:left;'>
                        <div class='equiptment'>
                        <div class='item' style='left:5px;top:45px;'>
                        ".return_item(0)."
                        </div>
                        <div class='item' style='left:104px;top:45px;'>
                        ".return_item(1)."
                        </div>
                        <div class='item' style='left:5px;top:145px;'>
                        ".return_item(2)."
                        </div>
                        <div class='item' style='left:104px;top:145px;'>
                        ".return_item(3)."
                        </div>
                        <div class='item' style='left:5px;top:245px;'>
                        ".return_item(4)."
                        </div>
                        <div class='item' style='left:104px;top:245px;'>
                        ".return_item(5)."
                        </div>
                        </div>
                    </div>
                    <div style='clear:both;'></div>
                </div>
            </div>";
        break;
        
    case 'challenges':
        echo "<a href='?p=fightclub&do=fight'>Click here to finnish it.</a>";
        break;
        
    default:
        header("Location: ?p=fightclub&do=prepare_fight");
        break;
	
	case 'fight':
            if($fightclub->fight_exists()) {
            $last_move = $fightclub->get_last_fight();
            echo "
                <div style='margin:0px auto;width:686px;height:258px;background:url(images/battlebg3.png) 0 0 no-repeat;'>
                    <div style='width:100%;position:aboslute;'>
                        <div style='height:119px;width:100%;padding-top:30px;'>
                        ".ajax::event_fightclub()."
                        </div>
                        <div style='width:49%;float:left;font-family:Georgia, arial,serif;font-size:14px;color:#b3b1b0;font-style:italic;margin-top:50px;'>
                        <center><div style='margin:0px auto;width:150px;height:35px;background:url(images/battlestatusbg.png) repeat-x;'>".$_SESSION['username']."<br>
                        <font style='font-size:12px;font-weight:bold;'>Health: </font><font style='color:#ad5255;font-size:12px;font-weight:bold;'>".$last_move['user_health']." / ".$last_move['user_maxhealth']."</font></div></center>
                        </div>
                        <div style='width:49%;float:right;font-family:Georgia, arial,serif;font-size:14px;color:#b3b1b0;font-style:italic;margin-top:50px;'>
                        <center><div style='margin:0px auto;width:150px;height:35px;background:url(images/battlestatusbg.png) repeat-x;'>".monsters::get_monster_attr("name", $fightclub->get_fightclub_attr("2_user_id"))."<br>
                        <font style='font-size:12px;font-weight:bold;'>Health: </font><font style='color:#ad5255;font-size:12px;font-weight:bold;'>".$last_move['bot_health']." / ".$last_move['bot_maxhealth']."</font></div></center>
                        </div>
                        <div style='clear:both;'></div>
                    </div>
                </div>
                
                <div id='attack_log'>";
                    include "include/ajax/fightclub_attacklog.ajax.php";
                echo "</div>

                <div id='pagespacer' style='width:500px;margin: 10px auto;'>
                </div>";

                if($fightclub->fight_complete($last_move['user_health'], $last_move['bot_health']) < 1) {
                    $items = new items();
                    foreach($fightclub->equiptment as $value) {
                        if($value > 0) {
                            $item = $items->get_item($value);
                            $item_slot[] = $value;
                            $item_name[] = $item['name'];
                            $item_image[] = $item['image'];
                            $item_type[] = $item['weapon_type'];
                        }
                    }

                    echo "
                    <div id='action_container'>
                    <form name='checkform' action='' method='post'>
                    <div style='margin: 0px auto;width:630px;height:auto;'>
                        <div style='margin:0px auto;'>
                        <table align='center'>
                        <tr>
                        <td><center>";
                    foreach($item_slot as $key => $value) {
                        $disabled = ($fightclub->weapon_type($item_type[$key]) != null || $last_move['user_frozen'] > 0 ? "disabled" : null);

                        echo "
                        <div style='float:left;width:82px;margin:0px 15px 10px 15px;'>
                        <div id='italicgrey' style='height:15px;width:82px;'>".$item_name[$key]."</div>
                        <div style='width:80px;height:80px;border:1px solid black;background:url(images/items/".$item_image[$key].") 0 0 no-repeat;'></div>
                        <input type='checkbox' name='weapon[]' value='".$value."' ".$disabled.">
                        </div>";
                        }
                        echo "
                        <div style='clear:both;'></div>
                        </center>
                        </td>
                        </tr>
                        </table>
                        </div>
                    </div>
                    <br>
                    <div style='margin:0px auto;width:500px;height:auto;padding-bottom:20px;'>
                        <center>
                        <select name='action' id='registerinput'>
                        <option value='1'>Berserk Attack</option>
                        <option value='2'>Normal Attack</option>
                        <option value='3'>Defend </option>
                        <option value='run'>Flee from battle!</option>
                        </select> 
                        <select name='ability' id='registerinput' style='width:120px;'>
                        <option value=''>Choose Ability</option>
                        <option value=''>Drain life</option>
                        </select> 
                        <input type='button' id='submit_button' class='gobutton' name='button' value='&nbsp;' size='10'></center>
                    </div>
                    </form>
                    </div>";
                }
                $check_fight = $fightclub->fight_complete($last_move['user_health'], $last_move['bot_health']);
                $show_complete_container = (!$check_fight > 0 ? "display:none;" : null);
                $show_lost = ($check_fight != 1 ? "display:none;" : null);
                $show_draw = ($check_fight != 2 ? "display:none;" : null);
                $show_won = ($check_fight != 3 ? "display:none;" : null);
                echo "
                <div class='complete_container' id='italicblack' style='".$show_complete_container.";line-height:150%;text-align:center;margin:0px auto;padding-top:10px;padding-bottom:20px;'>
                    <form name='submit' action='' method='post'>
                    <div id='fight_won' style='".$show_won."margin-left:auto;margin-right:auto;'>
                        Congratulations! You have won the fight!<br />
                        Click on the button below to claim your prize!<br />
                        <input type='button' id='claim_button' name='button' class='continue' size='10'>
                    </div>
                    <div id='fight_draw' style='".$show_draw."margin-left:auto;margin-right:auto;'>
                        The fight was a draw!<br />
                        Click on the button below to continue!<br />
                        <input type='button' id='claim_button' name='button' class='continue' size='10'>
                    </div>
                    <div id='fight_lost' style='".$show_lost."margin-left:auto;margin-right:auto;'>
                        You have lost the fight!<br />
                        Click on the button below to continue!<br />
                        <input type='button' id='claim_button' name='button' class='continue' size='10'>
                    </div>
                    </form>
                </div>";
            } else {
                echo error::return_error("You are currently not in a fight!");
            }
	break;
	
	case 'reward':
            if($fightclub->fight_exists()) {
                $last_move = $fightclub->get_last_fight(session::get_stat("fight"));
                $monsters = new monsters($fightclub->get_fightclub_attr("2_user_id", session::get_stat("fight")));
                $fetch = $monsters->get_monster();
                switch($fightclub->fight_complete($last_move['user_health'], $last_move['bot_health']) > 0 ? $fightclub->fight_complete($last_move['user_health'], $last_move['bot_health']) : null){
                    case '1':
                        echo "
                        <div style='margin:0px auto;width:300px;padding-top:30px;'>
                        <div id='pagespacer' style='width:296px;margin:0px auto;padding-bottom:10px;'>
                        </div>
                        <div style='width:280px;margin:0px;auto;padding-bottom:15px;'>
                                <center>You lost the fight against<br><b>".$fetch['name']."</b><br><br>
                                <a href='?p=fightclub'>Click here to go back</a></center>
                        </div>
                        <div id='pagespacer' style='width:296px;margin:0px auto;'>
                        </div>
                        </div>";
                        $fightclub->close_fight("lost", $fetch['id'], $last_move['user_health']);
                        break;
                    case '2':
                        echo "
                        <div style='margin:0px auto;width:300px;padding-top:30px;'>
                        <div id='pagespacer' style='width:296px;margin:0px auto;padding-bottom:10px;'>
                        </div>
                        <div style='width:280px;margin:0px;auto;padding-bottom:15px;'>
                                <center>You played a draw against<br><b>".$fetch['name']."</b><br><br>
                                <a href='?p=fightclub'>Click here to go back</a></center>
                        </div>
                        <div id='pagespacer' style='width:296px;margin:0px auto;'>
                        </div>
                        </div>";
                        $fightclub->close_fight("draw", $fetch['id'], $last_move['user_health']);
                        break;
                    case '3':
                        $award_coins = rand($fetch['coins'], $fetch['max_coins']);
                        $award_xp = rand($fetch['max_experience'], $fetch['max_experience']);
                        echo "
                        <div style='margin:0px auto;width:300px;padding-top:30px;'>
                        <div id='pagespacer' style='width:296px;margin:0px auto;padding-bottom:10px;'>
                        </div>
                        <div style='width:280px;margin:0px;auto;padding-bottom:15px;'>
                                <center>You have won the fight against<br><b>".$fetch['name']."</b><br><br>
                                Your Reward:<br>
                                <b>".$award_coins."</b> Mafia Coins<br>
                                <b>".$award_xp."</b> Experience<br>

                                <a href='?p=fightclub'>Click here to go back</a></center>
                        </div>
                        <div id='pagespacer' style='width:296px;margin:0px auto;'>
                        </div>
                        </div>";
                        $fightclub->close_fight("won", $fetch['id'], $last_move['user_health'], $award_xp, $award_coins);
                        break;
                    default:
                        echo error::return_error("You are still in a fight!");
                        break;
                }
            } else {
                echo error::return_error("You are currently not in a fight!");
            }
	break;
}
echo "</div></div>";
} else {
    error::return_error("You have to be logged in to view this page!");
}
?>