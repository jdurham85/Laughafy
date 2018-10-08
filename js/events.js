/**
 * Created by jermainedurham on 10/4/18.
 */

var event_item_total = 0;
$(document).ready(function () {
    //$("#event_add_btn").trigger("click");

    event_item_total = $(".event_item").length - 1;

    myevent_load();

    $("#eventFrm").submit(function (e) {
        e.preventDefault();

        event_item_total = $(".event_item").length - 1;

        $.ajax({
            url: "include/event_core.php",
            type: "POST",
            data: $("#eventFrm").serialize(),
            success: function (e) {
                $(".event_item:eq("+event_item_total+")").after(e);
            }
        })
    });
});

function event_add_tb_show() {
    $("#event_add_tb").fadeIn();

    $("#event_add_btn").html("Close");
    $("#event_add_btn").attr("onclick", "event_add_tb_close();");

    setTimeout(function(){
        $("#event_title").focus();
        $(document).scrollTop(50);
    }, 20);
}

function event_add_tb_close() {
    $("#event_title").val("");
    $("#event-description").val("");
    $("#event-datetime").val("");
    $("#event-location").val("");

    $("#event_add_btn").html("Create Event");
    $("#event_add_btn").attr("onclick", "event_add_tb_show();");

    $("#event_add_tb").fadeOut();
}

function myevent_load(){

    event_item_total = $(".event_item").length - 1;

    $.post("include/event_core.php", {myevent: true}, function(e){
        $(".event_item:eq("+event_item_total+")").after(e);
    });
}

function location_list(){

}