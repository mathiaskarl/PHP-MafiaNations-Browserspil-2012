<?php
session_start();
require "functions.include.php";
$login = new login();
$items = new items();
$inventory = new inventory($_SESSION['user_id']);
$equiptment = new equiptment($_SESSION['user_id']);

function switch_error($error) {
    switch($error) {
        case 'invalid_username':
            echo error::return_error_window("You must enter a username.");
            break;
        case 'unknown_username':
            echo error::return_error_window("There is no user with this username.");
            break;
        case 'send_self':
            echo error::return_error_window("You can't send items to yourself.");
            break;
        case 'inventory_full':
            echo error::return_error_window("This users inventory is full.");
            break;
        case 'blocked':
            echo error::return_error_window("This user has chosen not to receive any items.");
            break;
        case 'fight':
            echo error::return_error_window("You can't equipt any weapons while being in a fight.");
            break;
        case 'fight_item':
            echo error::return_error_window("You can't use any items while being in a fight.");
            break;
        case 'not_useable':
            echo error::return_error_window("You can't use this item.");
            break;
        case 'no_storage':
            echo error::return_error_window("You can't equipt more than 6 weapons.");
            break;
        case 'invalid_item':
            echo error::return_error_window("Invalid item");
            break;
        case 'invalid_type':
            echo error::return_error_window("This item is not a weapon and can't be equipted.");
            break;
        case 'only_one':
            echo error::return_error_window("You can only carry one type of these weapons.");
            break;
        default:
            echo error::return_error_window("An error as occoured!");
            break;
    }
}
if($login->check_login()) {
    if(isset($_POST['action'])) {
        $item_id = isNumber($_POST['item_id']);
        switch($_POST['action']) {
            default:
                break;
            case 'give':
                if($inventory->send_item($item_id, safe($_POST['username']), $_SESSION['username'])) {
                    echo error::return_error_window("Your item has been sent to ".safe($_POST['username']), "Item sent");
                } else {
                    switch_error($inventory->show_error());
                }
                break;
            case 'equipt':
                if($equiptment->equipt_item($item_id, $_SESSION['user_id'])) {
                    echo error::return_error_window("You have successfully equipted the item", "Item equipted");
                } else {
                    switch_error($equiptment->show_error());
                }
                break;
            case 'drop':
                if(items::item_exists($item_id, true)) {
                    $items->handle_item("remove", $item_id);
                    echo error::return_error_window("You have successfully dropped this item", "Item dropped");
                } else {
                    switch_error("invalid_item");
                }
                break;
            case 'use':
                if($inventory->use_item($item_id)) {
                    echo error::return_error_window($inventory->show_return(), "Item used");
                } else {
                    switch_error($inventory->show_error());
                }
                break;
        }
    }
}
?>
