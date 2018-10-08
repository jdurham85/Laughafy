<?php

/**
 * Created by PhpStorm.
 * User: Jermaine Durham
 * Date: 8/23/18
 * Time: 7:25 PM
 */
class notificationd extends database
{
    /*
     *
     *
     * */

    private function exmaple()
    {

        switch ("MODE") {

            case namespace\notification::$ADD_POST:
                break;

            case notification::$REPILED_TO_POST:

                break;

            case notification::$REACTED_TO_POST: {
                break;
            }

            case notification::$SHARED_POST:

                break;

            case notification::$ADDED_POST_COMMENT:

                break;

            case notification::$REPILED_TO_POST_COMMENT: {

                break;
            }

            case notification::$REACTED_TO_POST_COMMENT: {
                break;
            }

            case namespace\notification::$ADDED_PHOTO: {

                break;
            }

            case notification::$ADDED_VIDEO:

                break;

            case notification::$BIRTHDAY:

                break;

            case notification::$EVENT_INVITE:
                break;

            case notification::$EVENT_REMINDER:

                break;

            case notification::$IS_LIVED:

                break;

            case notification::$ACCOUNT_WARNING:

                break;

            case notification::$ADDED_SNAP:

                break;
        }
    }

    public static function notification_load($tomemberid)
    {
        $data = [];
        $sql = mysqli_query(self::$DB, "select * from `member-notification` where `tomemberid` = '$tomemberid'");
        while ($row = mysqli_fetch_assoc($sql)) {
            $data[] = $row;
        }

        return $data;
    }

    public static function notification_add_DB($tomemberid, $frommemberid, $mode, $description, $wallid, $commentid, $eventid, $gameid, $pageid)
    {
        $result = "";
        $query = "";

        $date = time();

        /*switch ($mode) {

            case namespace\notification::$ADD_POST:
                $query = "INSERT INTO `member-notification`(`notificationid`, `tomemberid`, `frommemberid`, `mode`, `description`, `date`, `seen`, `wallid`, `commentid`, `eventid`, `gameid`, `pageid`) VALUES (NULL, '$tomemberid', '$frommemberid', '$mode', '$description', '$date', '".notification::$NOTIFICATION_UNSEEN."', '$wallid', '$commentid', '$eventid', '$gameid', '$pageid')";
                break;

            case notification::$REPILED_TO_POST:
                $query = "INSERT INTO `member-notification`(`notificationid`, `tomemberid`, `frommemberid`, `mode`, `description`,`wallid`, `commentid` `date`, `seen`) VALUES (NULL, '$tomemberid', '$frommemberid', '$mode', '$wallid', '$commentid')";
                break;

            case notification::$REACTED_TO_POST: {
                $query = "INSERT INTO `member-notification`(`notificationid`, `tomemberid`, `frommemberid`, `mode`, `description`, `wallid`, `commentid`,`date`, `seen`) VALUES (NULL, '$tomemberid', '$frommemberid', '$mode', '$wallid', '$commentid')";
                break;
            }

            case notification::$SHARED_POST:
                $query = "INSERT INTO `member-notification`(`notificationid`, `tomemberid`, `frommemberid`, `mode`, `description`, `walid`, `commentid`,`date`, `seen`) VALUES (NULL, '$tomemberid', '$frommemberid', '$mode', '$wallid', '$commentid')";
                break;

            case notification::$ADDED_POST_COMMENT:
                $query = "INSERT INTO `member-notification`(`notificationid`, `tomemberid`, `frommemberid`, `mode`, `description`,`wallid`, `commentid` `date`, `seen`) VALUES (NULL, '$tomemberid', '$frommemberid', '$mode', '$wallid', '$commentid')";
                break;

            case notification::$REPILED_TO_POST_COMMENT: {
                $query = "INSERT INTO `member-notification`(`notificationid`, `tomemberid`, `frommemberid`, `mode`, `description`,`wallid`, `commentid` `date`, `seen`) VALUES (NULL, '$tomemberid', '$frommemberid', '$mode', '$wallid', '$commentid')";
                break;
            }

            case notification::$REACTED_TO_POST_COMMENT: {
                $query = "INSERT INTO `member-notification`(`notificationid`, `tomemberid`, `frommemberid`, `mode`, `description`,`wallid`, `commentid` `date`, `seen`) VALUES (NULL, '$tomemberid', '$frommemberid', '$mode', '$wallid', '$commentid')";
                break;
            }

            case namespace\notification::$ADDED_PHOTO: {
                $query = "INSERT INTO `member-notification`(`notificationid`, `tomemberid`, `frommemberid`, `mode`, `description`, `date`, `seen`) VALUES (NULL, '$tomemberid', '$frommemberid', '$mode')";
                break;
            }

            case notification::$ADDED_VIDEO:
                $query = "INSERT INTO `member-notification`(`notificationid`, `tomemberid`, `frommemberid`, `mode`, `description`, `date`, `seen`) VALUES (NULL, '$tomemberid', '$frommemberid', '$mode')";
                break;

            case notification::$BIRTHDAY:
                $query = "INSERT INTO `member-notification`(`notificationid`, `tomemberid`, `frommemberid`, `mode`, `description`, `date`, `seen`) VALUES (NULL, '$tomemberid', '$frommemberid', '$mode')";
                break;

            case notification::$EVENT_INVITE:
                $query = "INSERT INTO `member-notification`(`notificationid`, `tomemberid`, `frommemberid`, `mode`, `description`, `date`, `seen`) VALUES (NULL, '$tomemberid', '$frommemberid', '$mode')";
                break;

            case notification::$EVENT_REMINDER:
                $query = "INSERT INTO `member-notification`(`notificationid`, `tomemberid`, `frommemberid`, `mode`, `description`, `date`, `seen`) VALUES (NULL, '$tomemberid', '$frommemberid', '$mode')";
                break;

            case notification::$IS_LIVED:
                $query = "INSERT INTO `member-notification`(`notificationid`, `tomemberid`, `frommemberid`, `mode`, `description`, `date`, `seen`) VALUES (NULL, '$tomemberid', '$frommemberid', '$mode')";
                break;

            case notification::$ACCOUNT_WARNING:
                $query = "INSERT INTO `member-notification`(`notificationid`, `tomemberid`, `frommemberid`, `mode`, `description`, `date`, `seen`) VALUES (NULL, '$tomemberid', '$frommemberid', '$mode')";
                break;

            case notification::$ADDED_SNAP:
                $query = "INSERT INTO `member-notification`(`notificationid`, `tomemberid`, `frommemberid`, `mode`, `description`, `date`, `seen`) VALUES (NULL, '$tomemberid', '$frommemberid', '$mode')";
                break;
        }*/

        $query = "INSERT INTO `member-notification`(`notificationid`, `tomemberid`, `frommemberid`, `mode`, `description`, `date`, `seen`, `wallid`, `commentid`, `eventid`, `gameid`, `pageid`) VALUES (NULL, '$tomemberid', '$frommemberid', '$mode', '$description', '$date', '" . notification::$NOTIFICATION_UNSEEN . "', '$wallid', '$commentid', '$eventid', '$gameid', '$pageid')";

        $result = mysqli_query(self::$DB, $query) or die(mysqli_error(self::$DB));
    }

    public static function notification_delete($notificationid = "", $memberid = "", $wallid = "", $commentid = "", $eventid = "", $gameid = "", $pageid = "")
    {
        if ($notificationid != "") {
            mysqli_query(self::$DB, "delete from `member-notification` where `notificationid` = '$notificationid'");
        }

        if ($wallid != "" && $memberid != "") {
            mysqli_query(self::$DB, "delete from `member-notification` where `tomemberid` = '$memberid' && `wallid` = '$wallid'") or die(mysqli_error(self::$DB));
        }

        if ($commentid != "" && $memberid != "") {
            mysqli_query(self::$DB, "delete from `member-notification` where `tomemberid` = '$memberid' && `commentid` = '$commentid'");
        }

        if ($wallid != "") {
            mysqli_query(self::$DB, "delete from `member-notification` where `wallid` = '$wallid'");
        }

        if ($wallid != "" && $commentid != "") {
            mysqli_query(self::$DB, "delete from `member-notification` where `wallid` = '$wallid' && `commentid` = '$commentid'");
        }

        if ($commentid != "") {
            mysqli_query(self::$DB, "delete from `member-notification` where `commentid` = '$commentid'");
        }

        if ($memberid != "" && $eventid != "") {
            mysqli_query(self::$DB, "delete from `member-notification` where `tomemberid` = '$memberid' && `eventid` = '$eventid'");
        }

        if ($eventid != "") {
            mysqli_query(self::$DB, "delete from `member-notification` where `eventid` = '$eventid'");
        }

        if ($gameid != "") {
            mysqli_query(self::$DB, "delete from `member-notification` where `gameid` = '$gameid'");
        }

        if ($pageid != "") {
            mysqli_query(self::$DB, "delete from `member-notification` where `pageid` = '$pageid'");

        }
        return true;
    }

    public static function notification_count_unseen($memberid)
    {
        $sql = mysqli_query(self::$DB, " select * from `member-notification` where `tomemberid` = '$memberid' && `seen` = '" . notification::$NOTIFICATION_UNSEEN . "'");

        return mysqli_num_rows($sql);
    }

    public static function notification_set_seen($memberid)
    {
        mysqli_query(self::$DB, "update `member-notification` set `seen` = '" . notification::$NOTIFICATION_SEEN . "' where `tomemberid` = '$memberid'");
        return true;
    }
}