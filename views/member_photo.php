<?php

/**
 * Created by PhpStorm.
 * User: Jermaine Durham
 * Date: 8/17/18
 * Time: 11:42 PM
 */
class member_photo
{
    private static $CURRENT_MEMBER = false;

    function __construct($memberid = "")
    {
        $configfile = (file_exists("config.php") ? true : false);

        if ($configfile == TRUE) {
            require_once "config.php";
        } elseif (file_exists("core/config.php")) {
            require_once "core/config.php";
        } else {
            require_once "../core/config.php";
        }

        require_once "model/profiled.php";
        //require "model/friendd.php";

        require "inner_header.php";

        $config = new config();

        if ($memberid == "") {
            self::$CURRENT_MEMBER = true;
            self::load_photo($config->get_session_id());
        } else {
            self::load_photo($memberid);
        }
    }

    public static function load_photo($memberid)
    {
        if (self::$CURRENT_MEMBER) {
            //current member
            require_once "model/profiled.php";
            require_once "model/friendd.php";
            $member_info = new namespace\profiled();
            ?>
            <table class="profiletb">
                <tr>
                    <td style="text-align: center;">
                        <img src="<?php echo $member_info::MemberProfilePic($memberid); ?>"
                             width="160"/>
                    </td>
                </tr>
                <tr style="border-bottom: 2px black solid;">
                    <td style="text-align: center; font-size: 16px; font-family: 'Arial Black';">
                        <?php echo $member_info::MemberFullName($memberid); ?>
                    </td>
                </tr>
            </table>
            <table class="profiletb" style="margin-top: 5px;">
                <tr>
                    <td width="50%" align="center">
                        <a href="myprofile" target="_self">
                            <button class="btn font-weight-bold" style="width: 90%;">Profile</button>
                        </a>
                    </td>
                    <td width="50%" align="center">
                        <button class="btn font-weight-bold" style="width: 90%;">Videos</button>
                    </td>
                </tr>
            </table>
            <div id="photo_add_btn">
                <img src="image/camera-icon.png" width="40" height="40"/>
                <div id="photo_title_btn">Add Photo</div>
            </div>
            <?php
            self::photoview();
        } else {
            //GUEST VIEW
            require_once "model/profiled.php";
            require_once "model/friendd.php";
            $member_info = new namespace\profiled();

            $profileid = $memberid;
            ?>
            <table class="profiletb">
                <tr>
                    <td style="text-align: center;">
                        <img style="border-radius: 100%; height: 200px; width: 200px;" src="<?php echo $member_info::MemberProfilePic($memberid); ?>" />
                    </td>
                </tr>
                <tr style="border-bottom: 2px black solid;">
                    <td style="text-align: center; font-size: 16px; font-family: 'Arial Black';">
                        <?php echo $member_info::MemberFullName($memberid); ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center; padding:1em;">
                        <div onclick="messagebox_leave_message('<?php echo $profileid; ?>');" style="text-align: center; padding:0.5em; border:1px black solid;"><img src="image/message-icon.png" width="30" />Send <?php echo " " . profiled::MemberFirstName($profileid) . " a message"; ?></div>
                    </td>
                </tr>
            </table>
            <table class="profiletb" style="margin-top: 5px;">
                <tr>
                    <td width="50%" align="center">
                        <a href="profile?userid=<?php echo $memberid; ?>" target="_self">
                            <button class="btn font-weight-bold" style="width: 90%;">Profile</button>
                        </a>
                    </td>
                    <td width="50%" align="center">
                        <button class="btn font-weight-bold" style="width: 90%;">Videos</button>
                    </td>
                </tr>
            </table>
            <script type="text/javascript">
                function load_member_photos() {
                    $.post("include/member_photo_core.php", {load_member_photo: <?php echo $memberid; ?>}, function (result) {
                        $("#photo_view").append(result);
                    });
                }

                function set_profile_picture(filename) {
                    $.post("include/member_photo_core.php", {set_profile_picture: filename}, function (result) {
                        location = location;
                        //console.log(result);
                    });
                }

                function delete_picture(fileid, filename) {
                    $.post("include/member_photo_core.php", {
                        photo_delete: true,
                        fileid: fileid,
                        filename: filename
                    }, function (result) {
                        $("#member_photo_tb" + fileid).fadeOut(function () {
                            $(this).remove();
                        });
                    });

                    member_photo_viewer_option_menu_close();
                    member_photo_viewer_close();

                    location = location;
                }

                function member_photo_viewer_option_menu_show(fileid) {

                    $("#member_photo_option_menu").fadeIn();

                }

                function member_photo_viewer_option_menu_close() {

                    $("#member_photo_option_menu").fadeOut();

                }

                function member_photo_viewer_show(fileid, filename, imgsrc, description, membername) {
                    $("#block_screen").fadeIn(function () {
                        $("#member_photo_viewer").fadeIn(function () {
                            $("#member_photo_viewer_title").html(membername);
                            $("#member_photo_viewer_option_btn").attr("onclick", "member_photo_viewer_option_menu_show('" + fileid + "');");
                            $("#member_photo_viewer_set_profile_picture_btn").attr("onclick", "set_profile_picture('" + filename + "');");
                            $("#member_photo_viewer_delete_btn").attr("onclick", "delete_picture('" + fileid + "', '" + filename + "');");
                            $("#member_photo_viewer_img").attr("src", imgsrc);
                            $("#member_photo_viewer_description").html(description);
                        });
                    });
                }

                function member_photo_viewer_close() {
                    $("#block_screen").fadeOut(function () {
                        $("#member_photo_viewer").fadeOut(function () {
                            $("#member_photo_viewer_title").html("");
                            $("#member_photo_viewer_img").attr("src", "image/loading_img.gif");
                            $("#member_photo_viewer_description").html("");
                        });
                    });
                }

                $(document).ready(function (event) {

                    //setTimeout(function(){
                    load_member_photos();
                    //}, 2000);

                    $("#member_photo_viewer").height($(this).height());
                    $("#member_photo_option_menu").height($(this).height());
                });
            </script>
            <div id="photo_view">

            </div>
            <?php
        }
    }

    private static function photoview()
    {
        require_once "core/config.php";
        $config = new config();

        ?>
        <script type="text/javascript">
            function load_member_photos() {
                $.post("include/member_photo_core.php", {load_member_photo: <?php echo $config->get_session_id(); ?>}, function (result) {
                    $("#photo_view").append(result);
                    console.log(result);
                });
            }

            function set_profile_picture(filename) {
                $.post("include/member_photo_core.php", {set_profile_picture: filename}, function (result) {
                    location = location;
                    //console.log(result);
                });
            }

            function delete_picture(fileid, filename) {
                $.post("include/member_photo_core.php", {
                    photo_delete: true,
                    fileid: fileid,
                    filename: filename
                }, function (result) {
                    $("#member_photo_tb" + fileid).fadeOut(function () {
                        $(this).remove();
                    });
                });

                member_photo_viewer_option_menu_close();
                member_photo_viewer_close();

                location = location;
            }

            function member_photo_viewer_option_menu_show(fileid) {

                $("#member_photo_option_menu").fadeIn();

            }

            function member_photo_viewer_option_menu_close() {

                $("#member_photo_option_menu").fadeOut();

            }

            function member_photo_viewer_show(fileid, filename, imgsrc, description, membername) {
                $("#block_screen").fadeIn(function () {
                    $("#member_photo_viewer").fadeIn(function () {
                        $("#member_photo_viewer_title").html(membername);
                        $("#member_photo_viewer_option_btn").attr("onclick", "member_photo_viewer_option_menu_show('" + fileid + "');");
                        $("#member_photo_viewer_set_profile_picture_btn").attr("onclick", "set_profile_picture('" + filename + "');");
                        $("#member_photo_viewer_delete_btn").attr("onclick", "delete_picture('" + fileid + "', '" + filename + "');");
                        $("#member_photo_viewer_img").attr("src", imgsrc);
                        $("#member_photo_viewer_description").html(description);
                    });
                });
            }

            function member_photo_viewer_close() {
                $("#block_screen").fadeOut(function () {
                    $("#member_photo_viewer").fadeOut(function () {
                        $("#member_photo_viewer_title").html("");
                        $("#member_photo_viewer_img").attr("src", "image/loading_img.gif");
                        $("#member_photo_viewer_description").html("");
                    });
                });
            }

            $(document).ready(function (event) {

                //setTimeout(function(){
                load_member_photos();
                //}, 2000);

                $("#member_photo_viewer").height($(this).height());
                $("#member_photo_option_menu").height($(this).height());

                $("#file").on("change", function () {
                    if ($(this).val().length > 0) {
                        $("#photo_upload_frm").slideToggle(function () {
                            $("#photo_upload_btn").fadeIn();
                        });
                    }
                });

                $("#photo_add_btn").click(function () {
                    $("#file").click();
                });


                $("#photo_upload_frm").submit(function (event) {
                    event.preventDefault();
                });

                $("#photo_upload_btn").click(function () {
                    $.ajax({
                        url: "include/member_photo_core.php", // Url to which the request is send
                        type: "POST",             // Type of request to be send, called as method
                        data: new FormData($("#photo_upload_frm")[0]), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                        contentType: false,       // The content type used when sending data to the server.
                        cache: false,             // To unable request pages to be cached
                        processData: false,        // To send DOMDocument or non processed data file it is set to false
                        success: function (m) {
                            console.warn(m);
                            //if (m == "SUCCESS") {
                            $("#file").val("");
                            $("#photo_description_txt").val("");

                            $("#photo_upload_btn").html("Upload has been success");
                            $("#photo_upload_btn").css("color", "white");
                            $("#photo_upload_btn").css("background-color", "black");
                            $("#photo_upload_btn").attr("disable", "disable");

                            setTimeout(function () {
                                $("#photo_upload_btn").html("Upload");
                                $("#photo_upload_btn").css("background-color", "gray");
                                $("#photo_upload_btn").attr("enable", "enable");

                                $("#photo_upload_frm").slideToggle(function () {
                                    $("#photo_upload_btn").fadeOut();
                                });
                            }, 4000);
                            //}
                        },
                        error: function (m) {
                            console.error("ERROR" + m);
                        }
                    });
                });
            });
        </script>
        <!--div id="photo_upload_pl"-->
        <form id="photo_upload_frm" name="photo_upload_frm" enctype="multipart/form-data" method="post">
            <input type="file" name="file" id="file"/>
            <textarea id="photo_description_txt" name="photo_description_txt" maxlength="256"
                      placeholder="Write here....description"></textarea>
            <input type="hidden" name="member_photo_data" value="TRUE"/>
        </form>
        <div id="photo_upload_btn">
            Upload
        </div>
        <div id="photo_view">

        </div>
        <!--/div-->
        <?php
    }
}