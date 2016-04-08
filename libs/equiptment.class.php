<?php

class equiptment extends items {
    private $_equiptment = array();
    private $_equiptment_limit = array();
    private $_handle_error;
    private $_error;
    private $_open_slot;
    private $_weapon_id;
    private $_raw_weapon_id;
    
    public $user_id;
    
    public function __construct($user_id = null) {
        $this->core = db_core::getInstance();
        $this->user_id = ($user_id != null ? $user_id : $_SESSION['user_id']);
    }
    
    public function build_equiptment($user_id = null) {
        if(!isset($_SESSION['equiptment']) || $_SESSION['equiptment'] == null || $_SESSION['equiptment'] == "") {
            $this->equiptment_session($this->get_user($user_id));
        }
    }
    
    public function get_user($user_id = null) {
        $user = ($user_id > 0 ? $user_id : $this->user_id);
        return $user;
    }
    
    public function equiptment_session() {
        $query = db_core::getInstance()->conn->prepare("SELECT * FROM user_equiptment
                                                    WHERE user_id = :user_id");
        $query->bindValue(":user_id", $this->user_id, PDO::PARAM_STR);
        $query->execute();
        $fetch = $query->fetch(PDO::FETCH_ASSOC);
        $this->_equiptment[1] = (isset($fetch['slot_1']) && $fetch['slot_1'] != null ? $fetch['slot_1'] : null);
        $this->_equiptment[2] = (isset($fetch['slot_2']) && $fetch['slot_2'] != null ? $fetch['slot_2'] : null);
        $this->_equiptment[3] = (isset($fetch['slot_3']) && $fetch['slot_3'] != null ? $fetch['slot_3'] : null);
        $this->_equiptment[4] = (isset($fetch['slot_4']) && $fetch['slot_4'] != null ? $fetch['slot_4'] : null);
        $this->_equiptment[5] = (isset($fetch['slot_5']) && $fetch['slot_5'] != null ? $fetch['slot_5'] : null);
        $this->_equiptment[6] = (isset($fetch['slot_6']) && $fetch['slot_6'] != null ? $fetch['slot_6'] : null);
        $_SESSION['equiptment'] = $this->_equiptment;
    }
    
    public function weapon_limit($weapon_id) {
        $type_array = array("freeze", "bomb", "heal");
        $weapon_type = $this->get_item_attr("weapon_type", $weapon_id);
        if(in_array($weapon_type, $type_array)) {
            if(isset($this->_equiptment_limit[$weapon_type]) && $this->_equiptment_limit[$weapon_type] > 0) {
                return true;
            }
            return false;
        }
        return false;
    }
    
    private function handle_weapon_limit($weapon_id) {
        $type_array = array("freeze", "bomb", "heal");
        $weapon_type = $this->get_item_attr("weapon_type", $weapon_id);
        if(in_array($weapon_type, $type_array)) {
            $this->_equiptment_limit[$weapon_type] = 1;
        } 
    }
    
    public static function create_sql($user_id) {
        db_core::getInstance()->conn->query("INSERT INTO user_equiptment (`user_id`) VALUES ('".$user_id."')");
    }
    
    private function update_sql($slot, $weapon_id = null) {
        $weapon_id = (isset($weapon_id) && $weapon_id != null ? $weapon_id : "0");
        $temp_slot = "slot_".$slot;
        $query = $this->core->conn->prepare("UPDATE user_equiptment SET ".$temp_slot." = :weapon_id WHERE user_id = '".$this->user_id."'");
        $query->bindValue(":weapon_id", $weapon_id, PDO::PARAM_STR);
        $query->execute();
    }
    
    private function drop_item() {
        $return = false;
        foreach($this->_equiptment as $key => $value) {
            if($value == $this->_weapon_id && $value != null && $value != "") {
                $this->update_sql($key);
                session::set_equiptment($key, 0);
                $this->handle_item("add", $this->_weapon_id, $_SESSION['user_id']);
                $return = true;
                break;
            }
        }
        return $return;
    }
    
    public function unequipt_item($weapon_id, $user_id = null) {
      $this->_equiptment = $_SESSION['equiptment'];
      $this->_weapon_id = $weapon_id;
      
      $this->handle_unequipt_error($this->_weapon_id);
      return $this->_handle_error;
    }
    
    public function equipt_item($weapon_id, $user_id = null) {
        $this->_equiptment = $_SESSION['equiptment'];
        $this->_weapon_id = $this->get_item_id($weapon_id, "inventory");
        $this->_raw_weapon_id = $weapon_id;
        foreach($this->_equiptment as $value) {
            $this->handle_weapon_limit($value);
        }
        $this->handle_error($this->_weapon_id);
        return $this->_handle_error;
    }
    
    private function handle_error() {
        $this->_handle_error = false;
        try 
	{
            if(!$this->battle_check()) {
		throw new Exception ("fight");
	    }
            
	    if(!$this->check_storage()) {
		throw new Exception ("no_storage");
	    }
	    
            if(!$this->item_exists($this->_raw_weapon_id, true)) {
                throw new Exception ("invalid_item");
            }
            
	    if(!$this->item_type()) {
		throw new Exception ("invalid_type");
	    }
	    
	    if($this->weapon_limit($this->_weapon_id)) {
		throw new Exception ("only_one");
	    }
	    
	    $this->_handle_error = true;
	    $this->handle_equipt_item();
	}
	catch (Exception $e) 
	{
	    $this->_error = $e->getMessage();
	}
    }
    
    private function handle_unequipt_error() {
        $this->_handle_error = false;
        try 
	{
            if(!$this->battle_check()) {
		throw new Exception ("fight");
	    }
            
	    if(!$this->check_inventory()) {
		throw new Exception ("inventory_full");
            }
	    
	    $this->_handle_error = true;
	    $this->handle_unequipt_item();
	}
	catch (Exception $e) 
	{
	    $this->_error = $e->getMessage();
	}
    }
    
    public function show_error() {
        return $this->_error;
    }
    
    private function handle_equipt_item() {
        $this->update_sql($this->_open_slot, $this->_weapon_id);
        session::set_equiptment($this->_open_slot, $this->_weapon_id);
        $this->handle_item("remove", $this->_raw_weapon_id);
    }
    
    private function handle_unequipt_item() {
        try 
        {
            $this->core->conn->beginTransaction();

            if(!$this->drop_item()) {
               throw new Exception ("invalid_item");
            }
            $this->core->conn->commit();

            // Missing send mail functions
            $this->_handle_error = true;
        } 
        catch (PDOException $e) 
        {
            $this->core->conn->rollBack();
            $this->_error = $e->getMessage();
        }
    }
    
    private function check_storage() {
        $return = false;
        foreach($this->_equiptment as $key => $value) {
            if($value == 0 || $value == "" || $value == null) {
                $this->_open_slot = $key;
                $return = true;
                break;
            }
        }
        return $return;
    }
    
    private function check_inventory() {
        $query = $this->core->conn->query("SELECT item_id FROM user_inventory WHERE user_id = '". $_SESSION['user_id'] ."'");
        return (session::get_stat("inv") <= $query->rowCount() ? false : true);
    }
    
    private function battle_check() {
        if(session::get_stat("fight") > 0) {
            return false;
        }
        return true;
    }
    
    private function item_type() {
        if($this->get_item_attr("item_use", $this->_weapon_id) == "weapon") {
            return true;
        }
        return false;
    }
}
?>
