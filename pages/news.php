<?php
	$get_left = mysql_query("SELECT * FROM `news` WHERE sort='2' ORDER BY `id` DESC") or die(mysql_error());
	$get_right = mysql_query("SELECT * FROM `news` WHERE sort='1' ORDER BY `id` DESC") or die(mysql_error());
	echo "
	<div style='margin:0px auto;width:800px;padding-bottom:20px;'>
			<div style='width:389px;float:left;'>";
	while ($show_left = mysql_fetch_array($get_left)) {
		echo "
			<div id='italicblack' style='color:#e5e5e5;margin-left:23px;padding-left:4px;padding-top:2px;margin-top:".$show_left['margin']."px;margin-bottom:4px;height:20px;width:362px;background:url(images/newsheader.png) 0 0 no-repeat;'>
				<div style='float:left;'>".$show_left['header']."</div>
				<div style='float:right;text-aign:right;padding-right:8px;color:#c8c7c7;font-size:11px;'>".$show_left['time']."</div>
				<div style='clear:both;'></div>
			</div>
			<div id='newsspacer' style='width:370px;'></div>
			<div id='italicblack' style='margin-left:27px;padding-right:8px;margin-top:2px;'>
			".nl2br($show_left['text'])."
			</div>";
	}
	echo "
		</div>
		<div id='newsmiddlespacer'>
		</div>
		<div style='width:375px;float:left;'>";
	while ($show_right = mysql_fetch_array($get_right)) {
		echo "
			<div id='italicblack' style='color:#e5e5e5;margin-left:4px;padding-left:4px;padding-top:2px;margin-top:".$show_right['margin']."px;margin-bottom:4px;height:20px;width:362px;background:url(images/newsheader.png) 0 0 no-repeat;'>
			<div style='float:left;'>".$show_right['header']."</div>
				<div style='float:right;text-aign:right;padding-right:8px;color:#c8c7c7;font-size:11px;'>".$show_right['time']."</div>
				<div style='clear:both;'></div>
			</div>
			<div id='newsspacer' style='width:370px;margin-left:0px;'></div>
			<div id='italicblack' style='margin-left:8px;padding-right:8px;margin-top:2px;'>
			".nl2br($show_right['text'])."
			</div>";
	}
		echo "
			</div>
		<div style='clear:both;'></div>
	</div>";
?>