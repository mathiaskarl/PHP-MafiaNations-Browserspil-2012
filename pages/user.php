<?php
if($login->check_login()) {
    if(isset($_GET['id']) && user::get_user_info("id", $_GET['id'])) {
        $get_query = new user($_GET['id']);
        $query_user = $get_query->get_user();
            if($query_user['activate'] == 1) {
		$query_stats = new stats($query_user['id']);
                if($query_stats->get_stat("online") == 1) {
                    $last_activity = activity::get_last_activity($query_user['id'], "id");
                    if($last_activity) {
                        $timeSince = timeSince(strtotime(date("Y-m-d H:i:s")), activity::get_last_activity($query_user['id'], "time"));
                        if(activity::get_last_activity($query_user['id'], "type") == "logout") {
                        $showOnline = "<span style='color:#a22121;'><b>Offline</b></span>";
                        $showOnline .= "<br><span style='color:#a22121;'><b>Last seen: ".$timeSince."</b></span>";
                        } elseif((strtotime(date("Y-m-d H:i:s"))-strtotime(activity::get_last_activity($query_user['id'], "time")))<600) {
                            $showOnline = "<span style='color:#69ab52;'><b>Online</b></span>";
                        } else {
                            $showOnline = "<span style='color:#a22121;'><b>Offline</b></span>";
                            $showOnline .= "<br><span style='color:#a22121;'><b>Last seen: ".$timeSince."</b></span>";
                        }
                    } else {
                        $showOnline = "<span style='color:#a22121;'><b>Offline</b></span>";
                    }
                } else {
                    $showOnline = "<span style='color:#8e938c;'>Hidden</span>";
                }
                $query_avatar = new avatar();
                $query_monster = db_core::getInstance()->conn->query("SELECT won, lost, draw FROM `user_monsters` WHERE user_id = '". $query_user['id'] ."'");
                $wins = 0; $lost = 0; $draw = 0;
                while($fetch = $query_monster->fetch(PDO::FETCH_ASSOC)) {
                    $wins = $wins+$fetch['won'];
                    $lost = $lost+$fetch['lost'];
                    $draw = $draw+$fetch['draw'];
                }
                $total = $wins+$lost+$draw;
                $timeOld = timeSince(strtotime(date("Y-m-d H:i:s")), $query_user['register_time']);
                echo "
                    <div style='margin:0px auto;width:800px;padding-bottom:20px;'>
                        <div style='width:390px;float:left;'>
                            <div style='width:24px;height:24px;float:left;background:url(images/icons/home2.png) 0 0 no-repeat;margin-left:20px;margin-top:3px;'></div>
                            <div id='italicheadersmall' style='padding-left:10px;margin-bottom:5px;float:left;'>
                            " . $query_user['username'] . "
                            </div>
                            <div style='clear:both;'></div>

                            <div id='pagespacer' style='width:350px;'>
                            </div>

                            <div style='margin-left:20px;'>
                                                                            <div style='font-family:Georgia, arial, serif;font-size:19px;color:#2c2727;font-style:italic;margin-bottom:10px;'>User stats:</div>
                            <div id='italicgrey' style='color:#2c2727;margin-right:20px;'>

                            <div id='homeboxleft' style='width:40%'>
                                <b>Gangster Level:</b><br>
                                " . rank::getRank($query_stats->get_stat("lvl")) . "<br>
                                Level: " . $query_stats->get_stat("lvl") . "
                                </div>
                                <div id='homeboxleft' style='width:43%;text-align:right;margin-right:5px;'>
                                <b>Avatar Collection:</b><br>
                                0 avatars<br>
                                " . $query_stats->get_stat("posts") . " Posts
                                </div>
                                <div id='homeboxright style='width:6%text-align:right;'>
                                <img src='images/avatars/" . $query_avatar->return_avatar($query_user['avatar']) . "'>
                                </div>
                                <div style='clear:both;'></div>

                                <div id='homeboxleft'>
                                <b>Online status:</b><br>
                                " . $showOnline . "
                                <br>
                                </div>
                                <div id='homeboxright' style='text-align:right;'>
                                </div>
                                <div style='clear:both;'></div>

                                <div id='homeboxleft'>
                                <b>Country of residence:</b><br>";
                                if (empty($query_user['country'])) {
                                    echo "Currently unknown";
                                } else {
                                    echo $query_user['country'];
                                }
                                echo "<br>
                                </div>
                                <div id='homeboxright' style='text-align:right;'>
                                </div>
                                <div style='clear:both;'></div>

                                <div id='homeboxleft' style='margin-bottom:0px;'>
                                <b>Account age:</b><br>
                                ".$timeOld."<br>
                                </div>
                                <div id='homeboxright' style='margin-bottom:0px;'>
                                </div>
                                <div style='clear:both;'></div>
                            </div>
                            </div>

                            <div id='pagespacer' style='width:350px;'>
                            </div>

        <div style='margin-left:20px;'>
            <div id='italicgrey' style='color:#2c2727;margin-right:20px;'>

            <div id='homeboxleft' style='font-family:Georgia, arial, serif;font-size:19px;color:#2c2727;font-style:italic;'>
                Battle stats:<br>
                </div>
                <div id='homeboxright'>
                <b>Battles won:</b><br>
                " . $wins . " wins
                </div>
                <div style='clear:both;'></div>

                <div id='homeboxleft'>
                <b>Total battles:</b><br>
                " . $total . " battles played
                </div>
                <div id='homeboxright'>
                <b>Battles lost:</b><br>
                " . $lost . " lost
                </div>
                <div style='clear:both;'></div>

                <div id='homeboxleft' style='margin-bottom:0px;'>
                <b>Win/Lost %:</b><br>";
                if($total > 0) {
                    $showPercent = round(($wins / $total) * 100);
                } else {
                    $showPercent = "0";
                }
                echo $showPercent . "% win rate
                </div>
                <div id='homeboxright' style='margin-bottom:0px;'>
                <b>Battles draws:</b><br>
                " . $draw . " draws
                </div>
                <div style='clear:both;'></div>

                </div>
            </div>
            <div id='pagespacer' style='width:350px;'>
            </div>

            <div style='margin-left:20px;'>
                <div style='font-family:Georgia, arial, serif;font-size:19px;color:#2c2727;font-style:italic;margin-bottom:10px;'>Personal message:</div>
                <div id='italicgrey' style='color:#2c2727;margin-right:20px;'>";

            if (empty($query_user['description'])) {
                echo $query_user['username'] . " has yet to write a description about themselfs.<br> Give it a short while. I'm sure they'll figure something out!<br><br>
								In the meanwhile, use the hotlink bar bellow, to get in contact with this user, or fight them in the fightclub.";
            } else {
                $showText = nl2br($query_user['description']);
                echo $showText;
            }
            echo"
                    </div>
                </div>

                <div id='pagespacer' style='width:350px;'>
                </div>

                <div style='margin-left:20px;'>
                    <div style='width:350px;height:60px;'>
                    <div class='usermenu'>
                    <ul id='usernav'>
                        <li class='mail'><a href='?p=mail&do=send&id=" . $query_user['id'] . "'>Mail</a></li>
                        <li class='friends'><a href='?p=friends&do=add&id=" . $query_user['username'] . "'>Friends</a></li>
                        <li class='trades'><a href='?p=blackmarket&do=market&s=search&value=" . $query_user['username'] . "&t=1'>Trades</a></li>
                        <li class='battle'><a href='?p=fightclub&id=" . $query_user['username'] . "'>Battle</a></li>
                    </ul>
                    </div>
                    </div>
                </div>

                </div>
                <div id='registerspacerauto'>
                </div>
                <div id='italicgrey' style='width:375px;float:left;padding-left:20px;padding-top:5px;'>
                    <div style='font-family:Georgia, arial, serif;font-size:19px;color:#2c2727;font-style:italic;margin-bottom:10px;'>Achievments:</div>
                        <div style='color:#2c2727;width:365px;height:87px;background:url(images/avatarbg.png) 0 0 no-repeat;'>
                            <div style='width:160px;float:left;'>
                            <div style='font-family:Georgia, arial, serif;font-size:25px;color:#f0eded;font-weight:bold;padding-left:38px;padding-top:10px;'>22</div>
                            <div style='font-family:Georgia, arial, serif;font-size:11px;color:#f0eded;font-weight:bold;padding-left:30px;'>awards</div>
                            </div>
                            <div style='float:left;margin-left:102px;margin-top:-53px;'>
                            " . $query_user['username'] . " has completed 22 out of 56 Achivements.<br>
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
            echo error::return_error("This user hasnt activated their account yet!");
        }
    } else {
        echo error::return_error("This is not a valid user!");
    }
} else {
    echo error::return_error("You have to be logged in to view this page!");
}
?>