<?php

/**
 * Created by PhpStorm.
 * User: Jermaine Durham
 * Date: 8/27/18
 * Time: 1:33 PM
 */
class profile
{
    public static function load_member_profile($memberid)
    {
        ?>
        <table id="profile_box">
            <tr>
                <td colspan="2" id="profile_box_close_btn" onclick="profile_box_close();">
                    Close
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center; height: 200px;">
                    <img id="profile_box_img" src="<?php echo profiled::MemberProfilePic($memberid); ?>"/>
                </td>
            </tr>
            <tr>
                <td colspan="2" id="profile_box_membername">
                <?php echo profiled::MemberFullName($memberid); ?>
                </td>
            </tr>
            <tr>
                <td colspan="" style="text-align: center; width: 50%;">
                    <div class="profile_box_btn" onclick="goto_page('<?php echo 'profile?userid=' . $memberid; ?>')">
                        View Profile
                    </div>
                </td>
                <td style="text-align: center; width: 50%;" onclick="messagebox_leave_message('<?php echo $memberid ?>');">
                    <div class="profile_box_btn">Leave Message</div>
                </td>
            </tr>
        </table>
        <?php
    }
}