<?php

/**
 * .
 * User: Jermaine Durham
 * Date: 7/3/18
 * Time: 7:31 AM
 */

require "core/session_cookie_managerment.php";

class LF_ERROR extends session_cookie_managerment
{
    public static function db_errorpage()
    {
        //$scm = new session_cookie_managerment();
        require "inner_header.php";
        if (self::NOT_LOGINED == self::NOT_LOGINED) {
            require_once "outer_header.php";
            ?>
            <div id="" style="float: left; width: 100%;" class="alert-heading alert-info">Database error, please check
                again later.
            </div>
            <?php
} else {
            require_once "inner_header.php";
            ?>
            <div id="" style="float: left; width: 100%;" class="alert-heading alert-info">Database error, please check
                again later.
            </div>
            <?php
}
    }

    public static function error_page()
    {
        require "inner_header.php";
        ?>
            <div id="" style="float: left; padding: 1em; width: 100%;" class="alert-heading alert-info">The page you have request is not available at this time please try again later. <a href="home" target="_self">Click here to leave</a>
            </div>
        <?php
}
}