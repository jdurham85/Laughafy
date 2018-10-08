<?php

/**
 * .
 * User: Jermaine Durham
 * Date: 7/18/18
 * Time: 9:07 PM
 */
class friendd extends database
{

    public static $REQUEST_NOT_AVAILABLE = 0;
    public static $REQUEST_SEND = 1;
    public static $REQUEST_PENDING = 1;
    public static $REQUEST_ACCEPTED = 2;
    public static $REQUEST_DECLINED = 3;
    public static $REQUEST_BLOCKED = 4;

    private static $friend_class = "";
    private static $config_func = "";
    private static $database;

    function __construct()
    {
        require_once "../core/config.php";
        self::$friend_class = new namespace\friend();
        self::$config_func = new namespace\config();
        self::$database = self::$DB;
    }

    public static function friend_count()
    {
        require_once "core/config.php";
        require_once 'profiled.php';

        $config = new config();
        $current_member_info = new profiled;

        $current_memberid = $config->get_session_id();

        $result = mysqli_query(self::$DB, "select * from `member-friend-suggestions` where `tomemberid` = '$current_memberid' && `status` = 1");

        return mysqli_num_rows($result);
    }

    public static function IS_FRIEND($tomemberid, $frommemberid)
    {
        $query = " || `tomemberid` = '$frommemberid' && `frommemberid` = '$tomemberid' && `status` ='" . self::$REQUEST_ACCEPTED . "'";
        $sql = mysqli_query(self::$DB, "select * from `member-friends` where `tomemberid` = '$tomemberid' && `frommemberid` = '$frommemberid' && `status` ='" . self::$REQUEST_ACCEPTED . "'" . $query);

        if (mysqli_num_rows($sql) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function friend_sugguestion()
    {
        require_once "core/config.php";
        require_once 'profiled.php';

        $config = new config();
        $current_member_info = new profiled;

        $current_memberid = $config->get_session_id();

        $sql = mysqli_query(self::$DB, "select * from `member-friend-suggestions` where `tomemberid` = '$current_memberid' && `status` = 1");

        if (mysqli_num_rows($sql) > 0) {
            return mysqli_fetch_array($sql)['frommemberid'];
        } else {
            return NULL;
        }
    }

    public static function my_friends_birthday_list(){
        $config = new config();
        $result = mysqli_query(self::$DB, "select a.memberid, a.dob, b.tomemberid, b.frommemberid, b.status from  `member` a, `member-friends` b where b.status = '" . self::$REQUEST_ACCEPTED . "' && a.memberid = b.frommemberid order by a.dob asc") or die(mysqli_error(self::$DB));

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                //if($row['frommemberid'] != $config->get_session_id()){
                   $myfriend[] = $row;
                //}
            }
            return $myfriend;
        } else {
            return null;
        }
    }

    public static function my_friends_list($page = "")
    {
        $configfile = (file_exists("../core/config.php") ? true : false);

        if ($configfile == TRUE) {
            require_once "../core/config.php";
        } else {
            require_once "core/config.php";
        }

        require_once "database.php";
        $db = new database;

        $page = ($page == "" ? 1 : $page);

        $config = new config;

        $result = "";
        $limit = 20;

        $myfriend = [];


        $result = mysqli_query($db::$DB, "select * from `member-friends` where `tomemberid` = '" . $config->get_session_id() . "' && `status` = '" . self::$REQUEST_ACCEPTED . "'") or die(mysqli_error(self::$DB));

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if($row['frommemberid'] != $config->get_session_id()){
                    $myfriend[] = $row['frommemberid'];
                }
            }
            return $myfriend;
        } else {
            return null;
        }
    }

    public static function friend_suggestion_remove($frommemberid)
    {
        $config = new config();
        $current_member_info = new profiled;

        $current_memberid = $config->get_session_id();

        $sql = mysqli_query(self::$DB, "update `member-friend-suggestions` set `status` = '0' where `tomemberid` = '$current_memberid' && `frommemberid` = '$frommemberid'");

        if ($sql) {
            //$sqla = mysqli_query(self::$DB, "update `member-friend-suggestions` set `status` = '0' where `tomemberid` = '$frommemberid' && `frommemberid` = '$current_memberid'");

            return true;
        } else {
            return false;
        }
    }

    public static function friend_suggestion_count()
    {
        require_once "../core/config.php";
        $d = new database();

        $config = new config();


        $current_memberid = $config->get_session_id();

        $sql = mysqli_query(self::$DB, "select * from `member-friend-suggestions` where `tomemberid` = '$current_memberid' && `status` = 1");


        return mysqli_num_rows($sql);
    }

    public static function setup_friend_suggestions()
    {
        require_once "core/config.php";
        require_once 'profiled.php';

        $config = new config();
        $current_member_info = new profiled;

        $current_memberid = $config->get_session_id();

        $sql = mysqli_query(self::$DB, "select * from `member` where `memberid` !='" . $config->get_session_id() . "'");

        while ($m = mysqli_fetch_array($sql)) {
            $memberid = $m['memberid'];
            //$membercountry = self::getCountryNameByID($m['country']);
            $memberRegion = self::getRegionNameByID($m['state']);
            $memberCity = self::getCityNameByID($m['city']);

            if ($current_member_info::MemberCityName($config->get_session_id()) == $memberCity && $current_member_info::MemberRegionName($config->get_session_id()) == $memberRegion) {
                if (self::check_sugessted_friend($memberid) == false) {
                    self::add_suggested_friend($memberid);
                }
            }
        }
    }

    public static function add_suggested_friend($tomember)
    {
        require_once "core/config.php";

        $config = new config();

        //$current_memberid = $config->get_session_id();
        $sql = mysqli_query(self::$DB, "INSERT INTO `member-friend-suggestions`(`tomemberid`, `frommemberid`, `status`) VALUES ('$tomember', '" . $config->get_session_id() . "', '1')");
        if ($sql) {
            $sql2 = mysqli_query(self::$DB, "INSERT INTO `member-friend-suggestions`(`tomemberid`, `frommemberid`, `status`) VALUES ('" . $config->get_session_id() . "', '$tomember', '1')");
        }
    }

    public static function check_sugessted_friend($fromMember)
    {
        require_once "core/config.php";

        $config = new config();

        $current_memberid = $config->get_session_id();
        $sql = mysqli_query(self::$DB, "select * from `member-friend-suggestions` where `tomemberid` = '$fromMember' && `frommemberid` = '$current_memberid' || `tomemberid` = '$current_memberid' && `frommemberid` = '$fromMember'");

        if (mysqli_num_rows($sql) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function count_request()
    {
        require_once "database.php";
        require_once "../core/config.php";

        $config = new config();
        $d = new database();

        $sql = mysqli_query(self::$DB, "select * from `member-friends` where `tomemberid` = '" . $config->get_session_id() . "' && `status` = '" . self::$REQUEST_PENDING . "'");

        echo mysqli_num_rows($sql);
    }

    public static function friend_request_array()
    {
        require_once "database.php";
        require_once "core/config.php";
        $d = new database();
        $config = new config();

        $result = mysqli_query(self::$DB, "select * from `member-friends` where `tomemberid` = '" . $config->get_session_id() . "' && `status` = '" . self::$REQUEST_PENDING . "'");

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_array($result)['frommemberid'];
        } else {
            return null;
        }
    }

    public static function send_request($tomemberid)
    {
        require_once "../core/config.php";
        $config_func = new config;

        require_once 'profiled.php';
        $pd = new profiled();

        if (self::check_request($tomemberid) == self::$REQUEST_NOT_AVAILABLE) {
            $sql = mysqli_query(self::$DB, "INSERT INTO `member-friends`(`tomemberid`, `frommemberid`, `status`) VALUES ('$tomemberid', '" . $config_func->get_session_id() . "', '" . self::$REQUEST_SEND . "')");
            return self::$REQUEST_SEND;
        } elseif (self::check_request($tomemberid) == self::$REQUEST_PENDING) {
            return self::$REQUEST_PENDING;
        } elseif (self::check_request($tomemberid) == self::$REQUEST_ACCEPTED) {
            $sql = mysqli_query(self::$DB, "update `member-friends` where `frommemberid` = '$tomemberid' && `tomemberid` = '" . $config_func->get_session_id() . "' set `status` = '" . self::$REQUEST_ACCEPTED . "'");

            $sql = mysqli_query(self::$DB, "INSERT INTO `member-friends`(`tomemberid`, `frommemberid`, `status`) VALUES ('" . $config_func->get_session_id() . "', '$tomemberid', '" . self::$REQUEST_ACCEPTED . "')");
        }
    }

    public static function decline_request($frommemberid)
    {
        require_once "../core/config.php";
        $config_func = new config;
        $sql = mysqli_query(self::$DB, "delete from `member-friends` where `tomemberid` = '" . $config_func->get_session_id() . "' && `frommemberid` = '$frommemberid'");

        if ($sql) {
            $sql2 = mysqli_query(self::$DB, "delete from `member-friends` where `frommemberid` = '" . $config_func->get_session_id() . "' && `tomemberid` = '$frommemberid'");
        }

        return "REQUEST_DECLINED";
    }

    public static function block_request($frommemberid)
    {
        $sql = mysqli_query(self::$DB, "update `member-friends` set `status` = '" . self::$REQUEST_BLOCKED . "' where `tomemberid` = '" . self::$config_func->get_session_id() . "' `frommemberid` = '$frommemberid'");

        return true;
    }

    public static function accept_request($frommemberid)
    {
        require_once "../core/config.php";
        //require_once "database.php";
        $config = new config();

        $sql = mysqli_query(self::$DB, "update `member-friends` set `status` = '" . self::$REQUEST_ACCEPTED . "' where `tomemberid` = '" . $config->get_session_id() . "' && `frommemberid` = '$frommemberid'") or die(mysqli_error(self::$DB));

        if ($sql) {
            $sql = mysqli_query(self::$DB, "INSERT INTO `member-friends`(`tomemberid`, `frommemberid`, `status`) VALUES ('$frommemberid', '".$config->get_session_id()."', '" . self::$REQUEST_ACCEPTED . "')");
        }

        return "REQUEST_ACCEPTED";
    }

    public static function get_request_id($frommemberid)
    {
        $sql = mysqli_query(self::$DB, "select * from `member-friends` where `tomemberid` = '" . self::$config_func->get_session_id() . "' && `frommemberid` = '$frommemberid' ");

        while ($f = mysqli_fetch_array($sql)) {
            if ($f['frommemberid'] != self::$config_func->get_session_id()) {
                return $f['id'];
            } else {
                return $f['id'];
            }
        }
    }

    public static function check_request($frommemberid)
    {
        require_once "../core/config.php";
        $config_func = new config;

        require_once 'profiled.php';
        $pd = new profiled();


        $sql = mysqli_query(self::$DB, "select * from `member-friends` where `tomemberid` = '" . $config_func->get_session_id() . "' && `frommemberid` = '$frommemberid' || `frommemberid` = '" . $config_func->get_session_id() . "' && `tomemberid` = '$frommemberid'");

        if (mysqli_num_rows($sql) > 0) {
            while ($s = mysqli_fetch_array($sql)) {
                switch ($s['status']) {
                    case self::$REQUEST_PENDING:
                        return self::$REQUEST_PENDING;
                        break;
                }
            }
        } else {
            return self::$REQUEST_NOT_AVAILABLE;
        }
    }

    public static function is_block($parentid, $memberid)
    {
        $sql = mysqli_query(self::$DB, "select * from `member-block-list` where `parentid` = '$parentid' && `memberid` = '$memberid' || `parentid` = '$memberid' && `memberid` = '$parentid'");

        if (mysqli_num_rows($sql) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function blockf($parentid, $memberid)
    {
        $sql = mysqli_query(self::$DB, "INSERT INTO `member-block-list`(`blockid`, `parentid`, `memberid`) VALUES (NULL, '$parentid', '$memberid')");

        if (self::IS_FRIEND($parentid, $memberid)) {
            mysqli_query(self::$DB, "update `member-friends` set `status` = '" . self::$REQUEST_BLOCKED . "' where `tomemberid` = '$parentid' && `frommemberid` = '$memberid'");

            mysqli_query(self::$DB, "update `member-friends` set `status` = '" . self::$REQUEST_BLOCKED . "' where `tomemberid` = '$memberid' && `frommemberid` = '$parentid'");
        }

        return true;
    }

    public static function unblockf($parentid, $memberid)
    {
        $sql = mysqli_query(self::$DB, "delete from `member-block-list` where `parentid` = '$parentid' && `memberid` = '$memberid'");

        if (self::IS_FRIEND($parentid, $memberid) !== true) {
            mysqli_query(self::$DB, "update `member-friends` set `status` = '" . self::$REQUEST_ACCEPTED . "' where `tomemberid` = '$parentid' && `frommemberid` = '$memberid'");

            mysqli_query(self::$DB, "update `member-friends` set `status` = '" . self::$REQUEST_ACCEPTED . "' where `tomemberid` = '$memberid' && `frommemberid` = '$parentid'");
        }

        return true;
    }

    public static function blockf_list($parentid)
    {
        $sql = mysqli_query(self::$DB, "select * from `member-block-list` where `parentid` = '$parentid'");
        $block_list = [];

        while ($row = mysqli_fetch_assoc($sql)) {
            $block_list[] = $row;
        }

        return $block_list;
    }

}
