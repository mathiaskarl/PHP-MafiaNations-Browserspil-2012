<?php
class error {
    private static $_error_text;
    private static $_error_image;
    private static $_error_header;
    
    public function __construct() {
    }
    
    public static function return_error($error_text, $error_header = null, $error_image = null) {
        self::$_error_text = $error_text;
        self::$_error_header = ($error_header != null ? $error_header : "Something went wrong.");
        self::$_error_image = ($error_image != null ? $error_image : "errorimage.png");
        $fill_html = "
            <div style='width:450px;height:200px;margin:0px auto;padding-top:24px;'>
		<div style='width:50px;height:50px;float:left;background:url(images/".self::$_error_image.") 0 0 no-repeat;'>
		</div>
		<div style='width:4px;height:125px;float:left;background:url(images/errorspacer.png) 0 0 no-repeat;margin-left:8px;margin-right:6px;'>
		</div>
		<div style='width:380px;;float:left;'>
			<div style='width:300px;font-family:Georgia, arial, serif;font-size:22px;font-style:italic;color:#000;padding-left:6px;margin-bottom:5px;'>
			".self::$_error_header."
			</div>
		<div style='width:380px;font-family: tahoma, arial, serif;font-size:13;color:#2e2624;margin-left:6px;'>
		". self::$_error_text ."
		</div>
		</div>
		<div style='clear:both;'></div>
            </div>";
        return $fill_html;
    }
    
    public static function return_error_window($error_text, $error_header = null) {
        self::$_error_text = $error_text;
        self::$_error_header = ($error_header != null ? $error_header : "Something went wrong.");
        $fill_html = "
            <div style='width:100%;text-align:center;padding-top:24px;'>
                <div style='font-family:Georgia, arial, serif;font-size:22px;font-style:italic;color:#000;margin-bottom:5px;'>
                ".self::$_error_header."
                </div>
		<div style='font-family: tahoma, arial, serif;font-size:13;color:#2e2624;'>
		". self::$_error_text ."
		</div>
            </div>";
        return $fill_html;
    }
}
?>
