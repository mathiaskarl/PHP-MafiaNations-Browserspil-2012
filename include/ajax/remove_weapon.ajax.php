<?php
session_start();
require "functions.include.php";
$login = new login();
$equiptment = new equiptment($_SESSION['user_id']);

function switch_error($error) {
    switch($error) {
        case 'fight':
            echo "You can't unequipt items while being in a fight.";
            break;
        case 'inventory_full':
            echo "Your inventory is full.";
            break;
        case 'invalid_item':
            echo "Invalid item.";
            break;
        default:
            echo "An error as occoured!";
            break;
    }
}
if($login->check_login()) {
    $weapon_id = (isset($_GET['id']) ? isNumber($_GET['id']) : 0);
    if($weapon_id > 0) {
        if(!$equiptment->unequipt_item($weapon_id)) 
        {
            switch_error($equiptment->show_error());
        } else {
            echo "You have unequipted ". $equiptment->get_item_attr("name", $weapon_id) .".";
        }
    } else {
        echo "You cannot unequipt this item!";
    }
}
?>
