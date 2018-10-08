<?php

/**
 * .
 * User: Jermaine Durham
 * Date: 7/29/18
 * Time: 9:47 PM
 */
class friend_inc
{
    public static function friend_suggestion()
    {
        require_once "model/database.php";
        require_once "model/friendd.php";
        require_once "core/config.php";
        require_once "model/profiled.php";

        $db = new database;

        $suggestion_friends = [];

        $suggestion_friends = namespace\friendd::friend_sugguestion();

        if (count($suggestion_friends) != 0) {
            for ($i = 0; $i < count($suggestion_friends); $i++) {
                ?>
                <table id="member_suggestion_tb<?php echo $suggestion_friends[$i]; ?>" class="member_suggestion_tb">
                    <tr>
                        <td>
                            <img class="member_img"
                                 src="<?php echo namespace\profiled::MemberProfilePic($suggestion_friends[$i]); ?>"
                                 width="80"
                                 height="80"/>
                        </td>
                        <td>
                            <?php echo namespace\profiled::MemberFullName($suggestion_friends[$i]); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button onclick="send_friend_request(<?php echo $suggestion_friends[$i]; ?>);"
                                    id="send_request_btn<?php echo $suggestion_friends[$i]; ?>"
                                    style="background-color: black; width:50%; float: left; border-radius: 6px; height: 40px; color: white;">
                                Send Request
                            </button>
                            <button id="remove_request_btn<?php echo $suggestion_friends[$i]; ?>"
                                    onclick="friend_suggestion_remove(<?php echo $suggestion_friends[$i]; ?>);"
                                    style="width: 50%; background-color: white; float: left; border-radius: 6px; height: 40px; border-color: black;">
                                Remove
                            </button>
                        </td>
                    </tr>
                </table>
                <?php
            }
        } else {
            ?>
            <table class="member_suggestion_tb">
                <tr>
                    <td align="center">
                        No Suggestion Friend Available at the moment, you will get a notification when it comes
                        available.
                    </td>
                </tr>
            </table>
            <?php
        }
    }

    public static function friend_pending_request()
    {
        require_once "model/friendd.php";
        require_once "core/config.php";
        require_once "model/profiled.php";

        $myfriends = [];

        $myfriends = namespace\friendd::friend_request_array();

        if (!count($myfriends) == 0) {
            for ($i = 0; $i < count($myfriends); $i++) {
                ?>
                <table id="member_friend_request_tb<?php echo $myfriends[$i]; ?>" class="member_friend_tb">
                    <tr>
                        <td>
                            <img class="member_img"
                                 src="<?php echo namespace\profiled::MemberProfilePic($myfriends[$i]); ?>"
                                 width="80"
                                 height="80"/>
                        </td>
                        <td>
                            <?php echo namespace\profiled::MemberFullName($myfriends[$i]); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" id="friend_request_btn_tr<?php echo $myfriends[$i]; ?>">
                            <button onclick="accept_friend_request(<?php echo $myfriends[$i]; ?>);"
                                    id="send_request_btn<?php echo $myfriends[$i]; ?>"
                                    style="background-color: black; width:50%; float: left; border-radius: 6px; height: 40px; color: white;">
                                Accept
                            </button>
                            <button id="remove_request_btn<?php echo $myfriends[$i]; ?>"
                                    onclick="decline_friend_request(<?php echo $myfriends[$i]; ?>);"
                                    style="width: 50%; background-color: white; float: left; border-radius: 6px; height: 40px; border-color: black;">
                                Decline
                            </button>
                        </td>
                    </tr>
                </table>
                <?php
            }
        } else {
            ?>
            <table>
                <tr>
                    <td>

                    </td>
                </tr>
            </table>
            <?php
        }
    }

    public static function myfriends()
    {
        if ((file_exists("model/friendd.php") ? true : false)) {
            require_once "model/friendd.php";
            require_once "core/config.php";
            require_once "model/profiled.php";
        } else {
            require_once "../model/friendd.php";
            require_once "../core/config.php";
            require_once "../model/profiled.php";
        }

        $config = new config();

        //$myfriends = [];

        $myfriends = namespace\friendd::my_friends_list();

        $count = count($myfriends);

        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                ?>
                <table onclick="goto_page('profile?userid=<?php echo $myfriends[$i]; ?>');"
                       id="member_friend_tb<?php echo $myfriends[$i]; ?>"
                       class="member_friend_tb">
                    <tr>
                        <td style="width: 12%; text-align: center;">
                            <img class="member_img" style="border-radius: 100%; width: 60px; height: 60px;"
                                 src="<?php echo namespace\profiled::MemberProfilePic($myfriends[$i]); ?>"
                                 width="80"
                                 height="80"/>
                        </td>
                        <td align="center" style="width: 88%;">
                            <?php echo namespace\profiled::MemberFullName($myfriends[$i]); ?>
                        </td>
                    </tr>
                </table>
                <?php
            }
        } else {
            ?>
            <table class="member_friend_tb">
                <tr>
                    <td align="center">
                        You don't have any friends available, <a href="search" target="_parent">Click here to search for
                            friends.</a>
                    </td>
                </tr>
            </table>
            <?php
        }


    }
}