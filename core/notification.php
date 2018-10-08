<?php

/**
 * Created by PhpStorm.
 * User: Jermaine Durham
 * Date: 8/23/18
 * Time: 7:25 PM
 */
class notification
{
    public static $ADDED_POST = 0;
    public static $ADDED_POST_COMMENT = 1;
    public static $REPILED_TO_POST = 2;
    public static $REPILED_TO_POST_COMMENT = 3;
    public static $ADDED_PHOTO = 4;
    public static $ADDED_VIDEO = 5;
    public static $IS_LIVED = 6;
    public static $REACTED_TO_POST = 7;
    public static $REACTED_TO_POST_COMMENT = 8;
    public static $ADDED_SNAP = 9;
    public static $BIRTHDAY = 10;
    public static $EVENT_REMINDER = 11;
    public static $EVENT_INVITE = 12;
    public static $ACCOUNT_WARNING = 13;
    public static $FRIEND_SUGGESTED = 14;
    public static $SHARED_POST = 15;
    public static $NOTIFICATION_UNSEEN = 16;
    public static $NOTIFICATION_SEEN = 17;

    /*public static function notification_tofriend($mode, $parentid, $description = ""){

        $friends = friend::my_friends_list();
        //NOTIFCIATION ADD REPILED POST COMMENT
        for ($i = 0; $i < count($friends); $i++) {
            if ($friends[$i] != $parentid) {
                self::notification_add($friends[$i], $parentid, $mode, $description, $_POST['save_comment']);
            }
        }
    }*/

    public static function notification_add($tomemberid, $frommemberid, $mode, $description = "", $wallid = "", $commentid = "", $eventid = "", $gameid = "", $pageid = "")
    {
        notificationd::notification_add_DB($tomemberid, $frommemberid, $mode, $description, $wallid, $commentid, $eventid, $gameid, $pageid);
    }

    public static function notification_load($tomemberid)
    {
        $notification = [];
        $notification = namespace\notificationd::notification_load($tomemberid);

        for ($i = 0; $i < count($notification); $i++) {
            //echo $notification[$i]['mode'];
            if ($notification[$i]['mode'] == notification::$ACCOUNT_WARNING) {

            }

            if($notification[$i]['mode'] == self::$ADDED_PHOTO){
                ?>
                <div class="notification_pl" id="notification_pl<?php echo $notification[$i]['notificationid']; ?>">
                    <img src="<?php echo profiled::MemberProfilePic($notification[$i]['frommemberid']); ?>"/>
                    <?php echo profiled::MemberFirstName($notification[$i]['frommemberid']) . " has add a new photo." ?>
                <table style="float: left; width: 100%;">
                    <tr>
                        <td width="50%">
                            <div class="notification_delete_btn"
                                 onclick="notification_delete(<?php echo $notification[$i]['notificationid']; ?>);">
                                Delete
                            </div>
                        </td>
                        <td width="50%">
                            <div class="notification_btn"
                                 onclick="goto_page('profile?userid=<?php echo $notification[$i]['frommemberid']; ?>')">View
                                Post
                            </div>
                        </td>
                    </tr>
                </table>
                </div>
            }

            if ($notification[$i]['mode'] == notification::$REACTED_TO_POST) {
                ?>
                <div class="notification_pl" id="notification_pl<?php echo $notification[$i]['notificationid']; ?>">
                    <img src="<?php echo profiled::MemberProfilePic($notification[$i]['frommemberid']); ?>"/>
                    <?php echo profiled::MemberFirstName($notification[$i]['frommemberid']) . " has reacted to your post." ?>
                    <div class="notification_btn_pl">
                        <table style="float: left; width: 100%;">
                            <tr>
                                <td width="50%">
                                    <div class="notification_delete_btn"
                                         onclick="notification_delete(<?php echo $notification[$i]['notificationid']; ?>);">
                                        Delete
                                    </div>
                                </td>
                                <td width="50%">
                                    <div class="notification_btn" onclick="show_post_like_tb(<?php echo $notification[$i]['wallid']; ?>);">View Post</div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <?php
            }

            if ($notification[$i]['mode'] == notification::$REPILED_TO_POST) {
                ?>
                <div class="notification_pl" id="notification_pl<?php echo $notification[$i]['notificationid']; ?>">
                    <img src="<?php echo profiled::MemberProfilePic($notification[$i]['frommemberid']); ?>"/>
                    <?php echo profiled::MemberFirstName($notification[$i]['frommemberid']) . " has repiled to your post." ?>
                    <table style="float: left; width: 100%;">
                        <tr>
                            <td width="50%">
                                <div class="notification_delete_btn"
                                     onclick="notification_delete(<?php echo $notification[$i]['notificationid']; ?>);">
                                    Delete
                                </div>
                            </td>
                            <td width="50%">
                                <div class="notification_btn"
                                     onclick="post_popup_box_show(<?php echo $notification[$i]['wallid']; ?>);">View
                                    Post
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <?php
            }

            if ($notification[$i]['mode'] == notification::$REACTED_TO_POST) {
                ?>
                <div class="notification_pl" id="notification_pl<?php echo $notification[$i]['notificationid']; ?>">
                    <img src="<?php echo profiled::MemberProfilePic($notification[$i]['frommemberid']); ?>"/>
                    <?php echo profiled::MemberFirstName($notification[$i]['frommemberid']) . " has reacted to your post." ?>
                    <table style="float: left; width: 100%;">
                        <tr>
                            <td width="50%">
                                <div class="notification_delete_btn"
                                     onclick="notification_delete(<?php echo $notification[$i]['notificationid']; ?>);">
                                    Delete
                                </div>
                            </td>
                            <td width="50%">
                                <div class="notification_btn"
                                     onclick="post_popup_box_show(<?php echo $notification[$i]['wallid']; ?>);">View
                                    Post
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <?php
            }
        }
    }

    public static function notification_count_unseen($memberid)
    {
        return notificationd::notification_count_unseen($memberid);
    }

    public static function notification_delete($notificationid = "", $memberid = "", $wallid = "", $commentid = "", $eventid = "", $gameid = "", $pageid = "")
    {
        notificationd::notification_delete($notificationid, $memberid, $wallid, $commentid, $eventid, $gameid, $pageid);
    }

    public static function notification_set_seen($memberid)
    {
        notificationd::notification_set_seen($memberid);
    }
}