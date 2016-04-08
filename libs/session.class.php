<?php

class session {
    
    public function __construct() {
        
    }
    
    private static function exists($session) {
        if(isset($_SESSION[$session]) && $_SESSION[$session] != null) {
            return true;
        }
        return false;
    }
    
    public static function get_stat($stat) {
        if(self::exists("stats")) {
            return $_SESSION["stats"][$stat];
        }
    }
    
    public static function set_stat($stat, $value) {
        $_SESSION["stats"][$stat] = $value;
    }
    
    public static function get_equiptment($slot) {
        if(self::exists("equiptment")) {
            return $_SESSION["equiptment"][$slot];
        }
    }
    
    public static function set_equiptment($slot, $value) {
        $_SESSION["equiptment"][$slot] = $value;
    }
    
}
?>
