<?php
/**
 * Created by PhpStorm.
 * User: jermainedurham
 * Date: 8/29/18
 * Time: 3:04 PM
 */
session_start();
require_once "model/profiled.php";
require_once "model/friendd.php";
require_once "core/friend.php";

require "inner_header.php";

require_once "core/config.php";

$config   = new config();
$memberid = $config->get_session_id();

?>
<div id="account_setting_title">Account Settings</div>
<table id="account_setting_header_btn">
    <tr>
        <td class="account_setting_btn" onclick="goto_page('account-setting?page=account-information');">
            Account Info
        </td>
        <td class="account_setting_btn" onclick="goto_page('account-setting?page=block');">
            Block
        </td>
        <td class="account_setting_btn" onclick="goto_page('account-setting?page=login');">
            Login
        </td>
    </tr>
</table>
<?php
if ($_GET['page'] != "") {
    $pagename = $_GET['page'];
    if ($pagename == "account-information") {
        ?>
    <script type="text/javascript">
        $(".account_setting_btn:eq(0)").css("border", "1px black solid");

        var city = "";
        var state = "";
        var country = "";

        function save_mode(mode) {
            switch (mode) {
                case "first":

                    city = $("#account_setting_input_edit").attr("value");
                    $.post("include/account_setting_core.php", {update_member_city: city}, function(){

                    });
                    break;

                case "last":

                    break;

                case "city":

                    break;

                case "state":

                    break;

                case "country":

                    break;
            }
        }

        function edit_info(mode) {
            switch (mode) {
                case "first":

                    break;

                case "last":

                    break;

                case "city":
                    city = $(".account_setting_row2:eq(2)").html();
                    $(".account_setting_row2:eq(2)").html("<input type='text' id='account_setting_input_edit' value='" + city + "' />");
                    $("#account_setting_input_edit").focus();
                    $(".account_setting_edit_btn:eq(2)").html("Save");
                    $(".account_setting_edit_btn:eq(2)").attr("onclick", "save_mode('city');");
                    break;

                case "state":
                    state = $(".account_setting_row2:eq(3)").html();
                    $(".account_setting_row2:eq(3)").html("<input type='text' id='account_setting_input_edit' value='" + state + "' />");
                    $("#account_setting_input_edit").focus();
                    $(".account_setting_edit_btn:eq(3)").html("Save");
                    $(".account_setting_edit_btn:eq(3)").attr("onclick", "save_mode('state');");
                    break;

                case "country":
                    country = $(".account_setting_row2:eq(4)").html();
                    $(".account_setting_row2:eq(4)").html("<input type='text' id='account_setting_input_edit' value='" + country + "' />");
                    $("#account_setting_input_edit").focus();
                    $(".account_setting_edit_btn:eq(4)").html("Save");
                    $(".account_setting_edit_btn:eq(4)").attr("onclick", "save_mode('country');");
                    break;
            }
        }
    </script>
    <div id="account_settingbox">
        <table id="account_setting_tb">
            <tr>
                <td class="account_setting_row1">First</td>
                <td class="account_setting_row2"><?php echo profiled::MemberFirstName($config->get_session_id()); ?></td>
                <td>
                    <div class="account_setting_edit_btn">Edit</div>
                </td>
            </tr>
            <tr>
                <td class="account_setting_row1">Last</td>
                <td class="account_setting_row2"><?php echo profiled::MemberLastName($memberid); ?></td>
                <td>
                    <div class="account_setting_edit_btn">Edit</div>
                </td>
            </tr>
            <tr>
                <td class="account_setting_row1">City</td>
                <td class="account_setting_row2"><?php echo profiled::MemberCityName($memberid); ?></td>
                <td>
                    <div class="account_setting_edit_btn" onclick="edit_info('city');">Edit</div>
                </td>
            </tr>
            <tr>
                <td class="account_setting_row1">State</td>
                <td class="account_setting_row2"><?php echo profiled::MemberRegionName($memberid); ?></td>
                <td>
                    <div class="account_setting_edit_btn" onclick="edit_info('state');">Edit</div>
                </td>
            </tr>
            <tr>
                <td class="account_setting_row1">Country</td>
                <td class="account_setting_row2"><?php echo profiled::MemberCountryName($memberid); ?></td>
                <td>
                    <div class="account_setting_edit_btn" onclick="edit_info('country');">Edit</div>
                </td>
            </tr>
        </table>
    </div>
    <?php
}
    if ($pagename == "block") {
        ?>
<script type="text/javascript">
    $(".account_setting_btn:eq(1)").css("border", "1px black solid");

    $("#friend_list_box").height($(document).height());

    load_block_list();
</script>
<div id="account_settingbox">
    <div class="account_setting_title1">Block Member</div>
    <div class="account_setting_info">Here you have the option to block people from viewing your profile,
        sending you a friend request and viewing your post. Also blocking them from messaging you.
    </div>

    <div class="account_setting_block_tb">
        <table id="account_setting_bl_user_tb">
            <tr>
                <td>
                    <input type="text" style="font-size: 12px; display: none;" id="block_member_name"
                           placeholder="Click here to select member"/>
                    <div id="account_setting_block_member_btn" onclick="select_friend();">Select Member</div>
                </td>
            </tr>
        </table>
        <div id="account_setting_block_list">

        </div>

    </div>

    <!--div class="account_setting_title1">Block people from messaging you</div>
            <div class="account_setting_info">Here you have the option to block people from sending you messages.</div>
            <div class="account_setting_block_tb">
                <table id="account_setting_blm_user_tb">
                    <tr>
                        <td>
                            <input type="text" style="font-size: 12px;" id="block_member_message_name"
                                   placeholder="Click here to select member"/>
                            <div id="account_setting_block_message_btn">Block</div>
                        </td>
                    </tr>
                </table>

            </div>
        </div-->
        <?php
}

    if ($pagename == "login") {
        ?>
        <script type="text/javascript">
            $(".account_setting_btn:eq(2)").css("border", "1px black solid");
        </script>
        <?php
}
}

if ($pagename == "login") {
    ?>
    <div id="account_setting_tb">
        <div id="account_setting_title" style="font-size: 16px; border-bottom: 1px black solid;">2 Way Login</div>
        <div class="account_setting_info"></div>
    </div>
    <?php
}
?>
</div>
