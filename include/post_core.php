<?php

session_start();

require "../core/config.php";
require "../core/upload.php";
require "../core/post_inc.php";
require_once "../core/notification.php";
require "../core/friend.php";
//require "../core/notification_enum.php";

require_once "../model/database.php";
require "../model/postd.php";
require "../model/uploadd.php";
require "../model/friendd.php";
require "../model/notificationd.php";

$db = new database();
$config = new config();

if (!empty($_POST)) {
    switch (true) {
        case $_POST['load_feed']:

            $current_member_post_count = 0;

            $page = $_POST['load_feed'];

            $page = ($page == 0 ? 1 : $page);

            $limit = 20;

            $feed = postd::load_member_post($page, $limit);

            $myfriends = [];

            $myfriends[] = friend::my_friends_list()['tomemberid'];

            $myfriends[] = $config->get_session_id();

            for ($i = 0; $i < count($feed); $i++) {
                if (in_array($feed[$i]['parentid'], $myfriends) && !postd::is_wall_hidden($feed[$i]['wallid'], $config->get_session_id())) {

                    //CHECKING TO SEE IF PARENT MEMBER BLOCKED MEMBER
                    if (friend::is_block($config->get_session_id(), $feed[$i]['parentid']) !== true) {
                        postinc::create_post($feed[$i]['wallid'], $feed[$i]['parentid'], $feed[$i]['memberid'], $feed[$i]['description'], $feed[$i]['date']);

                        $current_member_post_count++;
                    }
                }
            }

            if ($current_member_post_count == 0) {
                //Add somthing here if the current use doesn't have a post available.
                ?>
                <div id="post_intro_message">
                    Be the post to leave a post. Click the textbox above to begin upload.
                </div>
                <?php
            }

            $page_number = array();
            $page_number['page'] = $page;
            json_encode($page_number);

            break;
        case $_POST['load_parent_user_last_post']:
            $config = new config();
            $data = postd::load_parent_user_last_post_DB($config->get_session_id());

            echo postinc::create_post($data[0]['wallid'], $data[0]['parentid'], $data[0]['memberid'], $data[0]['description'], $data[0]['date']);
            break;
        case $_POST["user_post_input"]:
            $source = "../views/profile/" . $config->get_session_id() . "/tmp/";
            $destination = "../views/profile/" . $config->get_session_id() . "/";

            $description = $_POST["user_post_input"];


            $description = config::word_filter($description);

            $description = htmlspecialchars($_POST["user_post_input"]);


            $date = time();
            //$date = mktime(date("H"),date("i"),date("s"),date("n"), date("j"),date("Y"));


            $wallid = postd::save_post($config->get_session_id(), $description, $date);

            $data = uploadd::load_tmp_file_DB($config->get_session_id());

            for ($i = 0; $i < count($data); $i++) {
                //../views/profile/" . $_SESSION['SessionMemberID'] . "/photo/" . $name

                $fileid = $data[$i]['fileid'];
                $filetype = $data[$i]["filetype"];
                $filename = $data[$i]["filename"];


                if ($filetype == "image") {
                    if (copy($source . $filename, $destination . "photo/" . $filename)) {
                        if (postd::save_post_file($wallid, $filetype, $filename)) {
                            if (uploadd::delete_tmp_file_DB($config->get_session_id(), $fileid)) {
                                //Delete tmp files
                                @unlink($destination . "tmp/" . $filename);
                            }
                        }
                    }
                }

                /*$friends = [];
                $friends[] = friendd::my_friends_list()['tomemberid'];

                //NOTIFCIATION ADD POST
                for ($i = 0; $i < count($friends); $i++) {
                    if($friends[$i] != $config->get_session_id()){
                        notification::notification_add($friends[$i], $config->get_session_id(), notification::$ADDED_POST);
                    }
                }*/
            }
            break;
        case $_POST['save_post_like']:
            $data = explode(",", $_POST['save_post_like']);

            postd::save_like_post_DB($config->get_session_id(), $data[0]);

            echo postd::total_like_post_DB($data[0]);

            $parent_like_post_ID = postd::getParentID($data[0]);

            if ($parent_like_post_ID != $config->get_session_id()) {
                $friends = [];
                $friends[] = friendd::my_friends_list()['tomemberid'];

                //NOTIFCIATION ADD REACTED POST
                for ($i = 0; $i < count($friends); $i++) {
                    if ($friends[$i] != $config->get_session_id()) {
                        notification::notification_add($friends[$i], $config->get_session_id(), notification::$REACTED_TO_POST, "", $data[0], "", "", "", "");
                    }
                }
            }

            break;

        case $_POST['delete_post']:
            $files = postd::post_file_wall($_POST['delete_post'], $config->get_session_id());

            $filelocation = "../views/profile/" . $config->get_session_id() . "/photo/";

            if (count($files) != 0) {
                for ($i = 0; $i < count($files); $i++) {
                    if ($files[$i]['filename'] != "") {
                        @unlink($filelocation . $files[$i]['filename']);
                    }
                }
            }

            $parent_like_post_ID = postd::getParentID($data[0]);

            if ($parent_like_post_ID != $config->get_session_id()) {
                $friends = [];
                $friends[] = friendd::my_friends_list()['tomemberid'];

                //NOTIFCIATION Delete POST
                for ($i = 0; $i < count($friends); $i++) {
                    if ($friends[$i] != $config->get_session_id()) {
                        notification::notification_delete("", "", $data[0]);
                    }
                }
            }

            //echo $data[0];

            echo postd::delete_posts_DB($_POST['delete_post'], $config->get_session_id());
            break;

        case $_POST['delete_post_like']:
            $data = explode(",", $_POST['delete_post_like']);

            postd::delete_like_post_DB($config->get_session_id(), $data[0]);

            echo postd::total_like_post_DB($data[0]);

            $parent_like_post_ID = postd::getParentID($data[0]);

            if ($parent_like_post_ID != $config->get_session_id()) {
                $friends = [];
                $friends[] = friendd::my_friends_list()['tomemberid'];

                //NOTIFCIATION Delete LIKE POST
                for ($i = 0; $i < count($friends); $i++) {
                    if ($friends[$i] != $config->get_session_id()) {
                        notification::notification_delete("", $friends[$i], $data[0]);
                    }
                }
            }

            break;

        case $_POST['edit_post']:
            echo postd::update_post_description($_POST['edit_post'], $config->get_session_id(), $_POST['description']);
            break;

        case $_POST['hide_post']:
            echo postd::hide_wallid($_POST['hide_post'], $config->get_session_id());
            break;

        case $_POST['unhide_post']:
            break;

        case $_POST['listed_member_like_post']:
            $listed_member_like_post_array = [];
            $listed_member_like_post_array = postd::listed_like_member_post_array($_POST['listed_member_like_post']);
            $PARENTID = postd::getParentID($_POST['listed_member_like_post']);

            $data = postd::load_parent_user_last_post_DB($PARENTID);

            //print_r($listed_member_like_post_array);

            postinc::create_list_like_post($_POST['listed_member_like_post'], $listed_member_like_post_array, $data[0]['parentid'], $data[0]['memberid'], $data[0]['description'], $data[0]['date']);
            break;

        case $_POST['status_comment_total']:
            $contains_comment = postd::post_contains_comment($_POST['status_comment_total']);
            if ($contains_comment) {
                $post_comment_total = postd::post_comment_total($_POST['status_comment_total']);
                echo "<img src='image/chat_icon.png' width='20' height='20' /> " . $post_comment_total;
            }
            break;

        case $_POST['load_comment']:
            $wall_comment = [];
            $wall_comment = postd::load_commentDB($_POST['load_comment']);

            if (count($wall_comment) > 0) {
                postinc::create_comment_post($_POST['load_comment'], $wall_comment);
            } else {
                postinc::create_comment_post($_POST['load_comment'], $wall_comment);
            }

            //sleep(5);

            break;

        case $_POST['delete_comment']: {

            //echo "DELETING...";
            $files = [];
            if (postd::comment_containFile($_POST['delete_comment'], $config->get_session_id())) {
                $files[] = postd::comment_get_files($_POST['delete_comment']);
            }

            postd::delete_member_commentDB($_POST['delete_comment'], $config->get_session_id());
            break;
        }

        case $_POST['save_comment']:

            //echo $_POST['description'] . "<br>";
            $description = config::word_filter($_POST['description']);

            if (namespace\postd::save_member_commentDB($_POST['save_comment'], $config->get_session_id(), time(), $description) == true) {
                $wall_comment = [];
                $wall_comment = postd::load_member_commentDB($_POST['save_comment'], $config->get_session_id());

                if (count($wall_comment) > 0) {
                    //print_r($wall_comment);
                    namespace\postinc::create_comment_post($_POST['save_comment'], $wall_comment, true);
                } else {
                    ?>
                    <div id="post_comment_into_description">
                        Be the first to leave a comment
                        on <?php echo profiled::MemberFirstName(postd::getParentID($wallid)) . " Post"; ?>.
                    </div>
                    <?php
                }

                $parent_id = postd::getParentID($_POST['save_comment']);

                if ($parent_id != $config->get_session_id()) {
                    $friends = [];
                    $friends[] = friendd::my_friends_list()['tomemberid'];

                    //NOTIFCIATION ADD REPILED POST COMMENT
                    for ($i = 0; $i < count($friends); $i++) {
                        if ($friends[$i] != $config->get_session_id()) {
                            notification::notification_add($friends[$i], $config->get_session_id(), notification::$REPILED_TO_POST, "", $_POST['save_comment']);
                        }
                    }
                }
            }
            break;

        case $_POST['load_friend_post']:
            $current_member_post_count = 0;

            $page = $_POST['load_friend_post'];

            $page = ($page == 0 ? 1 : $page);

            $limit = 20;

            $feed = postd::load_my_post($_POST['load_friend_post'], $page, $limit);

            $current_member_post_count = count($feed);


            if ($current_member_post_count == 0) {
                //Add somthing here if the current use doesn't have a post available.
            } else {
                for ($i = 0; $i < count($feed); $i++) {
                    postinc::create_post($feed[$i]['wallid'], $feed[$i]['parentid'], $feed[$i]['memberid'], $feed[$i]['description'], $feed[$i]['date']);
                    $current_member_post_count++;
                }
                //$page_number = array();
                //$page_number['page'] = $page;
                //json_encode($page_number);
            }
            break;

        case $_POST['load_my_post']:
            $current_member_post_count = 0;

            $page = $_POST['load_my_feed'];

            $page = ($page == 0 ? 1 : $page);

            $limit = 20;

            $feed = postd::load_my_post($config->get_session_id(), $page, $limit);

            $current_member_post_count = count($feed);


            if ($current_member_post_count == 0) {
                //Add somthing here if the current use doesn't have a post available.
            } else {
                for ($i = 0; $i < count($feed); $i++) {
                    postinc::create_post($feed[$i]['wallid'], $feed[$i]['parentid'], $feed[$i]['memberid'], $feed[$i]['description'], $feed[$i]['date']);
                    $current_member_post_count++;
                }
                //$page_number = array();
                //$page_number['page'] = $page;
                //json_encode($page_number);
            }

            $page_number = array();
            $page_number['page'] = $page;
            json_encode($page_number);
            break;

        case $_POST['post_popup']:
            $post = postd::load_post($_POST['post_popup']);
            $comment = postd::load_commentDB($_POST['post_popup']);
            postinc::create_post($post[0]['wallid'], $post[0]['parentid'], $post[0]['memberid'], $post[0]['description'], $post[0]['date']);
            postinc::create_comment_post("", $comment);
            break;
    }
}
?>