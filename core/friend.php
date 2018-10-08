<?php

/**
 * .
 * User: Jermaine Durham
 * Date: 7/18/18
 * Time: 8:52 PM
 */
class friend
{
    public static $REQUEST_NOT_AVAILABLE = 0;
    public static $REQUEST_SEND = 1;
    public static $REQUEST_PENDING = 1;
    public static $REQUEST_ACCEPTED = 2;
    public static $REQUEST_DECLINED = 3;
    public static $REQUEST_BLOCKED = 4;

    private static $friendd = "";

    public static function friend_suggestions()
    {
        require_once "../model/friendd.php";
    }

    public static function IS_FRIEND($tomemberid, $frommemberid)
    {
        return friendd::IS_FRIEND($tomemberid, $frommemberid);
    }

    public static function send_request($tomemberid)
    {
        require_once "../model/friendd.php";

        $request = new friendd();

        $request::send_request($tomemberid);
    }

    public static function decline_request($frommemberid)
    {
        require_once "../model/friendd.php";

        $request = new friendd();

        $request::decline_request($frommemberid);
    }

    public static function block_request($frommemberid)
    {
        require_once "../model/friendd.php";

        $request = new friendd();

        $request::block_request($frommemberid);
    }

    public static function accept_request($frommemberid)
    {
        require_once "../model/friendd.php";

        $request = new friendd();

        $request::accept_request($frommemberid);
    }

    public static function check_request($frommemberid)
    {
        require_once "../model/friendd.php";

        $request = new friendd();

        return $request::check_request($frommemberid);
    }

    public static function friends($memberid)
    {
        require_once "../model/friendd.php";

        $request = new friendd();
    }

    public static function myfriend_suggestions()
    {
        require_once '../model/friendd.php';

        $f = new friendd;

        $f->setup_friend_suggestions();
    }

    public static function my_friends_birthday_list(){
        return friendd::my_friends_birthday_list();
    }

    public static function my_friends_list()
    {
        return friendd::my_friends_list();
    }

    static function is_block($parentid, $memberid)
    {
        return friendd::is_block($parentid, $memberid);
    }

    public static function blockf($parentid, $memberid)
    {
        return friendd::blockf($parentid, $memberid);
    }

    public static function unblockf($parentid, $memberid)
    {
        return friendd::unblockf($parentid, $memberid);
    }

    public static function blockf_list($parentid)
    {
        return friendd::blockf_list($parentid);
    }


}