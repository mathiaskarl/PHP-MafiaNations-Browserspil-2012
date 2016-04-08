<?php

class items extends stats 
{
	public $item_id;
	public $core;
	
	public function __construct($item_id = null) 
	{
	    $this->item_id = $item_id;
	    $this->core = db_core::getInstance();
	}		
	
	function get_item_id($id, $type) 
	{
	    switch($type) {
		case 'inventory':
		    $query = $this->core->conn->query("SELECT item_id FROM `user_inventory` WHERE id = '".$id."'");
		    break;
	    }
	    
	    $fetch = $query->fetch(PDO::FETCH_ASSOC);
	    return $fetch['item_id'];
	}
	
	function get_item($item_id) 
	{
	    $query = $this->core->conn->query("SELECT * FROM items WHERE id = '".$item_id."'");
	    $fetch = $query->fetch(PDO::FETCH_ASSOC);
	    return $fetch;
	}
        
        function get_item_attr($attr, $item_id) {
            $query = $this->core->conn->query("SELECT ". $attr ." FROM items WHERE id = '".$item_id."'");
	    $fetch = $query->fetch(PDO::FETCH_ASSOC);
	    return $fetch[$attr];
        }
	
	function get_item_stat($stat_name, $item_id) 
	{
	    $query = $this->core->conn->query("SELECT item_stats.value FROM item_stats
					      INNER JOIN stats ON item_stats.stat_id = stats.id
					      WHERE (stats.name = '".$stat_name."' OR stats.shortname = '".$stat_name."')
					      AND item_stats.item_id = '".$item_id."'");
	    $fetch = $query->fetch(PDO::FETCH_ASSOC);
	    return $fetch['value'];
	}
	
	function set_item_stat($stat_name, $value, $item_id) 
	{
	    $this->core->conn->query("UPDATE item_stats
				INNER JOIN stats ON item_stats.stat_id = stats.id 
				SET item_stats.value = '".$value."' 
				WHERE (stats.name = '".$stat_name."' OR stats.shortname = '".$stat_name."') 
				AND item_stats.item_id = ".$item_id);
	}	
	
	function handle_item($action, $item_id, $user_id = null) 
	{
            if($item_id > 0) {
                switch($action) {
                    case 'add':
                        $this->core->conn->query("INSERT INTO `user_inventory` (item_id, user_id) VALUES ('".$item_id."', '".$user_id."')");
                        break;

                    case 'remove':
                        $this->core->conn->query("DELETE FROM `user_inventory` WHERE id = '".$item_id."'");
                        break;
                }
            }
	}
        
        public static function item_exists($item_id, $inventory = null) {
            if(isset($inventory)) {
                $query = db_core::getInstance()->conn->prepare("SELECT item_id FROM user_inventory WHERE id = :id");
                $query->bindValue(":id", $item_id, PDO::PARAM_STR);
                $query->execute();
                if($query->rowCount() > 0) {
                    return true;
                }
                return false;
            } else {
                $query = db_core::getInstance()->conn->prepare("SELECT name FROM items WHERE id = :id");
                $query->bindValue(":id", $item_id, PDO::PARAM_STR);
                $query->execute();
                if($query->rowCount() > 0) {
                    return true;
                }
                return false;
            }
        }
	
}
?>
