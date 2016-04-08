<?php
if(isset($_GET['val']) && $_GET['val'] == 1) {
    session_start();
    require "functions.include.php";
    $login = new login();
    $fightclub = new fightclub((session::get_stat("fight") > 0 ? session::get_stat("fight") : null));
    $last_move = $fightclub->get_last_fight();
}

if($login->check_login()) {
    if(!$last_move['fight_start'] > 0) {
        $bot_move = ($last_move['bot_move'] > 1 ? ($last_move['bot_move'] > 2 ? "They use Normal attack" : "They Defend themself!") : "They use Berserk attack!");
        $user_move = ($last_move['user_move'] > 1 ? ($last_move['user_move'] > 2 ? "You use Normal attack" : "You Defend yourself!") : "You use Berserk attack!");
        $user_weapon_array = explode(",", $last_move['user_weapons']);
        $bot_weapon_array = explode(",", $last_move['bot_weapons']);

        $show_user_heal = ($last_move['user_heal'] > 0 ? "<font style='color:#ad5255;'>Heal: ".$last_move['user_heal']."hp</font>" : null);
        $show_bot_heal = ($last_move['bot_heal'] > 0 ? "<font style='color:#ad5255;'>Heal: ".$last_move['bot_heal']."hp</font>" : null);
        $show_user_damage = ($last_move['user_dmg'] > 0 || $last_move['bot_dodged'] > 0 ? ($last_move['bot_dodged'] > 0 ? "<font style='color:#1a2a5e;'>All attacks were dodged!</font>" : "Damage taken: ".$last_move['user_dmg']." <font style='color:#ad5255;'>(".($last_move['bot_health']+$last_move['user_dmg'])." &rarr; ".$last_move['bot_health'].")</font>") : null);         
        $show_bot_damage = ($last_move['bot_dmg'] > 0 || $last_move['user_dodged'] > 0 ? ($last_move['user_dodged'] > 0 ? "<font style='color:#1a2a5e;'>All attacks were dodged!</font>" : "Damage taken: ".$last_move['bot_dmg']." <font style='color:#ad5255;'>(".($last_move['user_health']+$last_move['bot_dmg'])." &rarr; ".$last_move['user_health'].")</font>") : null);        
        $show_user_frozen = ($last_move['user_frozen'] > 0 ? "<font style='color:#ad5255;'>You were frozen and couldnt move for the turn!</font>" : null);
        $show_bot_frozen = ($last_move['bot_frozen'] > 0 ? "<font style='color:#ad5255;'>They were frozen and couldnt move for the turn!</font>" : null);

        echo "
        <div id='italicblack' style='width:500px;margin:0px auto;height:auto;background:url(images/battletextbg.png) repeat-y;color:#575656;'>
            <div style='width:45%;float:left;'>
            ".$show_user_frozen;
            if(isset($user_weapon_array)) {
                foreach($user_weapon_array as $value) {
                    echo "<div style='padding-bottom:7px;'>".$fightclub->get_item_attr("actiontext", $value)."</div>";
                }
            }
            echo "
            <div style='padding-bottom:7px;'>".$user_move."</div>
            </div>
            <div style='width:45%;float:right;text-align:right;'>
            ".$show_bot_frozen;
            if(isset($bot_weapon_array)) {
                foreach($bot_weapon_array as $value) {
                    echo "<div style='padding-bottom:7px;'>".$fightclub->get_item_attr("botactiontext", $value)."</div>";
                }
            }
            echo "
            <div style='padding-bottom:7px;'>".$bot_move."</div>
            </div>
        <div style='clear:both;'></div>
        </div>
        <div id='italicblack' style='width:500px;margin:0px auto;height:auto;background:url(images/battletextbg.png) repeat-y;color:#575656;'>
            <div style='width:45%;float:left;'>
                <div style='padding-top:10px;font-weight:bold;'>".$show_user_heal."<br />".$show_bot_damage."</div>
            </div>
            <div style='width:45%;float:right;text-align:right;'>
                <div style='padding-top:10px;font-weight:bold;'>".$show_bot_heal."<br />".$show_user_damage."</div>
            </div>
            <div style='clear:both;'></div>
        </div>";
    }
}
?>
