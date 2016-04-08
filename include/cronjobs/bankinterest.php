<?php
		include('../../functions.php');
		if($_GET['key'] == "zbclause132mx") {
		$get_users = mysql_query("SELECT * FROM `users`") or die(mysql_error());
		echo "hey";
		while($show_users = mysql_fetch_array($get_users)) {
			$get_gold = mysql_query("SELECT * FROM `user_stats` WHERE stat_id = '9' AND user_id='".$show_users['id']."'") or die(mysql_error());
			$show = mysql_fetch_array($get_gold);
			$calculate = round($show['value']/100 * 12.5);
			$percent = round($calculate/365);
			$updatedGold = $show['value']+$percent;
			echo $percent." And ". $updatedGold;
			if($percent < 1) {
				mysql_query("UPDATE `user_stats` SET value  = '0' WHERE user_id ='".$show_users['id']."' AND stat_id='14'") or die(mysql_error());
			} else {
				mysql_query("UPDATE `user_stats` SET value  = '".$percent."' WHERE user_id ='".$show_users['id']."' AND stat_id='14'") or die(mysql_error());
			}
			mysql_query("UPDATE `user_stats` SET value  = '".$updatedGold."' WHERE user_id ='".$show_users['id']."' AND stat_id='9'") or die(mysql_error());
		}
		} else {
		}
?>