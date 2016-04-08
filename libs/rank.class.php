<?php
class rank {
    public static function getRank($rank) {
            $rankName[1] = "Trial";
            $rankName[2] = "Street Associate I";
            $rankName[3] = "Street Associate II";
            $rankName[4] = "Street Associate III";
            $rankName[5] = "Street Soldier I";
            $rankName[6] = "Street Soldier II";
            $rankName[7] = "Street Soldier III";
            $rankName[8] = "Street Gangster I";
            $rankName[9] = "Street Gangster II";
            $rankName[10] = "Dealer I";
            $rankName[11] = "Dealer II";
            $rankName[12] = "Dealer III";
            $rankName[13] = "Gang Dealer I";
            $rankName[14] = "Gang Dealer II";
            return $rankName[$rank];
    }

    public static function showRank($rank) {
            $rankMax[1] = "200";
            $rankMax[2] = "400";
            $rankMax[3] = "800";
            $rankMax[4] = "1500";
            $rankMax[5] = "2500";
            $rankMax[6] = "4000";
            $rankMax[7] = "6000";
            $rankMax[8] = "7500";
            $rankMax[9] = "10000";
            $rankMax[10] = "13000";
            $rankMax[11] = "17000";
            $rankMax[12] = "22500";
            $rankMax[13] = "30000";
            $rankMax[14] = "35000";
            return $rankMax[$rank];
    }

    private function giftRank($rank, $user_id = null, $username = null) {
        $user = ($user_id != null ? $user_id : $_SESSION['user_id']);
        $username = ($username != null ? $username : $_SESSION['username']);
        $stats = new stats($user);
        $items = new items();
            switch ($rank) {
            default: 
                echo "Error d001";
                echo $rank;
                break;

            case '2':
                $stats->set_stat('mc', session::get_stat('mc')+5000); 
                mail::send_mail_admin($username, "Hello ".$username.".\n\nWe noticed that you increased to level <b>".$rank."</b>\nTherefor we would like to give you the following:\n\n<b>5,000 Mafia Coins</b>\n\nAdministrator.", "You have gained a level!");
                break;

            case '3':
                $stats->set_stat('maxhp', session::get_stat('maxhp')+20);
                mail::send_mail_admin($username, "Hello ".$username.".\n\nWe noticed that you increased to level <b>".$rank."</b>\nTherefor we would like to give you the following:\n\n<b>+20 Maximum Health</b>\n<b>+ Access to The Black Market</b>\n\nAdministrator.", "You have gained a level!");
                break;

            case '4':
                $stats->set_stat('mc', session::get_stat('mc')+10000);
                mail::send_mail_admin($username, "Hello ".$username.".\n\nWe noticed that you increased to level <b>".$rank."</b>\nTherefor we would like to give you the following:\n\n<b>10,000 Mafia Coins</b>\n\nAdministrator.", "You have gained a level!");
                break;

            case '5':
                mail::send_mail_admin($username, "Hello ".$username.".\n\nWe noticed that you increased to level <b>".$rank."</b>\nTherefor we would like to give you the following:\n\n<b>A Secret Avatar</b>\n\nAdministrator.", "You have gained a level!");
                break;

            case '6':
                $stats->set_stat('dodge', session::get_stat('dodge')+2);
                mail::send_mail_admin($username, "Hello ".$username.".\n\nWe noticed that you increased to level <b>".$rank."</b>\nTherefor we would like to give you the following:\n\n<b>2% Dodge Chance</b>\n\nAdministrator.", "You have gained a level!");
                break;

            case '7':
                mail::send_mail_admin($username, "Hello ".$username.".\n\nWe noticed that you increased to level <b>".$rank."</b>\nTherefor we would like to give you the following:\n\n<b>A Secret Fightclub Challenger</b>\n\nAdministrator.", "You have gained a level!");
                break;

            case '8':
                $items->handle_item("add", '1', $user);
                mail::send_mail_admin($username, "Hello ".$username.".\n\nWe noticed that you increased to level <b>".$rank."</b>\nTherefor we would like to give you the following:\n\n<b>A Desert Eagle</b>\n\nAdministrator.", "You have gained a level!");
                break;

            case '9':
                $stats->set_stat('attbonus', session::get_stat('attbonus')+2);
                mail::send_mail_admin($username, "Hello ".$username.".\n\nWe noticed that you increased to level <b>".$rank."</b>\nTherefor we would like to give you the following:\n\n<b>2% Attack Bonus</b>\n\nAdministrator.", "You have gained a level!");
                break;

            case '10':
                $stats->set_stat('inv', session::get_stat('dodge')+20);
                mail::send_mail_admin($username, "Hello ".$username.".\n\nWe noticed that you increased to level <b>".$rank."</b>\nTherefor we would like to give you the following:\n\n<b>20 Extra Inventory Slots</b>\n\nAdministrator.", "You have gained a level!");
                break;
            }
    }

    public function insertRank($xp_gain, $user_id = null) {
            $user = ($user_id != null ? $user_id : $_SESSION['user_id']);
            $stats = new stats($user);
            $deposit_xp = session::get_stat("xp")+$xp_gain;
            
            if($deposit_xp >= self::showRank(session::get_stat("lvl"))) {
                $xp_left = $deposit_xp-self::showRank(session::get_stat("lvl"));
                $set_level = session::get_stat("lvl")+1;
                $stats->set_stat('lvl', $set_level);
                
                $this->giftRank($set_level);
                $stats->set_stat("xp", $xp_left);
            } else {
                $stats->set_stat("xp", $deposit_xp);
            }
    }
}
?>