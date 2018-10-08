/**
 * Created by Jermaine Durham on 8/24/18.
 */

var notification_core_file = "include/notification_core.php";

setInterval(function(){
    notification_count_unseen();
}, 1000);

function notification_count_unseen(){
    $.post(notification_core_file, {notification_count_unseen: true}, function(result){
       if(result > 0){
            $("#notification_count_unseen_alert").html(result);
            $("#notification_count_unseen_alert").addClass("alert1");
       } else{
           $("#notification_count_unseen_alert").html("");
           $("#notification_count_unseen_alert").removeClass("alert1");
       }
    });
}

function notification_delete(notificationid){
    $.post(notification_core_file, {notification_delete: notificationid}, function(result){
        $("#notification_pl"+notificationid).fadeOut(function(){
            $(this).remove();
        });
    });
}

function notification_load(){
    $.post(notification_core_file, {notification_load: true}, function(load){
        $("#notification_item").after(load);
    });
}

function notification_show(){
    $("#notification_tb").fadeIn(function(){
        notification_load();
        $("#notification_menu_btn").attr("onclick", "notification_hide();");
    });
}

function notification_hide(){
    $("#notification_tb").fadeOut(function(){
        $("#notification_item").html("");
        $("#notification_menu_btn").attr("onclick", "notification_show();");

        //for(i=0;i<$(".notification_pl").length;i++){
            $(".notification_pl").remove();
        //}
    });
}