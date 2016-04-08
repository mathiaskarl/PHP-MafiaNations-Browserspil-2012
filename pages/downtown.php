<?php
if($login) {
	echo "
	<div class='downtown'>
			<div class='downtownmargin'>
			</div>
			<div class='downtowncontent'>
				<div style='width:55px;float:left;margin-left:12px;'>
					<div style='width:41px;'>
						<a href='?p=home'><div id='downtown_home'></div></a>
					</div>
				</div>
				<div style='width:55px;float:left;margin-left:50px;'>
					<div style='width:41px;'>
						<a href='?p=hospital'><div id='downtown_hospital'></div></a>
					</div>
				</div>
				<div style='width:55px;float:left;margin-left:50px;'>
					<div style='width:41px;'>
						<a href='?p=hospital'><div id='downtown_hospital'></div></a>
					</div>
				</div>
				<div style='width:55px;float:left;margin-left:50px;'>
					<div style='width:41px;'>
						<a href='?p=hospital'><div id='downtown_hospital'></div></a>
					</div>
				</div>
				<div style='width:55px;float:left;margin-left:50px;'>
					<div style='width:41px;'>
						<a href='?p=hospital'><div id='downtown_hospital'></div></a>
					</div>
				</div>
				<div style='width:55px;float:left;margin-left:50px;'>
					<div style='width:41px;'>
						<a href='?p=hospital'><div id='downtown_hospital'></div></a>
					</div>
				</div>
				<div style='clear:both'></div>
				
				<div style='height:50px;'></div>
				
				<div style='width:55px;float:left;margin-left:117px;'>
					<div style='width:41px;'>
						<a href='?p=hospital'><div id='downtown_hospital'></div></a>
					</div>
				</div>
				<div style='width:55px;float:left;margin-left:50px;'>
					<div style='width:41px;'>
						<a href='?p=hospital'><div id='downtown_hospital'></div></a>
					</div>
				</div>
				<div style='width:55px;float:left;margin-left:50px;'>
					<div style='width:41px;'>
						<a href='?p=hospital'><div id='downtown_hospital'></div></a>
					</div>
				</div>
				<div style='width:55px;float:left;margin-left:50px;'>
					<div style='width:41px;'>
						<a href='?p=hospital'><div id='downtown_hospital'></div></a>
					</div>
				</div>
				<div style='width:55px;float:left;margin-left:50px;'>
					<div style='width:41px;'>
						<a href='?p=hospital'><div id='downtown_hospital'></div></a>
					</div>
				</div>
				<div style='clear:both'></div>
				
				
				
				<div style='height:50px;'></div>
				
				<div style='width:55px;float:left;margin-left:117px;'>
					<div style='width:41px;'>
						<a href='?p=hospital'><div id='downtown_hospital'></div></a>
					</div>
				</div>
				<div style='width:55px;float:left;margin-left:50px;'>
					<div style='width:41px;'>
						<a href='?p=hospital'><div id='downtown_hospital'></div></a>
					</div>
				</div>
				<div style='width:55px;float:left;margin-left:50px;'>
					<div style='width:41px;'>
						<a href='?p=hospital'><div id='downtown_hospital'></div></a>
					</div>
				</div>
				<div style='width:55px;float:left;margin-left:50px;'>
					<div style='width:41px;'>
						<a href='?p=hospital'><div id='downtown_hospital'></div></a>
					</div>
				</div>
				<div style='width:55px;float:left;margin-left:50px;'>
					<div style='width:41px;'>
						<a href='?p=hospital'><div id='downtown_hospital'></div></a>
					</div>
				</div>
				<div style='clear:both'></div>
				
			</div>
	</div>
	<div style='padding-bottom:35px;'></div>";
	} else {
	$message = "You have to be logged in to view this page!<br><br><i>Errorcode: h001</i>";
	include("pages/error.php");
}
?>