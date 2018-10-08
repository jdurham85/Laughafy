/**
 * Created by Jermaine Durham on 7/29/18.
 */

function start_friend_interval() {
    setInterval(function () {
        friend_suggestion_count();
        friend_request_count();
    }, 1000);
}

var f_filelocation = "include/friend_core.php";

function friend_suggestion_tb_show() {
    $.post(f_filelocation, {friend_suggestion: true}, function (friend_suggestion_tb) {
        $("#friend_suggestion_tb").html(friend_suggestion_tb);
    });
}

function friend_suggestion_remove(memberid) {
    $.post(f_filelocation, {friend_suggestion_remove: memberid}, function (result) {
        $("#member_suggestion_tb" + memberid).fadeOut(function () {
            $(this).remove();
        });
    });
}

function friend_suggestion_count() {
    $.post(f_filelocation, {friend_suggestion_count: true}, function (result) {
        //console.log(result);
        if (result > 0) {
            $("#friend_sugesstion_pl").html(result);
            $("#friend_sugesstion_pl").addClass("alert1");
        } else {
            $("#friend_sugesstion_pl").html("");
            $("#friend_sugesstion_pl").removeClass("alert1");
        }
    });
}

function send_friend_request(memberid) {
    $.post(f_filelocation, {friend_request: memberid}, function (result) {
        //console.log(result);
        if (result === "REQUEST_SENT") {
            $("#send_request_btn" + memberid).html("REQUEST SENT");
            $("#send_request_btn" + memberid).attr("disable", "disable");
            //$("#send_request_btn" + memberid).css("width", "100%");
            $("#remove_request_btn" + memberid).remove();
        }

        if (result == "REQUEST_PENDING") {
            $("#send_request_btn" + memberid).html("REQUEST PENDING");
            $("#send_request_btn" + memberid).attr("disable", "disable");
            //$("#send_request_btn" + memberid).css("width", "100%");
            $("#remove_request_btn" + memberid).remove();
        } else {
            //alert("There was an error please try again later!");
        }
    });

    if($("#friend_request_btn"+memberid).length > 0){
        $("#friend_request_btn"+memberid).html("Cancel Pending Request");
        $("#friend_request_btn"+memberid).attr("onclick", "decline_friend_request('"+memberid+"');");
    }

    friend_suggestion_remove(memberid);
}

function friend_request_count() {
    $.post(f_filelocation, {friend_request_count: true}, function (result) {
        //console.log(result);
        if (result > 0) {
            $("#friend_request_pl").html(result);
            $("#friend_request_pl").addClass("alert1");

            $("#friend_header_request_pl").html(result);
            $("#friend_header_request_pl").addClass("alert1");

            $(".friends_request_count").html(result);
            $(".friends_request_count").addClass("alert1");
        } else {
            $("#friend_request_pl").html("");
            $("#friend_request_pl").removeClass("alert1");

            $("#friend_header_request_pl").html("");
            $("#friend_header_request_pl").removeClass("alert1");

            $(".friends_request_count").html("");
            $(".friends_request_count").removeClass("alert1");
        }
    });
}

function accept_friend_request(memberid) {
    $.post(f_filelocation, {accept_friend_request: memberid}, function (result) {
        console.log(result);
        if (result == "REQUEST_ACCEPTED") {
            $("#friend_request_btn_tr" + memberid).html("You are now friends.");
        }
    });
}

function decline_friend_request(memberid) {
    $.post(f_filelocation, {decline_friend_request: memberid}, function (result) {
        if (result == "REQUEST_DECLINED") {
            $("#friend_request_btn_tr" + memberid).html("You have declined request.");
        }
    });

    if($("#friend_request_btn"+memberid).length > 0){
        $("#friend_request_btn"+memberid).html("Send Request");
        $("#friend_request_btn"+memberid).attr("onclick", "send_friend_request('"+memberid+"');");
    }
}

function block_friend_request(memberid) {

}

function my_friends_show(){
    $.post(f_filelocation, {myfriends: true}, function(myfriend){
        $("#friend_tb").html("<tr><td>" + myfriend + "</td></tr>");
        //console.log(myfriend);
    });
}

