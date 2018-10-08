<?php

/**
 * Created by PhpStorm.
 * User: jermainedurham
 * Date: 9/10/18
 * Time: 3:31 PM
 */
class admin_config
{

    const LOGINED_IN = true;
    const NOT_LOGINED = false;

    function __construct()
    {
        date_default_timezone_set("America/New_York");
    }

    public static function check_logged_in()
    {
        if ($_SESSION['SessionAdminID'] != "" && $_SESSION['SessionAdminPassword'] != "") {
            return self::LOGINED_IN;
        } elseif ($_COOKIE['AdminID'] != "" && $_COOKIE['AdminPassword'] != "") {
            $_SESSION['SessionAdminID'] = $_COOKIE['AdminID'];
            $_SESSION['SessionAdminPassword'] = $_COOKIE['AdminPassword'];
            return self::LOGINED_IN;
        }else{
            return self::NOT_LOGINED;
        }
    }

    public static function create_session($Adminid, $Adminpassword)
    {
        $_SESSION['SessionAdminID'] = $Adminid;
        $_SESSION['SessionAdminPassword'] = $Adminpassword;
    }

    public static function create_cookie()
    {
        setcookie("AdminID", $_SESSION['SessionAdminID'], time() + (86400 * 365), "/");
        setcookie("AdminPassword", $_SESSION['SessionAdminPassword'], time() + (86400 * 365), "/");
    }

    public static function delete_session(){
        session_unset();
        session_destroy();
    }

    public static function delete_cookie(){
        setcookie("AdminID", $_SESSION['SessionAdminID'], time() - (86400 * 365), "/");
        setcookie("AdminPassword", $_SESSION['SessionAdminPassword'], time() - (86400 * 365), "/");
    }
}