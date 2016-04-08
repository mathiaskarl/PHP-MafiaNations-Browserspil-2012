<?php
class item_abilities {
    public $return_text;
    private $return;
    
    public function use_ability($item_id) {
        
        $stats = new stats($_SESSION['user_id']);
        $this->return = true;
        switch($item_id) {
            default: 
                $this->return = false;
            break;

            // Small Healing Potion (50hp heal)
            case '3':
                $stats->set_stat("hp", ((session::get_stat("hp")+50) > session::get_stat("maxhp") ? session::get_stat("maxhp") : session::get_stat("hp")+50));
                $this->return_text = "That was wonderful. You feel very refreshed!";
            break;

            // Ham And Cheese Sandwich (50mp energy)
            case '5':
                $stats->set_stat("ep", ((session::get_stat("ep")+50) > session::get_stat("maxep") ? session::get_stat("maxep") : session::get_stat("ep")+50));
                $this->return_text = "Yummy! That sandwich was delicious!";
            break;

            // Small Energy Potion (100ep restored)
            case '7':
                $stats->set_stat("ep", ((session::get_stat("ep")+100) > session::get_stat("maxep") ? session::get_stat("maxep") : session::get_stat("ep")+100));
            break;

            // Small Experience Potion (250xp gained)
            case '8':
                $rank = new rank();
                $rank->insertRank(250, $_SESSION['user_id']);
                $this->return_text = "That was awesome! I could sure use some more of that!";
            break;
        }
        return $this->return;
    }
    
    public function show_return() {
        return $this->return_text;
    }
}
?>
