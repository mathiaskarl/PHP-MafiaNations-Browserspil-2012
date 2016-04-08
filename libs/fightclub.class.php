<?php

class fightclub extends items {
    public $fight_id;
    
    private $_error;
    private $_handle_error;
    private $last_move = array();
    private $fight_complete;
    
    public $user_id;
    public $equiptment = array();
    public $weapons_used = array();
    private $user_weapons_string;
    private $user_current_hp;
    private $user_max_hp;
    private $user_hp_percent;
    private $user_defense_bonus;
    private $user_attack_bonus;
    private $user_dodge;
    private $user_dodged;
    private $user_move;
    private $user_damage;
    private $user_defense;
    private $user_heal;
    private $user_used_heal;
    private $user_used_bomb;
    private $user_used_freeze;
    
    private $temp_user_heal;
    private $temp_user_bomb;
    private $temp_user_freeze;
    
    public $monster_id;
    private $bot_equiptment = array();
    private $bot_equiptment_type = array();
    private $bot_weapons_used = array();
    private $bot_weapons_string;
    private $bot_current_hp;
    private $bot_max_hp;
    private $bot_hp_percent;
    private $bot_defense_bonus;
    private $bot_attack_bonus;
    private $bot_dodge;
    private $bot_dodged;
    private $bot_move;
    private $bot_damage;
    private $bot_defense;
    private $bot_heal;
    private $bot_used_heal;
    private $bot_used_bomb;
    private $bot_used_freeze;
    
    private $temp_bot_heal;
    private $temp_bot_bomb;
    private $temp_bot_freeze;
    
    public function __construct($fight_id = null, $user_id = null) {
        $this->core = db_core::getInstance();
        $this->fight_id = ($fight_id != null ? $fight_id : null);
        $this->user_id = ($user_id != null ? $user_id : $_SESSION['user_id']);
        $this->equiptment = $_SESSION['equiptment'];
        if($fight_id != null) {
            $this->last_move = $this->get_last_fight();
        }
    }
    
    public function get_user($user_id = null) {
        $user = ($user_id > 0 ? $user_id : $this->user_id);
        return $user;
    }
    
    public function get_fight($fight_id = null) {
        $fight = ($fight_id > 0 ? $fight_id : $this->fight_id);
        return $fight;
    }
    
    public function get_fightclub_attr($attr, $fight_id = null) {
        $query = db_core::getInstance()->conn->prepare("SELECT ".$attr." FROM fightclub WHERE id = :id");
        $query->bindValue(":id", $this->get_fight($fight_id));
        $query->execute();
        $fetch = $query->fetch(PDO::FETCH_ASSOC);
        return $fetch[$attr];
    }
    
    public function get_fight_attr($attr, $fight_id = null) {
        $query = db_core::getInstance()->conn->prepare("SELECT ".$attr." FROM fightclub_bot WHERE fight_id = :id ORDER BY id DESC LIMIT 1");
        $query->bindValue(":id", $this->get_fight($fight_id));
        $query->execute();
        $fetch = $query->fetch(PDO::FETCH_ASSOC);
        return $fetch[$attr];
    }
    
    public function get_last_fight($fight_id = null) {
        $query = db_core::getInstance()->conn->prepare("SELECT * FROM fightclub_bot WHERE fight_id = :id ORDER BY id DESC LIMIT 1");
        $query->bindValue(":id", $this->get_fight($fight_id));
        $query->execute();
        $fetch = $query->fetch(PDO::FETCH_ASSOC);
        return $fetch;
    }
    
    // FIGHT AREA //
    
    public function init_attack($user_move, $weapon_array = null) {
        $this->verify_weapons($weapon_array);
        if($this->_handle_error) {
            
            $this->set_bot_stats();
            
            if($this->last_move['bot_frozen'] < 1) {
                $this->set_bot_attack();
                $this->handle_bot_attack();
            }
            
            $this->set_user_stats($user_move);
            if($this->last_move['user_frozen'] < 1) {
                $this->handle_user_attack();
            }
            
            $this->match_attacks();
            if($this->fight_complete($this->user_current_hp, $this->bot_current_hp) > 0) {
                $this->fight_complete = $this->fight_complete($this->user_current_hp, $this->bot_current_hp);
            }
            return true;
        } else {
            return false;
        }
    }
    
    private function match_attacks() {
        $user_dodge = (rand(1,100)<=$this->user_dodge ? true : false);
        $set_user_dodge = ($user_dodge ? 1 : 0);
        $this->user_dodged = ($user_dodge ? 1 : 0);
        $bot_dodge = (rand(1,100)<=$this->bot_dodge ? true : false);
        $set_bot_dodge = ($bot_dodge ? 1 : 0);
        $this->bot_dodged = ($bot_dodge ? 1 : 0);
        
        $this->user_current_hp = ($this->user_heal > 0 ? ($this->user_current_hp+$this->user_heal>= $this->user_max_hp ? $this->user_max_hp : $this->user_current_hp+$this->user_heal) : $this->user_current_hp);
        $this->bot_current_hp = ($this->bot_heal > 0 ? ($this->bot_current_hp+$this->bot_heal>= $this->bot_max_hp ? $this->bot_max_hp : $this->bot_current_hp+$this->bot_heal) : $this->bot_current_hp);
        
        $this->bot_damage = $this->bot_damage*(($this->bot_attack_bonus/100)+1);
        $this->user_damage = $this->user_damage*(($this->user_attack_bonus/100)+1);
        
        switch($this->bot_move) {
            case '1':
                $this->bot_defense = (0.5*$this->bot_defense);
                $this->bot_damage = round($this->bot_damage*1.5);
                break;
            case '2':
                break;
            case '3':
                $this->bot_defense = (1.2*$this->bot_defense);
                $this->bot_damage = round($this->bot_damage*0.8);
                break;
        }
        
        switch($this->user_move){
            case '1':
                $this->user_defense = (0.5*$this->user_defense);
                $this->user_damage = round($this->user_damage*1.5);
                break;
            case '2':
                break;
            case '3':
                $this->user_defense = (1.2*$this->user_defense);
                $this->user_damage = round($this->user_damage*0.8);
                break;
        }
            
        $this->bot_damage = ($this->temp_user_freeze>0 || $user_dodge ? 0 : round(($this->bot_damage*(1-($this->user_defense_bonus/100)))-$this->user_defense));
        $this->user_damage = ($this->temp_bot_freeze>0 || $bot_dodge ? 0 : round(($this->user_damage*(1-($this->bot_defense_bonus/100)))-$this->bot_defense));
        
        $this->user_current_hp = (($this->user_current_hp-$this->bot_damage)< 1 ? 0 : ($this->user_current_hp-$this->bot_damage));
        $this->bot_current_hp = (($this->bot_current_hp-$this->user_damage)< 1 ? 0 : ($this->bot_current_hp-$this->user_damage));
        $this->bot_hp_percent = ($this->bot_current_hp/$this->bot_max_hp)*100;
        $this->user_hp_percent = ($this->user_current_hp/$this->user_max_hp)*100;
        $query = $this->core->conn->prepare("INSERT INTO fightclub_bot
                                    (fight_id, user_health, user_maxhealth, user_move, user_dmg, user_heal, user_weapons, user_dodged, user_frozen, user_freeze_used, user_bomb_used, user_heal_used,
                                     bot_health, bot_maxhealth, bot_move, bot_dmg, bot_heal, bot_weapons, bot_dodged, bot_frozen, bot_freeze_used, bot_bomb_used, bot_heal_used)
                                     VALUES
                                     ('".$this->fight_id."', '".$this->user_current_hp."', '".$this->user_max_hp."', '".$this->user_move."', '".$this->user_damage."', '".$this->user_heal."',
                                      '".$this->user_weapons_string."', '".$set_user_dodge."', '".$this->temp_bot_freeze."', '".$this->user_used_freeze."', '".$this->user_used_bomb."', '".$this->user_used_heal."',
                                      '".$this->bot_current_hp."', '".$this->bot_max_hp."', '".$this->bot_move."', '".$this->bot_damage."', '".$this->bot_heal."',
                                      '".$this->bot_weapons_string."', '".$set_bot_dodge."', '".$this->temp_user_freeze."', '".$this->bot_used_freeze."', '".$this->bot_used_bomb."', '".$this->bot_used_heal."')");
        $query->execute();
    }
    
    private function handle_bot_attack() {
        foreach($this->bot_weapons_used as $value) {
            $this->bot_weapons_string .= (empty($this->bot_weapons_string) ? $value : ",".$value);
            switch($this->get_weapon_type($value)) {
                case 'heal':
                    $this->bot_heal = $this->get_item_stat("heal", $value);
                    $this->temp_bot_heal = 1;
                    $this->bot_used_heal = 1;
                    break;
                case 'bomb':
                    $this->bot_damage = ($this->bot_damage < 1 || $this->bot_damage == null ? $this->get_item_stat("dmg", $value) : $this->bot_damage+$this->get_item_stat("dmg", $value));
                    $this->temp_bot_bomb = 1;
                    $this->bot_used_bomb = 1;
                    break;
                case 'freeze':
                    $this->temp_bot_freeze = 1;
                    $this->bot_used_freeze = 1;
                    break;
                case 'suit':
                    $this->bot_defense = ($this->bot_defense < 1 || $this->bot_defense == null ? $this->get_item_stat("def", $value) : $this->bot_defense+$this->get_item_stat("def", $value));
                    break;
                case 'hand':
                    $this->bot_damage = ($this->bot_damage < 1 || $this->bot_damage == null ? $this->get_item_stat("dmg", $value) : $this->bot_damage+$this->get_item_stat("dmg", $value));
                    break;
            }
        }
    }
    
    private function set_bot_attack() {
        $has_bomb = array_search('bomb', $this->bot_equiptment_type);
        $has_heal = array_search('heal', $this->bot_equiptment_type);
        $has_freeze = array_search('freeze', $this->bot_equiptment_type);
        $has_suit = array_search('suit', $this->bot_equiptment_type);
        $temp_hand_array = array();
        foreach($this->bot_equiptment_type as $key => $value) {
            if($value == "hand") {
                $temp_hand_array[] = $this->bot_equiptment[$key];
            }
        }
        $weapon_count = array_count_values($temp_hand_array);
        
        if($this->bot_hp_percent > 80) {
            if(!$this->bot_used_bomb > 0 && $has_bomb > 0) {
                $weapon_array[] = $this->bot_equiptment[$has_bomb];
            } elseif(!$this->bot_used_freeze > 0 && $has_freeze > 0) {
                $weapon_array[] = $this->bot_equiptment[$has_freeze];
            }
        } elseif($this->bot_hp_percent > 50) {
            if(!$this->bot_used_freeze > 0 && $has_freeze > 0) {
                $weapon_array[] = $this->bot_equiptment[$has_freeze];
            } elseif(!$this->bot_used_heal > 0 && $has_heal > 0) {
                $weapon_array[] = $this->bot_equiptment[$has_heal];
            } elseif($has_suit > 0) {
                $weapon_array[] = $this->bot_equiptment[$has_suit];
            }
        } elseif($this->bot_hp_percent < 50) {
            if(!$this->bot_used_heal > 0 && $has_heal > 0) {
                $weapon_array[] = $this->bot_equiptment[$has_heal];
            } elseif(!$this->bot_used_freeze > 0 && $has_freeze > 0) {
                $weapon_array[] = $this->bot_equiptment[$has_freeze];
            } elseif($has_suit > 0) {
                $weapon_array[] = $this->bot_equiptment[$has_suit];
            }
        }
        
        if(isset($weapon_array)) {
            $weapon_num = rand(0, floatval($weapon_count));
            $weapon_array[] = ($temp_hand_array[$weapon_num]);
            $final_weapons = $weapon_array;
        } else {
            $final_weapons = $this->shuffle_array(0, $weapon_count);
        }
        $this->bot_weapons_used = $final_weapons;
        $this->bot_move = 3;
    }
    
    private function shuffle_array($min, $max) {
        $stack = range($min, $max);
        shuffle($stack); 
        $nr1 = array_pop($stack);
        $nr2 = array_pop($stack);
        return array($nr1, $nr2);
    }
    
    private function set_bot_stats() {
        $this->monster_id = $this->get_fightclub_attr("2_user_id");
        $monsters = new monsters($this->monster_id);
        $monster = $monsters->get_monster();
        foreach($monster as $key => $value) {
            if(substr($key, 0, 4) == "slot") {
                if($value > 0) {
                    $build_bot_weapon_type[] = $this->get_item_attr("weapon_type", $value);
                    $build_bot_equiptment[] = $value;
                }
            }
        }
        $this->bot_equiptment = $build_bot_equiptment;
        $this->bot_equiptment_type = $build_bot_weapon_type;
        $this->bot_current_hp = $this->last_move['bot_health'];
        $this->bot_max_hp = $this->last_move['bot_maxhealth'];
        $this->bot_used_bomb = $this->last_move['bot_bomb_used'];
        $this->bot_used_freeze = $this->last_move['bot_freeze_used'];
        $this->bot_used_heal = $this->last_move['bot_heal_used'];
        $this->bot_hp_percent = ($this->last_move['bot_health']/$this->last_move['bot_maxhealth'])*100;
        $this->bot_defense_bonus = $monster['defense_bonus'];
        $this->bot_attack_bonus = $monster['attack_bonus'];
        $this->bot_dodge = $monster['dodge'];
    }
    
    private function handle_user_attack() {
        if(!empty($this->weapons_used)) {
            foreach($this->weapons_used as $value) {
                $this->user_weapons_string .= (empty($this->user_weapons_string) ? $value : ",".$value);
                switch($this->get_weapon_type($value)) {
                    case 'heal':
                        $this->user_heal = $this->get_item_stat("heal", $value);
                        $this->temp_user_heal = 1;
                        $this->user_used_heal = 1;
                        break;
                    case 'bomb':
                        $this->user_damage = ($this->user_damage < 1 || $this->user_damage == null ? $this->get_item_stat("dmg", $value) : $this->user_damage+$this->get_item_stat("dmg", $value));
                        $this->temp_user_bomb = 1;
                        $this->user_used_bomb = 1;
                        break;
                    case 'freeze':
                        $this->temp_user_freeze = 1;
                        $this->user_used_freeze = 1;
                        break;
                    case 'suit':
                        $this->user_defense = ($this->user_defense < 1 || $this->user_defense == null ? $this->get_item_stat("def", $value) : $this->user_defense+$this->get_item_stat("def", $value));
                        break;
                    case 'hand':
                        $this->user_damage = ($this->user_damage < 1 || $this->user_damage == null ? $this->get_item_stat("dmg", $value) : $this->user_damage+$this->get_item_stat("dmg", $value));
                        break;
                }
            }
        } else {
            $this->user_damage = 2;
        }
    }
    
    
    private function set_user_stats($user_move) {
        $this->user_move = ($user_move > 0 ? $user_move : 2);
        $this->user_current_hp = $this->last_move['user_health'];
        $this->user_max_hp = $this->last_move['user_maxhealth'];
        $this->user_used_bomb = $this->last_move['user_bomb_used'];
        $this->user_used_freeze = $this->last_move['user_freeze_used'];
        $this->user_used_heal = $this->last_move['user_heal_used'];
        $this->user_defense_bonus = session::get_stat("defbonus");
        $this->user_attack_bonus = session::get_stat("attbonus");
        $this->user_dodge = session::get_stat("dodge");
    }
    
    private function verify_weapons($weapon_array = null) {
        $this->_handle_error = false;
         try 
         {
             if(!empty($weapon_array)) {
                if(count($weapon_array) > 2) {
                    throw new Exception ("only_use_two");
                }

                foreach($weapon_array as $value) {
                    if(!in_array($value, $this->equiptment)) {
                        throw new Exception ("invalid_weapon");
                    }

                    if($this->weapon_type($this->get_item_attr("weapon_type", $value)) != null) {
                        throw new Exception ("one_use");
                    }
                }
             }

             $this->_handle_error = true;
             $this->weapons_used = $weapon_array;
         }
         catch (Exception $e) 
         {
             $this->_error = $e->getMessage();
         }
    }
    
    public function fight_complete($user_health, $bot_health) {
        if($user_health < 1 && $bot_health > 0) {
            return 1;
        }
        if($user_health < 1 && $bot_health < 1) {
            return 2;
        }
        if($user_health > 0 && $bot_health < 1) {
            return 3;
        }
        return 0;
    }
    
    
    // CREATE FIGHT AREA //
    public function create_fight($monster_id){
        $this->monster_id = $monster_id;
        $this->verify_create();
        return $this->_handle_error;
    }
    
    private function verify_create() {
         $this->_handle_error = false;
         try 
         {
             if($this->fight_exists()) {
                 throw new Exception ("fight_exists");
             }
             
             if(!monsters::monster_exists($this->monster_id)) {
                 throw new Exception ("invalid_monster");
             }
             
             if(!$this->hp_check()) {
                 throw new Exception ("no_hp");
             }

             $this->_handle_error = true;
             $this->handle_create_fight();
         }
         catch (Exception $e) 
         {
             $this->_error = $e->getMessage();
         }
     }
     
     private function handle_create_fight() {
        $monster = new monsters($this->monster_id);
        $fetch = $monster->get_monster();
        $query = $this->core->conn->query("SELECT id FROM `fightclub` ORDER BY id DESC LIMIT 1");
        if($query->rowCount() > 0) {
            $fetch_id = $query->fetch(PDO::FETCH_ASSOC);
            $last_id = $fetch_id['id']+1;
        } else {
            $last_id = 1;
        }
        $this->core->conn->query("INSERT INTO `fightclub` (id, type, 1_user_id, 2_user_id) VALUES ('".$last_id."', '1', '".$_SESSION['user_id']."', '".$this->monster_id."')");
        $this->set_stat("fight", $last_id);
        $this->core->conn->query("INSERT INTO `fightclub_bot` (fight_id, fight_start, user_health, user_maxhealth, bot_health, bot_maxhealth) VALUES ('".$last_id."', '1', '".session::get_stat("hp")."', '".session::get_stat("maxhp")."', '".$fetch['health']."', '".$fetch['health']."')");
    }
    
    public function show_error() {
        return $this->_error;
    }
     
     private function hp_check($user_id = null) {
         $temp_return = true;
         if($user_id != null) {
             if($this->get_stat("hp", $user_id) < 1) {
                 $temp_return = false;
             }
         } else {
             if(session::get_stat("hp") < 1) {
                 $temp_return = false;
             }
         }
         return $temp_return;
     }
     
     public function fight_exists($fight_id = null) {
         $fight_id = ($fight_id != null ? $fight_id : session::get_stat("fight"));
         if($fight_id > 0) {
             return true;
         }
         return false;
     }
     
     public function weapon_type($item, $bot = null) {
         $bomb_used = ($bot != null ? "bot_bomb_used" : "user_bomb_used");
         $freeze_used = ($bot != null ? "bot_freeze_used" : "user_freeze_used");
         $heal_used = ($bot != null ? "bot_heal_used" : "user_heal_used");
         switch($item) {
            case 'bomb':
                $temp_return = ($this->last_move[$bomb_used] > 0 ? "bomb" : null);
                break;
            case 'freeze':
                $temp_return = ($this->last_move[$freeze_used] > 0 ? "freeze" : null);
                break;
            case 'heal':
                $temp_return = ($this->last_move[$heal_used] > 0 ? "heal" : null);
                break;
            default:
                $temp_return = null;
                break;
        }
        return $temp_return;
     }
     
     private function get_weapon_type($item_id) {
         return $this->get_item_attr("weapon_type", $item_id);
     }
     
     public function leave_fight($health, $monster_id) {
         monsters::set_fight_stat("lost", $monster_id, $_SESSION['user_id']);
         $this->set_stat("hp", $health);
         $this->core->conn->query("DELETE FROM fightclub WHERE id = '".session::get_stat("fight")."'");
         $this->core->conn->query("DELETE FROM fightclub_bot WHERE fight_id = '".session::get_stat("fight")."'");
         $this->set_stat("fight", "0");
     }
     
     public function close_fight($fight_status, $monster_id, $user_hp, $xp = null, $mc = null) {
         monsters::set_fight_stat($fight_status, $monster_id, $_SESSION['user_id']);
         $this->set_stat("hp", (!$user_hp > 0 ? "0" : $user_hp));
         $this->core->conn->query("DELETE FROM fightclub WHERE id = '".session::get_stat("fight")."'");
         $this->core->conn->query("DELETE FROM fightclub_bot WHERE fight_id = '".session::get_stat("fight")."'");
         if($fight_status == "won") {
             $rank = new rank();
             $rank->insertRank($xp, $_SESSION['user_id']);
             $this->set_stat("mc", (session::get_stat("mc")+$mc));
         }
         $this->set_stat("fight", "0");
     }
     
     public function return_array() {
         $temp_array["user_dmg"] = $this->user_damage;
         $temp_array["user_health"] = $this->user_current_hp;
         $temp_array["user_move"] = $this->user_move;
         $temp_array["user_heal"] = $this->user_heal;
         $temp_array["user_hp_percent"] = $this->user_hp_percent;
         $temp_array["user_dodged"] = $this->user_dodged;
         $temp_array["bot_dmg"] = $this->bot_damage;
         $temp_array["bot_health"] = $this->bot_current_hp;
         $temp_array["bot_move"] = $this->bot_move;
         $temp_array["bot_heal"] = $this->bot_heal;
         $temp_array["bot_hp_percent"] = $this->bot_hp_percent;
         $temp_array["bot_dodged"] = $this->bot_dodged;
         $temp_array["fight_complete"] = $this->fight_complete;
         return $temp_array;
     }
}

?>
