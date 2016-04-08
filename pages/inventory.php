<?php
if($login->check_login()) {
    $query = db_core::getInstance()->conn->query("SELECT user_inventory.id, items.image, items.name, items.type FROM `user_inventory`
                                                INNER JOIN items ON items.id = user_inventory.item_id
                                                WHERE user_inventory.user_id = '". $_SESSION['user_id']."'
                                                ORDER BY user_inventory.id ASC");
    $inventory_count = ($query->rowCount() > 0 ? $query->rowCount() : "0");
    $items = new items();
 	echo "
	<div style='margin:0px auto;width:800px;'>
            <div style='width:24px;height:24px;float:left;background:url(images/icons/heart2.png) 0 0 no-repeat;margin-left:20px;margin-top:3px;'></div>
                <div id='italicheadersmall' style='padding-left:10px;margin-bottom:5px;float:left;'>
                Your inventory
                </div>
            <div style='clear:both;'></div>

            <div id='normalblack2' style='padding-left:20px;margin-top:5px;margin-bottom:15px;'>
            You are currently holding <b>".$inventory_count."</b> out of <b>".$stats->get_stat("inv")."</b> available items.
            </div>

            <div id='normalblacksmall' style='padding-left:20px;width:100%;'>";
            while ($fetch = $query->fetch(PDO::FETCH_ASSOC)) {
            echo "
            <div style='width:115px;height:140px;padding:5px;float:left;text-align:center;'>
                <a class='item_window' href='include/showitem.php?id=".$fetch['id']."' >
                <img src='images/items/".$fetch['image']."' style='background-color:#f6f6f6;border:1px solid black;margin-bottom:4px;'><br>
                </a>
                <b>".$fetch['name']."</b><br>
                (".$fetch['type'].")
            </div>";
            }
            echo "
            <div style='clear:both;'></div>
            </div>
	</div>";
} else {
    error::return_error("You have to be logged in to view this page!");
}
?>