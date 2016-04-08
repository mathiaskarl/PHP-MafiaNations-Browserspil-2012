<?php
$date = date("Y/m/d H:i:s");
$forgotfetch = $query->fetch(PDO::FETCH_ASSOC);
$mailindhold = "Dear ".$forgotfetch['username'].", <br><br>
This is an automatic email from Mafia Nation, to confirm a password reset of your account.<br>
If you didn't request a password reset, please overlook this email as nothing has changed yet.<br><br>
Before your password will be reset, you will have to confirm the action by clicking the link below:<br>
http://mafianations.com/?p=register&do=4&i=".$forgotfetch['id']."&c=".$confirm_code."<br><br>
<hr width='100%' size=1' color='#b0b0b0' align='left'><br>
If you experience any problems during this process, please feel free to contact us.<br>
We hope you enjoy your visit in the worlds of Mafia Nation.<br><br>
Regards<br>";
$mailsent = "Sent";
$mailfooter = "Rule the dark streets of Mafia Nations.";
$mailtitle = "Mafia Nations - Forgotten password";

$message = "
<html>
<head>
<title>".$mailtitle."</title>
</head>
<body>
<table width='800' border='0'>
<tr>
<td>
	<table width='95%' height='95%' valign='middle' align='center' bgcolor='white' border='0'>
	<tr>
	<td style='padding-top: 15px;'>
		<table width='90%' align='center' border='0'>
		<tr>
		<td width='50%' style='padding-left: 15px;'>
			<span style='font-family: Georgia, sans-serif; font-size:30pt; color: #000000;font-style:italic;'>Mafia Nations</span>
		</td>
		<td width='50&' align='right' valign='top'>
			<span style='font-family: Tahoma, Geneva, sans-serif; font-size:12px; color:#535353;'>".$mailsent.": ".$date."</span>
		</td>
		</tr> 
		</table>       
	</td>
	</tr>
	<tr>
	<td>
		<table width='90%' align='center' border='0' style='border: 1px solid #b0b0b0;'>
		<tr>
		<td width='100%' style='padding: 15px;'>
			<span style='font-family: Tahoma, Geneva, sans-serif; font-size:12px; color:#000000;'>
				".$mailindhold."
				Administrator <br /> � Mafia Nations � <br /> www.mafianations.com
			</span>
		</td>
		</tr> 
		</table>
	</td>
	</tr>
	<tr>
	<td style='padding-bottom: 15px;'>
		<table width='90%' align='center' border='0'>
		<tr>
		<td width='100%' style='padding-left: 15px;'>
			<span style='font-family: Tahoma, Geneva, sans-serif; font-size:12px; color:#535353;'>".$mailfooter."</span>
		</td>
		</tr> 
		</table>    
	</td>
	</tr>
	 </table>
</td>
</tr>
</table>
</body>
</html>";

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
$headers .= "From: noreply@mafianations.com" . "\r\n";
$headers .= "Reply-To: noreply@mafianations.com" . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();
mail($email, $mailtitle, $message, $headers);

?>