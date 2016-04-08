<?php
if($image != "") {
	$image = $image;
} else {
	$image = "errorimage.png";
}
if($header != "") {
	$header = $header;
} else {
	$header = "Something went wrong.";
}
	echo "
	<div style='width:370px;height:200px;margin:0px auto;padding-top:24px;'>
		<div style='width:50px;height:50px;float:left;background:url(images/".$image.") 0 0 no-repeat;'>
		</div>
		<div style='width:4px;height:125px;float:left;background:url(images/errorspacer.png) 0 0 no-repeat;margin-left:8px;margin-right:6px;'>
		</div>
		<div style='width:300px;;float:left;'>
			<div style='width:300px;font-family:Georgia, arial, serif;font-size:22px;font-style:italic;color:#000;padding-left:6px;margin-bottom:5px;'>
			".$header."
			</div>
		<div style='width:300px;font-family: tahoma, arial, serif;font-size:13;color:#2e2624;margin-left:6px;'>
		". $message ."
		</div>
		</div>
		<div style='clear:both;'></div>
	</div>";
?>