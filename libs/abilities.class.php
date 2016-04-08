<?php

class abilities {
    
    public function ability_power($ability_id) {
        switch($ability_id) {
            case '1':
                break;
            case '2':
                break;
            case '3':
                break;
        }
    }
    
    public function ability_type($ability_id) {
        
    }
    
    public function get_ability($ability_id) {
        $query = $this->core->conn->prepare("SELECT * FROM abilities WHERE id = :id");
        $query->bindValue(":id", $ability_id);
        $query->execute();
        $fetch = $query->fetch(PDO::FETCH_ASSOC);
        return $fetch;
    }
    
    public static function get_ability_attr($attr, $ability_id) {
        $query = db_core::getInstance()->conn->prepare("SELECT ".$attr." FROM abilities WHERE id = :id");
        $query->bindValue(":id", $ability_id);
        $query->execute();
        $fetch = $query->fetch(PDO::FETCH_ASSOC);
        return $fetch[$attr];
    }
    
    public static function ability_exists($ability_id, $user_id) {
        $query = db_core::getInstance()->conn->prepare("SELECT id FROM user_abilities WHERE user_id = '".$user_id."' AND ability_id = :ability_id");
        $query->bindValue(":ability_id", $ability_id);
        $query->execute();
        if($query->rowCount() > 0) {
            return true;
        }
        return false;
    }
}
?>
