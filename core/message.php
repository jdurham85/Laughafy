<?php

/**
 * Created by PhpStorm.
 * User: Jermaine Durham
 * Date: 8/27/18
 * Time: 12:28 PM
 */
class message
{

    public static $MESSAGE_SEEN = 0;
    public static $MESSAGE_UNSEEN = 1;
    public static $MESSAGE_SEND = 2;
    public static $MESSAGE_RECEIVE = 3;
    public static $MESSAGE_DELETED = 4;
    public static $MESSAGE_BLOCKED = 5;

    public static function load_friend()
    {
        $friends = friend::my_friends_list()['tomemberid'];

        if (count($friends) > 0) {
            for ($i = 0; $i < count($friends); $i++) {
                ?>
                <div class="messagebox_inboxbar" onclick="messagebox_select_memberbox('<?php echo $friends[$i]; ?>');">
                    <img class="messagebox_inbox_img" style="width: 60px; height: 60px; border-radius: 100%;"
                         src="<?php echo profiled::MemberProfilePic($friends[$i]); ?>"/>
                    <div class="messagebox_select_membername"
                         style="padding: 1.125em;"><?php echo profiled::MemberFullName($friends[$i]); ?></div>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="messagebox_inbox_message"
                 style="padding: 1.125em; width: 100%; float: left; font-size: 1em; text-align: center; font-weight: bold;">
                You do not have no friends available
            </div>
            <?php
        }
    }

    public static function send_message($tomember, $frommember, $message, $filetype = "", $filename)
    {

        require_once "../core/config.php";
        $config = new config();

        $message = $config::word_filter($message);

        return messaged::send_message($tomember, $frommember, $message, $filetype, $filename);
    }

    public static function receive_message($member, $get_unseen = 0)
    {
        $config = new config();

        //$messages = config::word_filter($messages);
        $messages = messaged::receive_message($member);
        
        require_once "../model/profiled.php";

        if (count($messages) > 0) {
            for ($i = 0; $i < count($messages); $i++) {
                if($messages[$i]['frommemberid'] == $config->get_session_id()){
                    ?>
                    <div class="messagebox_select_box"
                         style="float: left; width: 100%; margin-bottom: 5px; border-radius: 2%;">
                        <img class="messagebox_select_img speech-bubble"
                             src="<?php echo profiled::MemberProfilePic($messages[$i]['frommemberid']); ?>"/>
                        <!--div class="messagebox_select_membername"><?php //echo profiled::MemberFullName($messages[$i]['frommemberid']);
                        ?></div-->
                        <div class="messagebox_select_message speech-bubble2"
                             style="padding: 1.125em;"><?php echo $messages[$i]['message']; ?></div>
                    </div>
                    <?php
                }else{
                    ?>
                    <div class="messagebox_select_box"
                         style="float: left; width: 100%; margin-bottom: 5px; border-radius: 2%;">
                        <img class="messagebox_select_img"
                             src="<?php echo profiled::MemberProfilePic($messages[$i]['frommemberid']); ?>"/>
                        <!--div class="messagebox_select_membername"><?php //echo profiled::MemberFullName($messages[$i]['frommemberid']);
                        ?></div-->
                        <div class="messagebox_select_message speech-bubble"
                             style="padding: 1.125em;"><?php echo $messages[$i]['message']; ?></div>
                    </div>
                    <?php
                }
            }
            ?>
            <script type="text/javascript">

                function message_member_close() {
                    $(".messagebox_close_footer_btn").click();
                }

                <?php
                if($config->get_session_id() == $messages[0]['tomemberid']){
                ?>
                $("#messagebox_header").html("<tr><td width='100%' style='text-align:center;padding:1.5em;font-weight: bold;'><img style='width: 60px; height: 60px; border-radius: 100%; margin-top:6px; margin-left:8px; position: fixed; top:0; left: 0;' src='<?php echo profiled::MemberProfilePic($messages[0]['frommemberid']); ?>' /><?php echo profiled::MemberFullName($messages[0]['frommemberid']); ?><div id='message_select_close_btn' onclick='message_member_close();'>Close</div></td></tr>");
                //$("#message_sendmessage_btn").attr("onclick", "messagebox_send_message('<?php //echo $messages[0]['frommemberid']; ?>');");

                $("#message_sendmessage_btn").attr("onclick", "messagebox_send_message('<?php echo $messages[0]['frommemberid']; ?>');");
                <?php
                }else{
                ?>
                $("#messagebox_header").html("<tr><td width='100%' style='text-align:center;padding:1.5em;font-weight: bold;'><img style='width: 60px; height: 60px; border-radius: 100%; margin-top:6px; margin-left:8px; position: fixed; top:0; left: 0;' src='<?php echo profiled::MemberProfilePic($messages[0]['tomemberid']); ?>' /><?php echo profiled::MemberFullName($messages[0]['tomemberid']); ?><div id='message_select_close_btn' onclick='message_member_close();'>Close</div></td></tr>");

                $("#message_sendmessage_btn").attr("onclick", "messagebox_send_message('<?php echo $messages[0]['tomemberid']; ?>');");
                <?php
                }
                ?>
            </script>
            <?
        } else {
            ?>
            <script type="text/javascript">
                function message_member_close() {
                    $(".messagebox_close_footer_btn").click();
                }
                $("#messagebox_header").html("<tr><td width='100%' style='text-align:center;padding:1.5em;font-weight: bold;'><img style='width: 60px; height: 60px; border-radius: 100%; margin-top:6px; margin-left:8px; position: fixed; top:0; left: 0;' src='<?php echo profiled::MemberProfilePic($member); ?>' /><?php echo profiled::MemberFullName($member); ?><div id='message_select_close_btn' onclick='message_member_close();'>Close</div></td></tr>");

                $("#message_sendmessage_btn").attr("onclick", "messagebox_send_message('<?php echo $member; ?>');");
            </script>
            <div class="messagebox_select_box" style="float: left; display: none; width: 100%; margin-bottom: 5px; border-radius: 2%;">
                <img class="messagebox_select_img" style="display: none;"
                     src=""/>

                <div class="messagebox_select_message" style="display: none;"
                     style="padding: 1.125em;"></div>
            </div>
            <?php
        }
    }

    public static function unseen_message_count($parentid)
    {
        return messaged::unseen_message_count($parentid);
    }

    public static function set_seen_message($tomemberid, $frommemberid)
    {
        return messaged::set_seen_message($tomemberid, $frommemberid);
    }

    public static function delete_message($messageid)
    {
        return messaged::delete_message($messageid);
    }

    public static function block_member($PARENTID, $MEMBERID)
    {
        return messaged::block_member($PARENTID, $MEMBERID);
    }

    public static function unblock_member($PARENTID, $MEMBERID)
    {
        return messaged::unblock_member($PARENTID, $MEMBERID);
    }

    public static function receive_new_message($tomemberid, $frommemberid)
    {

        $messages = messaged::receive_new_message($tomemberid, $frommemberid);
        $config = new config();
        $messages_length = 0;
        //if (count($messages) > 0) {


        if ($config->get_session_id() != $messages[$messages_length]['frommemberid'] && $messages[$messages_length]['message'] != "") {
            ?>
            <div id="messagebox_select_box<?php echo $messages[$messages_length]['frommemberid']; ?>"
                 class="messagebox_select_box"
                 style="float: left; width: 100%; margin-bottom: 5px; border-radius: 2%;">
                <img class="messagebox_select_img"
                     src="<?php echo profiled::MemberProfilePic($messages[$messages_length]['frommemberid']); ?>"/>
                <div class="messagebox_select_message speech-bubble"
                     style="padding: 1.125em;"><?php echo $messages[$messages_length]['message']; ?></div>
            </div>
            <?php
        } elseif ($messages[$messages_length]['message'] != "") {
            ?>
            <?php if (self::$MESSAGE_UNSEEN == $messages[$messages_length]['status']) {
                ?>
                <script type="text/javascript">
                    //$("#messagebox_header").html("<tr><td style='text-align:center;' width='20%'><img width='50' src='<?php //echo profiled::MemberProfilePic($messages[0]['frommemberid']);   ?>' /></td><td width='80%;' style='text-align:center;'><?php echo profiled::MemberFirstName($messages[$messages_length]['tomemberid']); ?></td></tr>");
                    $("#messagebox_select_box<?php echo $messages[$messages_length]['messageid']; ?>").css("font-weight", "bolder");
                </script>
            <?php }
            ?>
            <div id="messagebox_select_box<?php echo $messages[$messages_length]['frommemberid']; ?>"
                 class="messagebox_select_box"
                 style="float: left; width: 100%; margin-bottom: 5px; border-radius: 2%;">
                <img class="messagebox_select_img"
                     src="<?php echo profiled::MemberProfilePic($messages[$messages_length]['frommemberid']); ?>"/>
                <div class="messagebox_select_message speech-bubble2"
                     style="padding: 1.125em;"><?php echo $messages[$messages_length]['message']; ?></div>
            </div>
            <?php
        }

        //}
    }

    public static function history($parentid)
    {
        $messages = messaged::history($parentid);
        $config = new config();
        $count = 0;

        for ($i = 0; $i < count($messages); $i++) {
            if (friend::is_block($config->get_session_id(), $messages[$i]['frommemberid']) !== true) {
                if ($config->get_session_id() != $messages[$i]['frommemberid']) {
                    ?>
                    <div class="messagebox_inboxbar"
                         onclick="messagebox_select_memberbox('<?php echo $messages[$i]['frommemberid']; ?>');">
                        <img class="messagebox_inbox_img"
                             src="<?php echo profiled::MemberProfilePic($messages[$i]['frommemberid']); ?>" width="50"/>
                        <div class="messagebox_inbox_membername"><?php echo profiled::MemberFullName($messages[$i]['frommemberid']); ?></div>
                        <div class="messagebox_inbox_message"><strong><?php echo $messages[$i]['message']; ?></strong>
                        </div>
                    </div>
                    <?php
                    $count++;
                } elseif (friend::is_block($config->get_session_id(), $messages[$i]['tomemberid']) !== true) {
                    ?>
                    <?php if (self::$MESSAGE_UNSEEN == $messages[$i]['status']) {
                        ?>
                        <script type="text/javascript">
                            $("#messagebox_inbox<?php echo $messages[$i]['messageid']; ?>").css("font-weight", "bolder");
                        </script>
                    <?php }
                    ?>
                    <div id="messagebox_inbox<?php echo $messages[$i]['messageid']; ?>" class="messagebox_inboxbar"
                         onclick="messagebox_select_memberbox('<?php echo $messages[$i]['tomemberid']; ?>');">
                        <img class="messagebox_inbox_img"
                             src="<?php echo profiled::MemberProfilePic($messages[$i]['tomemberid']); ?>" width="50"/>
                        <div class="messagebox_inbox_membername"><?php echo profiled::MemberFullName($messages[$i]['tomemberid']); ?></div>
                        <div class="messagebox_inbox_message"><?php echo "From you: " . $messages[$i]['message']; ?></div>
                    </div>
                    <?php
                    $count++;
                }
            }
        }

        if ($count == 0) {
            ?>
            <div class="messagebox_inboxbar">
                <div class="messagebox_inbox_message" style="width: 100%; font-weight: bold;">
                    Your inbox is currently empty select "My friend" at the bottom of the screen, from there you can
                    select a friend to send a message to.<br><br>
                    Note: You can message with friend only.
                </div>
            </div>
            <?php
        }
    }

    public static function create_messageox($parentid, $messages = [], $friends = [], $mode)
    {
        if ($mode == "intro") {
            ?>
            <div id="messagebox">

            </div>
            <?php
            //self::messagebox_footer();
        }

        if ($mode == "inbox") {

        }

        if ($mode == "friends") {

        }

        if ($mode == "camera") {

        }
    }

    private static function messagebox_footer()
    {
        ?>
        <div id="messagebox_footer">
            <table>
                <tr>
                    <td>
                        <img style="" src="image/inbox_icon.png"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        Mailbox
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td>
                        <img style="" src="image/camera-icon.png"/>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td>
                        <img style="" src="image/friend_request_icon.png"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        Friend
                    </td>
                </tr>
            </table>
        </div>
        <?php
    }

}
