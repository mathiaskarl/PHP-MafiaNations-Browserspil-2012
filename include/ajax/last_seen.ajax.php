<?php
session_start();
require "functions.include.php";
$login = new login();
if($login->check_login()) {
    $activity = new activity();
    $activity->last_seen($_SESSION['last_activity']);
}
?>
