<?php
/**
 * Created by PhpStorm.
 * User: Jermaine Durham
 * Date: 8/27/18
 * Time: 1:43 PM
 */
session_start();

require "../core/config.php";
require "../core/upload.php";
require "../core/post_inc.php";
require_once "../core/notification.php";
//require "../core/notification_enum.php";
require "../core/message.php";
require "../core/profile.php";

require_once "../model/database.php";
require "../model/postd.php";
require "../model/uploadd.php";
require "../model/friendd.php";
require "../model/notificationd.php";
require "../model/messaged.php";
require "../model/profiled.php";

$db = new database();
$config = new config();

if(!empty($_POST)){
    switch(TRUE){
        case $_POST['profilebox']:{
            profile::load_member_profile($_POST['profilebox']);
            break;
        }
    }
}