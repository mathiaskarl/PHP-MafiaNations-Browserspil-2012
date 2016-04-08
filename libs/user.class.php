<?php

class user 
{
    private $_user_id;
    
    public function __construct($user_id) 
    {
	$this->core = db_core::getInstance();
	$this->_user_id = $user_id;
	
    }
    
    public function get_user() 
    {
	$query = $this->core->conn->prepare("SELECT * FROM users WHERE id = :user_id");
	$query->bindValue(":user_id", $this->_user_id, PDO::PARAM_INT);
	$query->execute();
	
	if($query->rowCount() > 0) 
	{
	    $fetch = $query->fetch(PDO::FETCH_ASSOC);
	    return $fetch;
	}
    }
    
     public static function get_user_info($row, $user_id) 
    {
	$query = db_core::getInstance()->conn->prepare("SELECT ".$row." FROM users WHERE id = :user_id");
	$query->bindValue(":user_id", $user_id, PDO::PARAM_INT);
	$query->execute();
	
	if($query->rowCount() > 0) 
	{
	    $fetch = $query->fetch(PDO::FETCH_ASSOC);
	    return $fetch[$row];
	}
    }
    
    public static function get_user_id($username) {
        $query = db_core::getInstance()->conn->prepare("SELECT id FROM users WHERE username = :username");
	$query->bindValue(":username", $username, PDO::PARAM_INT);
	$query->execute();
	
	if($query->rowCount() > 0) 
	{
	    $fetch = $query->fetch(PDO::FETCH_ASSOC);
	    return $fetch['id'];
	}
    }
    
    public static function user_exists($username) {
        $query = db_core::getInstance()->conn->prepare("SELECT id FROM users WHERE username = :username");
	$query->bindValue(":username", $username, PDO::PARAM_INT);
	$query->execute();
	
	if($query->rowCount() > 0) 
	{
            $fetch = $query->fetch(PDO::FETCH_ASSOC);
	    return $fetch["id"];
	}
        return 0;
    }
    
    public function delete_user($name)
    {
	//
    }
}
?>
