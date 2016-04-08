<?php

class mafia {
    
    public static function get_mafia_name($mafia_id = null) {
        $mafia_id = ($mafia_id != null ? $mafia_id : session::get_stat("mafia"));
        switch($mafia_id) {
            default:
                return "Unknown";
            case '1':
                return "Chinese";
                break;
            case '2':
                return "Russian";
                break;
            case '3':
                return "Italian";
                break;
        }
    }
    
    public static function has_chosen() {
        return (session::get_stat("mafia")>0 ? true : false);
    }
}
?>
