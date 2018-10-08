<?php

/**
 * Created by PhpStorm.
 * User: Jermaine Durham
 * Date: 8/27/18
 * Time: 12:28 PM
 */
class messaged extends database
{
    public static $MESSAGE_SEEN = 0;
    public static $MESSAGE_UNSEEN = 1;
    public static $MESSAGE_SEND = 2;
    public static $MESSAGE_RECEIVE = 3;
    public static $MESSAGE_DELETED = 4;
    public static $MESSAGE_BLOCKED = 5;

    public static function history($parentid)
    {
        $sql = mysqli_query(self::$DB, "select * from `member-message` where `tomemberid` = '$parentid' || `frommemberid` = '$parentid' order by `messageid` desc LIMIT 1") or die(mysqli_error(self::$DB));

        $messages = [];
        while ($row = mysqli_fetch_assoc($sql)) {
            $messages[] = $row;
        }

        return $messages;
    }

    public static function receive_new_message($tomemberid, $frommemberid)
    {
        $sql = mysqli_query(self::$DB, "select * from `member-message` where `tomemberid` = '$tomemberid' && `frommemberid` = '$frommemberid' && `status` = '" . self::$MESSAGE_UNSEEN . "' order by `messageid` desc") or die(mysqli_error(self::$DB));

        $message = [];
        while($row = mysqli_fetch_assoc($sql)){
            $message[] = $row;
        }

        return $message;
    }

    public static function unseen_message_count($parentid)
    {
        $sql = mysqli_query(self::$DB, "select * from `member-message` where `tomemberid` = '$parentid' && `status` = '" . self::$MESSAGE_UNSEEN . "'");
        return mysqli_num_rows($sql);
    }

    public static function set_seen_message($tomemberid, $frommemberid)
    {
        $sql = mysqli_query(self::$DB, "update `member-message` set `status` = '" . self::$MESSAGE_SEEN . "' where `tomemberid` = '$tomemberid' && `frommemberid` = '$frommemberid'");
    }

    public static function send_message($tomember, $frommember, $message, $filetype, $filename)
    {
        $message = htmlspecialchars(trim($message));
        $sql = mysqli_query(self::$DB, "insert into `member-message` (`messageid`, `tomemberid`, `frommemberid`, `message`,`filetype`, `filename`, `status`) values(NULL, '$tomember', '$frommember', '$message', '$filetype', '$filename', '" . self::$MESSAGE_UNSEEN . "')");

        return self::$MESSAGE_SEND;
    }

    public static function receive_message($parentid, $get_unseen = 0)
    {
        $sql = mysqli_query(self::$DB, "select * from `member-message` where `tomemberid` = '$parentid' || `frommemberid` = '$parentid'") or die(mysqli_error(self::$DB));

        $messages = [];
        while ($row = mysqli_fetch_assoc($sql)) {
            $messages[] = $row;
        }

        return $messages;
    }

    public static function delete_message($messageid)
    {
        $sql = mysqli_query(self::$DB, "delete from `member-message` where `messageid` = '$messageid'");

        return self::$MESSAGE_DELETED;
    }

    public static function block_member($PARENTID, $MEMBERID)
    {
        $sql = mysqli_query(self::$DB, "insert into `member-message-block` (`blockid`, `parentid`, `memberid`) values(NULL, '$PARENTID', '$MEMBERID')");
    }

    public static function unblock_member($PARENTID, $MEMBERID)
    {
        $sql = mysqli_query(self::$DB, "delete from `member-message-block` where `parentid` = '$PARENTID' && `memberid` '$MEMBERID')");
    }

    public static function list_block_member($PARENTID)
    {
        $sql = mysqli_query(self::$DB, "select * from `memmber-message-block` where `parentid` = '$PARENTID'");

        $block_members = [];
        while ($row = mysqli_fetch_assoc($sql)) {
            $block_members[] = $row;
        }

        return $block_members;
    }


}