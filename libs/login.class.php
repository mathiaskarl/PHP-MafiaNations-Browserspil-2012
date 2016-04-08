<?php
class login 
{
    
    public $id;
    private $_username;
    private $_password;
    private $_passmd5;
    private $_last_activity;
    
    private $_login;
    private $_access;
    private $_token;
    private $_errors;
    private $_current_date;
    
    
    public function __construct() 
    {
	$this->core = db_core::getInstance();
	
	$this->_errors	= array();
	$this->_login	= isset($_POST['login']) ? 1 : 0;
	$this->_access	= false;
	$this->_token	= isset($_POST['token']) ? $_POST['token'] : "";
	$this->_last_activity = isset($_SESSION['last_activity']) ? $_SESSION['last_activity'] : "";
	$this->_current_date = date("Y/m/d H:i:s");
	
	$this->id	    = 0;
	$this->_username    = ($this->_login) ? $this->filter($_POST['username']) : (isset($_SESSION['username']) ? $_SESSION['username'] : "");
	$this->_password    = ($this->_login) ? $_POST['password'] : "";
	$this->_passmd5	    = ($this->_login) ? md5($this->_password) : (isset($_SESSION['password']) ? $_SESSION['password'] : "");
    }
    
    public function check_login($var = null) 
    {
	isset($var) ? $this->verify_post() : $this->verify_session();
	return $this->_access;
    }
    
    public function filter($var) 
    {
	return preg_replace('/[^a-zA-Z0-9]/', '', $var);
    }
    
    public function verify_post()
    {
	try 
	{
	    if(!$this->token_valid()) {
		throw new Exception ("invalid_form");
	    }
	    
	    if(empty($this->_username) || empty($this->_password)) {
		throw new Exception ("empty_form");
	    }
	    
	    if(!$this->data_valid()) {
		throw new Exception ("invalid_data");
	    }
	    
	    if($this->session_exist()) {
		throw new Exception ("login_exists");
	    }
	    
	    if(!$this->verify_login()) {
		throw new Exception ("invalid_info");
	    }
            
            if(!$this->verify_activation()) {
                throw new Exception ("require_activation");
            }
	    
	    $this->_access = true;
	    $this->register_session();
	    $this->log_in();
	}
	catch (Exception $e) 
	{
	    $this->_errors[] = $e->getMessage();
	}
    }
    
    public function verify_session()
    {
	if($this->session_exist()){
	    $this->_access = true;
	}
    }
    
    public function verify_login()
    {
	$query = $this->core->conn->prepare("SELECT id FROM `users` WHERE username = :username AND password = :password");
	$query->bindValue(":username", $this->_username, PDO::PARAM_STR);
	$query->bindValue(":password", $this->_passmd5, PDO::PARAM_STR);
	$query->execute();
	
	if($query->rowCount() > 0) {
	    $fetch = $query->fetch(PDO::FETCH_ASSOC);
	    $this->id = $fetch['id'];
	    return true;
	} else {
	    return false;
	}
	
    }
    
    public function verify_activation() {
        $query = $this->core->conn->prepare("SELECT activate FROM `users` WHERE id = '". $this->id."'");
        $query->execute();
        $fetch = $query->fetch(PDO::FETCH_ASSOC);
        if($fetch['activate'] == 1) {
            return true;
        }
        return false;
    }
    
    public function data_valid()
    {
	return (preg_match('/[^a-zA-Z0-9]/', $this->_username)) ? false : true;
    }
    
    public function token_valid()
    {
	return (!isset($_SESSION['token']) || $_SESSION['token'] != $this->_token) ? false : true;
    }
    
    public function register_session()
    {
	$_SESSION['user_id'] = $this->id;
	$_SESSION['username'] = $this->_username;
	$_SESSION['password'] = $this->_passmd5;
        $_SESSION['last_activity'] = date("Y/m/d H:i:s");
    }
    
    public function session_exist() 
    {
	return (isset($_SESSION['username']) && isset($_SESSION['password'])) ? true : false;
    }
    
    public function show_error()
    {
	foreach($this->_errors as $key => $value) {
	    return $value;
	}
    }
    
    public function log_in() 
    {
	return $this->core->conn->query("INSERT INTO `user_activity` (user_id, type, time, ip) VALUES ('".$this->id."', 'login', '".$this->_current_date."', '".$_SERVER['REMOTE_ADDR']."')"); 
    }
    
    public function log_out()
    {
	if($this->session_exist() && $this->verify_login()) 
	{
	    $this->core->conn->query("INSERT INTO `user_activity` (user_id, type, time, ip) VALUES ('".$this->id."', 'logout', '".$this->_current_date."', '".$_SERVER['REMOTE_ADDR']."')");
	    unset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['password'], $_SESSION['last_activity'], $_SESSION['stats'], $_SESSION['equiptment']);
	    return true;
	}
	else 
	{
	    return false;
	}
    }
}

?>
