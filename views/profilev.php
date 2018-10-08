<?php

/**
 * .
 * User: Jermaine Durham
 * Date: 7/2/18
 * Time: 9:09 AM
 */
class profilev
{
    public function profile($profileid)
    {
        if ($profileid != "") {

            require_once "model/profiled.php";

            require "inner_header.php";


            $member_info = new namespace\profiled();
            ?>
            <table class="profiletb">
                <tr>
                    <td style="text-align: center;">
                        <img src="<?php echo $member_info::MemberProfilePic($profileid); ?>"
                             width="160"/>
                    </td>
                </tr>
                <tr style="border-bottom: 2px black solid;">
                    <td style="text-align: center; font-size: 16px; font-family: 'Arial Black';">
                        <?php echo $member_info::MemberFullName($profileid); ?>
                    </td>
                </tr>
            </table>
            <table class="profiletb" style="margin-top: 5px;">
                <tr>
                    <td width="50%" align="center">
                        <button class="btn font-weight-bold" style="width: 90%;">Photos</button>
                    </td>
                    <td width="50%" align="center">
                        <button class="btn font-weight-bold" style="width: 90%;">Videos</button>
                    </td>
                </tr>
            </table>
            <table id="post_insert_tb" style="margin-top: 5px;">
                <tr>
                    <td>
            <textarea id="user_input" name="user_input" placeholder="Think of something positive."
                      style="border-radius: 8px; width: 100%; "></textarea>
                    </td>
                </tr>
            </table>
            <?php
        }
    }

    public function myprofile()
    {

    }
}