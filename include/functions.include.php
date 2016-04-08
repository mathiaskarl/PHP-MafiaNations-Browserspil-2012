<?php
require "../libs/db.core.php";
require "../libs/config.core.php";
require "../libs/error.core.php";
require "../libs/stats.class.php";
require "../libs/items.class.php";
require "../libs/login.class.php";
require "../libs/user.class.php";
require "../libs/session.class.php";
require "../libs/rank.class.php";
require "../libs/events.class.php";
require "../libs/avatar.class.php";
require "../libs/equiptment.class.php";
require "../libs/inventory.class.php";
require "../libs/item_abilities.class.php";
require "../libs/ajax.extra.php";

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
?>
