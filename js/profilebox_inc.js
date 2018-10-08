/**
 * Created by Jermaine Durham on 8/27/18.
 */
function profile_box_close(){
    $("#block_screen").fadeOut(function(){
        $("#profile_box").fadeOut(function(){
            $(this).remove();

        });
    });

    $(".post_option_btn").show();
}

function profile_box_show(member){
    $("#block_screen").fadeIn(function(){
        $("#profile_box").hide();
        $.post("include/profile_box_core.php", {profilebox: member}, function(result){
            $("#block_screen").append(result);
            $(".post_option_btn").hide();
        });
    });
}