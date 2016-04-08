<?php

class activity {
    public function __construct() {
        
    }
    
    public function last_seen($session) {
        if(strtotime(date("Y/m/d H:i:s"))-strtotime($session)>180) {
            $this->insert_last_seen();
        }
    } 
    
    public function set_last_seen() {
        $this->insert_last_seen();
    }
    
    public function insert_last_seen() {
        $_SESSION['last_activity'] = date("Y/m/d H:i:s");
        db_core::getInstance()->conn->query("INSERT INTO `user_activity` (user_id, time, ip) VALUES ('".$_SESSION['user_id']."', '".date("Y/m/d H:i:s")."', '".$_SERVER['REMOTE_ADDR']."')");
    }
    
    public static function get_last_activity($user_id, $value) {
        $query = db_core::getInstance()->conn->prepare("SELECT * FROM user_activity WHERE user_id = :user_id ORDER BY id DESC LIMIT 1");
        $query->bindValue(":user_id", $user_id, PDO::PARAM_STR);
        $query->execute();
        if($query->rowCount()>0) {
            $fetch = $query->fetch(PDO::FETCH_ASSOC);
	    return $fetch[$value];
        }
        return false;
    }
    

}
?>
