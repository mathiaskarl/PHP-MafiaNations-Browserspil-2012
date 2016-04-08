<?php
require "db.core.php";
require "config.core.php";
require "error.core.php";
require "stats.class.php";
require "items.class.php";
require "login.class.php";
require "user.class.php";
require "session.class.php";
require "rank.class.php";
require "events.class.php";
require "avatar.class.php";
require "equiptment.class.php";
require "inventory.class.php";
require "item_abilities.class.php";
require "mail.class.php";
require "ajax.extra.php";
require "mafia.class.php";
require "monsters.class.php";
require "fightclub.class.php";
require "activity.class.php";

// menu hover
if(isset($_GET['p'])) {
	if(in_array($_GET['p'], $filer)) {
		$activePage[$_GET['p']] = "2";
	} else {
	}
} else {
$activePage['front'] = "2";
}


// secure input
function safe($value) {
	if(!is_numeric($value)) {
		$value = mysql_real_escape_string($value);
		$value = htmlspecialchars($value);
	}
	return $value;
}

// is number
function isNumber($var) {
	if(is_numeric($var)) {
            return (int) $var;
	}
        return 0;
}

// Random password
function makeRandomPassword() {
    $salt = "abchefghjkmnpqrstuvwxyz0123456789";
    srand((double)microtime()*1000000);
    $i = 0;
    while ($i <= 7) {
        $num = rand() % 33;
        $tmp = substr($salt, $num, 1);
        $pass = $pass . $tmp;
        $i++;
    }
    return $pass;
}

// captcha password
function randomString() {
	$string = "abcdefghijklmnopqrstuvxyzABCDEFGHIJLMNOPQRSTUVXYZ";
	$getLength = strlen($string);
	$length = $getLength-1;
	$final = "";
		for($i=0;$i<=5;$i++) {
			$number = rand(1, $length);
			$getString = substr($string, $number, 1);
			$final .= $getString;
		}
	return $final;
}

//  time since last login

function timeSince($currentTime, $timeStamp) {
    $etime = $currentTime - strtotime($timeStamp);
    
    $a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                );
    
    foreach ($a as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago. ';
        }
    }
}
?>
