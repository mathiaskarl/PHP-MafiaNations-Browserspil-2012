<?php
if($login) {
	if($_GET['do'] == "del") {
			mysql_query("UPDATE `user_stats` SET value='0' WHERE stat_id = '14' AND user_id = '".$login."'") or die(mysql_error());
			echo "<meta http-equiv='refresh' content='0;URL=?p=bank'>";
	} else {
		if($_POST['widraw']) {
			if(isset($_POST['amount1'])) {
				$amount = bankNumber($_POST['amount1']);
				if($amount == "odbz12ldasa") {
					$message = "You can only use numbers in the widraw field.<br><br>
					Please wait.<meta http-equiv='refresh' content='2;URL=?p=bank'><br><br><i>Errorcode: f005</i>";
					include("pages/error.php");
				} elseif ($amount > $gb || $amount < 0) {
					$message = "You don't have that many mafia coins in the bank.<br><br>
					Please wait.<meta http-equiv='refresh' content='2;URL=?p=bank'><br><br><i>Errorcode: f002</i>";
					include("pages/error.php");
				} else {
					$image = "loginimage.png";
					$header = "Mafia coins widrawn";
					$message = "
					You have widrawn <b>".number_format($amount)."</b> mafia coins to your hand.<br><br>
					Please wait.<meta http-equiv='refresh' content='2;URL=?p=bank'>";
					include("pages/error.php");
					setStat('mc',$login,getStat('mc',$login) + $amount);
					setStat('gb',$login,getStat('gb',$login) - $amount);
				}
			} else {
				$message = "You must fill the widraw field with the amount you wish to widraw from your bank account.<br><br>
					Please wait.<meta http-equiv='refresh' content='2;URL=?p=bank'><br><br><i>Errorcode: f001</i>";
				include("pages/error.php");
			}
		} elseif ($_POST['deposit']) {
			if(isset($_POST['amount2'])) {
				$amount = bankNumber($_POST['amount2']);
				if($amount == "odbz12ldasa") {
					$message = "You can only use numbers in the deposit field.<br><br>
					Please wait.<meta http-equiv='refresh' content='2;URL=?p=bank'><br><br><i>Errorcode: f006</i>";
					include("pages/error.php");
				} elseif ($amount > $mc || $amount < 0) {
					$message = "You don't have that many mafia coins on your hand.<br><br>
					Please wait.<meta http-equiv='refresh' content='2;URL=?p=bank'><br><br><i>Errorcode: f003</i>";
					include("pages/error.php");
				} else {
					$image = "loginimage.png";
					$header = "Deposited mafia coins";
					$message = "
					You have deposited <b>".number_format($amount)."</b> mafia coins into the bank.<br><br>
					Please wait.<meta http-equiv='refresh' content='2;URL=?p=bank'>";
					include("pages/error.php");
					setStat('mc',$login,getStat('mc',$login) - $amount);
					setStat('gb',$login,getStat('gb',$login) + $amount);
				}
			} else {
				$message = "You must fill the deposit field with the amount you wish to deposit to your bank account.<br><br>
					Please wait.<meta http-equiv='refresh' content='2;URL=?p=bank'><br><br><i>Errorcode: f004</i>";
				include("pages/error.php");
			}
		} else {
			$calculate = round($gb/100 * 12.5);
			$percent = round($calculate/365);
			echo "
			<div style='margin:0px auto;width:800px;'>
				<div style='width:390px;float:left;'>
					<div style='width:24px;height:24px;float:left;background:url(images/icons/bank2.png) 0 0 no-repeat;margin-left:20px;margin-top:3px;'></div>
					<div id='italicheadersmall' style='padding-left:10px;float:left;'>
					The Bank
					</div>
					<div style='clear:both;'></div>
					<div id='italicblack' style='padding-left:20px;margin-top:5px;'>
					Welcome to the bank, ".$loginoutput['username'].". How may we help you today?<br>
					In the section below, you can see your current account balance, aswell as widraw and deposit mafia coins to your bank account.<br>
					</div>
					<div id='normalblacksmall' style='padding-left:20px;width:45%;float:left;margin-top:20px;'>
					<b>Account information:</b><br>
					Current account balance:<br>
					Money on hand:<br>
					Interest rate:<br>
					Daily interest:<br><br>
					</div>
					<div id='normalblacksmall' style='width:40%;float:left;margin-top:20px;'>
					&nbsp;<br>
					<b>".number_format($gb)."</b> <font color='#cdbb44' style='font-weight:bold;'>MC</font><br>
					<b>".number_format($mc)."</b> <font color='#cdbb44' style='font-weight:bold;'>MC</font><br>
					<b>12.5%</b> per year<br>
					<b>".number_format($percent)."</b> <font color='#cdbb44' style='font-weight:bold;'>MC</font><br><br>
					</div>
					<div style='clear:both;'></div>
					<div id='normalblacksmall' style='padding-left:20px;padding-bottom:20px;'>
					Everyday at 20:00 pm, you will receive your daily interest. 
					The interest is calculated from the account balance at 19:59pm.
					</div>
					<div style='width:100%;margin:0px auto;font-weight:bold;font-family:georgia,arial,serif;font-style:italic;'>
					<center>
					";
					if($interest<1) {
					} else {
						echo "
						<div style='width:351px;height:53px;margin-top:7px;padding-top:2px;background:url(images/bankinterest.png) 0 0 no-repeat;'>
							<div style='height:15px;width:351px;text-align:right;'>
							<a href='?p=bank&do=del'><img src='images/cross.png' alt='Remove this' title='Remove this' style='margin-top:1px;margin-right:3px;'></a>
							</div>
							<div>
							We deposited ".number_format($interest)." <font color='#cdbb44' style='font-weight:bold;'>MC</font> from todays interest.
							</div>
						</div>
						";
					}
					echo "</center></div>
					<div style='width:48%;float:left;font-family:tahoma, arial, serif; font-size: 14px;color:#000;padding-top:20px;'>
						<div>
						<center>
						<form name='submit' method='post' action='?p=bank'>
						Deposit Mafia Coins:<br>
						<input type='text' id='bankinput' name='amount2'><br>
						<input type='submit' name='deposit' value='&nbsp;' class='depositbutton' size='10'>
						</center>
						</form>
						</div>
					</div>
					<div style='width:48%;float:left;font-family:tahoma, arial, serif; font-size: 14px;color:#000;padding-top:20px;'>
						<div>
						<center>
						<form name='submit' method='post' action='?p=bank'>
						Widraw Mafia Coins:<br>
						<input type='text' id='bankinput' name='amount1'><br>
						<input type='submit' name='widraw' value='&nbsp;' class='widrawbutton' size='10'>
						</form>
						</center>
						</div>
					</div>
					<div style='clear:both;'></div>
				</div>
				<div id='registerspacer'>
				</div>
				<div id='italicblack' style='width:375px;float:left;padding-left:20px;padding-top:5px;'>
					By depositing your mafia coins into your bank account, you achieve two things.<br><br>
					The first is that you will get a daily interest from the coins you've deposited. The interest is currently on 12.5% of your account balance, a year.<br>
					You will also be secured from any random event on the site, that might have economic consequences.<br><br>
					Allthough you cannot spend any of the money that are currently sitting in your bank account.<br>
					You will have to widraw the money before you can spend them.
				</div>
				<center><img src='images/suitcase.png' style='margin-top:10px;margin-bottom:10px;'></center>
				<div style='clear:both;'></div>
			</div>";
		}
	}
} else {
	$message = "You have to be logged in to view this page!<br><br><i>Errorcode: q001</i>";
	include("pages/error.php");
}

?>