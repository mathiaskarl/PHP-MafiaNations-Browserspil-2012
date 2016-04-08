<?php
if($login->check_login()) { 
    $totalMc = number_format(session::get_stat("mc")+session::get_stat("gb"));
    $query = db_core::getInstance()->conn->query("SELECT won, lost, draw FROM `user_monsters` WHERE user_id = '". $_SESSION['user_id'] ."'");
    $wins = 0; $lost = 0; $draw = 0;
    while($fetch = $query->fetch(PDO::FETCH_ASSOC)) {
        $wins = $wins+$fetch['won'];
        $lost = $lost+$fetch['lost'];
        $draw = $draw+$fetch['draw'];
    }
    echo ajax::overlay_loading()."
    <div style='margin:0px auto;width:800px;padding-bottom:20px;'>
        <div style='width:390px;float:left;'>
            <div style='width:24px;height:24px;float:left;background:url(images/icons/home2.png) 0 0 no-repeat;margin-left:20px;margin-top:3px;'></div>
                <div id='italicheadersmall' style='padding-left:10px;margin-bottom:5px;float:left;'>
                Your home
                </div>
                <div style='clear:both;'></div>
                <div id='italicblack' style='padding-left:20px;'>
                Welcome to your home. Here you can see your account stats, your equiptment, and other specifications about your account.
                </div>
                <div id='pagespacer' style='width:350px;'>
                </div>
                <div style='font-family:Georgia, arial, serif;font-size:19px;color:#2c2727;font-style:italic;margin-left:20px;'>
                <div style='float:left;'>Current Health:</div>
                <div style='float:right;text-align:right;margin-right:20px;'><font color='#ad5255' style='font-weight:bold;'>".session::get_stat("hp")."</font> / <font color='#ad5255' style='font-weight:bold;'>".session::get_stat("maxhp")."</font></div>
                <div style='clear:both;'></div>
                <div style='width:350px;height:27px;background:url(images/homebar.png) 0 0 no-repeat;padding-top:2px;margin-top:5px;margin-bottom:12px;'>
                        <div style='width:".$stats->stat_procent(session::get_stat("hp"), session::get_stat("maxhp"))."%;height:24px;background:url(images/hpbar.png) 0 0 no-repeat;margin-left:2px;'></div>
                </div>
                <div style='float:left;'>Current Energy:</div>
                <div style='float:right;text-align:right;margin-right:20px;'><font color='#4e82a9' style='font-weight:bold;'>".session::get_stat("ep")."</font> / <font color='#4e82a9' style='font-weight:bold;'>".session::get_stat("maxep")."</font></div>
                <div style='clear:both;'></div>
                <div style='width:350px;height:27px;background:url(images/homebar.png) 0 0 no-repeat;padding-top:2px;margin-top:5px;margin-bottom:12px;'>
                        <div style='width:".$stats->stat_procent(session::get_stat("ep"), session::get_stat("maxep"))."%;height:24px;background:url(images/epbar.png) 0 0 no-repeat;margin-left:2px;'></div>
                </div>
                <div style='float:left;'>Experience:</div>
                <div style='float:right;text-align:right;margin-right:20px;'><font color='#50bc67' style='font-weight:bold;'>".session::get_stat("xp")."</font> / <font color='#50bc67' style='font-weight:bold;'>". rank::showRank(session::get_stat("lvl")) ."</font></div>
                <div style='clear:both;'></div>
                <div style='width:350px;height:27px;background:url(images/homebar.png) 0 0 no-repeat;padding-top:2px;margin-top:5px;margin-bottom:17px;'>
                        <div style='width:".$stats->stat_procent(session::get_stat("xp"), rank::showRank(session::get_stat("lvl")))."%;height:24px;background:url(images/xpbar.png) 0 0 no-repeat;margin-left:2px;'></div>
                </div>
                </div>

                <div id='pagespacer' style='width:350px;'>
                </div>

                <div style='margin-left:20px;'>
                <div style='font-family:Georgia, arial, serif;font-size:19px;color:#2c2727;font-style:italic;margin-bottom:10px;'>Battle stats:</div>
                <div id='italicgrey' style='color:#2c2727;margin-right:20px;'>

                    <div id='homeboxleft'>
                    <b>Fights won:</b><br>
                    Total: ".$wins."
                    </div>
                    <div id='homeboxright'>
                    <b>More stats?</b><br>
                    <a href='?p=fightclub&do=stats'>Click here to see more</a>
                    </div>
                    <div style='clear:both;'></div>

                    <div id='homeboxleft'>
                    <b>Fights lost:</b><br>
                    Total: ".$lost."
                    </div>
                    <div id='homeboxright'>
                    <br>
                    
                    </div>
                    <div style='clear:both;'></div>

                    <div id='homeboxleft' style='margin-bottom:0px;'>
                    <b>Draw fights:</b><br>
                    Total: ".$draw."
                    </div>
                    <div id='homeboxright' style='margin-bottom:0px;'>
                    </div>
                    <div style='clear:both;'></div>

                </div>
            </div>

            <div id='pagespacer' style='width:350px;'>
            </div>

            <div style='margin-left:20px;'>
                <div style='font-family:Georgia, arial, serif;font-size:19px;color:#2c2727;font-style:italic;margin-bottom:10px;'>Account stats:</div>
                <div id='italicgrey' style='color:#2c2727;margin-right:20px;'>

                    <div id='homeboxleft'>
                    <b>Gangster Level:</b><br>
                    ". rank::getRank(session::get_stat("lvl")) ." Level: ".session::get_stat("lvl")."
                    </div>
                    <div id='homeboxright'>
                    <b>Avatar Collection:</b><br>";
                    echo $avatar->avatar_count()."
                    avatars
                    </div>
                    <div style='clear:both;'></div>

                    <div id='homeboxleft'>
                    <b>Total Mafia Coins:</b><br>
                    ".$totalMc." <font color='#d2bb23' style='font-weight:bold;'>MC</font>
                    </div>
                    <div id='homeboxright'>
                    <b>Inventory space:</b><br>
                    ".session::get_stat("inv")." Slots
                    </div>
                    <div style='clear:both;'></div>

                    <div id='homeboxleft' style='margin-bottom:0px;'>
                    <b>Gold Coin Balance:</b><br>
                    <b>0</b> Gold Coins (<b><u>Buy coins</u></b>)
                    </div>
                    <div id='homeboxright' style='margin-bottom:0px;'>
                    <b>Mail space:</b><br>
                    ".session::get_stat("mailspace")." Mails
                    </div>
                    <div style='clear:both;'></div>

                </div>
            </div>
        </div>
        <div id='registerspacerauto'>
        </div>
        <div id='italicgrey' style='width:375px;float:left;padding-left:20px;padding-top:5px;'>
            <div style='font-family:Georgia, arial, serif;font-size:19px;color:#2c2727;font-style:italic;margin-bottom:10px;'>Achievments:</div>
                <div style='color:#2c2727;width:365px;height:87px;background:url(images/avatarbg.png) 0 0 no-repeat;'>
                    <div style='width:100px;float:left;'>
                        <div style='font-family:Georgia, arial, serif;font-size:25px;color:#f0eded;font-weight:bold;padding-left:38px;padding-top:10px;'>22</div>
                        <div style='font-family:Georgia, arial, serif;font-size:11px;color:#f0eded;font-weight:bold;padding-left:30px;'>awards</div>
                    </div>
                    <div style='float:left;'>
                    You have completed 22 out of 56 Achivements.<br>
                    <a href='?p=achievements'>Click here to see the full list.</a>
                    </div>
                    <div style='clear:both;'></div>
                </div>

            <div id='pagespacer' style='width:370px;margin-left:0px;'>
            </div>
           
        </div>
        <div style='clear:both;'></div>
    </div>";
} else {
    echo error::return_error("You have to be logged in to view this page!");
}
?>