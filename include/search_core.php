<?php
session_start();
require "../core/config.php";
require "../core/upload.php";
require "../core/post_inc.php";
require_once "../core/notification.php";
require "../core/friend.php";
require "../core/searchinc.php";
//require "../core/notification_enum.php";

require_once "../model/database.php";
require "../model/postd.php";
require "../model/uploadd.php";
require "../model/friendd.php";
require "../model/notificationd.php";
require "../model/searchd.php";
require "../model/profiled.php";

$config = new config;
$db = new database;

if(!empty($_POST)){
	switch(true){
		case $_POST['search']:
			searchinc::search($_POST['search']);
		break;
	}
}
?>