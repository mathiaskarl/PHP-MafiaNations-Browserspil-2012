<?php

class ajax {
    public static function overlay_loading() {
        $html = "
        <div id='loading_box' style='display:none;'>
        <div class='loading_overlay'></div>
        <div class='loading_overlay_center'>
            <div class='loading_overlay_box'>
                <img id='loading_image' src='images/loading_white.gif' style='margin-bottom:5px;'>
                <div id='loading_header' style='font-family:Georgia, arial, serif;font-size:22px;font-style:italic;color:#ebebeb;margin-bottom:5px;'>
                </div>
                <div id='loading_text' style='font-family: tahoma, arial, serif;font-size:13;color:#ebebeb;'>
                </div>
            </div>
        </div>
        </div>";
        return $html;
    }
    
    public static function event_center() {
        $html = "<div id='event' style='width:100%;text-align:center;margin-top:5px;margin-bottom:10px;display:none;font-family:Georgia, arial, serif;font-size:15px;color:#a22121;font-style:italic;'></div>";
        return $html;
    }
    
    public static function event_fightclub() {
        $html = "<div id='event' class='event_fightclub'></div>";
        return $html;
    }
}
?>
