<?php
/**
 * Created by PhpStorm.
 * User: Jermaine Durham
 * Date: 8/24/18
 * Time: 1:52 AM
 */
session_start();

require "../core/config.php";
require "../core/upload.php";
require "../core/notification.php";
//require "../core/notification_enum.php";

require "../model/uploadd.php";
require "../model/profiled.php";
require "../model/notificationd.php";

require "../views/member_photo.php";

$config = new config();

if(!empty($_POST)){
    switch (true){
        case $_POST['notification_count_unseen']:
            echo notification::notification_count_unseen($config->get_session_id());
            break;

        case $_POST['notification_load']:
            echo notification::notification_load($config->get_session_id());

            notification::notification_set_seen($config->get_session_id());
            break;

        case $_POST['notification_delete']:
            notification::notification_delete($_POST['notification_delete']);
            break;
    }
}