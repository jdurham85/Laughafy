<?php

/**
 * Created by PhpStorm.
 * User: Jermaine Durham
 * Date: 8/27/18
 * Time: 3:38 PM
 */
class header
{

    public function __construct()
    {
        self::messagebox();
        self::friend_list_box();
        self::member_photo_viewer();
        self::post_comment_box();
        self::member_photo_option_menu();
    }

    public static function messagebox()
    {
        $config = new config();
        ?>
        <table id="messagebox_header_1" style="width: 100%; display: none; border-bottom: 2px black solid; float: left;"
               cellspacing="5" cellpadding="5">
            <tr>
                <td style="width: 20%; text-align: center;">
                    <img src="<?php profiled::MemberProfilePic($config->get_session_id()); ?>"
                         style="text-align: center; border-radius: 100%; border: 1px black solid; width: 50px; height: 50px;"/>
                </td>
                <td style="width: 80%; text-align: center;">
                    <input type="text" placeholder="Search"
                           style="width: 100%; border-radius: 20px; font-size: 12px; padding:1em; border: 1px black solid; float: left;"/>
                </td>
            </tr>
        </table>
        <div id="messagebox">
            <table id="messagebox_header" style="width: 100%; border-bottom: 2px black solid; float: left;"
                   cellspacing="5" cellpadding="5">
                <tr>
                    <td style="width: 20%; text-align: center;">
                        <img src="<?php profiled::MemberProfilePic($config->get_session_id()); ?>"
                             style="text-align: center; border-radius: 100%; border: 1px black solid; width: 50px; height: 50px;"/>
                    </td>
                    <td style="width: 80%; text-align: center;">
                        <input type="text" placeholder="Search"
                               style="width: 100%; border-radius: 20px; font-size: 12px; padding:1em; border: 1px black solid; float: left;"/>
                    </td>
                </tr>
            </table>
            <div id="messagebox_body">

            </div>

            <div class="messagebox_member">
                <div id="message_select_footer">
                    <input type="text" placeholder="Write here..." id="message_inputbox"/>
                    <div id="message_sendmessage_btn">Send</div>
                </div>
            </div>


            <div id="messagebox_footer">
                <table class="messagebox_inbox_footer_btn" onclick="messagebox_refresh();">
                    <tr>
                        <td style="text-align: center;">
                            <img style="" src="image/comment-icon.png"/>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">
                            Mailbox
                        </td>
                    </tr>
                </table>
                <table class="messagebox_friend_footer_btn" onclick="messagebox_load_friend();">
                    <tr>
                        <td style="text-align: center;">
                            <img style="" src="image/friend_request_icon.png"/>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">
                            My Friend
                        </td>
                    </tr>
                </table>
                <table class="messagebox_close_footer_btn" id="message_member_close_btn" onclick="messagebox_hide();">
                    <tr>
                        <td style="text-align: center;">
                            <img style="" src="image/logout-icon.png"/>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">
                            Close
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <?php
    }

    public static function friend_list_box()
    {
        ?>
        <div id="friend_list_box">
            <div id="friend_list_close_box_btn" onclick="friend_list_box_close();">Close</div>
        </div>
        <?php
    }

    public static function post_comment_box()
    {
        ?>
        <div id="post_comment_box">
            <div class="post_comment_header_bar">Comment
                <span class="post_comment_close_btn" id="post_comment_close_btn"
                      onclick="wall_comment_close();">Close</span>
            </div>
            <div id="post_comment_insert" style="">
                <img width='60' style='margin: auto; position: fixed; top: 0; right: 0; left: 0; bottom: 0;'
                     src='image/loading_img.gif'/></div>
            <div class="post_comment_footer">
                <input placeholder="Write your comment here..." type="text" id="post_user_comment_input"
                       class="post_user_comment_input"/>
                <div id="post_user_comment_btn" onclick="save_wall_comment_post();">POST
                </div>
            </div>
        </div>
        <?php
    }

    static function member_photo_viewer()
    {
        ?>
        <div id="member_photo_viewer">
            <div height="40">
                <div id="member_photo_viewer_close_btn" onclick="member_photo_viewer_close();">Close</div>
                <div id="member_photo_viewer_option_btn">Option</div>
            </div>
            <div>
                <div id="member_photo_viewer_title"></div>
            </div>

            <div style="width: 100%; float: left; padding: 1.125em; text-align: center;">
                <img id="member_photo_viewer_img" src="image/loading_img.gif"/>
            </div>
            <div id="member_photo_viewer_description" style=" line-height: 30px;">

            </div>
        </div>
        <?php
    }

    static function member_photo_option_menu()
    {
        ?>
        <div id="member_photo_option_menu">
            <?php
            if ($_GET['userid'] != "") {
                ?>
                <div style="font-weight: bold; text-align: center;">Please choose one of the following options:</div>
                <div id="member_photo_viewer_option_close_btn" class="btn-block"
                     onclick="member_photo_viewer_option_menu_close();">Cancel
                </div>
                <div id="member_photo_option_download_btn">Download</div>
                <?php
            } else {
                ?>
                <div style="font-weight: bold; text-align: center;">Please choose one of the following options:</div>
                <div id="member_photo_viewer_option_close_btn" class="btn-block"
                     onclick="member_photo_viewer_option_menu_close();">Cancel
                </div>
                <div id="member_photo_viewer_edit_btn">Edit Description</div>
                <div id="member_photo_viewer_set_profile_picture_btn" onclick="set_profile_picture()">Set Profile Picture
                </div>
                <div id="member_photo_viewer_delete_btn">Delete Photo</div>
                <div>Post Photo</div>
                <div id="member_photo_option_download_btn">Download</div>
                <?php
            }
            ?>
        </div>
        <?php
    }

}
