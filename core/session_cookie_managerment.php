<?php

/**
 * .
 * User: Jermaine Durham
 * Date: 7/2/18
 * Time: 9:18 AM
 */
class session_cookie_managerment
{
    const LOGINED_IN = true;
    const NOT_LOGINED = false;

    public static function check_logged_in()
    {
        if ($_SESSION['SessionMemberID'] != "" && $_SESSION['SessionMemberPassword'] != "") {
            return self::LOGINED_IN;
        } elseif ($_COOKIE['MemberID'] != "" && $_COOKIE['MemberPassword'] != "") {
            $_SESSION['SessionMemberID'] = $_COOKIE['MemberID'];
            $_SESSION['SessionMemberPassword'] = $_COOKIE['MemberPassword'];
            return self::LOGINED_IN;
        }else{
            return self::NOT_LOGINED;
        }
    }

    public static function create_session($memberid, $memberpassword)
    {
        $_SESSION['SessionMemberID'] = $memberid;
        $_SESSION['SessionMemberPassword'] = $memberpassword;
    }

    public static function create_cookie()
    {
        setcookie("MemberID", $_SESSION['SessionMemberID'], time() + (86400 * 365), "/");
        setcookie("MemberPassword", $_SESSION['SessionMemberPassword'], time() + (86400 * 365), "/");
    }

    public static function delete_session(){
        session_unset();
        session_destroy();
    }

    public static function delete_cookie(){
        setcookie("MemberID", $_SESSION['SessionMemberID'], time() - (86400 * 365), "/");
        setcookie("MemberPassword", $_SESSION['SessionMemberPassword'], time() - (86400 * 365), "/");
    }
}