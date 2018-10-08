<?php

class postinc
{

    public static $_LIKE_btn = "image/like-on.png";
    public static $_UNLIKE_btn = "image/like-off.png";
    public static $_comment_btn_img = "image/comment-icon.png";
    public static $_comment_fill_btn_img = "image/comment-icon-fill.png";

    public static function create_post($wallid, $parentid, $memberid, $description, $date)
    {
        ?>
        <div id="post_box<?php echo $wallid; ?>" class="post_box">

            <?php self::header($wallid, $parentid, $memberid, $date); ?>

            <?php self::body($wallid, $parentid, $memberid, $description); ?>

            <?php self::footer($wallid, $parentid, $memberid); ?>
        </div>
        <?php

    }

    public static function create_comment_post($wallid = "", $member_comments = [])
    {
        require_once "../model/profiled.php";
        $config = new config();

        if (count($member_comments) > 0) {
            for ($i = 0; $i < count($member_comments); $i++) {
                ?>
                <div id="post_comment_tb<?php echo $member_comments[$i]['commentid']; ?>" class="post_comment_tb">
                    <div class="post_comment_header">
                        <div class="post_comment_member_header">
                            <img class="post_comment_member_img"
                                 src="<?php echo profiled::MemberProfilePic($member_comments[$i]['memberid']); ?>"/>
                        </div>
                        <div class="post_comment_body">
                            <div class="post_comment_member_description">
                                <span class="post_comment_member"><?php echo profiled::MemberFullName($member_comments[$i]['memberid']); ?></span>
                                <?php echo $member_comments[$i]['description']; ?>
                            </div>
                        </div>
                        <div class="post_comment_body_btn">
                            <?php
                            if ($config->get_session_id() == $member_comments[$i]['memberid']) {
                                ?>
                                <table style="margin: auto; width: 100%;">
                                    <tr>
                                        <td style="width: 33.3%;">
                                            <span class="post_comment_member_date">
                                    <?php echo date("M d, Y", $member_comments[$i]['date']); ?>
                                </span>
                                        </td>
                                        <!--td style="width: 33.3%;">
                                            <a href="javascript:void(0);">React</a>
                                        </td-->
                                        <td style="width: 33.3%;">
                                            <a href="javascript:void(0);"
                                               onclick="delete_post_comment(<?php echo $member_comments[$i]['commentid']; ?>);">Delete</a>
                                        </td>
                                    </tr>
                                </table>

                                <?php
                            } else {
                                ?>
                                <table style="margin: auto; width: 100%;">
                                    <tr>
                                        <td style="width: 25%;">
                                            <span class="post_comment_member_date">
                                    <?php echo date("M d, Y", $member_comments[$i]['date']); ?>
                                </span>
                                        </td>
                                        <!--td style="width: 25%;">
                                            <a href="javascript:void(0);">React</a>
                                        </td-->
                                        <td style="width: 25%;">
                                            <a href="javascript:void(0);">Hide</a>
                                        </td>
                                        <td style="width: 25%;">
                                            <a href="javascript:void(0);">Report</a>
                                        </td>
                                    </tr>
                                </table>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="post_comment_react_status"></div>
                    </div>
                </div>
                <?php
            }
        } else {
            ?>
            <div id="post_comment_into_description">Be the first to leave a comment
                on <?php echo profiled::MemberFirstName(postd::getParentID($wallid)) . " Post"; ?>.
            </div>
            <?php
        }
    }

    public static function create_list_like_post($wallid, $react_memberid = [], $parentid, $memberid, $description, $date)
    {

        $react_parentid = namespace\postd::getParentID($wallid);
        ?>
        <tr>
            <td colspan="2">
                <div id="post_like_close_btn" onclick="close_post_like_tb();">Close</div>
            </td>
        </tr>
        <tr>
            <td>
                <div>
                    <?php
                    self::create_post($wallid, $parentid, $memberid, $description, $date);
                    ?>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2"
                style="text-align: center; font-weight: bold; border-bottom: 2px black solid; height: 50px; width: 85%;">
                Reactions
            </td>
        </tr>
        <?php
        for ($i = 0; $i < count($react_memberid); $i++) {
            ?>
            <tr onclick="goto_page('profile?userid=<?php echo $react_memberid[$i]; ?>')">
                <td colspan="2" style="padding: 1.10em; border-bottom: 1px gray solid;">
                    <img class="post_like_tb_img"
                         src="<?php echo namespace \profiled::MemberProfilePic($react_memberid[$i]); ?>"/>
                    <?php echo($react_memberid[$i] == $react_parentid ? namespace \profiled::MemberFullName($react_memberid[$i]) : namespace \profiled::MemberFullName($react_memberid[$i])); ?>
                </td>
            </tr>
            <?php

        }
    }

    private static function header($wallid, $parentid, $memberid, $date)
    {
        require_once "../model/profiled.php";
        require_once 'config.php';
        $config = new config();
        ?>
        <div class="post_header">
            <div class="post_option_btn"
                 onclick="load_option_menu(<?php echo $wallid . ',' . $parentid . ',' . $config->get_session_id(); ?>);">
                ...
            </div>

            <?php
            if ($config->get_session_id() == $parentid || $config->get_session_id() == $memberid) {
                ?>
                <div class="post_header_img">
                    <img src="<?php echo namespace \profiled::MemberProfilePic($memberid); ?>">
                </div>

                <div class="post_header_membername"
                     id="post_header_member_name<?php echo $wallid; ?>"><?php echo namespace \profiled::MemberFullName($memberid); ?>
                </div>
                <?php
            } else {
                ?>
                <div class="post_header_img" onclick="profile_box_show('<?php echo $memberid; ?>');">
                    <img src="<?php echo namespace \profiled::MemberProfilePic($memberid); ?>">
                </div>

                <div class="post_header_membername" onclick="profile_box_show('<?php echo $memberid; ?>');"
                     id="post_header_member_name<?php echo $wallid; ?>"><?php echo namespace \profiled::MemberFullName($memberid); ?>
                </div>
                <?php
            }
            ?>

            <div class="post_header_date">
                <?php
                echo date("l M d, Y", $date) . " at " . date("g:i A", $date);
                ?>
            </div>
        </div>
        <?php

    }

    private static function body($wallid, $parentid, $memberid, $description)
    {
        ?>
        <div class="post_body">
            <?php
            require_once "../model/postd.php";
            $member_post_file_total = namespace \postd::count_member_post_file_item($wallid);

            $CONTAIN_IMAGES = 0;
            $CONTAIN_VIDEOS = 0;
            $IMAGES = [];
            if ($member_post_file_total > 0) {
                $data = namespace \postd::load_member_post_wall($wallid);
                for ($i = 0; $i < count($data); $i++) {

                    if (in_array("image", $data[$i])) {
                        $CONTAIN_IMAGES++;
                        $IMAGES[] = $data[$i]['filename'];
                    }
                }

                //print_r($IMAGES);
                $filelocation = "admin-view/profile/" . $parentid . "/photo/";

                if ($CONTAIN_IMAGES > 2 || $CONTAIN_IMAGES == 2) {
                    ?>
                    <script type="text/javascript">
                        mphoto<?php echo $wallid; ?> = <?php echo json_encode($IMAGES); ?>;

                        mphoto_length<?php echo $wallid; ?> = mphoto<?php echo $wallid; ?>.length;

                        mphoto_track<?php echo $wallid; ?> = 0;

                        function <?php  echo "next" . $wallid; ?>() {
                            mphoto_track<?php echo $wallid; ?>++;
                            if (mphoto_track<?php echo $wallid; ?> == mphoto_length<?php echo $wallid; ?>) {
                                mphoto_track<?php echo $wallid; ?> = mphoto_length<?php echo $wallid; ?> - 1;
                            }

                            //console.log(mphoto_track<?php echo $wallid; ?>);

                            $("#post_body_img<?php echo $wallid; ?>").attr("src", "<?php echo $filelocation; ?>" + mphoto<?php echo $wallid; ?>[mphoto_track<?php echo $wallid; ?>]);
                        }

                        function <?php echo "back" . $wallid; ?>() {
                            mphoto_track<?php echo $wallid; ?>--;
                            if (mphoto_track<?php echo $wallid; ?> < mphoto_length<?php echo $wallid; ?>) {
                                mphoto_track<?php echo $wallid; ?> = 0;
                            }

                            //console.log(mphoto_track<?php echo $wallid; ?>);

                            $("#post_body_img<?php echo $wallid; ?>").attr("src", "<?php echo $filelocation; ?>" + mphoto<?php echo $wallid; ?>[mphoto_track<?php echo $wallid; ?>]);
                        }
                    </script>
                    <?php

                }
            }
            ?>
            <div class="post_body_item">
                <?php
                /* switch ($filetype) {
                  case "image":
                  ?>
                  <img width="80%" src="admin-view/profile/<?php echo $parentid; ?>/photo/<?php echo $filename; ?>"/>
                  <?php
                  break;

                  case "video":
                  break;
              } */

                if ($CONTAIN_IMAGES > 2 || $CONTAIN_IMAGES == 2) {
                    ?>
                    <img width="80%" id="post_body_img<?php echo $wallid; ?>"
                         src="views/profile/<?php echo $parentid; ?>/photo/<?php echo $IMAGES[0]; ?>"/>
                    <div id="post_body_track_btn<?php echo $wallid ?>" class="post_body_track_btn">
                        <div class="post_body_back_btn" onclick="back<?php echo $wallid; ?>();">
                            Back
                        </div>
                        <div class="post_body_next_btn" onclick="next<?php echo $wallid; ?>();">
                            Next
                        </div>
                    </div>
                    <?php

                } elseif ($CONTAIN_IMAGES == 1) {
                    ?>
                    <img width="80%" src="views/profile/<?php echo $parentid; ?>/photo/<?php echo $IMAGES[0]; ?>"/>
                    <?php

                }
                ?>
            </div>
            <div id="post_description<?php echo $wallid; ?>" class="post_description">
                <?php echo $description; ?>
            </div>
            <div id="post_description_tb<?php echo $wallid; ?>" class="post_description_tb">
                <table style="width: 100%; float:left;">
                    <tr>
                        <td colspan="2">
                            <textarea
                                    id="post_description_textbox_editor<?php echo $wallid; ?>"><?php echo $description; ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">
                            <button id="post_description_tb_cancel_btn<?php echo $wallid; ?>"
                                    onclick="show_description(<?php echo $wallid; ?>);"
                                    class="btn post_description_tb_cancel_btn">Cancel
                            </button>
                        </td>
                        <td width="50%">
                            <button id="post_description_tb_save_btn<?php echo $wallid; ?>"
                                    class="btn-dark post_description_tb_save_btn"
                                    onclick="save_edit_post(<?php echo $wallid; ?>)">Save
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <?php

    }

    private static function footer($wallid, $parentid, $memberid)
    {
        //require_once "../model/postd.php";
        $config = new config();
        $contains_comment = postd::post_contains_comment($wallid);
        $post_comment_total = postd::post_comment_total($wallid);


        ?>
        <div class="post_footer">
            <div id="post_footer_status<?php echo $wallid; ?>" class="post_footer_status">
                <div onclick="show_post_like_tb(<?php echo $wallid; ?>);"
                     id="post_footer_like_status<?php echo $wallid; ?>" class="post_footer_like_status">
                    <?php echo(namespace \postd::total_like_post_DB($wallid) == 0 ? "" : "<img src='image/like-on.png' width='20' height='20' /> " . namespace \postd::total_like_post_DB($wallid)); ?></div>
                <div id="post_footer_comment_status<?php echo $wallid; ?>" class="post_footer_comment_status">
                    <?php if ($contains_comment) {
                        echo "<img src='image/chat_icon.png' width='20' height='20' /> " . $post_comment_total;
                    }
                    ?>
                </div>
            </div>
            <div class="post_footer_bottom">
                <div id="post_footer_btn<?php echo $wallid; ?>">
                    <?php if (namespace \postd::is_wall_like($wallid, $config->get_session_id())) {
                        ?>
                        <div id="post_like_btn<?php echo $wallid; ?>"
                             onclick="unlike_post(<?php echo $wallid . "," . $memberid; ?>);" class="post_like_btn">
                            <img width="25" height="25" src="<?php echo self::$_LIKE_btn; ?>"/> <span
                                    id="post_like_text_btn<?php echo $wallid; ?>">Reacted</span>
                            <script type="text/javascript">
                                $("#post_like_btn" + <?php echo $wallid; ?>).css("font-weight", "bolder");
                            </script>
                        </div>
                        <?php

                    } else {
                        ?>
                        <div id="post_like_btn<?php echo $wallid; ?>"
                             onclick="like_post(<?php echo $wallid . "," . $memberid; ?>);" class="post_like_btn">
                            <img width="25" height="25" src="<?php echo self::$_UNLIKE_btn; ?>"/> <span
                                    id="post_like_text_btn<?php echo $wallid; ?>">React</span>
                        </div>
                        <?php
                    }
                    ?>

                </div>
                <div id="post_comment_btn<?php echo $wallid; ?>" onclick="load_wall_comment(<?php echo $wallid; ?>);"
                     class="post_comment_btn">
                    <img width="25" height="25" src="<?php echo self::$_comment_btn_img; ?>"/> Comment
                </div>
            </div>
        </div>
        <?php

    }
}
