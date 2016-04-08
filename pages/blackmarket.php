<?php
if($login) {
	if($lvl >= 3) {
	echo "
	<div style='margin:0px auto;width:800px;'>
		<div style='width:24px;height:24px;float:left;background:url(images/icons/market2.png) 0 0 no-repeat;margin-left:20px;margin-top:3px;margin-bottom:25px;'></div>
			<div id='italicheadersmall' style='padding-left:10px;margin-bottom:5px;float:left;'>
			Black Market
			</div>
		<div style='float:'right;'></div>
			<div id='normalblack2' style='padding-left:10px;margin-top:5px;margin-right:45px;float:right;'>
			<a href='?p=blackmarket&do=trades'>Your trades</a> | <a href='?p=blackmarket&do=create'>Create new trade</a> | <a href='?p=blackmarket&do=market'>Search the Market</a> | <a href='?p=blackmarket&do=offers'>Your offers</a>
			</div>
		<div style='clear:both;'></div>
	</div>";
		switch($_GET['do']) {
		default:
			if($loginoutput['mafia'] == "chinese") {
				$sentence = "One of you Chinese men.. What can i do for you monsieur?";
			} elseif($loginoutput['mafia'] == "italian") {
				$sentence = "Another Italian.. What can i do for you monsieur?";
			} elseif($loginoutput['mafia'] == "russian") {
				$sentence = "A Russian! Oh my.. What can i do for you monsieur?";
			}
			echo "
			<div style='margin:0px auto;width:800px;'>
				<div style='margin:0px auto;width:300px;padding-top:170px;' id='italicblack'>
					<center><b>Perri the Frenchman says: 'Ahh, Oui.. ".$sentence."'</b></center>
				</div>
				<div id='pagespacer' style='margin:0px auto;width:300px;'>
				</div>
			</div>";
		break;
		
		case 'trades':
			$get_trades = mysql_query("SELECT * FROM `market` WHERE user_id='".$login."' AND type='trade' ORDER BY `id` DESC") or die(mysql_error());
			if(mysql_num_rows($get_trades) > 0) {
				while($show_trades = mysql_fetch_array($get_trades)) {
					$get_offer = mysql_query("SELECT * FROM `market_offers` WHERE id='".$show_trades['trade_id']."' AND type='offer'") or die(mysql_error());
					$show_offer = mysql_num_rows($get_offer);
					
					echo "
					<div style='margin:0px auto;width:400px;font-family:Georgia, arial, serif;font-size:13px;font-style:italic;color:#444343;'>
							<div style='float:left;'>
								Trade id: <b>".$show_trades['trade_id']."</b>
							</div>
							<div style='float:right;text-align:right;'>
								Created: ".$show_trades['time']."
							</div>
							<div style='clear:both;'></div>
						</div>
						<div style='margin:0px auto;width:400px;background:url(images/tradebg.png) repeat-y;border:5px solid #cbc7c6;margin-top:2px;'>
					";
						$get_trade_info = mysql_query("SELECT * from `market_offers` WHERE id = '".$show_trades['trade_id']."' AND type='trade'") or die(mysql_error());
						$show_trade_info = mysql_fetch_array($get_trade_info);
						for($i=1;$i<$show_trade_info['item_num']+1;$i++) {
						$showitem = getItem($show_trade_info["item_".$i]);
						echo "
							<div style='float:left;margin:10px 5px 3px 10px;'>
							<img src='images/items/".$showitem['image']."' width='60' height='60' style='margin-top:2px;border:1px solid #b4b0b0;'>
							</div>
							<div style='float:left;margin:18px 10px 3px 0px;'>
							<b>".$showitem['name']."</b><br>
							Rarity: ".$showitem['rarity']."<br>
							Type: ".$showitem['type']."
							</div>
							<div style='clear:both;'>
							</div>
						";
						}
						
					echo "
					<div style='margin-left:10px;margin-top:8px;'>
						<b>Wishlist:</b> ".$show_trades['text']."<br>
						<b>Trade link:</b><br>
						<a href='?p=blackmarket&do=market&s=search&value=".$show_trades['trade_id']."'>www.mafianations.com/?p=blackmarket&do=market&search=id&value=".$show_trades['trade_id']."</a>
					</div>";
					if($show_offer == 1) {
						echo "
						<div style='margin-top:4px;margin-bottom:7px;'><center>(<a href='?p=blackmarket&do=showoffer&id=".$show_trades['trade_id']."'>There is 1 offer on this trade!</a>)</center></div>";
					} elseif($show_offer > 0) {
						echo "
						<div style='margin-top:4px;margin-bottom:7px;'><center>(<a href='?p=blackmarket&do=showoffer&id=".$show_trades['trade_id']."'>There are ".$show_offer." offers on this trade!</a>)</center></div>";
					} else {
						echo "
						<div style='margin-top:4px;margin-bottom:7px;'><center>(There are no offers on this trade.)</center></div>";
					}
					echo "
					</div>
					<div style='margin:0px auto;width:400px;text-align:right;font-family:Georgia, arial, serif;font-size:13px;font-style:italic;color:#444343;'>
					<form action='?p=blackmarket&do=remove&id=".$show_trades['trade_id']."' method='post'>
					<input type='submit' name='submit' value='&nbsp;' onClick='return confirmPost(\"Are you sure you wish to remove this trade?\")' class='removetrade' style='margin-top:4px;' size='10'> 
					</form>
					</div>
					<div style='height:40px;'></div>";
				}
			} else {
				echo "<meta http-equiv='refresh' content='0;URL=?p=blackmarket'>";
			}
			
		break;
		
		case 'remove':
			if(isset($_GET['id'])) {
				if(isNumber($_GET['id'])) {
					$checkOwner = mysql_query("SELECT * FROM `market` WHERE trade_id = '".isNumber($_GET['id'])."' AND user_id = '".$login."'") or die(mysql_error());
					$isOwner = mysql_num_rows($checkOwner);
					if($isOwner > 0) {
						$checkOffers = mysql_query("SELECT * FROM `market_offers` WHERE id = '".isNumber($_GET['id'])."'") or die(mysql_error());
						while($showOffers = mysql_fetch_array($checkOffers)) {
						for($i=1;$i<$showOffers['item_num']+1;$i++) {
							$showitem = getItem($showOffers["item_".$i]);
							inputItem($showOffers["item_".$i], $showOffers['user_id']);
						}
							if($showOffers['mc'] > 0) {
								setStat('mc',$showOffers['user_id'],getStat('mc',$showOffers['user_id']) + $showOffers['mc']);
							}
						}
						mysql_query("DELETE FROM `market_offers` WHERE id = '".isNumber($_GET['id'])."'") or die(mysql_error());
						mysql_query("DELETE FROM `market` WHERE trade_id = '".isNumber($_GET['id'])."' AND user_id ='".$login."'") or die(mysql_error());
						$image = "loginimage.png";
						$header = "Please wait";
						$message = "Removing the trade and returning items to your inventory<br><br>
						Please wait..
						<meta http-equiv='refresh' content='2;URL=?p=blackmarket&do=trades'>";
						include("pages/error.php");
					} else {
						$message = "You can't remove this trade!<br><br><i>Errorcode: bm007</i>";
						include("pages/error.php");
					}
				} else {
					$message = "You can't remove this trade!<br><br><i>Errorcode: bm006</i>";
					include("pages/error.php");
				}
			} else {
				$message = "You can't remove this trade!<br><br><i>Errorcode: bm005</i>";
				include("pages/error.php");
			}
		break;
		
		case 'create';
			if($_POST['submit']) {
				$get_offer = mysql_query("SELECT * FROM `market` WHERE user_id='".$login."' AND type='trade'") or die(mysql_error());
				$show_offer = mysql_num_rows($get_offer);
				$item = $_POST['item'];
					if(!empty($_POST['item'])) {
						if(count($_POST['item']) > 10) {
							$message = "You cannot choose more than 10 items per trade.<br><br><i>Errorcode: bm003</i>";
							include("pages/error.php");
						} else {
							if($show_offer > 4) {
								$message = "You can only have a maximum of 5 trades open at a time.<br><br><i>Errorcode: bm004</i>";
								include("pages/error.php");
							} else {
								foreach ($_POST['item'] as $del) {
								mysql_query("DELETE FROM `user_inventory` WHERE item_id='".$del."' AND user_id='".$login."' LIMIT 1") or die(mysql_error());
								}
								$items = implode(",", $_POST['item']);
								$time = date("Y/m/d H:i:s");
								$text = safe($_POST['text']);
								$checkLatest = mysql_query("SELECT * FROM `market` ORDER BY `trade_id` DESC") or die(mysql_error());
								$showLatest = mysql_fetch_array($checkLatest);
								$newId = $showLatest['trade_id']+1;
								
								mysql_query("INSERT INTO `market` (user_id, trade_id, time, type, text) VALUES ('".$login."', '".$newId."', '".$time."', 'trade', '".$text."')")or die(mysql_error());
								mysql_query("INSERT INTO `market_offers` (id, user_id, item_num, type) VALUES ('".$newId."', '".$login."', '".count($_POST['item'])."', 'trade')") or die(mysql_error());
								$is = 1;
								foreach($_POST['item'] as $update) {
									$setItem = "item_".$is;
									mysql_query("UPDATE `market_offers` SET ".$setItem."='".$update."' WHERE id = '".$newId."'") or die(mysql_error());
									$is++;
								}
								
								$image = "loginimage.png";
								$header = "Creating trade";
								$message = "
								Creating your trade.<br><br>
								Please wait.<meta http-equiv='refresh' content='1;URL=?p=blackmarket&do=trades'>";
								include("pages/error.php");
							}
						}
					} else {
						$message = "You have to choose some items to trade.<br><br><i>Errorcode: bm002</i>";
						include("pages/error.php");
					}
			} else {
				$querynum = mysql_query("SELECT * FROM `user_inventory` WHERE user_id = '".$login."' ORDER BY `id` DESC") or die(mysql_error());
				$inventorynum = mysql_num_rows($querynum);
				echo "
				<form action='?p=blackmarket&do=create' method='post'>
				<div style='margin:0px auto;width:400px;font-family:Georgia, arial, serif;font-size:13px;font-style:italic;color:#444343;'>
					<div style='float:left;'>
						Showing <b>".$inventorynum."</b> items from your inventory.
					</div>
					<div style='float:right;text-align:right;'>
					</div>
					<div style='clear:both;'></div>
				</div>
				<div style='margin:0px auto;width:400px;background:url(images/tradebg.png) repeat-y;border:5px solid #cbc7c6;margin-top:2px;'>";
				
				if($inventorynum < 1) {
					echo "You don't have any items to trade at the moment";
				}
				while ($queryexe = mysql_fetch_array($querynum)) {
					$inventoryquery = mysql_query("SELECT * FROM `items` WHERE id = '".$queryexe['item_id']."'") or die(mysql_error());
					$show = mysql_fetch_array($inventoryquery);
					echo "
					<div style='float:left;margin:10px 5px 3px 10px;'>
					<img src='images/items/".$show['image']."' width='60' height='60' style='margin-top:2px;border:1px solid #b4b0b0;'>
					</div>
					<div style='float:left;margin:18px 10px 5px 0px;'>
					<b>".$show['name']."</b><br>
					Rarity: ".$show['rarity']."<br>
					Type: ".$show['type']."
					</div>
					<div style='float:right;margin-top:35px;margin-right:30px;'>
						<input type='checkbox' name='item[]' value='".$show['id']."'>
					</div>
					<div style='clear:both;'>
					</div>
					<div id='pagespacer' style='width:380px;margin:10px 0px 3px 10px;'>
					</div>";
					}
					echo "
						<div id='italicblack' style='width:100%;margin-top:10px;'>
						<center>In the section below, you can write a wishlist to your trade.</center>
						</div>
						<div style='margin-bottom:10px;margin-top:5px;'>
						<center><textarea rows='9' cols='30' name='text' id='markettext'></textarea></center>
						</div>
					</div>
					<div style='margin:0px auto;width:400px;'>
						<center>
						<input type='submit' name='submit' value='&nbsp;' onClick='return confirmPost(\"Are you sure you wish to create this trade?\")' class='createtrade' size='10'> 
						<input type='reset' name='reset' value='&nbsp;'  class='reset' size='10'>
						</center>
					</div>
				<div style='height:20px;'></div>
				</form>";
			}
		break;

		case 'market':
			if(isset($_GET['value'])) {
				if(isset($_GET['t'])) {
					$select2 = "selected";
					$value = safe($_GET['value']);
				} else {
					$value = isNumber($_GET['value']);
					$select = "selected";
				}
			}
			echo "
				<div style='margin:0px auto;width:400px;font-family:Georgia, arial, serif;font-size:13px;font-style:italic;color:#444343;'>
					<div>
						Search the entire market from here.
					</div>
				</div>
				<div style='margin:0px auto;margin-bottom:10px;width:400px;background:url(images/tradebg.png) repeat-y;border:5px solid #cbc7c6;margin-top:2px;height:auto;'>
					<div style='width:100%;text-align:center;margin-bottom:8px;'>
					<form action='?p=blackmarket&do=market&s=search' method='post'>
						<table align='center'>
							<tr>
								<td width='100' style='text-align:right;'>
								<select name='action' id='searchinput' style='width:140px;'>
									<option value='1'>Containing phrase</option>
									<option value='2'>Identical phrase</option>
									<option ".$select." value='3'>Trade id</option>
									<option ".$select2." value='4'>Username</option>
								</select> 
								</td>
								<td width='100'>
									<input type='text' id='searchinput' style='height:20px;width:140px;' name='input' value='".$value."'>
								</td>
							</tr>
							<tr>
								<td width='100' style='text-align:left;'>
								Order search by:
								</td>
								<td width='100'>
								Newest:<input type='radio' name='order' value='newest' checked> Oldest:<input type='radio' name='order' value='oldest'>
								</td>
							</tr>
							<tr>
								<td width='100' style='text-align:right;'>
								<input type='submit' name='submit' value='&nbsp;' onClick='return confirmPost(\"Confirm search!\")' class='searchtrade' size='10'> 
								</td>
								<td width='100' style='text-align:left;'>
								<input type='reset' name='reset' value='&nbsp;'  class='reset' style='margin:0px;' size='10'>
								</td>
							</tr>
						</table>
					</form>
					</div>
				</div>
				
				";
				if($_POST['submit']) {
					if($_GET['s'] == "search") { 
						if($_POST['input'] == "") {

						} else {
							if($_POST['order'] == "oldest") {
								$setOrder = "ASC";
							} else {
								$setOrder = "DESC";
							}
							$setSearch = safe($_POST['input']);
							switch ($_POST['action']) {
							case '1':
								$getName = mysql_query("SELECT * FROM `items` WHERE name like '%".$setSearch."%'") or die(mysql_error());
								$getNum = mysql_num_rows($getName);
								if($getNum > 0) {
									$showName = mysql_fetch_array($getName);
									$showTrade = mysql_query("SELECT * FROM `market_offers` WHERE item_1 = '".$showName['id']."' OR item_2 = '".$showName['id']."' OR item_3 = '".$showName['id']."'
									OR item_4 = '".$showName['id']."' OR item_5 = '".$showName['id']."' OR item_6 = '".$showName['id']."' OR item_7 = '".$showName['id']."' OR item_8 = '".$showName['id']."'
									OR item_9 = '".$showName['id']."' OR item_10 = '".$showName['id']."' ORDER BY id ".$setOrder."") or die(mysql_error());
									$showTrade_num = mysql_num_rows($showTrade);
									if($showTrade_num > 0) {
										while($getTrade = mysql_fetch_array($showTrade)) {
										$getName2 = mysql_query("SELECT * FROM `market` WHERE trade_id = '".$getTrade['id']."'") or die(mysql_error());
										$showName2 = mysql_fetch_array($getName2);
											echo "
											<div style='margin:0px auto;width:400px;font-family:Georgia, arial, serif;font-size:13px;font-style:italic;color:#444343;'>
													<div style='float:left;'>
														Trade id: <b>".$getTrade['id']."</b>
													</div>
													<div style='float:right;text-align:right;'>
														Created: ".$showName2['time']."
													</div>
													<div style='clear:both;'></div>
												</div>
												<div style='margin:0px auto;width:400px;background:url(images/tradebg.png) repeat-y;border:5px solid #cbc7c6;margin-top:2px;'>
											";
												for($i=1;$i<$getTrade['item_num']+1;$i++) {
												$showitem = getItem($getTrade["item_".$i]);
												echo "
													<div style='float:left;margin:10px 5px 3px 10px;'>
													<img src='images/items/".$showitem['image']."' width='60' height='60' style='margin-top:2px;border:1px solid #b4b0b0;'>
													</div>
													<div style='float:left;margin:18px 10px 3px 0px;'>
													<b>".$showitem['name']."</b><br>
													Rarity: ".$showitem['rarity']."<br>
													Type: ".$showitem['type']."
													</div>
													<div style='clear:both;'>
													</div>
												";
												}
											$getNamez = mysql_query("SELECT * FROM `users` WHERE  id = '".$getTrade['user_id']."'") or die(mysql_error());
											$theNamez = mysql_fetch_array($getNamez);
											echo "
											<div style='margin-left:10px;margin-top:8px;'>
												<b>Owner:</b> <a href='?p=user&id=".$theNamez['id']."'>".$theNamez['username']."</a><br>
												<b>Wishlist:</b> ".$showName2['text']."<br>
												<b>Trade link:</b><br>
												<a href='?p=blackmarket&do=market&s=search&value=".$getTrade['id']."'>www.mafianations.com/?p=blackmarket&do=market&search=id&value=".$getTrade['id']."</a>
											</div>
											</div>
											<div style='margin:0px auto;width:400px;text-align:center;font-family:Georgia, arial, serif;font-size:13px;font-style:italic;color:#444343;'>
											<form action='?p=blackmarket&do=offer&id=".$getTrade['id']."' method='post'>
											<input type='submit' name='submit' value='&nbsp;' onClick='return confirmPost(\"You are about to offer on trade lot: ".$getTrade['id']."\")' class='offertrade' style='margin-top:4px;' size='10'> 
											</form>
											</div>
											<div style='height:20px;'></div>";
										}
									} else {
										echo "
										
										<center>The item you search for: <b>".$showName['name']."</b><br>Is no where to be found.</center>";
									}
								} else {
									echo "
									<center>That item doesn't exist!</center>";
								}
							break;
							
							case '2':
								$getName = mysql_query("SELECT * FROM `items` WHERE name = '".$setSearch."'") or die(mysql_error());
								$getNum = mysql_num_rows($getName);
								if($getNum > 0) {
									$showName = mysql_fetch_array($getName);
									$showTrade = mysql_query("SELECT * FROM `market_offers` WHERE type='trade' AND item_1 = '".$showName['id']."' OR item_2 = '".$showName['id']."' OR item_3 = '".$showName['id']."'
									OR item_4 = '".$showName['id']."' OR item_5 = '".$showName['id']."' OR item_6 = '".$showName['id']."' OR item_7 = '".$showName['id']."' OR item_8 = '".$showName['id']."'
									OR item_9 = '".$showName['id']."' OR item_10 = '".$showName['id']."' ORDER BY id ".$setOrder."") or die(mysql_error());
									$showTrade_num = mysql_num_rows($showTrade);
									if($showTrade_num > 0) {
										while($getTrade = mysql_fetch_array($showTrade)) {
										$getName2 = mysql_query("SELECT * FROM `market` WHERE trade_id = '".$getTrade['id']."'") or die(mysql_error());
										$showName2 = mysql_fetch_array($getName2);
											echo "
											<div style='margin:0px auto;width:400px;font-family:Georgia, arial, serif;font-size:13px;font-style:italic;color:#444343;'>
													<div style='float:left;'>
														Trade id: <b>".$getTrade['id']."</b>
													</div>
													<div style='float:right;text-align:right;'>
														Created: ".$showName2['time']."
													</div>
													<div style='clear:both;'></div>
												</div>
												<div style='margin:0px auto;width:400px;background:url(images/tradebg.png) repeat-y;border:5px solid #cbc7c6;margin-top:2px;'>
											";
												for($i=1;$i<$getTrade['item_num']+1;$i++) {
												$showitem = getItem($getTrade["item_".$i]);
												echo "
													<div style='float:left;margin:10px 5px 3px 10px;'>
													<img src='images/items/".$showitem['image']."' width='60' height='60' style='margin-top:2px;border:1px solid #b4b0b0;'>
													</div>
													<div style='float:left;margin:18px 10px 3px 0px;'>
													<b>".$showitem['name']."</b><br>
													Rarity: ".$showitem['rarity']."<br>
													Type: ".$showitem['type']."
													</div>
													<div style='clear:both;'>
													</div>
												";
												}
											$getNamez = mysql_query("SELECT * FROM `users` WHERE  id = '".$getTrade['user_id']."'") or die(mysql_error());
											$theNamez = mysql_fetch_array($getNamez);
											echo "
											<div style='margin-left:10px;margin-top:8px;'>
												<b>Owner:</b> <a href='?p=user&id=".$theNamez['id']."'>".$theNamez['username']."</a><br>
												<b>Wishlist:</b> ".$showName2['text']."<br>
												<b>Trade link:</b><br>
												<a href='?p=blackmarket&do=market&s=search&value=".$getTrade['id']."'>www.mafianations.com/?p=blackmarket&do=market&search=id&value=".$getTrade['id']."</a>
											</div>
											</div>
											<div style='margin:0px auto;width:400px;text-align:center;font-family:Georgia, arial, serif;font-size:13px;font-style:italic;color:#444343;'>
											<form action='?p=blackmarket&do=offer&id=".$getTrade['id']."' method='post'>
											<input type='submit' name='submit' value='&nbsp;' onClick='return confirmPost(\"You are about to offer on trade lot: ".$getTrade['id']."\")' class='offertrade' style='margin-top:4px;' size='10'> 
											</form>
											</div>
											<div style='height:20px;'></div>";
										}
									} else {
										echo "
										
										<center>The item you search for: <b>".$showName['name']."</b><br>Is no where to be found.</center>";
									}
								} else {
									echo "
									<center>That item doesn't exist!</center>";
								}
								
							break;
							
							case '3':
								$getName = mysql_query("SELECT * FROM `market` WHERE trade_id = '".$setSearch."'") or die(mysql_error());
								$getNum = mysql_num_rows($getName);
								if($getNum > 0) {
									$showName = mysql_fetch_array($getName);
									$showTrade = mysql_query("SELECT * FROM `market_offers` WHERE type='trade' AND id='".$setSearch."'") or die(mysql_error());
									$showTrade_num = mysql_num_rows($showTrade);
									if($showTrade_num > 0) {
										while($getTrade = mysql_fetch_array($showTrade)) {
											
											echo "
											<div style='margin:0px auto;width:400px;font-family:Georgia, arial, serif;font-size:13px;font-style:italic;color:#444343;'>
													<div style='float:left;'>
														Trade id: <b>".$getTrade['id']."</b>
													</div>
													<div style='float:right;text-align:right;'>
														Created: ".$showName['time']."
													</div>
													<div style='clear:both;'></div>
												</div>
												<div style='margin:0px auto;width:400px;background:url(images/tradebg.png) repeat-y;border:5px solid #cbc7c6;margin-top:2px;'>
											";
												for($i=1;$i<$getTrade['item_num']+1;$i++) {
												$showitem = getItem($getTrade["item_".$i]);
												echo "
													<div style='float:left;margin:10px 5px 3px 10px;'>
													<img src='images/items/".$showitem['image']."' width='60' height='60' style='margin-top:2px;border:1px solid #b4b0b0;'>
													</div>
													<div style='float:left;margin:18px 10px 3px 0px;'>
													<b>".$showitem['name']."</b><br>
													Rarity: ".$showitem['rarity']."<br>
													Type: ".$showitem['type']."
													</div>
													<div style='clear:both;'>
													</div>
												";
												}
											$getNamez = mysql_query("SELECT * FROM `users` WHERE  id = '".$getTrade['user_id']."'") or die(mysql_error());
											$theNamez = mysql_fetch_array($getNamez);
											echo "
											<div style='margin-left:10px;margin-top:8px;'>
												<b>Owner:</b> <a href='?p=user&id=".$theNamez['id']."'>".$theNamez['username']."</a><br>
												<b>Wishlist:</b> ".$showName['text']."<br>
												<b>Trade link:</b><br>
												<a href='?p=blackmarket&do=market&s=search&value=".$getTrade['id']."'>www.mafianations.com/?p=blackmarket&do=market&search=id&value=".$getTrade['id']."</a>
											</div>
											</div>
											<div style='margin:0px auto;width:400px;text-align:center;font-family:Georgia, arial, serif;font-size:13px;font-style:italic;color:#444343;'>
											<form action='?p=blackmarket&do=offer&id=".$getTrade['id']."' method='post'>
											<input type='submit' name='submit' value='&nbsp;' onClick='return confirmPost(\"You are about to offer on trade lot: ".$getTrade['id']."\")' class='offertrade' style='margin-top:4px;' size='10'> 
											</form>
											</div>
											<div style='height:20px;'></div>";
										}
									} else {
										echo "
										
										<center>There is no trade with that id!</center>";
									}
								} else {
									echo "
									<center>There is no trade with that id!</center>";
								}
							break;
							
							case '4':
								$getName = mysql_query("SELECT * FROM `users` WHERE  username = '".$setSearch."'") or die(mysql_error());
								$countName = mysql_num_rows($getName);
								if($countName > 0) {
									$theName = mysql_fetch_array($getName);
									$getName = mysql_query("SELECT * FROM `market` WHERE user_id = '".$theName['id']."'") or die(mysql_error());
									$getNum = mysql_num_rows($getName);
									if($getNum > 0) {
										$showName = mysql_fetch_array($getName);
										$showTrade = mysql_query("SELECT * FROM `market_offers` WHERE type='trade' AND user_id = '".$theName['id']."' ORDER BY id ".$setOrder."") or die(mysql_error());
										$showTrade_num = mysql_num_rows($showTrade);
										if($showTrade_num > 0) {
											while($getTrade = mysql_fetch_array($showTrade)) {
												echo "
											<div style='margin:0px auto;width:400px;font-family:Georgia, arial, serif;font-size:13px;font-style:italic;color:#444343;'>
													<div style='float:left;'>
														Trade id: <b>".$getTrade['id']."</b>
													</div>
													<div style='float:right;text-align:right;'>
														Created: ".$showName['time']."
													</div>
													<div style='clear:both;'></div>
												</div>
												<div style='margin:0px auto;width:400px;background:url(images/tradebg.png) repeat-y;border:5px solid #cbc7c6;margin-top:2px;'>
											";
												for($i=1;$i<$getTrade['item_num']+1;$i++) {
												$showitem = getItem($getTrade["item_".$i]);
												echo "
													<div style='float:left;margin:10px 5px 3px 10px;'>
													<img src='images/items/".$showitem['image']."' width='60' height='60' style='margin-top:2px;border:1px solid #b4b0b0;'>
													</div>
													<div style='float:left;margin:18px 10px 3px 0px;'>
													<b>".$showitem['name']."</b><br>
													Rarity: ".$showitem['rarity']."<br>
													Type: ".$showitem['type']."
													</div>
													<div style='clear:both;'>
													</div>
												";
												}
												
											echo "
											<div style='margin-left:10px;margin-top:8px;'>
												<b>Owner:</b> <a href='?p=user&id=".$theName['id']."'>".$theName['username']."</a><br>
												<b>Wishlist:</b> ".$showName['text']."<br>
												<b>Trade link:</b><br>
												<a href='?p=blackmarket&do=market&s=search&value=".$getTrade['id']."'>www.mafianations.com/?p=blackmarket&do=market&search=id&value=".$getTrade['id']."</a>
											</div>
											</div>
											<div style='margin:0px auto;width:400px;text-align:center;font-family:Georgia, arial, serif;font-size:13px;font-style:italic;color:#444343;'>
											<form action='?p=blackmarket&do=offer&id=".$getTrade['id']."' method='post'>
											<input type='submit' name='submit' value='&nbsp;' onClick='return confirmPost(\"You are about to offer on trade lot: ".$getTrade['id']."\")' class='offertrade' style='margin-top:4px;' size='10'> 
											</form>
											</div>
											<div style='height:20px;'></div>";
											}
										} else {
											echo "
											
											<center>This user doesn't have any trades!</center>";
										}
									} else {
										echo "
										<center>This user doesn't have any trades!</center>";
									}
								} else {
									echo "
									<center>That user doesn't exist!</center>";
								}
							break;
							}
							
						}
					} 
				}
		break;
		
		case 'offer';
			if(isset($_GET['id'])) {
			$checkLot = mysql_query("SELECT * FROM `market` WHERE trade_id = '".isNumber($_GET['id'])."'") or die(mysql_error());
			$numLot = mysql_num_rows($checkLot);
			if($numLot > 0) {
				$checkOffer = mysql_query("SELECT * FROM `market_offers` WHERE id = '".isNumber($_GET['id'])."' AND type='offer' AND user_id='".$login."'") or die(mysql_error());
				$doCheck = mysql_num_rows($checkOffer);
				if ($doCheck > 0) {
					$message = "You have allready offered on this lot<br>Please cancel your old offer, before offering a new one!<br><br><i>Errorcode: bm018</i>";
					include("pages/error.php");
				} else {
					$showLot = mysql_fetch_array($checkLot);
					if($showLot['user_id'] == $login) {
						$message = "You can't offer on your own Trade lots<br><br><i>Errorcode: bm013</i>";
						include("pages/error.php");
					} else {
						if($_POST['submit2']) {
							$item = $_POST['item'];
								if(!empty($_POST['item'])) {
									if(count($_POST['item']) > 10) {
										$message = "You cannot choose more than 10 items per trade.<br><br><i>Errorcode: bm003</i>";
										include("pages/error.php");
									} else {
										if(isNumber($_POST['coins'])>$mc) {
											$message = "You do not have enough Mafia Coins on hand to make that offer<br><br><i>Errorcode: bm016</i>";
											include("pages/error.php");
										} else {
											foreach ($_POST['item'] as $del) {
											mysql_query("DELETE FROM `user_inventory` WHERE item_id='".$del."' AND user_id='".$login."' LIMIT 1") or die(mysql_error());
											}
											$items = implode(",", $_POST['item']);
											setStat('mc',$login,getStat('mc',$login) - isNumber($_POST['coins']));
											mysql_query("INSERT INTO `market_offers` (id, user_id, item_num, type, mc) VALUES ('".$_GET['id']."', '".$login."', '".count($_POST['item'])."', 'offer', '".isNumber($_POST['coins'])."')") or die(mysql_error());
											$is = 1;
											foreach($_POST['item'] as $update) {
												$setItem = "item_".$is;
												mysql_query("UPDATE `market_offers` SET ".$setItem."='".$update."' WHERE id = '".$_GET['id']."' and user_id = '".$login."' and type='offer'") or die(mysql_error());
												$is++;
											}
											
											$image = "loginimage.png";
											$header = "Creating trade";
											$message = "
											Offer has been placed.<br><br>
											Please wait.<meta http-equiv='refresh' content='1;URL=?p=blackmarket&do=offers'>";
											include("pages/error.php");
										}
									}
								} else {
									$message = "You have to choose some items to trade.<br><br><i>Errorcode: bm002</i>";
									include("pages/error.php");
								}
						} else {
							$querynum = mysql_query("SELECT * FROM `user_inventory` WHERE user_id = '".$login."' ORDER BY `id` DESC") or die(mysql_error());
							$inventorynum = mysql_num_rows($querynum);
							echo "
							<form action='?p=blackmarket&do=offer&id=".isNumber($_GET['id'])."' method='post'>
							<div style='margin:0px auto;width:400px;font-family:Georgia, arial, serif;font-size:13px;font-style:italic;color:#444343;'>
								<div style='float:left;'>
									Making offer on lot: <b>".isNumber($_GET['id'])."</b><br>
									Showing <b>".$inventorynum."</b> items from your inventory.
								</div>
								<div style='float:right;text-align:right;'>
								</div>
								<div style='clear:both;'></div>
							</div>
							<div style='margin:0px auto;width:400px;background:url(images/tradebg.png) repeat-y;border:5px solid #cbc7c6;margin-top:2px;'>";
							
							if($inventorynum < 1) {
								echo "You don't have any items to trade at the moment";
							}
							while ($queryexe = mysql_fetch_array($querynum)) {
								$inventoryquery = mysql_query("SELECT * FROM `items` WHERE id = '".$queryexe['item_id']."'") or die(mysql_error());
								$show = mysql_fetch_array($inventoryquery);
								echo "
								<div style='float:left;margin:10px 5px 3px 10px;'>
								<img src='images/items/".$show['image']."' width='60' height='60' style='margin-top:2px;border:1px solid #b4b0b0;'>
								</div>
								<div style='float:left;margin:18px 10px 5px 0px;'>
								<b>".$show['name']."</b><br>
								Rarity: ".$show['rarity']."<br>
								Type: ".$show['type']."
								</div>
								<div style='float:right;margin-top:35px;margin-right:30px;'>
									<input type='checkbox' name='item[]' value='".$show['id']."'>
								</div>
								<div style='clear:both;'>
								</div>
								<div id='pagespacer' style='width:380px;margin:10px 0px 3px 10px;'>
								</div>
								";
								}
								echo "
								<div style='text-align:center;margin:10px 10px 10px 0px;'>
								Offer Mafia Coins: <input type='text' value='0' id='mailinput' name='coins' style='text-align:right;width:110px;'>
								</div>
								</div>
								<div style='margin:0px auto;width:400px;'>
									<center>
									<input type='submit' name='submit2' value='&nbsp;' onClick='return confirmPost(\"Confirm your offer!\")' class='makeoffer' size='10'> 
									</center>
								</div>
							<div style='height:20px;'></div>
							</form>";
						}
				}
				}
				} else {
					$message = "Invalid trade id<br><br><i>Errorcode: bm014</i>";
					include("pages/error.php");
				}
		} else {
			$message = "Invalid trade id<br><br><i>Errorcode: bm014</i>";
			include("pages/error.php");
		}
		break;
		
		case 'showoffer':
		if($_POST['submit']) {
			if(isNumber($_POST['trade_id']) != NULL && isNumber($_POST['offer_id']) != NULL) {
				$checkOwner = mysql_query("SELECT * FROM `market` where trade_id = '".isNumber($_POST['trade_id'])."'") or die(mysql_error());
				$doCheck = mysql_fetch_array($checkOwner);
				if($login == $doCheck['user_id']) {
				
					$checkOffers = mysql_query("SELECT * FROM `market_offers` WHERE theid = '".isNumber($_POST['offer_id'])."' AND type = 'offer' ") or die(mysql_error());
						$showOffers = mysql_fetch_array($checkOffers);
						for($i=1;$i<$showOffers['item_num']+1;$i++) {
							$showitem = getItem($showOffers["item_".$i]);
							inputItem($showOffers["item_".$i], $login);
						}
							if($showOffers['mc'] > 0) {
								setStat('mc',$login,getStat('mc',$login) + $showOffers['mc']);
							}
							
					$getName = mysql_query("SELECT * FROM `market_offers` WHERE theid = '".isNumber($_POST['offer_id'])."' and type='offer'") or die(mysql_error());
					$doName = mysql_fetch_array($getName);
					$checkOffers2 = mysql_query("SELECT * FROM `market_offers` WHERE id = '".isNumber($_POST['trade_id'])."' AND type='trade'") or die(mysql_error());
						$showOffers2 = mysql_fetch_array($checkOffers2);
						for($k=1;$k<$showOffers2['item_num']+1;$k++) {
							$showitem = getItem($showOffers2["item_".$k]);
							inputItem($showOffers2["item_".$k], $doName['user_id']);
						}
						
					mysql_query("DELETE FROM `market_offers` WHERE theid = '".isNumber($_POST['offer_id'])."'") or die(mysql_error());
					mysql_query("DELETE FROM `market_offers` WHERE id = '".isNumber($_POST['trade_id'])."' AND type='trade'") or die(mysql_error());
					
					$checkOffers3 = mysql_query("SELECT * FROM `market_offers` WHERE id = '".isNumber($_POST['trade_id'])."'") or die(mysql_error());
						while($showOffers3 = mysql_fetch_array($checkOffers3)) {
						for($i=1;$i<$showOffers3['item_num']+1;$i++) {
							$showitem3 = getItem($showOffers3["item_".$i]);
							inputItem($showOffers3["item_".$i], $showOffers3['user_id']);
						}
							if($showOffers3['mc'] > 0) {
								setStat('mc',$showOffers3['user_id'],getStat('mc',$showOffers3['user_id']) + $showOffers3['mc']);
							}
						}
					
					mysql_query("DELETE FROM `market_offers` WHERE id = '".isNumber($_POST['trade_id'])."'") or die(mysql_error());
					mysql_query("DELETE FROM `market` WHERE trade_id = '".isNumber($_POST['trade_id'])."' AND user_id ='".$login."'") or die(mysql_error());
						
					$image = "loginimage.png";
					$header = "Please wait";
					$message = "Accepting trade!<br><br>
					Please wait..
					<meta http-equiv='refresh' content='2;URL=?p=inventory'>";
					include("pages/error.php");
				} else {
					$message = "Invalid trade id<br><br><i>Errorcode: bm021</i>";
					include("pages/error.php");
				}
			} else {
				$message = "Invalid trade id<br><br><i>Errorcode: bm020</i>";
				include("pages/error.php");
			}
		} elseif ($_POST['submit2']) {
		
		} else {
				$checkOwner = mysql_query("SELECT * FROM `market` WHERE trade_id='".isNumber($_GET['id'])."' AND user_id = '".$login."'") or die(mysql_error());
				$showOwner = mysql_fetch_array($checkOwner);
				if($showOwner['trade_id'] != "") {
				
				$get_offer = mysql_query("SELECT * FROM `market_offers` WHERE id='".$showOwner['trade_id']."' AND type='offer'") or die(mysql_error());
				while($show_offer = mysql_fetch_array($get_offer)) {
					$showOffering = mysql_query("SELECT * FROM `users` WHERE id='".$show_offer['user_id']."'") or die(mysql_error());
					$getOffering = mysql_fetch_array($showOffering);
				echo "
				<div style='margin:0px auto;width:400px;font-family:Georgia, arial, serif;font-size:13px;font-style:italic;color:#444343;'>
						<div style='float:left;'>
							Offer made by: <b>".$getOffering['username']."</b>
						</div>
						<div style='clear:both;'></div>
					</div>
					<div style='margin:0px auto;width:400px;background:url(images/tradebg.png) repeat-y;border:5px solid #cbc7c6;margin-top:2px;'>
				";
					for($i=1;$i<$show_offer['item_num']+1;$i++) {
					$showitem = getItem($show_offer["item_".$i]);
					echo "
						<div style='float:left;margin:10px 5px 10px 10px;'>
						<img src='images/items/".$showitem['image']."' width='60' height='60' style='margin-top:2px;border:1px solid #b4b0b0;'>
						</div>
						<div style='float:left;margin:18px 10px 3px 0px;'>
						<b>".$showitem['name']."</b><br>
						Rarity: ".$showitem['rarity']."<br>
						Type: ".$showitem['type']."
						</div>
						<div style='clear:both;'>
						</div>
					";
					}
				if($show_offer['mc'] > 0) {
					echo "
						<div style='text-align:center;margin:10px 10px 10px 0px;'>
						Offer includes: <b>".number_format($show_offer['mc'])."</b> <font color='#f0de65' style='font-weight:bold;'>MC</font>
						</div>";
				} else {
				}
				echo "
				</div>
				<div style='margin:0px auto;margin-top:5px;width:400px;text-align:center;font-family:Georgia, arial, serif;font-size:13px;font-style:italic;color:#444343;'>
				<form action='?p=blackmarket&do=showoffer&id=".$show_offer['id']."' method='post'>
				<input type='hidden' name='trade_id' value='".$showOwner['trade_id']."'>
				<input type='hidden' name='offer_id' value='".$show_offer['theid']."'>
				<input type='submit' name='submit' value='&nbsp;' onClick='return confirmPost(\"Notice! Youre about to accept the offer from ".$getOffering['username']."\")' class='accepttrade' style='margin-top:4px;' size='10'> 
				<input type='submit' name='submit2' value='&nbsp;' onClick='return confirmPost(\"You're about to reject the offer! Please confirm\")' class='rejecttrade' style='margin-top:4px;' size='10'> 
				</form>
				</div>
				<div style='height:40px;'></div>";
			}
		} else {
			$message = "Invalid trade id<br><br><i>Errorcode: bm019</i>";
			include("pages/error.php");
		}
		}
		break;
		
		}
	} else {
		$message = "You must be level <b>3</b> to visit The Black Market!<br><br><i>Errorcode: bm001</i>";
		include("pages/error.php");
	}
} else {
	$message = "You have to be logged in to view this page!<br><br><i>Errorcode: q001</i>";
	include("pages/error.php");
}
?>