<?php
/**
 * .
 * User: Jermaine Durham
 * Date: 7/4/18
 * Time: 1:38 AM
 */

require_once "model/profiled.php";
require "model/friendd.php";

require "inner_header.php";


$member_info = new namespace\profiled();
?>
<script type="text/javascript">
    $(document).ready(function(){
        $.post("include/post_core.php", {load_my_post: true}, function(feed){
            //console.log(feed);
            $("#post_box_insert_first").append(feed);
        });
    });
</script>
<table class="profiletb">
    <tr>
        <td style="text-align: center;">
            <img style="border-radius: 100%; height: 200px; width: 200px;" src="<?php echo $member_info::MemberProfilePic($_SESSION['SessionMemberID']); ?>" />
        </td>
    </tr>
    <tr style="border-bottom: 2px black solid;">
        <td style="text-align: center; font-size: 16px; font-family: 'Arial Black';">
            <?php echo $member_info::MemberFullName($_SESSION['SessionMemberID']); ?>
        </td>
    </tr>
</table>
<table class="profiletb" style="margin-top: 5px;">
    <tr>
        <td width="50%" align="center">
            <a href="myphoto" target="_self"><button class="btn font-weight-bold" style="width: 90%;">Photos</button></a>
        </td>
        <td width="50%" align="center">
            <button class="btn font-weight-bold" style="width: 90%;">Videos</button>
        </td>
    </tr>
</table>
<table id="profile_info_tb">
    <tr>
        <td>
            <span style="font-weight: bold;">22,233</span>
            Posts
        </td>
        <td>
           <span style="font-weight: bold;"><?php echo namespace\friendd::friend_count(); ?></span>
            Friends
        </td>
    </tr>
</table>
<table id="post_insert_tb" style="margin-top: 5px;">
    <tr>
        <td>
            <textarea id="user_input" name="user_input" placeholder="Think of something positive." style="border-radius: 8px; width: 100%; "></textarea>
        </td>
    </tr>
</table>
<div id="post_box_insert_first"></div>


