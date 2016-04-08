<?php
class stats {
	public $user_id;
        public $temp_array = array();
	
	public function __construct($user_id = null) 
	{
            $this->core = db_core::getInstance();
	    $this->user_id = $user_id;
	}
	
	public function get_user($user_id = null) 
	{
	    $user = ($user_id > 0 ? $user_id : $this->user_id);
	    return $user;
	}
	
	public function get_stat($stat_name, $user_id = null) 
	{
	    $query = $this->core->conn->query("SELECT user_stats.value as value FROM user_stats 
					INNER JOIN stats ON user_stats.stat_id = stats.id 
					WHERE (stats.name = '".$stat_name."' OR stats.shortname = '".$stat_name."') 
					AND user_stats.user_id = ".$this->get_user($user_id));
	    $value = $query->fetch(PDO::FETCH_ASSOC);
	    return $value['value'];
	}
        
        private function get_stat_id($shortname) {
            $query = $this->core->conn->query("SELECT id FROM stats WHERE shortname = '". $shortname ."'");
	    $value = $query->fetch(PDO::FETCH_ASSOC);
	    return $value['id'];
        }
        
	private function stat_query($user_id = null) 
	{
	    $query = $this->core->conn->query("SELECT user_stats.value as value, stats.shortname as shortname FROM user_stats 
					INNER JOIN stats ON user_stats.stat_id = stats.id 
					WHERE user_stats.user_id = ".$this->get_user($user_id));
	    while($fetch = $query->fetch(PDO::FETCH_ASSOC)) {
                $this->temp_array[$fetch['shortname']] = $fetch['value'];
            }
	}
        
        public function store_session($user_id = null) {
            $this->stat_query($this->get_user($user_id));
            $_SESSION['stats'] = $this->temp_array;
        }
        
        private function stat_exists($stat_name, $user_id = null) {
            $query = $this->core->conn->query("SELECT user_stats.id FROM user_stats
                                        INNER JOIN stats ON stats.id = user_stats.stat_id
                                        WHERE user_stats.user_id = '". $this->get_user($user_id) ."'
                                        AND stats.shortname = '". $stat_name ."'");
            if($query->rowCount() > 0) {
                return true;
            }
            return false;
        }
        
	public function set_stat($stat_name, $value, $user_id = null, $no_session = null) 
	{
            if($this->stat_exists($stat_name, $this->get_user($user_id))) {
	    $this->core->conn->query("UPDATE user_stats
				INNER JOIN stats ON user_stats.stat_id = stats.id 
				SET user_stats.value = '".$value."' 
				WHERE (stats.name = '".$stat_name."' OR stats.shortname = '".$stat_name."') 
				AND user_stats.user_id = ".$this->get_user($user_id));
            if($no_session == null) {
                session::set_stat($stat_name, $value);
            }
            } else {
            $this->core->conn->query("INSERT INTO user_stats 
                                (value, user_id, stat_id)
                                VALUES
                                ('".$value."', '". $this->get_user($user_id) ."', '".$this->get_stat_id($stat_name)."')");
            if($no_session == null) {
                session::set_stat($stat_name, $value);
            }
            }
	}
        
	
	public function stat_procent($stat_one, $stat_two) 
	{
	    return ($stat_one / $stat_two * 100);
	}
}
?>