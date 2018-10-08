/**
 * Created by Jermaine Durham on 8/27/18.
 */

setInterval(function () {
    message_alert();
}, 1000);

var message_timer = '';

function messagebox_load() {
    $("#messagebox_header").html("");
    $.post("include/message_core.php", {historymessage: true}, function (result) {
        $("#messagebox_body").append(result);
    });
}

function messagebox_refresh() {
    $("#messagebox_body").html("");
    $.post("include/message_core.php", {historymessage: true}, function (result) {
        $("#messagebox_body").append(result);
    });

    $(".post_option_btn").hide();

    $(".messagebox_inbox_footer_btn").css("border", "1px black solid");
    $(".messagebox_friend_footer_btn").css("border", "none");
}

function messagebox_show() {
    $("#block_screen").fadeIn(function () {
        messagebox_load();
        $("#messagebox").show();
    });

    $(".post_option_btn").hide();

    $(".messagebox_inbox_footer_btn").css("border", "1px black solid");
    $(".messagebox_friend_footer_btn").css("border", "none");

    $(".post_box").hide();

    return true;
}

function messagebox_hide() {

    $("#block_screen").fadeOut(function () {
        $("#messagebox_body").html("");
        $("#messagebox").hide();
        $(".post_option_btn").show();
        $(".post_box").show();
    });
}

function messagebox_select_memberbox(mem) {
    $("#messagebox_body").hide();
    $(".messagebox_member").fadeIn();
    $("#message_select_footer").show();
    $("#message_member_close_btn").attr("onclick", "messagebox_select_close();");
    $("#message_sendmessage_btn").attr("onclick", "messagebox_send_message('" + mem + "');");
   // $(".messagebox_member").css("top", $("#messagebox").height() - $("#messagebox_footer").height() + "px");
    $(".messagebox_member").height($(document).height() - $("#messagebox_footer").height() - 100);
    $.post("include/message_core.php", {receivemessage: mem}, function (msg) {
        $(".messagebox_member").append(msg);
    });

    $(".messagebox_inbox_footer_btn").fadeOut();
    $(".messagebox_friend_footer_btn").fadeOut();
    $(".messagebox_close_footer_btn").fadeOut();

    message_timer = setInterval(function () {
        messagebox_member_update(mem);
    }, 1000);
}

function messagebox_select_close() {
    $("#messagebox_body").show();
    $(".messagebox_member").fadeOut();
    $(".messagebox_select_box").remove();
    //$(".messagebox_select_img").remove();
    //$(".messagebox_select_membername").remove();
    //$(".messagebox_select_message").remove();
    $(".messagebox_inbox_footer_btn").fadeIn();
    $(".messagebox_friend_footer_btn").fadeIn();
    $(".messagebox_close_footer_btn").fadeIn();

    $("#message_select_footer").html('<div id="message_select_footer"><input type="text" placeholder="Write here..." id="message_inputbox"/><div id="message_sendmessage_btn">Send</div></div>');
    $("#message_select_footer").hide();
    $("#message_member_close_btn").attr("onclick", "messagebox_hide();");

    $("#messagebox_header").html("");

    //$("#messagebox_header").html($("#messagebox_header_1").html());

    clearInterval(message_timer);

    messagebox_refresh();
}

function message_alert() {
    $.post("include/message_core.php", {message_alert_count: true}, function (result) {
        if (result > 0) {
            $("#message_alert").html(result);
            $("#message_alert").addClass("alert1");
        } else {
            $("#message_alert").html("");
            $("#message_alert").removeClass("alert1");
        }
    });
}

function messagebox_send_message(mem) {
    //console.log(mem);

    //var messagebox_select_box_length = $(".messagebox_select_box").length;

    if ($("#message_inputbox").val().length != 0) {
        $.post("include/message_core.php", {sendmessage: mem, message: $("#message_inputbox").val()}, function (msg) {
            $(".messagebox_select_box:last").after(msg);
            $(".messagebox_member").scrollTop($(".messagebox_member")[0].scrollHeight);
        });

        $("#message_inputbox").val("");
    }
    //$(".messagebox_member").height($(document).height() - $("#messagebox_footer").height() - $("#messagebox_header").height() - 200);    $("#message_inputbox").val("");

}

function messagebox_member_update(mem) {

    var messagebox_select_box_length = $(".messagebox_select_box").length;

    $.post("include/message_core.php", {updatemessage: mem}, function (msg) {
        if(msg != ""){
            $(".messagebox_select_box:last").after(msg);
            $(".messagebox_member").scrollTop($(".messagebox_member")[0].scrollHeight);
            //$(".messagebox_member").height($(document).height() - $("#messagebox_footer").height() - $("#messagebox_header").height() - 200);
        }
    });
}

function messagebox_leave_message(mem) {

    if ($("#profile_box:visible")) {
        profile_box_close();
    }

    //setTimeout(function(){
    if (messagebox_show()) {
        setTimeout(function () {
            messagebox_select_memberbox(mem);
        }, 700);
    }
    //console.log("OK");
    //}, 30);
}

function messagebox_load_friend() {
    $("#messagebox_body").html('');

    $(".messagebox_inbox_footer_btn").css("border", "none");
    $(".messagebox_friend_footer_btn").css("border", "1px black solid");
    $(".messagebox_close_footer_btn").css("border", "none");

    $.post("include/message_core.php", {messagebox_friends: true}, function (html) {
        $("#messagebox_body").html(html);
    });
}



