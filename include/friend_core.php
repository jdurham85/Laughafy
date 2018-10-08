<?php
/**
 * .
 * User: Jermaine Durham
 * Date: 7/29/18
 * Time: 9:04 PM
 */
session_start();
require "../core/config.php";
require "../model/database.php";
require "../model/friendd.php";
require "../core/friend.php";
require "../views/views.php";
require "../model/profiled.php";
require "../views/friend_inc.php";
$db = new database;
$config = new config();

if (!empty($_POST)) {
    switch (true) {
        case $_POST['friend_suggestion_count']:
            $friend_suggestion_count = namespace\friendd::friend_suggestion_count();
            echo $friend_suggestion_count;
            break;

        case $_POST['accept_friend_request']:
            echo namespace\friendd::accept_request($_POST['accept_friend_request']);
            break;

        case $_POST['decline_friend_request']:
            echo namespace\friendd::decline_request($_POST['decline_friend_request']);
            break;

        case $_POST['friend_suggestion']:
            echo namespace\friend_inc::friend_suggestion();
            break;

        case $_POST["friend_request"]:
            if (namespace\friendd::send_request($_POST['friend_request']) == namespace\friendd::$REQUEST_SEND) {
                echo "REQUEST_SENT";
            } elseif (namespace\friendd::send_request($_POST['friend_request']) == namespace\friendd::$REQUEST_PENDING) {
                echo "REQUEST_PENDING";
            } else {
                echo "ERROR";
            }
            break;

        case $_POST['friend_request_count']:
            echo namespace\friendd::count_request();
            break;

        case $_POST['friend_pending_request']:

            break;

        case $_POST["friend_contact"]:
            break;

        case $_POST["myfriends"]:
            echo namespace\friend_inc::myfriends();
            break;

        case $_POST["friend"]:

            break;

        case $_POST["friend_suggestion_remove"]:
            namespace\friendd::friend_suggestion_remove($_POST['friend_suggestion_remove']);
            break;

        case $_POST['blocklist']: {
            //$block_list = [];
           $block_list = friend::blockf_list($config->get_session_id());

            for ($i = 0; $i < count($block_list); $i++) {
                ?>
                <table id="block_list_tb<?php echo $block_list[$i]['blockid'] ?>" onclick="" style="border-bottom: 1px black solid;">
                    <tr>
                        <td width="20%" align="center">
                            <img width="60" height="60" style="border-radius: 100%;"
                                 src="<?php echo profiled::MemberProfilePic($block_list[$i]['memberid']); ?>"
                        </td>
                        <td width="80%" align="center" style="font-weight: bold;">
                            <?php echo profiled::MemberFullName($block_list[$i]['memberid']); ?>
                        </td>
                        <td align="center" style="font-weight: bold;">
                            <a href="javascript:void(0);" onclick="unblockm('<?php echo $block_list[$i]['memberid']; ?>');">Unblock</a>
                        </td>
                    </tr>
                </table>
                <?php
            }
            break;
        }

        case $_POST['unblockfriend']:
            friend::unblockf($config->get_session_id(), $_POST['unblockfriend']);
            break;

        case $_POST['blockfriend']:
            friend::blockf($config->get_session_id(), $_POST['blockfriend']);
            break;

        case $_POST['account_setting_friend_list']:
            $friend_list = friend::my_friends_list()['tomemberid'];

            for ($i = 0; $i < count($friend_list); $i++) {
                ?>
                <table onclick="blockm('<?php echo $friend_list[$i]; ?>')">
                    <tr>
                        <td width="20%" align="center">
                            <img width="60" height="60" style="border-radius: 100%;"
                                 src="<?php echo profiled::MemberProfilePic($friend_list[$i]); ?>"
                        </td>
                        <td width="80%" align="center">
                            <?php echo profiled::MemberFullName($friend_list[$i]); ?>
                        </td>
                    </tr>
                </table>
                <?php
            }
            break;
    }
}