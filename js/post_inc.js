/**
 * Created by Jermaine Durham on 8/7/18.
 */

var post_page = 1;
var p_filelocation = "include/post_core.php";
var current_open_comment_post_wallid = "";

/*WALL COMMENT*/
function load_wall_comment(wallid) {
    $.post(p_filelocation, {load_comment: wallid}, function (comment) {
        current_open_comment_post_wallid = wallid;
        $("#block_screen").fadeIn(function () {
            $("#post_comment_box").fadeIn(function () {
                $("#post_comment_insert").html(comment);
                $("#post_comment_box").css("height", $(document).height() - $(".post_comment_header_bar").height() - $(".post_comment_footer").height());
                $("#post_comment_box").css("margin-top", $(".post_comment_header_bar").height() + $(".post_comment_footer").height() / 2 - 8);
            });
        });
    });

    if($("#post_popup_box:visible")){
        pop_popup_box_hide();
    }
}

function update_post_comment_status(wallid) {
    $.post(p_filelocation, {status_comment_total: wallid}, function (comment_status) {
        $("#post_footer_comment_status" + wallid).html(comment_status);
    });
}

function delete_post_comment(commentid) {
    $.post(p_filelocation, {delete_comment: commentid}, function (result) {
        //console.log(result);
        $("#post_comment_tb" + commentid).fadeOut(function () {
            $(this).remove();
        });
        update_post_comment_status(current_open_comment_post_wallid);
    });
}

function wall_comment_close() {
    $("#post_comment_box").fadeOut(function () {
        $("#post_comment_insert").html("<img width='60' style='margin: auto; position: fixed; top: 0; right: 0; left: 0; bottom: 0;' src='image/loading_img.gif' />");
        $("#block_screen").fadeOut();
        update_post_comment_status(current_open_comment_post_wallid);
    });

    current_open_comment_post_wallid = "";
}

function save_wall_comment_post() {
    $(document).ready(function () {
        var last_comment_tb = "";
        var user_description = $("#post_user_comment_input").val();

        $.post(p_filelocation, {
            save_comment: current_open_comment_post_wallid,
            description: user_description
        }, function (result) {
            //console.log(result);
            if ($("#post_comment_into_description is:visible")) {
                $("#post_user_comment_input").val("");
                $("#post_comment_into_description").fadeOut(function () {
                    $(this).remove();
                });
            }

            $("#post_comment_insert").append(result);
            //console.log(result);
        });
    });
}
/*WALL COMMENT END*/

function show_post_like_tb(wallid) {
    $.post("include/post_core.php", {listed_member_like_post: wallid}, function (result) {
        $("#block_screen").fadeIn(function () {
            $("#post_like_tb").html(result);
            $("#post_like_tb").fadeIn();
        });
        if($("#post_popup_box:visible")){
            pop_popup_box_hide();
            $("#block_screen").hide();
        }
    });

    $(".post_option_btn").hide();
    setTimeout(function(){
        $("#block_screen").show();
    }, 1000);
}

function close_post_like_tb() {
    $("#block_screen").fadeOut(function () {
        $("#post_like_tb").html("");
        $("#post_like_tb").fadeOut();
    });
    $(".post_option_btn").show();
    $("#block_screen").hide();
}

function load_parent_user_last_post() {
    $.post(p_filelocation, {load_parent_user_last_post: true}, function (result) {
        if($(".post_box").length > 0){
            $(".post_box:eq(0)").before(result);
        }else{
            $("#post_box_insert").before(result);
        }
    });
}

function load_option_menu(wallid, parentid, memberid) {
    var table_html = "";

    if (parentid == memberid) {
        table_html = "<table>" +
            "<tr><td onclick='option_tb_close();'>Close</td></tr>" +
            "<tr><td onclick='delete_post(" + wallid + "," + parentid + ", " + memberid + ");'>Delete</td></tr>" +
            "<tr><td onclick='show_edit_post_tb(" + wallid + ");'>Edit</td></tr>";
    } else {
        table_html = "<tr><td onclick='option_tb_close();'>Close</td></tr>" +
            "<tr><td>Report</td></tr>" +
            "<tr><td onclick='hide_post(" + wallid + ");'>Hide</td></tr>";
    }
    $("#post_option_tb").html(table_html);

    option_tb_show();
}

function hide_post(wallid) {
    $.post(p_filelocation, {hide_post: wallid}, function (result) {
        if (result == "SUCCESS") {
            $("#post_box" + wallid).fadeOut(function () {
                $(this).remove();
            });

            option_tb_close();
        }
    });
}

function show_edit_post_tb(wallid) {
    $("#post_description_tb" + wallid).fadeIn(function () {
        $("#post_description" + wallid).fadeOut();
        option_tb_close();
    });

    $("#post_description_tb" + wallid + " textarea").focus();
}

function show_description(wallid) {
    $("#post_description" + wallid).fadeIn(function () {
        $("#post_description_tb" + wallid).fadeOut();
    });
}

function save_edit_post(wallid) {
    $.post(p_filelocation, {
        edit_post: wallid,
        description: $("#post_description_tb" + wallid + " textarea").val()
    }, function (result) {
        if (result == "SUCCESS") {
            $("#post_description" + wallid).html($("#post_description_tb" + wallid + " textarea").val());
            show_description(wallid);
        }
        //console.log($("#post_description_tb" + wallid + " textarea").val());
    });
}

var delete_post = function (wallid, parentid, memberid) {
    $.post(p_filelocation, {delete_post: wallid}, function (dwallid) {
        if (dwallid == "DELETED") {
            $("#post_box" + wallid).fadeOut(function () {
                $(this).remove();
            });
        }
        //console.log(dwallid);
    });

    option_tb_close();
};

var option_tb_show = function () {

    $("#post_option_tb").fadeIn();
    $("#block_screen").fadeIn();
};

var option_tb_close = function () {
    $("#post_option_tb").html("");
    $("#post_option_tb").fadeOut();
    $("#block_screen").fadeOut();
};


function load_feed(page) {
    //console.log(page);
    $.post(p_filelocation, {load_feed: page}, function (result) {
        if (result == "" || result == null) {
            post_page--;
        } else {
            $("#post_insert_tb").after(result);
        }
    });

    //console.log(post_page);
}

function like_post(wallid, memberid) {
    $.post(p_filelocation, {save_post_like: wallid + "," + memberid}, function (result) {
        //console.log(result);
        if (result == 0) {
            $("#post_footer_like_status" + wallid).html("");
        } else {
            $("#post_footer_like_status" + wallid).html("<img src='image/like-on.png' width='20' height='20' /> " + result);
        }
        $("#post_like_btn" + wallid + " img").attr("src", "image/like-on.png");
        $("#post_like_btn" + wallid).attr("onclick", "unlike_post(" + wallid + "," + memberid + ");");
        $("#post_like_btn" + wallid).css("font-weight", "bolder");
        $("#post_like_text_btn" + wallid).html("Reacted");
    });

    //console.log(wallid);
}

function unlike_post(wallid, memberid) {
    $.post(p_filelocation, {delete_post_like: wallid + "," + memberid}, function (result) {

        if (result == 0) {
            $("#post_footer_like_status" + wallid).html("");
        } else {
            $("#post_footer_like_status" + wallid).html("<img src='image/like-on.png' width='20' height='20' /> " + result);
        }

        $("#post_like_btn" + wallid + " img").attr("src", "image/like-off.png");
        $("#post_like_btn" + wallid).attr("onclick", "like_post(" + wallid + "," + memberid + ");");
        $("#post_like_btn" + wallid).css("font-weight", "normal");
        $("#post_like_text_btn" + wallid).html("React");
    });
}

/*POST POPUP BOX*/
function post_popup_box_show(wallid) {
    notification_hide();
    $("#block_screen").show();
    $("#post_popup_box").fadeIn(function () {
        $.post(p_filelocation, {post_popup: wallid}, function (post) {
            $("#post_popup_box").html("<div id='post_popup_box_close_btn' onclick='pop_popup_box_hide();'>Close</div>" + post);
            $(".post_option_btn").hide();
        });
    });


}

function pop_popup_box_hide() {
    $("#post_popup_box").fadeOut(function(){
        $(this).html("");
        $(".post_option_btn").show();
    });

    $("#block_screen").hide();
}
/*POST POPUP BOX END*/