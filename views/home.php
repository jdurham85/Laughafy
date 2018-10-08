<?php
/**
 * .
 * User: Jermaine Durham
 * Date: 7/3/18
 * Time: 11:01 AM
 */
require_once "model/profiled.php";
require_once "core/session_cookie_managerment.php";
require "inner_header.php";

$member_info = new profiled();
?>
<style>
    #galleryview img {
        float: left;
        width: 100%;
    }

    .imagebox {
        width: 32%;
        float: left;
        margin: 4px .6% auto;
    }

    .image_btn_post {
        margin-top: 5px;
        background-color: white;
        font-weight: bold;
        border-radius: 8px;
        float: left;
        width: 100%;
        border: 2px black solid;
    }

    #post_link_tb{
        display: none;
    }
</style>
<script type="text/javascript">
    function opengallery_post_fm() {
        //app.makeToast();
        //return false;
        show_create_post_tb();
        //app.show_create_post_tb();
    }

    function show_create_post_tb() {
        $("#post_insert_tb").fadeOut(function() {
            $("#post_box_insert_first").fadeOut(function() {
                $("#form1").fadeIn();
            });

        });
    }

    function show_post_insert_tb() {
        $("#form1").fadeOut(function() {
            $("#post_insert_tb").fadeIn();
            $("#post_box_insert_first").fadeIn();
            clear_post_tmp_data();
        });
    }

    function delete_image(id, filename) {
        $.post("include/tmp_file_upload.php", {filename: filename, fileid: id}, function() {
            $("#imagebox" + id).fadeOut(function() {
                $(this).remove();
            });
        });
    }

    function clear_post_tmp_data() {

        var fileid = "";
        var filename = ""

        $("#user_post_input").val("");

        $(".image_btn_post").each(function() {
            $(this).click();
        });

        $("#file").val("");

        //$("#galleryview").html("");
        //alert("Bye Mr. Anderson");
    }

    $(document).ready(function() {

        $("#post_box_insert_first").css("max-height", $(window).height() - 11 - $("#header").height()  + "px");

        $("#newsfeed_btn").css("background-color", "black");
        $("#newsfeed_btn").css("color", "white");
        $("#newsfeed_btn").css("font-weight", "bold");

        //Load NewsFeed
        load_feed(post_page);

        $("#photo_btn").click(function() {
            $("#file").click();
        });


        $("#file").on("change", function() {
            if ($(this).val().length > 0) {

                $.ajax({
                    url: "include/tmp_file_upload.php", // Url to which the request is send
                    type: "POST", // Type of request to be send, called as method
                    data: new FormData($("#form1")[0]), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false, // To send DOMDocument or non processed data file it is set to false
                    success: function(m) {
                        $("#galleryview").append(m);
                        $("#file").val("");
                        console.log(m);
                    },
                    error: function(m) {
                        console.error("ERROR" + m);
                    }
                });
            }
        });

        $("#form1").on("submit", function(e) {
            e.preventDefault();
        });


        $("#video_btn").click(function() {
            $("#file").click();
        });

        $("#post_btn").click(function() {

            var description = $("#user_post_input").val();

            if (description === "") {
                description = " ";
            }

            $.post("include/post_core.php", {user_post_input: description}, function(result) {
                //Add a function here to show new post

                if ($("#post_intro_message").length > 0) {
                    $("#post_intro_message").fadeOut();
                }

                load_parent_user_last_post();

                setTimeout(function() {
                    show_post_insert_tb();
                    clear_post_tmp_data();
                }, 100);
            });
        });

        $("#newsfeed_btn").click(function() {
            $("#newsfeed_btn").css("background-color", "black");
            $("#newsfeed_btn").css("color", "white");
            $("#newsfeed_btn").css("font-weight", "bold");

            $("#snap_btn").css("background-color", "white");
            $("#snap_btn").css("color", "black");
            $("#snap_btn").css("font-weight", "normal");
        });

        $("#snap_btn").click(function() {
            $("#snap_btn").css("background-color", "black");
            $("#snap_btn").css("color", "white");
            $("#snap_btn").css("font-weight", "bold");

            $("#newsfeed_btn").css("background-color", "white");
            $("#newsfeed_btn").css("color", "black");
            $("#newsfeed_btn").css("font-weight", "normal");
        });

        var set1 = $("#post_link_tb").height() + $("#post_insert_tb").height();
        var start_f = 0;

        $("#post_box_insert_first").scroll(function() {

            $(this).scrollLeft(0);

            //if($(this).scrollTop() == 0){
            //post_page++;
            //load_feed(post_page);
            //}

            //console.log($(this).scrollTop());

            //$("#post_box_insert_first").css("max-height", $(this).height() - $("#header").height() + "px");
            //console.log($("#post_link_tb").height() + $("#post_insert_tb").height());

            /*if ($(this).scrollTop() > 0) {
             $("#post_box_insert_first").css("max-height", $(window).height() - $("#header").height());


             if (start_f === 0) {
             //$("#post_box_insert_first").css("max-height", $(window).height() - $("#header").height());
             $("#post_insert_tb").fadeOut();
             $("#post_link_tb").fadeOut();


             //console.log("CLEAR");
             start_f = 1;
             }

             //console.log(start_f);

             } else {
             $("#post_insert_tb").fadeIn();
             $("#post_link_tb").fadeIn();

             $("#post_box_insert_first").css("margin-top", 0);
             //$("#post_box_insert_first").css("height", $(this).height() - $("#header").height() - $("#post_link_tb").height() - $("#post_insert_tb").height());
             //$("#post_box_insert_first").css("max-height", $(this).height() - $("#header").height() - $("#post_link_tb").height() - $("#post_insert_tb").height());
             $("#post_box_insert_first").css("max-height", $(window).height() - $("#header").height() - $("#post_link_tb").height() - $("#post_insert_tb").height() + "px");
             start_f = 0;
             //console.clear();
             }*/
        });
    });
</script>
<table id="post_link_tb" class="">
    <tr>
        <td>
            <button class="btn" id="newsfeed_btn">NewsFeed</button>
        </td>
        <td>
            <button class="btn" id="snap_btn">Snaps from Friends</button>
        </td>
    </tr>
</table>

<div id="post_box_insert_first">
    <table id="post_insert_tb" style="margin-top: 5px;">
        <tr>
            <!--td style="text-align: center;">
            <img style="width: 30px;"
                 src="<?php //echo $member_info::MemberProfilePic($_SESSION['SessionMemberID']);     ?>"/>
        </td-->
            <td style="text-align: center;">
                <input type="text" id="user_input" onclick="opengallery_post_fm();" name="user_input"
                       placeholder="Think of something positive."/>
            </td>
        </tr>
    </table>
    <div id="post_box_insert"></div>
</div>

<form id="form1" name="form1" enctype="multipart/form-data" style="display: none;" method="post">
    <table id="post_create_tb" style="float: left; border: 1px black solid; width: 100%;">
        <tr>
            <td colspan="2">
                <button onclick="show_post_insert_tb();"
                        style=" width: 100%; height: 40px; background-color: black; color: white; font-size: 12px; font-weight: bold;">
                    Close
                </button>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; margin: auto;">
                <img src="<?php echo $member_info::MemberProfilePic($_SESSION['SessionMemberID']); ?>" width="40"/>
            </td>
            <td>
                <?php echo $member_info::MemberFullName($_SESSION['SessionMemberID']); ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="margin: auto; text-align: center;">
                <textarea id="user_post_input" name="user_post_input" placeholder="What's on your mind?"
                          style="border-radius: 6px; margin: auto; border: 1px black solid; width: 99%; height: 100px;"></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button id="photo_btn" style="width: 100%; border:1px black solid;" class="btn">
                    <img src="image/photo-icon.png" width="25" height="auto"/> Add Photo
                </button>
            </td>
        </tr>
        <tr style="display: none;">
            <td colspan="2">
                <button id="photo_btn" style="width: 100%;" class="btn">
                    <img src="image/video-icon.png" width="25" height="auto"/> Add Video
                </button>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button id="post_btn" style="background-color: #040505; width: 100%; color: white;" class="btn">Create
                    Post
                </button>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="file" name="file[]" id="file" accept="image/*, video/*" style="width: 50px; display: none;"
                       multiple/>
                <div id="galleryview" style="width: 100%; height: auto;">

                </div>
            </td>
        </tr>
    </table>
</form>
