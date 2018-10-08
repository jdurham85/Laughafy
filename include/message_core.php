<?php
/**
 * Created by PhpStorm.
 * User: Jermaine Durham
 * Date: 8/27/18
 * Time: 1:21 PM
 */

session_start();

/*
require "../core/config.php";
require "../core/upload.php";
require "../core/post_inc.php";
require_once "../core/notification.php";
//require "../core/notification_enum.php";
require "../core/message.php";
require "../core/friend.php";

require_once "../model/database.php";
require "../model/postd.php";
require "../model/uploadd.php";
require "../model/friendd.php";
require "../model/notificationd.php";
require "../model/messaged.php";
require_once '../model/profiled.php';
*/

require "core_file.php";

$db = new database();
$config = new config();

if (!empty($_POST)) {
    switch (TRUE) {
        case $_POST['historymessage']: {
            message::history($config->get_session_id());
            break;
        }

        case $_POST['sendmessage']: {
            message::send_message($_POST['sendmessage'], $config->get_session_id(), $_POST['message'], "", "");

            //message::receive_new_message($_POST['sendmessage'], $config->get_session_id());
            ?>
            <div class="messagebox_select_box" style="float: left; width: 100%; margin-bottom: 5px; border-radius: 2%;">
                <img class="messagebox_select_img"
                     src="<?php echo profiled::MemberProfilePic($config->get_session_id()); ?>"/>
                <div class="messagebox_select_message speech-bubble2"><?php echo config::word_filter($_POST['message']); ?></div>
            </div>
            <?php
            break;
        }

        case $_POST['message_alert_count']: {
            echo message::unseen_message_count($config->get_session_id());
            break;
        }

        case $_POST['receivemessage']: {
            message::receive_message($_POST['receivemessage']);
            message::set_seen_message($config->get_session_id(), $_POST['receivemessage']);
            break;
        }

        case $_POST['updatemessage']: {
            message::receive_new_message($config->get_session_id(), $_POST['updatemessage']);
            message::set_seen_message($config->get_session_id(), $_POST['updatemessage']);
            break;
        }

        case $_POST['messagebox_friends']: {
            echo message::load_friend();
            break;
        }

        case $_POST['receive_new_message']: {

            break;
        }

        case $_POST['blockmessage']: {
            message::block_member($_POST['blockmessage'], $config->get_session_id());
            break;
        }

        case $_POST['unblockmessage']: {

            break;
        }

        case $_POST['list_block_member']: {

            break;
        }

        case $_POST['loadmessagehistory']: {

            break;
        }
    }
}