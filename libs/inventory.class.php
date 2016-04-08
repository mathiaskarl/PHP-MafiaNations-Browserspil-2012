<?php

class inventory extends items {
    public $user_id;
    private $user_to;
    private $user_to_id;
    private $user_from;
    public $item_id;
    private $specific_item_id;
    
    private $_use_return;
    private $_handle_error;
    private $_error;
    
    public function __construct($user_id = null) {
        $this->core = db_core::getInstance();
        $this->user_id = ($user_id != null ? $user_id : $_SESSION['user_id']);
    }
    
    public function get_user($user_id = null) {
        $user = ($user_id > 0 ? $user_id : $this->user_id);
        return $user;
    }
    
    public function send_item($item_id, $user_to, $user_from) {
        $this->user_to = $user_to;
        $this->user_from = $user_from;
        $this->user_to_id = user::user_exists($user_to);
        $this->specific_item_id = $item_id;

        $this->handle_send_error();
        return $this->_handle_error;
    }
    
    public function use_item($item_id) {
        $this->item_id = $this->get_item_id($item_id, "inventory");
        $this->specific_item_id = $item_id;
        
        $this->handle_use_error();
        return $this->_handle_error;
    }
        
        private function handle_send_error() {
            $this->_handle_error = false;
            try 
            {
                if($this->user_to == null || $this->user_to == "") {
                    throw new Exception ("invalid_username");
                }
                
                if(user::user_exists($this->user_to)<1) {
                    throw new Exception ("unknown_username");
                }
                
                if(!$this->send_self()) {
                    throw new Exception ("send_self");
                }
                
                if(!$this->inventory_space($this->user_to_id)) {
                    throw new Exception ("inventory_full");
                }
                
                if(!$this->blocked()) {
                    throw new Exception ("blocked");
                }

                $this->handle_send_item();
            }
            catch (Exception $e) 
            {
                $this->_error = $e->getMessage();
            }
        }
        
        private function handle_use_error() {
            $this->_handle_error = false;
            try 
            {
                if(!$this->item_exists($this->specific_item_id, true)) {
                    throw new Exception ("invalid_item");
                }
                
                if(!$this->battle_check()) {
                    throw new Exception ("fight_item");
                }
                
                if(!$this->useable_check()) {
                    throw new Exception ("not_useable");
                }

                $this->handle_use_item();
            }
            catch (Exception $e) 
            {
                $this->_error = $e->getMessage();
            }
        }
        
        public function show_error() {
            return $this->_error;
        }
        
        public function show_return() {
            return $this->_use_return;
        }
        
        private function handle_send_item() {
            try 
	    {
		$this->core->conn->beginTransaction();
		
		$this->item_id = $this->get_item_id($this->specific_item_id, "inventory");
		$this->handle_item("remove", $this->specific_item_id);
		$this->handle_item("add", $this->item_id, $this->user_to_id);
		
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
        
        private function handle_use_item() {
            try 
	    {
		$this->core->conn->beginTransaction();
		
                $item_abilities = new item_abilities();
                if(!$item_abilities->use_ability($this->item_id)) {
                   throw new Exception ("invalid_item");
                }
		$this->handle_item("remove", $this->specific_item_id);
		
		$this->core->conn->commit();
		
		// Missing send mail functions
                $this->_use_return = $item_abilities->show_return();
                $this->_handle_error = true;
	    } 
	    catch (PDOException $e) 
	    {
		$this->core->conn->rollBack();
		$this->_error = $e->getMessage();
	    }
        }
        
        private function battle_check() {
            if(session::get_stat("fight") > 0) {
                return false;
            }
            return true;
        }
        
        private function useable_check() {
            if($this->get_item_attr("item_use", $this->item_id) != "useable") {
                return false;
            }
            return true;
        }
        
        private function inventory_space($user_id = null) {
            $query = $this->core->conn->query("SELECT item_id FROM user_inventory WHERE user_id = '". $this->get_user($this->user_id) ."'");
            return ($this->get_stat("inv", $this->user_to_id) <= $query->rowCount() ? false : true);
        }
        
        private function send_self() {
            return (strtolower($this->user_to) == strtolower($_SESSION['username']) ? false : true);
        }
        
        private function blocked() {
            return ($this->get_stat("blockitems", $this->user_to_id)>0 ? false : true);
        }
        
}
?>
