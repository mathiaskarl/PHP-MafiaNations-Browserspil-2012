<?php

class events extends stats {
    private $_event;
    private $_event_header;
    private $_event_text;
    private $_event_image;
    private $_temp_var;
    
    public function __construct() {
        stats::__construct($_SESSION['user_id']);
    }
    
    private function event_exists() {
        if(session::get_stat("event") > 0) {
            $this->_event = $this->get_stat("event");
            return true;
        }
        return false;
    }
    
    public function show_event() {
        if($this->event_exists()) {
            $this->init_event($this->_event);
            
            $temp_html = "
            <div style='width:100%;margin:0px auto;'>
                <div style='width:396px;padding-bottom:25px;margin:0px auto;height:103px;background:url(images/eventbg.png) 0 0 no-repeat;'>
                    <div style='height:12px;width:100%;text-align:right;position:relative;'>
                    <a href='http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."&eh=erase_event'><img src='images/cross.png' style='margin-top:3px;margin-right:3px;'></a>
                    </div>
                    <div style='float:left;width:80px;height:80px;margin:0px 12px 12px 12px;background:url(images/random/".$this->_event_image.") 0 0 no-repeat;'>
                    </div>
                    <div id='italicblack' style='float:left;font-size:13px;'>
                    ".$this->_event_header."
                    <div id='italicblack' style='margin-top:3px;font-size:12px;color:#584e4c;'>
                    ".$this->_event_text."
                    </div>
                    <div id='italicblack' style='margin-top:4px;font-size:12px;color:#584e4c;'>
                    <a href='?p=events'>View all events</a>
                    </div>
                    </div>
                    <div style='clear:both;'></div>
                </div>
            </div>";
            return $temp_html;
        }
    }
    
    private function init_event($event_id) {
        switch($event_id) {
            default:
                break;
                
            case '1':
                $this->_event_header = "Something has happened!";
                $this->_event_text = "Congratulations, you have gained a level!<br>You are now level <b>". session::get_stat("lvl") ."</b>.'";
                $this->_event_image = "level.png";
                break;
        }
    }
    
    public function remove_event() {
        if($this->event_exists()) {
            $this->set_stat("event", "0", $_SESSION['user_id']);
        }
    }
    
    public function set_event($event_id, $user_id = null) {
        $this->set_stat("event", $event_id, ($user_id != null ? $user_id : $_SESSION['user_id']));
    }
}        
?>
