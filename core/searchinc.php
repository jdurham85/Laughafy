<?php

class searchinc
{

    static $PROFILE = 0;
    static $EVENT = 1;
    static $GAME = 2;

    public static function search($searchtxt, $searchtype = "")
    {
        $searchtxt = trim($searchtxt);
        $c = new config; //CONFIG FILE
        //$people   = [];
        $people = searchd::search($searchtxt, $searchtype);
        //print_r($people);

        if(array_key_exists("NORESULT", $people)){
            ?>
            <table style="width: 100%; float: left; border:1px black solid; margin-bottom: 6%;">
                <tr>
                    <td align="center">
                        <?php echo $people['NORESULT']; ?>
                    </td>
                </tr>
            </table>
            <?php
        }else{
            for ($a = 0; $a < count($people); $a++) {
                if (friend::is_block($c->get_session_id(), $people[$a]['memberid']) !== true) {
                    ?>
                    <table style="width: 100%; float: left; border:1px black solid; margin-bottom: 6%;">
                        <tr>
                            <td align="center" width="10%" style="">
                                <img width="60" height="60" style="border-radius: 100%; border: 1px black solid;"
                                     src="<?php echo profiled::MemberProfilePic($people[$a]['memberid']); ?>"/>
                            </td>
                            <td width="90%" align="center">
                                <?php echo profiled::MemberFullName($people[$a]['memberid']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <?php
                                if (friend::IS_FRIEND($c->get_session_id(), $people[$a]['memberid'])) {
                                    ?>
                                    <button class="btn btn-secondary"
                                            onclick="goto_page('profile?userid=<?php echo $people[$a]['memberid']; ?>');">
                                        View Profile
                                    </button>
                                    <button class="btn btn-secondary"
                                            onclick="messagebox_leave_message('<?php echo $people[$a]['memberid']; ?>')">
                                        Leave Message
                                    </button>
                                    <button id="block_member_btn<?php echo $people[$a]['memberid']; ?>"
                                            class="btn btn-danger"
                                            onclick="block_member('<?php echo $people[$a]['memberid']; ?>')">
                                        Block
                                    </button>
                                    <?php
                                } elseif (friend::check_request($people[$a]['memberid']) == friend::$REQUEST_NOT_AVAILABLE) {
                                    ?>
                                    <button id="friend_request_btn<?php echo $people[$a]['memberid']; ?>"
                                            class="btn btn-secondary"
                                            onclick="send_friend_request('<?php echo $people[$a]['memberid']; ?>')">
                                        Send Request
                                    </button>
                                    <button id="block_member_btn<?php echo $people[$a]['memberid']; ?>"
                                            class="btn btn-danger"
                                            onclick="block_member('<?php echo $people[$a]['memberid']; ?>')">
                                        Block
                                    </button>
                                    <?php
                                } elseif (friend::check_request($people[$a]['memberid']) == friend::$REQUEST_PENDING) {
                                    ?>
                                    <button id="friend_request_btn<?php echo $people[$a]['memberid']; ?>"
                                            class="btn btn-secondary"
                                            onclick="decline_friend_request('<?php echo $people[$a]['memberid']; ?>')">
                                        Cancel Pending Request
                                    </button>
                                    <button id="block_member_btn<?php echo $people[$a]['memberid']; ?>"
                                            class="btn btn-danger"
                                            onclick="block_member('<?php echo $people[$a]['memberid']; ?>')">
                                        Block
                                    </button>
                                    <?php
                                } else {
                                    ?>
                                    <button id="send_request_btn<?php echo $people[$a]['memberid']; ?>"
                                            class="btn btn-secondary"
                                            onclick="send_friend_request('<?php echo $people[$a]['memberid']; ?>')">Send
                                        Friend
                                        Request
                                    </button>
                                    <button id="block_member_btn<?php echo $people[$a]['memberid']; ?>"
                                            class="btn btn-danger"
                                            onclick="block_member('<?php echo $people[$a]['memberid']; ?>')">
                                        Block
                                    </button>
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                    <?php
                }
            }
        }




        //echo $people['memberid'];
    }
}
