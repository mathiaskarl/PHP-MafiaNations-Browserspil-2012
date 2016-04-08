<?php
session_start();
ob_start();
require "pages.php";
require "libs/functions.extra.php";

$config = new config();
$login = new login();
if( $login->check_login() ) {
    $activity = new activity();
    $activity->last_seen($_SESSION['last_activity']);
    $stats = new stats($_SESSION["user_id"]);
    if(!mafia::has_chosen()) {
        include("include/activate.php");
    }
    $avatar = new avatar($_SESSION['user_id']);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Mafia Nations</title>
	<link rel="shortcut icon" href="images/icon.png">
	<link rel="stylesheet" type="text/css" href="style.css">
        <link rel="stylesheet" href="colorbox.css" />
        <link rel="stylesheet" href="animate-custom.css" />
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta name="description" content="Description will come">
	<meta name="keywords" content="key words">
	<script src="js/jquery.js" type="text/javascript"></script>
        <script src="js/jquery.colorbox-min.js"></script>
	<script src="js/jquery/timer.js" type="text/javascript"></script>
	<script src="js/include.js" type="text/javascript"></script>
	<script src="js/jscolor.js" type="text/javascript"></script>
</head>
<body>
<script type="text/javascript">

function confirmPost(confirmText) {
var agree = confirm(confirmText);
if (agree)
    return true ;
else
    return false ;
}

function subChar(val) {
    var len = val.value.length;
    if (len >= 500) {
        val.value = val.value.substring(0, 500);
    }
}

$(document).ready(function(){
     $(".item_window").colorbox({width:"400px", height:"500px"});
        setTimeout(perform_ajax, 185000);
        setTimeout(perform_ajax, 380000);
        setTimeout(perform_ajax, 570000);
        
    function perform_ajax() {
        $.post("include/ajax/last_seen.ajax.php");           
    }
    
});
</script>
    <div id="background">
    <div id="page-background">
	    <img src="images/bg2.jpg" width="100%" height="100%" alt="">
    </div>
    <div id="header">
	<div id="headercontainer">
	    <div class="logo"></div>
	    <?php
	    if($login->check_login()) {
            
	    ?>
	    <div id="headerbox">
		<div id="glass">
		    <div id='usercontent'>
			<div id='usercontenttop'>
				<div class='frontboxleft'>Nickname:</div>
				<div class='frontboxright'><a id="user" href="?p=user&id=<?= $_SESSION['user_id'] ?>"><?= $_SESSION['username'] ?></a></div>
				<div style='clear:both;'></div>

				<div class='frontboxleft'>Gangster Level:</div>
                                <div class='frontboxright'> <?= rank::getRank(session::get_stat("lvl")) ." (".session::get_stat("lvl").")"; ?></div>
				<div style='clear:both;'></div>

				<div class='frontboxleft'>Coins on hand:</div>
				<div class='frontboxright'><a id="user" href="?p=bank"><?= number_format(session::get_stat("mc")); ?></a> <font style='color:#d2bb23;font-weight:bold;'>MC</font></div>
				<div style='clear:both;'></div>
			</div>
                        <div id='frontavatar' style='background:url(images/avatars/<?= $avatar->return_avatar(); ?>) 0 0 no-repeat;'>
			</div>
			<div style='clear:both;'></div>

			<div id='italicblack' style='color:#FFF;font-size:11px;width:300px;margin-top:13px;'>
			    <div style='height:14px;'>
				    <div class='frontboxone'>Health:</div>
				    <div class='frontboxtwo'><div style='width:<?= $stats->stat_procent(session::get_stat("hp"), session::get_stat("maxhp")); ?>%;height:13px;background:url(images/redbar.png) 0 0 no-repeat;'><div style='width:126px;height:13px;background:url(images/bartop.png) 0 0 no-repeat;'></div></div></div>
				    <div class='frontboxthree' style='color:#d15858'><?= session::get_stat("hp") ."<font style='color:#FFF;'> / </font>". session::get_stat("maxhp"); ?></div>
				    <div style='clear:both'></div>
			    </div>
			    <div style='height:14px;padding-top:8px;'>
				    <div class='frontboxone'>Energy:</div>
				    <div class='frontboxtwo'><div style='width:<?= $stats->stat_procent(session::get_stat("ep"), session::get_stat("maxep")); ?>%;height:13px;background:url(images/bluebar.png) 0 0 no-repeat;'><div style='width:126px;height:13px;background:url(images/bartop.png) 0 0 no-repeat;'></div></div></div>
				    <div class='frontboxthree' style='color:#5c7fd3'><?= session::get_stat("ep") ."<font style='color:#FFF;'> / </font>". session::get_stat("maxep"); ?></div>
				    <div style='clear:both'></div>
			    </div>
			    <div style='height:14px;padding-top:8px;'>
				    <div class='frontboxone'>Experience:</div>
                                    <div class='frontboxtwo'><div style='width:<?= $stats->stat_procent(session::get_stat("xp"), rank::showRank(session::get_stat("lvl"))); ?>%;height:13px;background:url(images/greenbar.png) 0 0 no-repeat;'><div style='width:126px;height:13px;background:url(images/bartop.png) 0 0 no-repeat;'></div></div></div>
                                    <div class='frontboxthree' style='color:#5cb657'><?= session::get_stat("xp") ."<font style='color:#FFF;'> / </font>". rank::showRank(session::get_stat("lvl")); ?></div>
				    <div style='clear:both'></div>
			    </div>
			</div>
		    </div>
		</div>
	    </div>
	    <?php
	    } else {
	    ?>
	    <div id="headerbox2">
		<div id="glass2">
		    <form method="post" action="?p=login&do=in">
		    <table id='loginbox'>
			<tr>
			    <td><input type="text" value="Enter username" id="input" name="username" onblur="if (this.value == '') {this.value = 'Enter username';}" onfocus="if (this.value == 'Enter username') {this.value = '';}"></td>
			    <td><img src='images/icons/user.png' alt="Enter your username" title="Enter your username" style='padding-left:7px;'></td>
			</tr>
			<tr>
			    <td><input type="password" value="Password ed" id="input" name="password" onblur="if (this.value == '') {this.value = 'Password ed';}" onfocus="if (this.value == 'Password ed') {this.value = '';}"></td>
			    <td><img src='images/icons/lock.png' alt="Enter your password" title="Enter your password" style='padding-left:7px;'></td>
			</tr>
		    </table>
		    <table style='padding-left:7px;'>
			<tr>
			    <td><input type="hidden" name="token" value="<?= $config->token ?>"></td>
			    <td><input type="submit" name="login" value="" class="submit" size="10"></td>
			</tr>
		    </table>
		    </form>
		    <div id='loginfooter'>
			<img src='images/warningsmall.png' style='padding-bottom:1px;padding-right:1px;'> <a href='?p=register&do=3'>Have you forgotten your password?</a><br>
			<img src='images/warningsmall.png' style='padding-bottom:1px;padding-right:1px;'> Never been registered? <a href='?p=register'><b>Click here</b></a></b>
		    </div>
		</div>
	    </div>
	    <?php
	    }
	    ?>
	    <div style='clear:both;'></div>
	</div>
    </div>

    <div id='container'>

    <?php 
	    if( $login->check_login() ) {
		    echo "
		    <div id='glassleft'>
			    <div id='glassposition'>
				    <div id='glassframe'>
					    <div id='glasscontent2'>
						    <table width='125' style='margin-left:9px;padding-top:2px;'>
							    <tr>
							    <td id='smallmenu' valign='top'><img src='images/icons/heart.png' style='padding-right:8px;'><a href='?p=inventory'>Your inventory</a></td>
							    </tr>
							    <tr>
							    <td id='smallmenu' valign='top'><img src='images/icons/mail.png' style='padding-right:8px;'><a href='?p=mail'>Mailbox (".mail::new_mail().")</a></td>
							    </tr>
							    <tr>
							    <td id='smallmenu' valign='top'><img src='images/icons/star.png' style='padding-right:8px;'><a href='?p=skills'>Your skills</a></td>
							    </tr>
							    <tr>
							    <td id='smallmenu' valign='top'><img src='images/icons/home.png' style='padding-right:8px;'><a href='?p=home'>Your home</a></td>
							    </tr>
							    <tr>
							    <td id='smallmenu' valign='top'><img src='images/icons/bank.png' style='padding-right:8px;'><a href='?p=bank'>The Bank</a></td>
							    </tr>
							    <tr>
							    <td id='smallmenu' valign='top'><img src='images/icons/market.png' style='padding-right:8px;'><a href='?p=blackmarket'>Black Market</a></td>
							    </tr>
							    <tr>
							    <td id='smallmenu' valign='top'><img src='images/menuspacer.png' style='padding-right:8px;'><a href='?p=downtown'>Go Downtown</a></td>
							    </tr>
							    <tr>
							    <td id='smallmenu' valign='top'><img src='images/menuspacer.png' style='padding-right:8px;'><a href='?p=fightclub'>The Fightclub</a></td>
							    </tr>
							    <tr>
							    <td id='smallmenu' valign='top'><img src='images/menuspacer.png' style='padding-right:8px;'><a href='?p=gang'>Your gang</a></td>
							    </tr>
							    <tr>
							    <td id='smallmenu' valign='top'><img src='images/icons/off.png' style='padding-right:8px;'><a href='?p=login&do=off' onClick='return confirmPost(\"Are you sure you wish to log out?\")'>Log off</a></td>
							    </tr>
						    </table>
					    </div>
				    </div>
				    <div id='glassbottom'>
				    </div>
			    </div>
		    </div>";
	    } else {
		    echo "
		    <div id='glassleft2'>
		    </div>";
	    }
    ?>
    <div id="repeatcontainer">
	    <div id="repeat">
		    <div style='width:100%;'>
			    <div style='float:left;margin-top:157px;margin-left:42px;width:105px;height:80px;'>
				    <div class="menu" style='width:105px;'>
					    <ul id='nav'>
						    <li class='front'><a href='<?php echo ( $login->check_login() ? "?p=home" :"?p=front") ?>'>Front</a></li>
					    </ul>
				    </div>
			    </div>
			    <div id='menulink' style='width:118px;'>
				    <div class="menu" style='width:118px;'>
					    <ul id='nav'>
						    <li class='information'><a href='?p=information'>Information</a></li>
					    </ul>
				    </div>
			    </div>
			    <div id='menulink' style='width:76px;'>
				    <div class="menu" style='width:76px;'>
					    <ul id='nav'>
						    <li class='news'><a href='?p=news'>News</a></li>
					    </ul>
				    </div>
			    </div>
			    <div id='menulink' style='width:79px;'>
				    <div class="menu">
					    <ul id='nav'>
						    <li class='games'><a href='?p=games'>Games</a></li>
					    </ul>
				    </div>
			    </div>
			    <div id='menulink' style='width:125px;'>
				    <div class="menu">
					    <ul id='nav'>
						    <li class='community'><a href='?p=community'>Community</a></li>
					    </ul>
				    </div>
			    </div>
			    <div id='menulink' style='width:93px;'>
				    <div class="menu">
					    <ul id='nav'>
						    <li class='settings'><a href='?p=settings&do=preferences'>Settings</a></li>
					    </ul>
				    </div>
			    </div>
			    <div id='menulink' style='width:93px;'>
				    <div class="menu">
					    <ul id='nav'>
						    <li class='premium'><a href='?p=premium'>Premium</a></li>
					    </ul>
				    </div>
			    </div>
			    <div style='clear:both;'></div>
		    </div>
		    <div id='pagecontent'>
			    <?php
			    if($login->check_login()) {
                                $event = new events();
                                if(isset($_GET['eh']) && $_GET['eh'] == "erase_event") {
                                    $event->remove_event();
                                }
                                echo $event->show_event();
			    }
			    if(isset($_GET['p'])) {
				    if ($login->check_login() && !mafia::has_chosen()) {
					    include('pages/front.php');
				    } elseif(in_array($_GET['p'], $filer)) {
					    include('pages/' . $_GET['p'] . '.php');
				    } elseif ($_GET['p'] == "") {
					    include('pages/front.php');
				    } else {
                                        echo error::return_error("The page you are trying to reach doesn't exist.<br><br>If you think this might be a bug, please contact the administrator.");
				    }
			    } else {
				    include('pages/front.php');
			    }
			    ?>
		    </div>
	    </div>
	    <div id='bottom'></div>
	    <div id='backtotop'>
		    <a href='#'><div class='backtotopbutton'></div></a></li>
	    </div>
	    <div id='footer'>
		    <div id='top' style='margin-top:13px;'></div>
		    <div id='repeatfooter'></div>
		    <div id='bottom'></div>
	    </div>
	    <div id='copyright'>
		    <div id='copycontainer'>
			    <a href='?p=#'>Privacy policy</a> - <a href='?p=#'>Safety tips</a> - <a href='?p=#'>Abous us</a> - <a href='?p=#'>Contact us</a> - <a href='?p=#'>Help</a><br>
			    � 2012 Mafia Nations All rights reserved 
		    </div>
		    <div style='clear:both;'></div>
	    </div>
    </div>
<?php 
    if($login->check_login()) {
	    echo "
	    <div id='glassright'>
		    <div id='glassposition' style='margin-left:-10px;'>
			    <div id='glassframe' style='min-height:270px;'>
				    <div id='glasscontent'>
					    <div id='italicblack' style='font-size:14px;margin-left:8px;margin-top:4px;'>
						    Friends Online
						    </div>
						    <div id='friendcontent'>
							    <img src='images/avatars/4.png' style='margin-top:5px;margin-left:5px;'>
					    </div>
				    </div>
			    </div>
			    <div id='glassbottom'>
			    </div>
		    </div>
	    </div>";
    } else {
	    echo "
	    <div id='glassright2'>
	    </div>";
    }
?>
	    <div style='clear:both;'></div>
    </div>
    </div>
</body>
</html>
