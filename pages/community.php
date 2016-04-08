<?php
	if($login) {
	echo "
		<div style='margin:0px auto;width:800px;'>
			<div style='width:390px;float:left;'>
				<div style='width:24px;height:24px;float:left;background:url(images/icons/forum2.png) 0 0 no-repeat;margin-left:20px;margin-top:3px;'></div>
					<div id='italicheadersmall' style='padding-left:10px;margin-bottom:5px;float:left;'>
					<a style='color:#000;text-decoration:none;' href='?p=community'>Community</a>
					</div>
			</div>
			<div id='normalblack2' style='padding-left:10px;margin-top:5px;margin-right:45px;float:right;'>
			<a href='?p=community'>Front</a> | <a href='?p=community&do=preferences'>Preferences</a> | <a href='?p=community&do=rules'>Forum rules</a> | <a href='?p=community&do=friends'>Friends Actions</a>
			</div>
			<div style='clear:both;'></div>
		</div>";
		
		switch($_GET['do']) {
		default:
			echo "
			<div style='width:740px;height:auto;margin:0px auto;'>
				<div style='margin-top:20px;padding:10px;width:740px;height:auto;background:url(images/forumbg.png) repeat-y;'>
				
					<div style='width:420px;float:left;padding:15px 0px 15px 15px;'>
					
					
						<div  style='float:left;width:200px;'>
							<a id='forumheaderlink' href='?p=community&do=forum&id=1'>
							<div id='forumheader'>
								<div style='float:left;width:50px;height:50px;margin-top:10px;border-right:1px dashed #b8b2b2;'>
								<img src='images/icons/forum1.png' style='margin-top:5px;margin-left:8px;'>
								</div>
								<div style='height:50px;width:114px;float:left;padding:7px 5px 0px 7px;'>
								<font style='color:#FFF;font-size:15px;'>Beta Questions</font><br>
								Report errors and feedback on Mafia Nations
								</div>
								<div style='clear:both;'></div>
							</div>
							</a>
						</div>
						<div style='float:left;width:180px;'>
						<a id='forumheaderlink' href='?p=community&do=forum&id=2'>
						<div id='forumheader'>
								<div style='float:left; width:52px;height:50px;margin-top:10px;border-right:1px dashed #b8b2b2;'>
								<img src='images/icons/forum3.png' style='margin-top:5px;margin-left:11px;'>
								</div>
								<div style='height:50px;width:114px;float:left;padding:7px 5px 0px 7px;'>
								<font style='color:#FFF;font-size:15px;'>Anouncements</font><br>
								The official announcement topic.
								</div>
								<div style='clear:both;'></div>
							</div>
							</a>
						</div>
						<div style='clear:both;'></div>
						
						<div  style='float:left;width:200px;margin-top:20px;'>
						<a id='forumheaderlink' href='?p=community&do=forum&id=3'>
							<div id='forumheader'>
								<div style='float:left;width:50px;height:50px;margin-top:10px;border-right:1px dashed #b8b2b2;'>
								<img src='images/icons/forum22.png' style='margin-top:5px;margin-left:10px;'>
								</div>
								<div style='height:50px;width:114px;float:left;padding:7px 5px 0px 7px;'>
								<font style='color:#FFF;font-size:15px;'>Newbie Section</font><br>
								For all the newcomers, that needs to learn!
								</div>
								<div style='clear:both;'></div>
							</div>
							</a>
						</div>
						<div style='float:left;width:180px;margin-top:20px;'>
						<a id='forumheaderlink' href='?p=community&do=forum&id=4'>
						<div id='forumheader'>
								<div style='float:left;width:50px;height:50px;margin-top:10px;border-right:1px dashed #b8b2b2;'>
								<img src='images/icons/forum4.png' style='margin-top:5px;margin-left:10px;'>
								</div>
								<div style='height:50px;width:114px;float:left;padding:7px 5px 0px 7px;'>
								<font style='color:#FFF;font-size:15px;'>Avatars</font><br>
								Show off and discuss your achievements and avatars.
								</div>
								<div style='clear:both;'></div>
							</div>
							</a>
						</div>
						<div style='clear:both;'></div>
						
						<div  style='float:left;width:200px;margin-top:20px;'>
						<a id='forumheaderlink' href='?p=community&do=forum&id=5'>
							<div id='forumheader'>
								<div style='float:left;width:50px;height:50px;margin-top:10px;border-right:1px dashed #b8b2b2;'>
								<img src='images/icons/forum5.png' style='margin-top:5px;margin-left:10px;'>
								</div>
								<div style='height:50px;width:114px;float:left;padding:7px 5px 0px 7px;'>
								<font style='color:#FFF;font-size:15px;'>The Fightclub</font><br>
								Talk and discuss everything about fighting.
								</div>
								<div style='clear:both;'></div>
							</div>
							</a>
						</div>
						<div style='float:left;width:180px;margin-top:20px;'>
						<a id='forumheaderlink' href='?p=community&do=forum&id=6'>
						<div id='forumheader'>
								<div style='float:left;width:50px;height:50px;margin-top:10px;border-right:1px dashed #b8b2b2;'>
								<img src='images/icons/forum6.png' style='margin-top:5px;margin-left:10px;'>
								</div>
								<div style='height:50px;width:114px;float:left;padding:7px 5px 0px 7px;'>
								<font style='color:#FFF;font-size:15px;'>Find Friends</font><br>
								Find a new friend to help you gain experience!
								</div>
								<div style='clear:both;'></div>
							</div>
							</a>
						</div>
						<div style='clear:both;'></div>
						
						<div  style='float:left;width:200px;margin-top:20px;'>
						<a id='forumheaderlink' href='?p=community&do=forum&id=7'>
							<div id='forumheader'>
								<div style='float:left;width:50px;height:50px;margin-top:10px;border-right:1px dashed #b8b2b2;'>
								<img src='images/icons/forum7.png' style='margin-top:5px;margin-left:10px;'>
								</div>
								<div style='height:50px;width:114px;float:left;padding:7px 5px 0px 7px;'>
								<font style='color:#FFF;font-size:15px;'>General Talk</font><br>
								Talk about anything from your everyday!
								</div>
								<div style='clear:both;'></div>
							</div>
							</a>
						</div>
						<div style='float:left;width:180px;margin-top:20px;'>
						<a id='forumheaderlink' href='?p=community&do=forum&id=8'>
						<div id='forumheader'>
								<div style='float:left;width:50px;height:50px;margin-top:10px;border-right:1px dashed #b8b2b2;'>
								<img src='images/icons/forum8.png' style='margin-top:5px;margin-left:9px;'>
								</div>
								<div style='height:50px;width:114px;float:left;padding:7px 5px 0px 7px;'>
								<font style='color:#FFF;font-size:15px;'>Questing</font><br>
								Discuss and help others with quests.
								</div>
								<div style='clear:both;'></div>
							</div>
							</a>
						</div>
						<div style='clear:both;'></div>
						
						<div  style='float:left;width:200px;margin-top:20px;'>
						<a id='forumheaderlink' href='?p=community&do=forum&id=9'>
							<div id='forumheader'>
								<div style='float:left;width:50px;height:50px;margin-top:10px;border-right:1px dashed #b8b2b2;'>
								<img src='images/icons/forum9.png' style='margin-top:5px;margin-left:10px;'>
								</div>
								<div style='height:50px;width:114px;float:left;padding:7px 5px 0px 7px;'>
								<font style='color:#FFF;font-size:15px;'>Trade Section</font><br>
								Trade/Sell and buy items from other users.
								</div>
								<div style='clear:both;'></div>
							</div>
							</a>
						</div>
						<div style='float:left;width:180px;margin-top:20px;'>
						<a id='forumheaderlink' href='?p=community&do=forum&id=10'>
						<div id='forumheader'>
								<div style='float:left;width:50px;height:50px;margin-top:10px;border-right:1px dashed #b8b2b2;'>
								<img src='images/icons/forum10.png' style='margin-top:5px;margin-left:11px;'>
								</div>
								<div style='height:50px;width:114px;float:left;padding:7px 5px 0px 7px;'>
								<font style='color:#FFF;font-size:15px;'>Help Section</font><br>
								Ask question about anything on Mafia Nations
								</div>
								<div style='clear:both;'></div>
							</div>
							</a>
						</div>
						<div style='clear:both;'></div>
						
					</div>
					
					<div id='forumspacer'>
					</div>
					
					<div id='italicblack' style='width:210px;float:left;padding:15px;font-size:15px;'>
					<div style='float:left;'>
					<img src='images/icons/burn.png'>
					</div>
					<div style='margin-top:2px;margin-left:5px;float:left;'>Current popular topics:</div>
					<div style='clear:both;'></div>
					<div id='pagespacer' style='margin-left:0px;margin-top:5px;margin-bottom:2px;width:250px;'>
					</div>
					";
			$hotTopic = mysql_query("SELECT * FROM `forum_topic` ORDER BY `post_number` DESC LIMIT 8") or die(mysql_error());
			while($showHot = mysql_fetch_array($hotTopic)) {
			echo "
			<a id='hottopiclink' href='?p=community&do=topic&id=".$showHot['id']."'>
			<div id='hottopic' style='margin-top:8px;'>
			".$showHot['header']."<br>
				<font style='font-size:11px;color:#696767;font-style:none;'>".$showHot['forum_name']."</font> <font style='font-size:10px;color:#535353;font-style:none;'>".$showHot['date']."</font>
			</div>
			</a>";
			}
		echo "
					</div>
					
					<div style='clear:both;'></div>
				</div>
			</div>
			<div style='height:40px;'></div>";
		break;
		
		case 'forum':
			if(isset($_GET['id'])) {
				$forumId = isNumber($_GET['id']);
				$getForum = mysql_query("SELECT * FROM `forum` where id='".$forumId."'") or die(mysql_error());
				$countForum = mysql_num_rows($getForum);
				if($countForum > 0) {
					$showForum = mysql_fetch_array($getForum);
					
				echo "
				<div style='width:740px;height:auto;margin:0px auto;'>
					<div style='margin-top:20px;padding:10px;width:740px;height:auto;background:url(images/forumbg.png) repeat-y;'>
						<div id='italicblack' style='font-size:13px;padding:20px;width:680px'>
								<div id='linkmenu' style='margin-left:-10px;margin-top:-15px;margin-bottom:15px;'>
								<a href='?p=community'>Community</a> &rarr; <a href='?p=community&do=forum&id=".$showForum['id']."'>".$showForum['name']."</a>
								</div>
								<div style='float:left;width:480px;font-size:14px;'>
								Topic / Author
								</div>
								<div style='float:left;width:80px;text-align:center;font-size:14px;'>
								Posts
								</div>
								<div style='float:left;width:110px;text-align:center;font-size:14px;'>
								Last Post
								</div>
								<div style='clear:both;'></div>
								<div id='pagespacer' style='margin-top:2px;margin-left:0px;margin-bottom:5px;width:680px;'>
								</div>
								";
				$getTopic = mysql_query("SELECT * FROM `forum_topic` WHERE forum_id = '".$showForum['id']."'") or die(mysql_error());
				$numSql = mysql_num_rows($getTopic);
				$rowsperpage = 10;
				$totalpages = ceil($numSql / $rowsperpage);
				if (isset($_GET['s']) && is_numeric($_GET['s'])) {
					$currentpage = (int) $_GET['s'];
				} else {
					$currentpage = 1;
				}
				if ($currentpage > $totalpages) {
					$currentpage = $totalpages;
				}
				if ($currentpage < 1) {
					$currentpage = 1;
				}
				$offset = ($currentpage - 1) * $rowsperpage;
				$getTopic = mysql_query("SELECT * FROM `forum_topic` WHERE forum_id='".$showForum['id']."' ORDER BY `last_post` DESC LIMIT $offset, $rowsperpage") or die(mysql_error());
				$range = 2;
				$showPage = "";
				if ($currentpage > 1) {
					$showPage .= " <a href='?p=community&do=forum&id=".$showForum['id']."&s=1'><img src='images/icons/backactive.gif' border='0'></a> ";
					$prevpage = $currentpage - 1;
					$showPage .= " <a href='?p=community&do=forum&id=".$showForum['id']."&s=$prevpage'><img src='images/icons/prevactive.gif' border='0'></a> ";
				} else {
					$showPage .= " <img src='images/icons/previnactive.gif' border='0'> ";
					$prevpage = $currentpage - 1;
					$showPage .= " <img src='images/icons/backinactive.gif' border='0'> ";
				}
				for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
				   if (($x > 0) && ($x <= $totalpages)) {
					  if ($x == $currentpage) {
						 $showPage .= " [<b>$x</b>] ";
					  } else {
						 $showPage .= " <a href='?p=community&do=forum&id=".$showForum['id']."&s=$x'>$x</a> ";
					  } 
				   }
				}                  
				if ($currentpage != $totalpages && $rowsperpage < $numSql) {
				   $nextpage = $currentpage + 1;
				   $showPage .= " <a href='?p=community&do=forum&id=".$showForum['id']."&s=$nextpage'><img src='images/icons/nextactive.gif' border='0'></a> ";
				   $showPage .= " <a href='?p=community&do=forum&id=".$showForum['id']."&s=$totalpages'><img src='images/icons/lastactive.gif' border='0'></a> ";
				} elseif ($rowsperpage >= $totalpages) {
					$showPage .= " <img src='images/icons/nextinactive.gif' border='0'> ";
					$showPage .= " <img src='images/icons/lastinactive.gif' border='0'> ";
				} else {
					$showPage .= " <img src='images/icons/nextinactive.gif' border='0'> ";
					$showPage .= " <img src='images/icons/lastinactive.gif' border='0'> ";
				}
				
				
				while ($showTopic = mysql_fetch_array($getTopic)) {
					$getPost = mysql_query("SELECT * FROM `forum_post` WHERE topic_id = '".$showTopic['id']."' ORDER BY `id` DESC") or die(mysql_error());
						if($showTopic['post_number'] > 0) {
							$showPost = mysql_fetch_array($getPost);
							$showCount = $showTopic['post_number'];
							$showLast = "<a href='?p=user&id=".$showPost['creater_id']."'>".$showPost['creater_username']."</a>";
						} else {
							$showCount = "0";
							$showLast = "None";
						}
					echo "
					<div id='forumpost' style='margin-top:7px;'>
						<div style='float:left;width:480px;'>
						<a style='text-decoration:none;color:#000;font-weight:bold;' href='?p=community&do=topic&id=".$showTopic['id']."'>".$showTopic['header']."</a><br>
						<font style='font-size:11px;color:#696767;font-style:none;'>by <a href='?p=user&id=".$showTopic['creater_id']."'>".$showTopic['creater_username']."</a></font> - <font style='font-size:11px;color:#535353;font-style:none;'>".$showTopic['date']."</font>
						</div>
						<div style='float:left;width:80px;text-align:center;'>
						".$showCount."
						</div>
						<div style='float:left;width:110px;text-align:center;font-size:12px;'>
						".$showLast."
						</div>
						<div style='clear:both;'></div>
					</div>";
								
				$i++;
				$checkVar = 1;
				}
				if($checkVar != 1) {
					echo "
					<table class='mailcontent' align='center'>
					<tr>
					<td width='100%'>
					<center>There are no topics in this forum!</center>
					</td>
					</tr>
					</table>";
				}
						echo "
						<div style='margin-top:10px;'>
							<form name='submit' method='post' action='?p=community&do=createtopic'>
								<input type='hidden' name='forum' value='".$forumId."' >
								<input type='submit' name='submit' class='createtopic' value='&nbsp;' size='10'>
							</form>
						</div>
						<div style='margin-top:-10px;'>
							<center>".$showPage."</center>
						</div>
						</div>
					</div>
				</div>
				<div style='height:40px;'></div>";
			} else {
				$message = "Invalid forum id!<br><br><i>Errorcode: f002</i>";
				include("pages/error.php");
			}
		} else {
			$message = "Invalid forum id!<br><br><i>Errorcode: f003</i>";
			include("pages/error.php");
		}
		break;
		
		case 'topic':
			if(isset($_GET['id'])) {
				$topicId = isNumber($_GET['id']);
				$getTopic = mysql_query("SELECT * FROM `forum_topic` WHERE id='".$topicId."'") or die(mysql_error());
				$countTopic = mysql_num_rows($getTopic);
				if($countTopic > 0) {
					$showTopic = mysql_fetch_array($getTopic);
					
					
					echo "
					<div style='width:740px;height:auto;margin:0px auto;'>
					<div style='margin-top:20px;padding:10px;width:740px;height:auto;background:url(images/forumbg.png) repeat-y;'>
						<div id='italicblack' style='font-size:13px;padding:20px;width:680px'>
								<div id='linkmenu' style='margin-left:-10px;margin-top:-15px;margin-bottom:20px;'>
								<a href='?p=community'>Community</a> &rarr; <a href='?p=community&do=forum&id=".$showTopic['forum_id']."'>".$showTopic['forum_name']."</a> &rarr; <a href='?p=community&do=topic&id=".$showTopic['id']."'>".$showTopic['header']."</a>
								</div>";
								
					$getPost = mysql_query("SELECT * FROM `forum_post` WHERE topic_id = '".$showTopic['id']."'") or die(mysql_error());
					$numSql = mysql_num_rows($getPost);
					$rowsperpage = 10;
					$totalpages = ceil($numSql / $rowsperpage);
					if (isset($_GET['s']) && is_numeric($_GET['s'])) {
						$currentpage = (int) $_GET['s'];
					} else {
						$currentpage = 1;
					}
					if ($currentpage > $totalpages) {
						$currentpage = $totalpages;
					}
					if ($currentpage < 1) {
						$currentpage = 1;
					}
					$offset = ($currentpage - 1) * $rowsperpage;
					$getPost = mysql_query("SELECT * FROM `forum_post` WHERE topic_id='".$showTopic['id']."' ORDER BY `id` ASC LIMIT $offset, $rowsperpage") or die(mysql_error());
					$range = 2;
					$showPage = "";
					if ($currentpage > 1) {
						$showPage .= " <a href='?p=community&do=topic&id=".$showTopic['id']."&s=1'><img src='images/icons/backactive.gif' border='0'></a> ";
						$prevpage = $currentpage - 1;
						$showPage .= " <a href='?p=community&do=topic&id=".$showTopic['id']."&s=$prevpage'><img src='images/icons/prevactive.gif' border='0'></a> ";
					} else {
						$showPage .= " <img src='images/icons/previnactive.gif' border='0'> ";
						$prevpage = $currentpage - 1;
						$showPage .= " <img src='images/icons/backinactive.gif' border='0'> ";
					}
					for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
					   if (($x > 0) && ($x <= $totalpages)) {
						  if ($x == $currentpage) {
							 $showPage .= " [<b>$x</b>] ";
						  } else {
							 $showPage .= " <a href='?p=community&do=topic&id=".$showTopic['id']."&s=$x'>$x</a> ";
						  } 
					   }
					}                  
					if ($currentpage != $totalpages && $rowsperpage < $numSql) {
					   $nextpage = $currentpage + 1;
					   $showPage .= " <a href='?p=community&do=topic&id=".$showTopic['id']."&s=$nextpage'><img src='images/icons/nextactive.gif' border='0'></a> ";
					   $showPage .= " <a href='?p=community&do=topic&id=".$showTopic['id']."&s=$totalpages'><img src='images/icons/lastactive.gif' border='0'></a> ";
					} elseif ($rowsperpage >= $totalpages) {
						$showPage .= " <img src='images/icons/nextinactive.gif' border='0'> ";
						$showPage .= " <img src='images/icons/lastinactive.gif' border='0'> ";
					} else {
						$showPage .= " <img src='images/icons/nextinactive.gif' border='0'> ";
						$showPage .= " <img src='images/icons/lastinactive.gif' border='0'> ";
					}
					$i = 1;
					while ($showPost = mysql_fetch_array($getPost)) {
						if(isNumber($_GET['s']) > 0) {
							if($x != 1) {
							$calcPostNumber = (isNumber($_GET['s'])-1)*10;
							$x = 1;
							} else {
							$calcPostNumber = 0;
							}
						} else {
							$calcPostNumber = 0;
						}
						if(isset($_GET['s'])) {
							$i = $calcPostNumber+$i;
						}
						$getUser = mysql_query("SELECT * FROM `users` WHERE id='".$showPost['creater_id']."'") or die(mysql_error());
						$showUser = mysql_fetch_array($getUser);
						$showRank = getRank(getStat('lvl', $showUser['id']));
						$showPosts = getStat('posts', $showUser['id']);
						if($showPosts == 1) {
							$showPostText = "Post";
						} else {
							$showPostText = "Posts";
						}
							
						if($showUser['sex'] == "Male") {
							$colour = "#177ad5";
						} elseif($showUser['sex'] == "Female") {
							$colour = "#ff6c6c";
						} else {
							$color = "#000";
						}
						
						$showSize = getStat('fontsize', $showUser['id']);
						$showStyle = getStat('fontstyle', $showUser['id']);
						$showColor = getStat('fontcolor', $showUser['id']);
						$showType = getStat('fonttype', $showUser['id']);
						$showFontAlign = getStat('fontalign', $showUser['id']);
						$showSigAlign = getStat('sigalign', $showUser['id']);
						
						if(empty($showSize) || $hidefont == 1) {
							$showSize = "11";
						}
						if(empty($showStyle)|| $hidefont == 1) {
							$showStyle = "normal";
						}
						if(empty($showColor)|| $hidefont == 1) {
							$showColor = "#2c2b2b";
						}
						if(empty($showType)|| $hidefont == 1) {
							$showType = "Tahoma";
						}
						if(empty($showFontAlign)|| $hidefont == 1) {
							$showFontAlign = "Left";
						}
						if(empty($showSigAlign)|| $hidefont == 1) {
							$showSigAlign = "Left";
						}
						if($showUser['signature'] != "") {
							$showIt = 1;
						}
						echo "
						<div style='width:480px;margin:0px auto;'>
							<div style='padding:5px;width:480px;min-height:150px;height:auto;background:url(images/topicbg.png) 0 0 no-repeat;'>
								<div style='font-size:11px;float:left;width:98px;height:150px;'>
									<div style='width:98px;text-align:center;margin-top:5px;margin-bottom:5px;'>
									<a href='?p=user&id=".$showUser['id']."' style='text-decoration:none;'>".$showUser['username']."</a>
									</div>
									<div style='width:50px;margin:0px auto;'>
										<img src='images/avatars/".$showUser['avatar']."'>
									</div>
									
									<div style='color:#2c2b2b;width:98px;text-align:center;margin-top:7px;margin-bottom:1px;'>
									".$showRank."
									</div>
									
									<div style='color:#2c2b2b;width:98px;text-align:center;margin-bottom:1px;'>
									".$showPosts." ".$showPostText."
									</div>
									
									<div style='color:".$colour.";width:98px;text-align:center;margin-bottom:5px;'>
									".$showUser['sex']."
									</div>
								</div>
								<div id='italicblack' style='color:#2c2b2b;padding:5px 10px 5px 10px;font-size:11px;float:left;margin-left:8px;width:348px;height:auto;'>
									<div style='text-align:center;width:45px;font-size:19px;z-index:10;position:absolute;margin-left:315px;margin-top:-9px;'>
									#".$i."
									</div>
									<font style='color:#383634;'>Posted on: <b>".$showPost['date']."</b></font><br>
									<div style='padding-top:3px;width:100%;text-align:".$showFontAlign."'>
									<p style='font-family:".$showType.";font-size:".$showSize."px;font-style:".$showStyle.";color:".$showColor.";'>".nl2br($showPost['text'])."</p>
									</div>";
									if($hidesig != 1) {
										if($showUser['signature'] != "") {
											echo "
											<div style='padding-top:-3px;width:100%;text-align:".$showSigAlign."'>
											<hr style='width:100%;color:#767373;height:1px;margin-bottom:-2px;'>
											<p style='font-family:".$showType.",serif;font-size:".$showSize."px;font-style:".$showStyle.";color:".$showColor.";'>".$showUser['signature']."</p>
											</div>";
										}
									}
									echo "
								</div>
								<div style='clear:both;'></div>
							</div>
							<div style='width:480px;margin-top:-45px;height:48px;background:url(images/topicfooter.png) 0 0 no-repeat;'>
							</div>
						</div>
						<div style='height:30px;'></div>
						";
					$i++;
					}
					echo "
					
					<div style='margin-top:-22px;margin-bottom:15px;'>
							<center>".$showPage."</center>
						</div>
						
						
					<div style='width:480px;margin:0px auto;'>
						<div style='margin-bottom:3px;width:100%;font-family:Times New Roman, serif;font-size:21px;color:#000;font-style:italic;text-align:center;'>
						Post A Message.
						</div>
						<div style='padding:5px;width:480px;min-height:200px;height:auto;background:url(images/postbg.png) 0 0 no-repeat;'>
							<div id='italicblack' style='color:#2c2b2b;padding:5px;font-size:11px;margin:0px auto;width:460px;height:auto;'>
							<form name='submit' method='post' action='?p=community&do=post'>
							<input type='hidden' name='topic' value='".$showTopic['id']."' >
								<div style='width:450px;margin:0px auto;'>
									<div style='width:50px;float:left;'>
									<div id='forumbuttons' style='width:30px;'>
										<div class='forumbutton'>
											<ul id='forumbutton'>
												<li class='bold'><a href='?p=games' style='margin-top:5px;'>B</a></li>
												<li class='italic'><a href='?p=games'>I</a></li>
												<li class='underline'><a href='?p=games'>U</a></li>
											</ul>
										</div>
									</div>
									</div>
									<div style='width:350px;float:left;'>
									<font style='color:#383634;'>You can write a maximum of 400 characters!</font>
									<textarea rows='9' cols='30' name='message' id='forummessage'></textarea><br>
									<center><input type='submit' name='submit' class='postmessage' style='margin-top:-8px;' value='&nbsp;' size='10'></center>
									</div>
									<div style='float:left;'>
									
									</div>
									
									<div style='clear:both;'></div>
									
									<div style='margin-top:15px;color:#383634;'>
										- Make sure to read the forum rules before posting on the forums<br>
										- Breaking the rules in any way, may be punished by ban from Mafia Nations.<br>
									</div>
								</div>
							</form>
							</div>
						</div>
					</div>
					<div style='height:20px;'></div>
						
						
						</div>
						
					
					</div>        
					</div>
					<div style='height:40px;'></div>";
					
				} else {
					$message = "Invalid topic id<br><br><i>Errorcode: f004</i>";
					include("pages/error.php");
				}
			} else {
				$message = "Invalid topic id<br><br><i>Errorcode: f004</i>";
				include("pages/error.php");
			}
		break;
		
		case 'post':
			if($_POST['submit']) {
				if(isset($_POST['topic'])) {
					$checkTopic = mysql_query("SELECT * FROM `forum_topic` WHERE id='".isNumber($_POST['topic'])."'") or die(mysql_error());
					$countTopic = mysql_num_rows($checkTopic);
					if($countTopic > 0) {
						if(strlen($_POST['message']) > 6) {
							if(strlen($_POST['message']) < 401) {
								$message = safe($_POST['message']);
								$safeMessage = nl2br($message);
								$showTopic = mysql_fetch_array($checkTopic);
								$date = date("Y/m/d H:i:s");
								mysql_query("INSERT INTO `forum_post` (`topic_id`, `forum_id`, `creater_id`, `creater_username`, `text`, `date`) VALUES ('".$showTopic['id']."', '".$showTopic['forum_id']."', '".$login."', '".$loginoutput['username']."', '".$safeMessage."', '".$date."')") or die(mysql_error());
								$postNumber = $showTopic['post_number']+1;
								mysql_query("UPDATE `forum_topic` SET post_number='".$postNumber."', last_post='".$date."' WHERE id='".$showTopic['id']."'") or die(mysql_error());
								setStat('posts',$login,getStat('posts', $login)+1);
								$image = "loginimage.png";
								$header = "Please wait";
								$message = "Your post is being submitted!
								Please wait..
								<meta http-equiv='refresh' content='1;URL=?p=community&do=topic&id=".$showTopic['id']."'>";
								include("pages/error.php");
							} else {
								$message = "Your message cannot exceed 400 characters!<br><br><i>Errorcode: p003</i>";
								include("pages/error.php");
							}
						} else {
							$message = "Your message must be atleast 7 characters long!<br><br><i>Errorcode: p004</i>";
							include("pages/error.php");
						}
					} else {
						$message = "Your post was not created!<br><br><i>Errorcode: p002</i>";
						include("pages/error.php");
					}
				
				} else {
					$message = "Your post was not created!<br><br><i>Errorcode: p001</i>";
					include("pages/error.php");
				}
			} else {
				echo "<meta http-equiv='refresh' content='2;URL=?p=community'>";
			}
		break;
		
		case 'createtopic':
			if(isset($_POST['post'])) {
					if(strlen($_POST['message']) > 6) {
						if(strlen($_POST['message']) < 401) {
							if(strlen($_POST['header']) > 6) {
								if(strlen($_POST['header']) < 81) {
									$message = safe($_POST['message']);
									$header = safe($_POST['header']);
									$forum = isNumber($_POST['forum']);
									$safeMessage = nl2br($message);
									$checkForum = mysql_query("SELECT * FROM `forum` WHERE id='".$forum."'") or die(mysql_error());
									$countForum = mysql_num_rows($checkForum);
									if($countForum > 0) {
										$showForum = mysql_fetch_array($checkForum);
										$date = date("Y/m/d H:i:s");
										mysql_query("INSERT INTO `forum_topic` (`post_number`, `header`, `creater_id`, `creater_username`, `date`, `forum_id`, `forum_name`, `last_post`) VALUES ('0', '".$header."', '".$login."', '".$loginoutput['username']."', '".$date."', '".$showForum['id']."', '".$showForum['name']."', '".$date."')") or die(mysql_error());
										$getNew = mysql_query("SELECT * FROM `forum_topic` WHERE creater_id = '".$login."' AND post_number ='0' AND header = '".$header."'") or die(mysql_error());
										$showNew = mysql_fetch_array($getNew);
										mysql_query("INSERT INTO `forum_post` (`topic_id`, `forum_id`, `creater_id`, `creater_username`, `text`, `date`) VALUES ('".$showNew['id']."', '".$showForum['id']."', '".$login."', '".$loginoutput['username']."', '".$safeMessage."', '".$date."')") or die(mysql_error());
										setStat('posts',$login,getStat('posts', $login)+1);
										$image = "loginimage.png";
										$header = "Please wait";
										$message = "Your topic has been created!
										Please wait..
										<meta http-equiv='refresh' content='1;URL=?p=community&do=forum&id=".$showForum['id']."'>";
										include("pages/error.php");
									} else {
										$message = "Your topic was not created!!<br><br><i>Errorcode: p010</i>";
										include("pages/error.php");
									}
								} else {
								$message = "Your title cannot exceed 80 characters!<br>Please wait!<br><br><i>Errorcode: p009</i>
								<meta http-equiv='refresh' content='2;URL=?p=community&do=createtopic'>";
								include("pages/error.php");
								}
							} else {
								$message = "Your title must be atleast 6 characters long!<br>Please wait!<br><br><i>Errorcode: p008</i>
								<meta http-equiv='refresh' content='2;URL=?p=community&do=createtopic'>";
								include("pages/error.php");
							}
						} else {
							$message = "Your message cannot exceed 400 characters!<br>Please wait!<br><br><i>Errorcode: p007</i>
							<meta http-equiv='refresh' content='2;URL=?p=community&do=createtopic'>";
							include("pages/error.php");
						}
					} else {
						$message = "Your message must be atleast 7 characters long!<br>Please wait!<br><br><i>Errorcode: p006</i>
						<meta http-equiv='refresh' content='2;URL=?p=community&do=createtopic'>";
						include("pages/error.php");
					}
			} else {
				if(isset($_POST['forum'])) {
					$_SESSION['fct'] = $_POST['forum'];
				}
				echo "
				<div style='width:740px;height:auto;margin:0px auto;'>
				<div style='margin-top:20px;padding:10px;width:740px;height:auto;background:url(images/forumbg.png) repeat-y;'>
					<div id='italicblack' style='font-size:13px;padding:20px;width:680px'>
							<div id='linkmenu' style='margin-left:-10px;margin-top:-15px;margin-bottom:20px;'>
							<a href='?p=community'>Community</a> &rarr; <a href='?p=community&do=createtopic'>Create Topic</a>
							</div>
							<div style='width:480px;margin:0px auto;'>
					<div style='padding:5px;width:480px;min-height:200px;height:auto;background:url(images/postbg.png) 0 0 no-repeat;'>
						<div id='italicblack' style='color:#2c2b2b;padding:5px;font-size:11px;margin:0px auto;width:460px;height:auto;'>
						<form name='submit' method='post' action='?p=community&do=createtopic'>
						<input type='hidden' name='post' value='post' >
							<div style='width:450px;margin:0px auto;'>
								<div style='width:50px;float:left;'>
								<div id='forumbuttons' style='width:30px;margin-top:99px;'>
									<div class='forumbutton'>
										<ul id='forumbutton'>
											<li class='bold'><a href='?p=games' style='margin-top:5px;'>B</a></li>
											<li class='italic'><a href='?p=games'>I</a></li>
											<li class='underline'><a href='?p=games'>U</a></li>
										</ul>
									</div>
								</div>
								</div>
								<div style='width:350px;float:left;'>
									<div style='margin-bottom:2px;'>
										<font style='color:#383634;'>Topic title:</font><br>
										<input type='text' id='topicinput' name='header' style='width:250px;margin-bottom:5px;'>
									</div>
									<div style='margin-bottom:2px;'>
										<font style='color:#383634;'>Forum to write topic in</font><br>
										<select id='topicinput' name='forum' style='height:22px;margin-bottom:5px;width:180px;'>";
										$getForum = mysql_query("SELECT * FROM `forum`") or die(mysql_error());
										while ($showForum = mysql_fetch_array($getForum)) {
											if($showForum['id'] == $_SESSION['fct']) {
												echo "
												<option value='".$showForum['id']."' selected>".$showForum['name']."</option>";
											} else {
												echo "
												<option value='".$showForum['id']."'>".$showForum['name']."</option>";
											}
										}
										echo "
										</select>
									</div>
									<font style='color:#383634;'>You can write a maximum of 400 characters!</font>
									<textarea rows='9' cols='30' name='message' id='forummessage'></textarea><br>
									<center><input type='submit' name='submit' class='postmessage' style='margin-top:-8px;' value='&nbsp;' size='10'></center>
								</div>
								<div style='float:left;'>
								</div>
								
								<div style='clear:both;'></div>
								
								<div style='margin-top:15px;color:#383634;'>
									- Make sure to read the forum rules before posting on the forums<br>
									- Breaking the rules in any way, may be punished by ban from Mafia Nations.<br>
								</div>
							</div>
						</form>
						</div>
					</div>
				</div>
				</div>        
				</div>
				</div>
				<div style='height:40px;'></div>";
			}
		break;
		
		case 'preferences':
		$arrStyle[] = "Bold";
		$arrStyle[] = "Italic";
		$arrStyle[] = "Underline";
		$arrSize[] = "11";
		$arrSize[] = "12";
		$arrSize[] = "13";
		$arrSize[] = "14";
		$arrSize[] = "15";
		$arrType[] = "Arial";
		$arrType[] = "Comic Sans ms";
		$arrType[] = "Courier New";
		$arrType[] = "Georgia";
		$arrType[] = "Helvetica";
		$arrType[] = "Impact";
		$arrType[] = "Tahoma";
		$arrType[] = "Terminal";
		$arrType[] = "Times New Roman";
		$arrType[] = "Verdana";
		$arrColor[] = "#000";
		$arrAlign[] = "Left";
		$arrAlign[] = "Center";
		$arrAlign[] = "Right";
		$date = date("Y/m/d H:i:s");
		$showRank = getRank(getStat('lvl', $login));
		$showPosts = getStat('posts', $login);
		if($showPosts == 1) {
			$showPostText = "Post";
		} else {
			$showPostText = "Posts";
		}
			
		if($login['sex'] == "Male") {
			$colour = "#177ad5";
		} elseif($login['sex'] == "Female") {
			$colour = "#ff6c6c";
		} else {
			$color = "#000";
		}
		if($_POST['submit']){
			$safeSize = safe($_POST['size']);
			$safeStyle = safe($_POST['style']);
			$safeColor = safe($_POST['color']);
			$safeType = safe($_POST['type']);
			$safeFontAlign = safe($_POST['fontalign']);
			$safeSigAlign = safe($_POST['sigalign']);
			$subSig = safe($_POST['signature']);
			$checkPreg = preg_match('/^[\w\d]$/', $safeColor);
			if($checkPreg == FALSE) {
				if(strlen($subSig)>0) {
					$safeSig = substr($subSig, 0, 60);
				} else {
					$safeSig = "";
				}
				$safeSig = safe($safeSig);
				if(in_array($safeSize, $arrSize)) {
					$showSize = $safeSize;
				} else {
					$showSize = "11";
				}
				if(in_array($safeStyle, $arrStyle)) {
					$showStyle = $safeStyle;
				} else {
					$showStyle = "normal";
				}
				if(strlen($safeColor) == 6) {
					$showColor = "#".$safeColor;
				} else {
					$showColor = "#2c2b2b";
				}
				if(in_array($safeType, $arrType)) {
					$showType = $safeType;
				} else {
					$showType = "Tahoma";
				}
				if(in_array($safeFontAlign, $arrAlign)) {
					$showFontAlign = $safeFontAlign;
				} else {
					$showFontAlign = "Left";
				}
				if(in_array($safeSigAlign, $arrAlign)) {
					$showSigAlign = $safeSigAlign;
				} else {
					$showSigAlign = "Left";
				}
				
				if(empty($showSize)) {
					$showSize = "11";
				}
				if(empty($showStyle)) {
					$showStyle = "normal";
				}
				if(empty($showColor)) {
					$showColor = "#2c2b2b";
				}
				if(empty($showType)) {
					$showType = "Tahoma";
				}
				if(empty($showFontAlign)) {
					$showType = "Left";
				}
				if(empty($showSigAlign)) {
					$showType = "Left";
				}
				
				if($_POST['showeffects'] == 1) {
					$showEffects = 1;
				} else {
					$showEffects = 0;
				}
				
				if($_POST['showsignatures'] == 1) {
					$showSignatures = 1;
				} else {
					$showSignatures = 0;
				}
				
				setStat('fontsize',$login,$showSize);
				setStat('fontstyle',$login,$showStyle);
				setStat('fontcolor',$login,$showColor);
				setStat('fonttype',$login,$showType);
				setStat('sigalign',$login,$showSigAlign);
				setStat('fontalign',$login,$showFontAlign);
				setStat('hidefont',$login,$showEffects);
				setStat('hidesig',$login,$showSignatures);
				mysql_query("UPDATE `users` SET signature='".$safeSig."' WHERE id='".$login."'") or die(mysql_error());
				$image = "loginimage.png";
				$header = "Changing settings";
				$message = "
				Your settings are being changed!
				Please wait.<meta http-equiv='refresh' content='2;URL=?p=community&do=preferences'>";
				include("pages/error.php");
			} else {
				$message = "That color code is incorrect<br>Please wait!<br><br><i>Errorcode: p007</i>
				<meta http-equiv='refresh' content='2;URL=?p=community&do=preferences'>";
				include("pages/error.php");
			}
		} else {
			if($_POST['submit2']) {
				$safeSize = safe($_POST['size']);
				$safeStyle = safe($_POST['style']);
				$safeColor = safe($_POST['color']);
				$safeType = safe($_POST['type']);
				$safeFontAlign = safe($_POST['fontalign']);
				$safeSigAlign = safe($_POST['sigalign']);
				$subSig = safe($_POST['signature']);
				$nShowEffects = $_POST['showeffects'];
				$nShowSignatures = $_POST['showsignatures'];
				$checkSubmit = 1;
				$currentColor = $safeColor;
			} else {
				$safeSize = $fontsize;
				$safeStyle = $fontstyle;
				$safeColor = substr($fontcolor, 1, 6);
				$safeType = $fonttype;
				$safeFontAlign = $fontalign;
				$safeSigAlign = $sigalign;
				$subSig = $loginoutput['signature'];
				$nShowEffects = $hidefont;
				$nShowSignatures = $hidesig;
				$currentColor = substr($fontcolor, 1,6);
			}
				if(strlen($subSig)>0) {
					$safeSig = substr($subSig, 0, 60);
				} else {
					$dontShow = 1;
				}
				if(in_array($safeSize, $arrSize)) {
					$showSize = $safeSize;
				} else {
					$showSize = "11";
				}
				if(in_array($safeStyle, $arrStyle)) {
					$showStyle = $safeStyle;
				} else {
					$showStyle = "normal";
				}
				if(strlen($safeColor) == 6) {
					$showColor = "#".$safeColor;
				} else {
					$showColor = "#2c2b2b";
				}
				if(in_array($safeType, $arrType)) {
					$showType = $safeType;
				} else {
					$showType = "Tahoma";
				}
				if(in_array($safeFontAlign, $arrAlign)) {
					$showFontAlign = $safeFontAlign;
				} else {
					$showFontAlign = "Left";
				}
				if(in_array($safeSigAlign, $arrAlign)) {
					$showSigAlign = $safeSigAlign;
				} else {
					$showSigAlign = "Left";
				}
				
				if($nShowEffects == 1) {
					$checkFont = "checked";
				}
				if($nShowSignatures == 1) {
					$checkSig = "checked";
				}
				if(empty($showSize)) {
					$showSize = "11";
				}
				if(empty($showStyle)) {
					$showStyle = "normal";
				}
				if(empty($showColor)) {
					$showColor = "#2c2b2b";
				}
				if(empty($showType)) {
					$showType = "Tahoma";
				}
				if(empty($showFontAlign)) {
					$showFontAlign = "Left";
				}
				if(empty($showSigAlign)) {
					$showSigAlign = "Left";
				}
				if(isset($safeSig)) {
					$signature = $safeSig;
					$showIt = 1;
				} elseif($loginoutput['signature'] != "" && $dontShow != 1) {
					$signature = $loginoutput['signature'];
					$showIt = 1;
				}
			

			echo "
					<form name='submit' method='post' action='?p=community&do=preferences'>
					
					<div style='margin-bottom:5px;margin-top:20px;width:100%;font-family: Times New Roman, arial, serif;font-size:25px;color:#000;font-style:italic;'>
							<center>Forum settings</center>
						</div>
						<div id='italicblack' style='padding:20px;margin:0px auto;width:510px;background:url(images/settingsbg2.png) repeat-y;'>
						<div style='width:480px;margin:0px auto;font-size:12px;color:#383634;'>
							Here you can change the visibility of fonts and signatures on the forums.<br>
						If you wish to disable these effects, please check the fields below.
							</div>
							<table align='center' id='italicblack' style='margin-top:10px;'>
									<tr>
										<td width='150' style='text-align:right;'>
										<b>Hide font effects:</b></td>
										<td width='5'></td>
										<td width='150'>
										<input type='checkbox' name='showeffects' value='1' ".$checkFont."> <font style='font-size:11px;'></font>
										</td>
									</tr>
									<tr style='height:8px;'>
									</tr>
									<tr>
										<td width='150' style='text-align:right;'>
										<b>Hide signatures:</b></td>
										<td width='5'></td>
										<td width='150'>
										<input type='checkbox' name='showsignatures' value='1' ".$checkSig."> <font style='font-size:11px;'></font>
										</td>
									</tr>
								</table>
						</div>
						
						<div style='height:20px;'>
						</div>
						
					
						<div style='margin-bottom:5px;width:100%;font-family: Times New Roman, arial, serif;font-size:25px;color:#000;font-style:italic;'>
							<center>Font settings</center>
						</div>
						<div id='italicblack' style='padding:20px;margin:0px auto;width:510px;background:url(images/settingsbg2.png) repeat-y;'>
								<table align='center' id='italicblack' style='margin-bottom:10px;'>
									<tr>
										<td width='150' style='text-align:right;'>
										<b>Font Size:</b></td>
										<td width='5'></td>
										<td>
										<select name='size' id='registerinput' style='width:90px;margin-top:-3px;'>
											<option value=''>Basic</option>";
											foreach($arrSize as $size) {
											if($showSize == $size) {
												$selected = "selected";
											} elseif($checkSubmit != 1 && $fontsize == $size) {
												$selected = "selected";
											}
												echo "
												<option value='".$size."' ".$selected.">".$size." pixels</option>";
												$selected = "";
											}
											echo "
										</select>
										</td>
									</tr>
									<tr style='height:8px;'>
									</tr>
									<tr>
										<td width='150' style='text-align:right;'>
										<b>Font Style:</b></td>
										<td width='5'></td>
										<td>
										<select name='style' id='registerinput' style='width:90px;margin-top:-3px;'>
											<option value='Basic'>Basic</option>";
											foreach($arrStyle as $style) {
											if($showStyle == $style) {
												$selected = "selected";
											} elseif($checkSubmit != 1 && $fontstyle == $style) {
												$selected = "selected";
											}
												echo "
												<option value='".$style."' ".$selected.">".$style."</option>";
												$selected = "";
											}
											echo "
										</select>
										</td>
									</tr>
									<tr style='height:8px;'>
									</tr>
									<tr>
										<td width='150' style='text-align:right;'>
										<b>Font Color:</b></td>
										<td width='5'></td>
										<td>
										<input type='text' name='color' class='color' value='".$currentColor."' style='width:85px;margin-top:-3px;'>
										</td>
									</tr>
									<tr style='height:8px;'>
									</tr>
									<tr>
										<td width='150' style='text-align:right;'>
										<b>Font Type:</b></td>
										<td width='5'></td>
										<td>
										<select name='type' id='registerinput' style='width:150px;margin-top:-3px;'>
											<option value='Basic'>Basic</option>";
											foreach($arrType as $type) {
											if($showType == $type) {
												$selected = "selected";
											} elseif($checkSubmit != 1 && $fonttype == $type) {
												$selected = "selected";
											}
												echo "
												<option value='".$type."' ".$selected.">".$type."</option>";
												$selected = "";
											}
											echo "
										</select>
										</td>
									</tr>
									<tr style='height:8px;'>
									</tr>
									<tr>
										<td width='150' style='text-align:right;'>
										<b>Font Align:</b></td>
										<td width='5'></td>
										<td>
										<select name='fontalign' id='registerinput' style='width:150px;margin-top:-3px;'>
											<option value='Basic'>Basic</option>";
											foreach($arrAlign as $dfontAlign) {
											if($showFontAlign == $dfontAlign) {
												$selected = "selected";
											} elseif($checkSubmit != 1 && $fontalign == $dfontAlign) {
												$selected = "selected";
											}
												echo "
												<option value='".$dfontAlign."' ".$selected.">".$dfontAlign."</option>";
												$selected = "";
											}
											echo "
										</select>
										</td>
									</tr>
									<tr style='height:8px;'>
									</tr>
									<tr>
										<td width='150' style='text-align:right;'>
										<b>Signature Align:</b></td>
										<td width='5'></td>
										<td>
										<select name='sigalign' id='registerinput' style='width:150px;margin-top:-3px;'>
											<option value='Basic'>Basic</option>";
											foreach($arrAlign as $dsigAlign) {
											if($showSigAlign == $dsigAlign) {
												$selected = "selected";
											} elseif($checkSubmit != 1 && $sigalign == $dsigAlign) {
												$selected = "selected";
											}
												echo "
												<option value='".$dsigAlign."' ".$selected.">".$dsigAlign."</option>";
												$selected = "";
											}
											echo "
										</select>
										</td>
									</tr>
								</table>
								<div style='text-align:center;margin-top:10px;'>
								<b><font style='font-size:14px;'>Signature</font>:</b><br>
								<input type='text' name='signature' id='topicinput' value='".$signature."' style='height:22px;width:280px;margin-top:0px;margin-bottom:10px;'>
								</div>
							<div style='width:480px;margin:0px auto;font-size:11px;color:#383634;'>
							Below is the preview of how your font is going to look like. Remember to click the save settings button, for the preferences to change permanently.
							</div>
							<div style='height:10px;'></div>
							<div style='margin:0px auto;width:516px;height:216px;background:url(images/previewfont.png) 0 0 no-repeat;'>
								<div style='width:480px;margin:0px auto;'>
								<div style='margin-bottom:10px;'>
									<div style='text-align:center;padding-top:5px;font-family:Times New Roman, Georgia, serif;font-size:18px;color:#FFF;text-style:italic;'>
									Preview your font!
									</div>
								</div>
								<div style='padding:5px;width:480px;min-height:150px;height:auto;background:url(images/previewtopic.png) 0 0 no-repeat;'>
									<div style='font-size:11px;float:left;width:98px;height:150px;'>
										<div style='width:98px;text-align:center;margin-top:5px;margin-bottom:5px;'>
										<a href='?p=user&id=".$login."' style='text-decoration:none;'>".$loginoutput['username']."</a>
										</div>
										<div style='width:50px;margin:0px auto;'>
											<img src='images/avatars/".$loginoutput['avatar']."'>
										</div>
										
										<div style='color:#2c2b2b;width:98px;text-align:center;margin-top:7px;margin-bottom:1px;'>
										".$showRank."
										</div>
										
										<div style='color:#2c2b2b;width:98px;text-align:center;margin-bottom:1px;'>
										".$showPosts." ".$showPostText."
										</div>
										
										<div style='color:".$colour.";width:98px;text-align:center;margin-bottom:5px;'>
										".$showUser['sex']."
										</div>
									</div>
									<div id='italicblack' style='color:#2c2b2b;padding:5px 10px 5px 10px;font-size:11px;float:left;margin-left:8px;width:348px;height:auto;'>
										<div style='text-align:center;width:45px;font-size:19px;z-index:10;position:absolute;margin-left:315px;margin-top:-9px;'>
										#1
										</div>
										<font style='color:#383634;'>Posted on: <b>".$date."</b></font><br>
										<div style='padding-top:3px;width:100%;text-align:".$showFontAlign."'>
										<p style='font-family:".$showType.",serif;font-size:".$showSize."px;font-style:".$showStyle.";color:".$showColor.";'>This is how your text will look like!</p>
										</div>";
										if($showIt == 1) {
										echo "
										<div style='padding-top:-3px;width:100%;text-align:".$showSigAlign."'>
										<hr style='width:100%;color:#767373;height:1px;margin-bottom:-2px;'>
										<p style='font-family:".$showType.",serif;font-size:".$showSize."px;font-style:".$showStyle.";color:".$showColor.";'>".$signature."</p>
										</div>";
										}
										echo "
									</div>
									<div style='clear:both;'></div>
								</div>
								<div style='width:480px;margin-top:-45px;height:48px;background:url(images/topicfooter.png) 0 0 no-repeat;'>
								</div>
							</div>
						</div>
						
						</div>
						
						
						
						<div style='padding:20px;'>
							<center><input type='submit' name='submit' class='savesettings' onClick='return confirmPost(\"Are you sure you wish to change these settings? You might wanna preview your font first.\")' value='&nbsp;' size='10'> <input type='submit' name='submit2' class='preview' value='&nbsp;' size='10'></center>
						</div>
					</form>";
		}
		break;
		
		case 'rules':
		break;
		
		case 'friends':
		break;
		}
		
	} else {
		$message = "You have to be logged in to view this page!<br><br><i>Errorcode: q001</i>";
		include("pages/error.php");
	}
?>