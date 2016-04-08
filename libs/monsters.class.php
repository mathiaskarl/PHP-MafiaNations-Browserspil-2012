<?php

class monsters {
    private $monster_id;
    
    public function __construct($monster_id) {
        $this->monster_id = $monster_id;
        $this->core = db_core::getInstance();
    }
    
    private function set_monster_id($monster_id = null) {
        return ($monster_id != null ? $monster_id : $this->monster_id);
    }
    
    public function get_monster($monster_id = null) {
        $query = $this->core->conn->prepare("SELECT * FROM monsters WHERE id = :id");
        $query->bindValue(":id", $this->set_monster_id($monster_id));
        $query->execute();
        $fetch = $query->fetch(PDO::FETCH_ASSOC);
        return $fetch;
    }
    
    public static function get_monster_attr($attr, $monster_id) {
        $query = db_core::getInstance()->conn->prepare("SELECT ".$attr." FROM monsters WHERE id = :id");
        $query->bindValue(":id", $monster_id);
        $query->execute();
        $fetch = $query->fetch(PDO::FETCH_ASSOC);
        return $fetch[$attr];
    }
    
    public static function set_fight_stat($fight_stat, $monster_id, $user_id) {
        db_core::getInstance()->conn->query("UPDATE user_monsters SET `".$fight_stat."` = (`".$fight_stat."`+1) WHERE user_id = '".$user_id."' AND monster_id = '".$monster_id."'");
    }
    
    public static function monster_exists($monster_id) {
        $query = db_core::getInstance()->conn->prepare("SELECT user_monsters.id FROM user_monsters
                                            INNER JOIN monsters ON monsters.id = user_monsters.monster_id
                                            WHERE monsters.id = :id");
        $query->bindValue(":id", $monster_id);
        $query->execute();
        if($query->rowCount() > 0) {
            return true;
        }
        return false;
    }
}
?>
