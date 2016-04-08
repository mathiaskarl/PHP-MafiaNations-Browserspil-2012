<script type="text/javascript">
    function alert_check(check) {
        if(check) {
            return true;
        }
        return false;
    }
    
$('.submit_button').click(function() {
    var value = $(this.form).find('.input_action').val();
    switch(value) {
        case 'give':
            $('#content_wrapper').hide();
            $('#send_wrapper').show();
            var value = null;
            break;
            
        case 'disabled':
            break;
            
        default:
            var box = confirm("Are you sure you wish to do this?");
            if(alert_check(box)) {
                $('#loading_event').show();
                $('#send_wrapper').hide();
                $('#content_wrapper').hide();
                $.ajax({
                type: "POST",
                url: "include/ajax/showitem.ajax.php",
                data: $(this.form).serialize(),
                success: function(data) {
                  $('#loading_event').hide();
                  $('#event').append(data);
                  $('#event').show();
                }
                });
            }
            break;
    }
});
</script>
<?php
session_start();
require "functions.include.php";
$login = new login();
$items = new items();
if($login->check_login()) {
    $id = (isset($_GET['id']) ? isNumber($_GET['id']) : 0);
    if(isset($_GET['id']) && items::item_exists($id, true)) {
            $id = isNumber($_GET['id']);
            $query = db_core::getInstance()->conn->prepare("SELECT * FROM `user_inventory` WHERE user_id = '".$_SESSION['user_id']."' AND id = :id");
            $query->bindValue(":id", $id, PDO::PARAM_STR);
            $query->execute();
            if($query->rowCount() > 0) {
                $fetch = $query->fetch(PDO::FETCH_ASSOC);
                $item = $items->get_item($fetch['item_id']);

                switch($item['item_use']) {
                    case 'useable':
                        $build_select = "<option value='use'>Use item</option>";
                        break;
                    case 'weapon':
                        $build_select = "<option value='equipt'>Equipt item</option>";
                        break;

                }
                $build_description = ($item['description'] != null ? $item['description'] : "This item has no description");
                $build_effect = ($item['ability'] != null ? "<br /><br /><b>Effect:</b><br />".$item['ability'] : "");

                echo "
                <div style='width:100%;height:100%;background-color:#ded9d8;'>
                <div id='italicblack'>
                    <div id='content_wrapper'>
                        <div style='width:80px;height:80px;background:url(images/items/".$item['image'].") 0 0 no-repeat;border:1px solid black;float:left;margin-top:10px;margin-left:10px;'></div>
                        <div style='float:left;margin-top:10px;margin-left:10px;'>
                        <b>Item:</b> ".$item['name']."<br>
                        <b>Type:</b> ".$item['type']."<br>
                        <b>Rarity:</b> ".$item['rarity']."<br>
                        </div>
                        <div style='clear:both;'></div>
                        <div style='margin-left:10px;margin-top:10px;'>
                        <b>Description:</b><br>
                        ".$build_description."
                        ".$build_effect."
                        <form name='form_content' class='form_content' method='post' action=''>
                        <table width='100%' style='margin-top:10px;'>
                        <tr>
                            <td width='55%' style='text-align:right;'>
                            <input name='item_id' value='".$fetch['id']."' type='hidden'>
                            <select name='action' id='registerinput' class='input_action' style='width:140px;'>
                            <option value='disabled' selected='' disabled>Choose an Action</option>
                            ".$build_select."
                            <option value='give'>Give to friend</option>
                            <option value='drop'>Drop item</option>
                            </select>
                            </td>
                            <td width='45%' style='text-align:left;'>
                            <input class='submit_button' type='button' name='button' value='Submit' style='margin-top:10px;' size='10'>
                            </td>
                        </tr>
                        </table>
                        </form>
                        </div>
                    </div>

                    <div id='send_wrapper' style='display:none'>
                        <form name='form_content' class='form_content' method='post' action=''>
                        <input name='item_id' value='".$fetch['id']."' type='hidden'>
                        <center><br><br>Enter the username you wish to send this item to.<br>
                        <input name='action' value='give' type='hidden'>
                        <input name='username' value='' id='registerinput' type='text'>
                        <input class='submit_button' type='button' name='button' value='Submit' style='margin-top:10px;' size='10'>
                        </center>
                        </form>
                    </div>

                    <div id='event' style='display:none'>
                    </div>

                    <div id='loading_event' style='display:none;'>
                    <div style='width:100%;text-align:center;padding-top:24px;'>
                        <img src='images/loading.gif' style='margin-bottom:5px;'>
                        <div style='font-family:Georgia, arial, serif;font-size:22px;font-style:italic;color:#000;margin-bottom:5px;'>
                        Processing..
                        </div>
                        <div style='font-family: tahoma, arial, serif;font-size:13;color:#2e2624;'>
                        Your action is currently being processed.
                        </div>
                    </div>
                    </div>
                </div>
                </div>";
            } else {
                echo error::return_error_window("You are not allowed to view this page1!");
            }
    } else {
        echo error::return_error_window("Invalid item!");
    }
} else {
    echo error::return_error_window("You must be logged in to view this page!");
}
?>