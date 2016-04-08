<?php
if($login) {
	$calcHp = round($hp/$maxhp*100);
	if($calcHp < 35) {
		$sentence = "Oh my! you look badly injured, we certainly need to get you fixed up!";
	} elseif($calcHp > 70 && $calcHp < 100) {
		$sentence = "Hello darling. You look like you could use some medical help";
	} elseif($calcHp > 35 && $calcHp < 100) {
		$sentence = "Oh you don't look to bad.. Grab a health potion or something, and let the needy ones through.";
	} else {
		$sentence = "You're allready at full health, what are you doing here?";
	}
	if($_GET['do'] == "heal") {
		if($fight < 1) {
			if($hp != $maxhp) {		
			$calcMc = $mc+$gb;
			if($calcMc > 2999) {
				if($mc >= 1000) {
					$current = $mc-1000;
					$fullhp = $maxhp;
					setStat('mc',$login,$current);
					setStat('hp',$login,$fullhp);
					$image = "loginimage.png";
					$header = "Please wait";
					$message = "Healing your character!<br>You will be restored to full health!<br>
					Please wait..
					<meta http-equiv='refresh' content='2;URL=?p=hospital'>";
					include("pages/error.php");
				} else {
					$message = "You need <b>1,000</b> MC on hand to use the hospital!<br><br><i>Errorcode: h002</i>";
					include("pages/error.php");
				}
			} else {
				$fullhp = $maxhp;
				setStat('hp',$login,$fullhp);
				$image = "loginimage.png";
				$header = "Please wait";
				$message = "Healing your character!<br>You will be restored to full health!<br>
				Please wait..
				<meta http-equiv='refresh' content='2;URL=?p=hospital'>";
				include("pages/error.php");
			}
			} else {
			$message = "You are allready at full health<br><br><i>Errorcode: h003</i>";
			include("pages/error.php");
			}
		} else {
			$message = "You can't heal while being in a fight!<br><br><i>Errorcode: h0003</i>";
			include("error.php");
		}
	} else {
		echo "
		<div style='margin:0px auto;width:800px;'>
			<div style='width:24px;height:24px;float:left;t;margin-left:20px;margin-top:3px;'></div>
				<div id='italicheadersmall' style='padding-left:10px;margin-bottom:5px;float:left;'>
				The Hospital
				</div>
			<div style='float:'right;'></div>
				<div id='normalblack2' style='padding-left:10px;margin-top:5px;margin-right:45px;float:right;'>
				</div>
			<div style='clear:both;'></div>
			  <div id='linkmenu' style='margin-left:54px;'><a href='?p=downtown'>Downtown</a> &rarr; <a href='?p=hospital'>Hospital</a></div>
		</div>";
				echo "
				<br><br>
				<div style='margin:0px auto;width:800px;'>
					<div style='margin:0px auto;width:350px;padding-top:170px;' id='italicblack'>
						<center><b>Kary the Nurse says: '".$sentence."'</b><br>
						
						<div id='heal' style='margin-top:15px;margin-bottom:15px;'>
						<a href='?p=hospital&do=heal'><img src='images/blank3.png'></a>
						</div>
						Click on the button above, to heal yourself to full health.<br>
						If you have over <b>3,000</b> <font color='#d2bb23' style='font-weight:bold;'>Mafia Coins</font>, then it will cost you <b>1,000</b> in hospital bills, otherwise it's totally free!
					</div>
					</center>
				</div>";
	}
} else {
	$message = "You have to be logged in to view this page!<br><br><i>Errorcode: h001</i>";
	include("pages/error.php");
}
?>