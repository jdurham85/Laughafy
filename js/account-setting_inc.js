/**
 * Created by jermainedurham on 9/4/18.
 */
function blockm(mem) {
    friend_list_box_close();
    $.post("include/friend_core.php", {blockfriend: mem});
    load_block_list();
}

//FOR OTHER PAGES
function block_member(mem){
    $.post("include/friend_core.php", {blockfriend: mem});
    if($("#block_member_btn"+mem).length > 0){
        $("#block_member_btn"+mem).html("BLOCKED");
        $("#block_member_btn"+mem).attr("onclick", "unblock_member('"+mem+"');");
    }
}

function unblock_member(mem){
    $.post("include/friend_core.php", {unblockfriend: mem});
    if($("#block_member_btn"+mem).length > 0){
        $("#block_member_btn"+mem).html("BLOCK");
        $("#block_member_btn"+mem).attr("onclick", "block_member('"+mem+"')");
    }
}

function unblockm(mem) {
    $.post("include/friend_core.php", {unblockfriend: mem});
    load_block_list();
}

function friend_list_box_close() {
    $("#friend_list_box").fadeOut();
    $("#friend_list_box table").remove();
}

function load_block_list() {
    $.post("include/friend_core.php", {blocklist: true}, function (html) {
        $("#account_setting_block_list").html(html);
    });
}

function select_friend() {
    $("#friend_list_box").fadeIn(function () {
        $.post("include/friend_core.php", {account_setting_friend_list: true}, function (friend_list) {
            $("#friend_list_close_box_btn").after(friend_list);
        });
    });
}