<?php
/**
 * .
 * User: Jermaine Durham
 * Date: 7/2/18
 * Time: 8:15 AM
 */
require "core/header.php";
?>
<script type="text/javascript" src="js/friend_inc.js"></script>
<script type="text/javascript" src="js/post_inc.js"></script>
<script type="text/javascript" src="js/notification_inc.js"></script>
<script type="text/javascript" src="js/message_inc.js"></script>
<script type="text/javascript" src="js/profilebox_inc.js"></script>

<script type="text/javascript">
    function show_camera(){
        //app.Camera();
    }

    function toogle_menu() {
        $("#sidemenu").slideToggle();
    }

    function menu_show() {
        $("#sidemenu").fadeIn();
        $("#menu_btn").attr("onclick", "menu_hide();");
    }

    function menu_hide() {
        $("#sidemenu").fadeOut();
        $("#menu_btn").attr("onclick", "menu_show();");
    }

    function goto_myprofile() {
        location = "myprofile";
    }

    function goto_page(page) {
        location = page;
    }

    $(function () {
        start_friend_interval();
    });

    $(document).ready(function () {
        $("#block_screen").height($(this).height());
        $("#sidemenu").css("height", $(this).height() - $("#header").height() + "px");
        $("#sidemenu").css("margin-top", $("#header").height() + "px");

        $("#notification_tb").css("height", $(this).height() - $("#header").height() + "px");
        $("#notification_tb").css("margin-top", $("#header").height() + "px");
        $("#messagebox").css("height", $(this).height() + "px");

        //$("#post_popup_box").css("height", $(this).height() - $("#header").height() + "px");
        //$("#post_popup_box").css("margin-top",  $("#header").height() + "px");
    });


</script>

<div id="header">
    <div id="block_screen"></div>
    <table id="post_option_tb"></table>
    <table id="post_like_tb"></table>


    <div id="post_popup_box"></div>

    <div id="notification_tb">
        <div id="notification_close_btn" onclick="notification_hide();">Close</div>
        <div id="notification_title">Notification</div>
        <div id="notification_item"></div>
    </div>

    <?php $header = new header(); ?>

    <table id="menu_btn_panel">
        <tr>
            <td style="text-align: left;">
                <div id="menu_btn" onclick="menu_show();">Menu</div>
            </td>
            <td>
                <a href="home" target="_parent"><img src="image/home-512.png"/></a>
            </td>
            <td>
                <a href="myfriends?request=1"><img src="image/friend_request_icon.png"/>
                    <div id="friend_header_request_pl"></div>
                </a>
            </td>
            <td onclick="messagebox_show();">
                <a href="javascript:void(0);"><img src="image/message-icon.png"/>
                    <div id="message_alert" class=""></div>
                </a>
            </td>

            <!--td onclick="show_camera();">
                <a href="javascript:void(0);"><img src="image/camera-icon.png"/></a>
            </td-->

            <td style="padding-right: 12px;" id="notification_menu_btn" onclick="notification_show();">
                <a href="javascript:void(0);"><img src="image/notification_icon.png"/>
                    <span id="notification_count_unseen_alert"></span>
                </a>
            </td>
        </tr>
    </table>
    <div id="sidemenu" class="table">
        <div class="" onclick="goto_myprofile();">
            <span style="position: absolute; margin-left: 12px; left: 0;">
                <img src="image/no-profile-picture-male.jpg"/>
            </span>
            My Profile
        </div>

        <div class="" onclick="goto_page('myfriends');">

            <span style="position: absolute; margin-left: 12px; left: 0;">
                <img src="image/friend_request_icon.png"/>
            </span>
            Friends
            <span class="friends_request_count"></span>
        </div>

        <div onclick="goto_page('account-setting?page=account-information');">
            <span style="position: absolute; margin-left: 12px; left: 0;">
                <img src="image/account-setting-ico.png"/>
            </span>
            Settings
        </div>

        <div class="" onclick="goto_page('search');">
            <span style="position: absolute; margin-left: 12px; left: 0;">
                <img src="image/search-icon-png-9985.png"/>
            </span>
            Search
        </div>

        <div class="" onclick="goto_page('events');">
            <span style="position: absolute; margin-left: 12px; left: 0;">
                <img src="image/calendar_icon.png"/>
            </span>
            Events
        </div>
        <a href="logout">
            <div class="">
                <span style="position: absolute; margin-left: 12px; left: 0;">
                    <img src="image/logout-icon.png"/>
                </span>
                Logout
            </div>
        </a>
        <div class="">
            <a href="javascript:void(0);">Privacy</a>
        </div>
        <div style="text-align: center;">
            <a href="javascript:void(0);">Terms & Condtions</a>
        </div>
        <div style="text-align: center;">
            <strong>All Rights Reserved Laughafy &copy; 2018</strong>
        </div>
    </div>
</div>
</div>
