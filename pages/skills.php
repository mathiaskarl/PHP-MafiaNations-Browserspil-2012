<?php
if($login) {
	echo "
	<div style='margin:0px auto;width:800px;'>
			<div style='width:24px;height:24px;float:left;background:url(images/icons/star2.png) 0 0 no-repeat;margin-left:20px;margin-top:3px;'></div>
				<div id='italicheadersmall' style='padding-left:10px;margin-bottom:5px;float:left;'>
				Your skills
				</div>
			<div style='clear:both;'></div>";
			
	if($path != "") {
	} else {
		echo "		
			<div id='italicblack' style='margin-top:10px;padding-left:20px;'>
			You may choose from three different path's, that each provide a great deal of talents and skills.<br>These skills is unique to the path you choose, and will help you to survive the horrors in the streets of Mafia Nations.<br>
			Remember! It takes a great deal of knowledge and money to change your path, so pick wisely!
			</div>
			<div style='padding-top:12px;margin:0px auto;text-align:center;font-family:Times New Roman, serif;font-size:32px;font-style:italic;'>
			Choose Your Path
			</div>
			<div id='italicblack' style='width:100%;margin-bottom:15px;'>
				<div style='margin-left:23px;float:left;width:249px;height:461px;background:url(images/talentbg.png) 0 0 no-repeat;'>
					<div style='position:absolute;background:url(images/rangertop.png) 0 0 no-repeat;width:249px;height:461px;'>
					</div>
				</div>
				<div style='float:left;width:249px;height:461px;background:url(images/talentbg.png) 0 0 no-repeat;'>
					<div style='position:absolute;background:url(images/guardiantop.png) 0 0 no-repeat;width:249px;height:461px;'>
					</div>
				</div>
				<div style='float:left;width:249px;height:461px;background:url(images/talentbg.png) 0 0 no-repeat;'>
					<div style='position:absolute;background:url(images/hitmantop.png) 0 0 no-repeat;width:249px;height:461px;'>
					</div>
				</div>
				<div style='clear:both;'></div>
			</div>";
	}
	echo "
	</div>
	<div style='height:20px;'>
	</div>";
} else {
	$message = "You have to be logged in to view this page!<br><br><i>Errorcode: t001</i>";
	include("pages/error.php");
}
?>