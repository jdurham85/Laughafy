<?php
/**
 * .
 * User: Jermaine Durham
 * Date: 7/29/18
 * Time: 12:55 AM
 */

require_once "model/profiled.php";
require_once "model/friendd.php";
require_once "core/friend.php";

require "inner_header.php";

require_once "core/config.php";

$config = new config();

$profileid = $_GET['userid'];

$member_info = new namespace\profiled();

if (friend::is_block($config->get_session_id(), $profileid)) {
    ?>
    <table class="profiletb">
        <tr>
            <td style="text-align: center;">
                <img style="border-radius: 100%; height: 200px; width: 200px;" src="image/unavailabel_icon.png"
                     width="160"/>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold; font-size: 16px; padding:1em;">
                Profile Unavailable, Try again later.
            </td>
        </tr>
    </table>
    <?php
    exit;
} elseif (friend::IS_FRIEND($profileid, $config->get_session_id()) === false) {
    ?>
    <table class="profiletb">
        <tr>
            <td style="text-align: center;">
                <img src="<?php echo $member_info::MemberProfilePic($profileid); ?>" width="160"/>
            </td>
        </tr>
        <tr style="border-bottom: 2px black solid;">
            <td style="text-align: center; font-size: 16px; font-family: 'Arial Black';">
                <?php echo $member_info::MemberFullName($profileid); ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; padding: 1.125em;">
                <?php echo $member_info::MemberFullName($profileid); ?> profile is private.
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                <table class="member_friend_tb" style="float: left; width: 100%;">
                    <tr>
                        <td style="text-align: center;">
                            <button onclick="send_friend_request(<?php echo $profileid; ?>);"
                                    id="send_request_btn<?php echo $profileid; ?>"
                                    style="background-color: black; width:50%; border-radius: 6px; height: 40px; color: white;">
                                Add Friend
                            </button>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <?php
    exit();
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        $.post("include/post_core.php", {load_friend_post: <?php echo $profileid; ?>}, function (feed) {
            //console.log(feed);
            $("#post_box_insert_first").append(feed);
        });
    });
</script>
<table class="profiletb">
    <tr>
        <td style="text-align: center;">
            <img style="border-radius: 100%; height: 200px; width: 200px;"
                 src="<?php echo $member_info::MemberProfilePic($profileid); ?>" width="160"/>
        </td>
    </tr>
    <tr style="border-bottom: 2px black solid;">
        <td style="text-align: center; font-size: 16px; font-family: 'Arial Black';">
            <?php echo $member_info::MemberFullName($profileid); ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: center; padding:1em;">
            <div onclick="messagebox_leave_message('<?php echo $profileid; ?>');"
                 style="text-align: center; padding:0.5em; border:1px black solid;"><img src="image/message-icon.png"
                                                                                         width="30"/>Send <?php echo " " . profiled::MemberFirstName($profileid) . " a message"; ?>
            </div>
        </td>
    </tr>
</table>
<table class="profiletb" style="margin-top: 5px;">
    <tr>
        <td width="50%" align="center" onclick="goto_page('photo?userid=<?php echo $profileid; ?>')">
            <button class="btn font-weight-bold" style="width: 90%;">Photos</button>
        </td>
        <td width="50%" align="center">
            <button class="btn font-weight-bold" style="width: 90%;">Videos</button>
        </td>
    </tr>
</table>
<table id="profile_info_tb">
    <tr>
        <td>
            <span style="font-weight: bold;">22,233</span>
            Posts
        </td>
        <td>
            <span style="font-weight: bold;"></span>
            Friends
        </td>
    </tr>
</table>
<div id="post_box_insert_first"></div>
