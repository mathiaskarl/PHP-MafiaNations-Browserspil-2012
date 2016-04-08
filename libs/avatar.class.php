<?php

class avatar {
    public $user_id;
    
    public function __construct($user_id = null) {
        $this->core = db_core::getInstance();
        $this->user_id = $user_id;
    }
    
    public function get_user($user_id = null) 
	{
	    $user = ($user_id > 0 ? $user_id : $this->user_id);
	    return $user;
	}
    
    private function avatar_exists($avatar_id) {
        $query = $this->core->conn->query("SELECT image FROM avatar WHERE id = '". $avatar_id."'");
        if($query->rowCount() > 0) {
            return true;
        }
        return false;
    }
    
    private function avatar_owned_check($avatar_id, $user_id = null) {
        $query = $this->core->conn->query("SELECT id FROM user_avatars WHERE user_id = '". $this->get_user($user_id)."' AND avatar_id = '".$avatar_id."'");
        if($query->rowCount() > 0) {
            return true;
        }
        return false;
    }
    
    public function return_avatar($avatar_id = null, $user_id = null) {
        if($avatar_id == null) {
            $query = $this->core->conn->query("SELECT image FROM avatar WHERE id = '". user::get_user_info("avatar", $this->get_user($user_id))."'");
        } else {
            $query = $this->core->conn->query("SELECT image FROM avatar WHERE id = '". $avatar_id ."'");
        }
        if($query->rowCount() > 0) {
            $fetch = $query->fetch(PDO::FETCH_ASSOC);
            return $fetch['image'];
        }
        return "1.png";    
    }
    
    public function avatar_count($user_id = null) {
        $query = $this->core->conn->query("SELECT id FROM user_avatars WHERE user_id = '". $this->get_user($user_id) ."'");
        return $query->rowCount();
    }
    
    public  function set_avatar($avatar_id, $user_id = null) {
        if($this->avatar_exists($avatar_id)) {
            $this->core->conn->query("UPDATE users SET avatar = '".$avatar_id."' WHERE id = '".$this->get_user($user_id)."'");
            return true;
        }
        return false;
    }
    
    public function add_avatar($avatar_id, $user_id = null) {
        if($this->avatar_exists($avatar_id)) {
            if(!$this->avatar_owned_check($avatar_id)) {
               $query = $this->core->conn->query("INSERT INTO user_avatars
                                                (user_id, avatar_id)
                                                VALUES
                                                ('".$this->get_user($user_id)."', '".$avatar_id."')"); 
            }
        }
    }
}
?>
