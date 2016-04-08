<?php
session_start();
require "functions.include.php";
$login = new login();

if($login->check_login()) {
    $fightclub = new fightclub((session::get_stat("fight") > 0 ? session::get_stat("fight") : null));
    function return_json($error, $json_array = null) {
            switch($error) {
                
                case 'only_use_two':
                    $return_array["error"] = "You may only use two weapons at a time";
                    break;
                
                case 'invalid_weapon':
                    $return_array["error"] = "Invalid weapon";
                    break;
                
                case 'one_use':
                    $return_array["error"] = "You can only use that weapon once";
                    break;
                
                case 'success':
                    $json_array['status'] = "true";
                    echo json_encode($json_array);
                    exit();
                    break;
                
                case 'flee':
                    $return_array["flee"] = 1;
                    break;
                
                default:
                    $return_array["error"] = $error;
                    break;
            }
            echo json_encode($return_array);
        }

    if($fightclub->fight_exists()) {
        $last_move = $fightclub->get_last_fight(session::get_stat("fight"));

        switch($_POST['action']) {
            case 'run':
                $fightclub->leave_fight($last_move['user_health'], $fightclub->get_fightclub_attr("2_user_id", session::get_stat("fight")));
                return_json('flee');
                exit();
                break;
            default:
                if($fightclub->init_attack(isNumber($_POST['action']), (isset($_POST['weapon']) ? $_POST['weapon'] : null))) {
                    return_json('success', $fightclub->return_array());
                    exit();
                } else {
                    return_json($fightclub->show_error());
                    exit();
                }
                break;
        }
    }
}
?>
