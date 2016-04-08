<?php

class mail extends stats {
    public $user_id;
    
    private $to_user_id;
    private $_error;
    private $_handle_error;
    private $_reply;
    
    public function __construct($user_id = null) {
        $this->core = db_core::getInstance();
        $this->user_id = ($user_id != null ? $user_id : $_SESSION['user_id']);
    }
    
    public function get_user($user_id = null) {
        $user = ($user_id > 0 ? $user_id : $this->user_id);
        return $user;
    }
    
    public function get_mail($mail_id) {
        $query = $this->core->conn->prepare("SELECT * FROM user_mail WHERE id = :id");
        $query->bindValue(":id", $mail_id, PDO::PARAM_STR);
        $query->execute();
        if($query->rowCount() > 0) {
            $fetch = $query->fetch(PDO::FETCH_ASSOC);
            return $fetch;
        }
    }
    
    private function get_mail_attr($attr, $mail_id) {
        $query = $this->core->conn->prepare("SELECT ".$attr." FROM user_mail WHERE id = :id");
        $query->bindValue(":id", $mail_id, PDO::PARAM_STR);
        $query->execute();
        if($query->rowCount() > 0) {
            $fetch = $query->fetch(PDO::FETCH_ASSOC);
            return $fetch[$attr];
        }
    }
    
    public function delete_mail($mail_id) {
        if(is_array($mail_id)) {
            foreach($mail_id as $value) {
                $this->handle_mail_error($value);
            }
        } else {
            $this->handle_mail_error($mail_id);
        }
        return $this->_handle_error;
    }
    
    public function mark_mail($mail_id, $mark_status) {
        foreach($mail_id as $value) {
            $this->handle_mail_error($value, $mark_status);
        }
        return $this->_handle_error;
    }
    
    public function send_mail($sent_to, $message, $subject, $reply = null) {
        $this->to_user_id = user::get_user_id($sent_to);
        $this->_reply = ($reply != null ? $reply : null);
        $this->handle_send_error($message, $subject);
        
        return $this->_handle_error;
    }
    
    public static function send_mail_admin($sent_to, $message, $subject) {
        $to_user = user::get_user_id($sent_to);
        $admin = 1;
        $query = db_core::getInstance()->conn->prepare("INSERT INTO `user_mail` (`sent_to`, `sent_from`, `subject`, `message`, `time`) VALUES ('".$to_user."', '".$admin."', :subject, :message, '".date("Y-m-d H:i:s")."')");
        $query->bindValue(":message", $message, PDO::PARAM_STR);
        $query->bindValue(":subject", $subject, PDO::PARAM_STR);
        $query->execute();
    }
    
    private function handle_mail_error($mail_id, $mark_status = null) {
        $this->_handle_error = false;
        try 
	{
            if(!$this->mail_exists($mail_id)) {
		throw new Exception ("invalid_mail");
	    }
            
            if($this->get_mail_attr("sent_to", $mail_id) != $_SESSION['user_id']) {
                throw new Exception ("invalid_mail");
            }
	    
	    $this->_handle_error = true;
            if($mark_status != null) {
                $this->handle_mark_mail($mail_id, $mark_status);
            } else {
                $this->handle_delete_mail($mail_id);
            }
	}
	catch (Exception $e) 
	{
	    $this->_error = $e->getMessage();
	}
    }
    
    private function handle_send_error($message, $subject){
         $this->_handle_error = false;
        try 
	{
            if($this->to_user_id < 1) {
		throw new Exception ("unknown_user");
	    }
            
            if($this->to_user_id == $_SESSION['user_id']) {
                throw new Exception ("send_self");
            }
            
            if($message == null || $message == "") {
                throw new Exception ("no_message");
            }
            
            if($subject == null || $subject == "") {
                throw new Exception ("no_subject");
            }
            
            if(!$this->mail_full()) {
                throw new Exception ("mail_full");
            }
            
            if(!$this->mail_block()) {
                throw new Exception ("mail_block");
            }
	    
	    $this->_handle_error = true;
            $this->handle_send_mail($message, $subject);

	}
	catch (Exception $e) 
	{
	    $this->_error = $e->getMessage();
	}
    }
    
    public function show_error() {
        return $this->_error;
    }
    
    private function handle_delete_mail($mail_id) {
        $query = $this->core->conn->prepare("DELETE FROM user_mail WHERE id = :id");
        $query->bindValue(":id", $mail_id, PDO::PARAM_STR);
        $query->execute();
    }
    
    private function handle_mark_mail($mail_id, $mark_status) {
        $mark_status = ($mark_status == "read" ? 1 : 0);
        $query = $this->core->conn->prepare("UPDATE user_mail SET status = '".$mark_status."' WHERE id = :id");
        $query->bindValue(":id", $mail_id, PDO::PARAM_STR);
        $query->execute();
    }
    
    private function handle_send_mail($message, $subject) {
        if($this->_reply != null && $this->mail_exists($this->_reply)) {
            $reply_message = $this->get_mail_attr("message", $this->_reply);
            $query = $this->core->conn->prepare("INSERT INTO `user_mail` (`sent_to`, `sent_from`, `subject`, `message`, `time`, `reply_message`) VALUES ('".$this->to_user_id."', '".$this->user_id."', :subject, :message, '".date("Y-m-d H:i:s")."', '".$reply_message."')");
        } else {
            $query = $this->core->conn->prepare("INSERT INTO `user_mail` (`sent_to`, `sent_from`, `subject`, `message`, `time`) VALUES ('".$this->to_user_id."', '".$this->user_id."', :subject, :message, '".date("Y-m-d H:i:s")."')");
        }
        $query->bindValue(":message", $message, PDO::PARAM_STR);
        $query->bindValue(":subject", $subject, PDO::PARAM_STR);
        $query->execute();
    }

    private function mail_full() {
        $query = $this->core->conn->prepare("SELECT id FROM user_mail WHERE sent_to = :id");
        $query->bindValue(":id", $this->to_user_id, PDO::PARAM_STR);
        $query->execute();
        if($query->rowCount()>=$this->get_stat("mailspace", $this->to_user_id)) {
            return false;
        }
        return true;
    }
    
    private function mail_block() {
        return ($this->get_stat("blockmail", $this->to_user_id)>0 ? false : true);
    }

    private function mail_exists($mail_id) {
        $query = $this->core->conn->prepare("SELECT sent_from, sent_to FROM user_mail WHERE id = :id");
        $query->bindValue(":id", $mail_id, PDO::PARAM_STR);
        $query->execute();
        if($query->rowCount()>0) {
            return true;
        }
        return false;
    }
    
    public static function set_status($status, $mail_id) {
        db_core::getInstance()->conn->query("UPDATE user_mail SET status = '".$status."' WHERE id = '".$mail_id."'");
    }
    
    public static function new_mail() {
        $query = db_core::getInstance()->conn->query("SELECT id FROM user_mail WHERE sent_to = '".$_SESSION['user_id']."' AND status != '1' AND status != '2'");
        if($query->rowCount() > 0) {
            return "<b>".$query->rowCount()."</b>";
        }
        return 0;
    }
    
    public static function allow_mail($user_id, $mail_id) {
        $query = db_core::getInstance()->conn->prepare("SELECT sent_from FROM user_mail WHERE id = :id AND sent_to = :sent_to");
        $query->bindValue(":id", $mail_id, PDO::PARAM_STR);
        $query->bindValue(":sent_to", $user_id, PDO::PARAM_STR);
        $query->execute();
        if($query->rowCount()>0) {
            return true;
        }
        return false;
    }
}
?>
