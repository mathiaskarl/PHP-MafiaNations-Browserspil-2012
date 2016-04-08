<?php
session_start();
require "functions.include.php";
$login = new login();
$fightclub = new fightclub();

function switch_error($error) {
    switch($error) {
        case 'fight_exists':
            echo "You are allready in a fight.";
            break;
        case 'invalid_monster':
            echo "You can't fight this monster.";
            break;
        case 'no_hp':
            echo "You don't have enough hp to fight.";
            break;
        default:
            echo "An error as occoured!";
            break;
    }
}
if($login->check_login()) {
    if($fightclub->create_fight(isNumber($_GET['monster_id']))) {
        echo "success";
    } else {
        echo switch_error($fightclub->show_error());
    }
}
?>
