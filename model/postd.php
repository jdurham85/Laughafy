<?php

/**
 * .
 * User: Jermaine Durham
 * Date: 8/5/18
 * Time: 7:20 PM
 */
class postd extends database
{

    public static $POST_SUCCESS = true;
    public static $POST_FAIL = false;
    public static $_PUBLIC = 0;
    public static $_PRIVATE = 1;

    public static function post_contains_comment($wallid)
    {
        $sql = mysqli_query(self::$DB, "select * from `member-post-comment` where `wallid` = '$wallid'");

        if (mysqli_num_rows($sql) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function post_comment_total($wallid)
    {
        $sql = mysqli_query(self::$DB, "select * from `member-post-comment` where `wallid` = '$wallid'") or die(mysqli_error(self::$DB));

        return mysqli_num_rows($sql);
    }

    public static function hide_wallid($wallid, $memberid)
    {
        $sql = mysqli_query(self::$DB, "insert into `member-post-hide`(`wallid`, `memberid`) values('$wallid', '$memberid')");

        echo "SUCCESS";
    }

    public static function is_wall_hidden($wallid, $memberid)
    {
        $sql = mysqli_query(self::$DB, "select * from `member-post-hide` where `wallid` = '$wallid' && `memberid` = '$memberid'");

        if (mysqli_num_rows($sql) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function is_wall_like($wallid, $memberid)
    {
        $sql = mysqli_query(self::$DB, "select * from `member-post-like` where `wallid` = '$wallid' && `memberid` = '$memberid'");

        if (mysqli_num_rows($sql) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function listed_like_member_post_array($wallid)
    {

        $sql = mysqli_query(self::$DB, "select * from `member-post-like` where `wallid` = '$wallid'") or die(mysqli_error(self::$DB));

        $data = [];

        while ($row = mysqli_fetch_assoc($sql)) {
            $data[] = $row['memberid'];
        }

        return $data;
    }

    public static function update_post_description($wallid, $memberid, $description)
    {
        $sql = mysqli_query(self::$DB, "update `member-post` set `description` = '$description' where `wallid` = '$wallid' && `memberid` = '$memberid'");

        echo "SUCCESS";
    }

    public static function save_like_post_DB($memberid, $wallid)
    {
        $sql = mysqli_query(self::$DB, "INSERT INTO `member-post-like`(`wallid`, `memberid`) VALUES ('$wallid', '$memberid')");

        if ($sql) {
            return "SUCCESS";
        } else {
            return "FAILED";
        }
    }

    public static function getParentID($wallid)
    {
        $sql = mysqli_query(self::$DB, "select * from `member-post` where `wallid` = '$wallid'");
        return mysqli_fetch_assoc($sql)['memberid'];
    }

    public static function delete_like_post_DB($memberid, $wallid)
    {
        $sql = mysqli_query(self::$DB, "delete from `member-post-like` where `wallid` = '$wallid' && `memberid` = '$memberid'");
    }

    public static function total_like_post_DB($wallid)
    {
        $sql = mysqli_query(self::$DB, "select * from `member-post-like` where `wallid` = '$wallid'");

        return mysqli_num_rows($sql);
    }

    public static function save_post($parentid, $description = "", $date)
    {
        $description = addslashes(trim($description));

        $sql = mysqli_query(self::$DB, "INSERT INTO `member-post`(`memberid`, `parentid`, `description`, `date`, `level`) VALUES ('$parentid', '$parentid', '$description', '$date', '0')") or die(mysqli_error(self::$DB));


        $last_row = mysqli_insert_id(self::$DB);
        return $last_row;
    }

    public static function save_post_file($wallid, $filetype, $filename)
    {
        $sql = mysqli_query(self::$DB, "INSERT INTO `member-post-file`(`wallid`, `filetype`, `filename`) VALUES ( '$wallid', '$filetype', '$filename')") or die(mysqli_error(self::$DB));

        return true;
    }

    public static function post_file_wall($wallid, $memberid)
    {
        $sql = mysqli_query(self::$DB, "select a.filename, a.wallid, b.wallid, b.memberid from `member-post-file` a, `member-post` b where b.memberid = '$memberid' && b.wallid = '$wallid' && a.wallid = b.wallid");
        $data = [];
        while ($row = mysqli_fetch_assoc($sql)) {
            $data[] = $row;
        }

        return $data;
    }

    public static function post_edit_wall_description($wallid, $memberid, $description)
    {
        $sql = mysqli_query(self::$DB, "update `member-post` set `description` = '$description' where `wallid` = '$wallid' && `memberid` = '$memberid'");
        echo "SUCCESS";
    }

    public static function delete_posts_DB($wallid, $memberid)
    {
        $sql = mysqli_query(self::$DB, "delete from `member-post` where `wallid` = '$wallid' && `memberid` = '$memberid'") or die(mysqli_error(self::$DB));
        $sqla = mysqli_query(self::$DB, "delete from `member-post-file` where `wallid` = '$wallid'");
        return "DELETED";
    }

    public static function create_comment_post()
    {

    }

    public static function load_parent_user_last_post_DB($parentid)
    {
        $sql = mysqli_query(self::$DB, "select * from `member-post` where `parentid` =  '$parentid' ORDER BY `wallid` DESC LIMIT 1") or die("Error: " . mysqli_error(self::$DB));

        $rows = [];

        while ($row = mysqli_fetch_assoc($sql)) {
            $rows[] = $row;
        }

        return $rows;
    }

    public static function count_member_post_file_item($wallid)
    {
        $sql = mysqli_query(self::$DB, "select * from `member-post-file` where `wallid` = '$wallid'") or die("Error: " . mysqli_error(self::$DB));
        return mysqli_num_rows($sql);
    }

    public static function load_member_post_wall($wallid)
    {
        $sql = mysqli_query(self::$DB, "select * from `member-post-file` where `wallid` = '$wallid'") or die("Error: " . mysqli_error(self::$DB));

        $rows = [];

        while ($row = mysqli_fetch_assoc($sql)) {
            $rows[] = $row;
        }

        return $rows;
    }

    public static function load_member_post($page, $limit)
    {//ORDER BY `wallid` DESC
        $sql = mysqli_query(self::$DB, "select * from `member-post` order by `wallid` desc") or die("Error: " . mysqli_error(self::$DB));

        $rows = [];

        while ($row = mysqli_fetch_assoc($sql)) {
            $rows[] = $row;
        }

        return $rows;
    }

    public static function load_my_post($memberid, $limit = 0, $page = 0){
        $sql = mysqli_query(self::$DB, "select * from `member-post` where `memberid` = '$memberid' order by `wallid` desc") or die("Error: " . mysqli_error(self::$DB));

        $rows = [];

        while ($row = mysqli_fetch_assoc($sql)) {
            $rows[] = $row;
        }

        return $rows;
    }

    public static function load_post($wallid){
        $sql = mysqli_query(self::$DB, "select * from `member-post` where `wallid` = '$wallid'") or die("Error: " . mysqli_error(self::$DB));

        $rows = [];

        while ($row = mysqli_fetch_assoc($sql)) {
            $rows[] = $row;
        }

        return $rows;
    }

    /*POST COMMENT*/
    public static function load_commentDB($wallid, $limit = 0)
    {
        $sql = mysqli_query(self::$DB, "select * from `member-post-comment` where wallid = '$wallid'");

        $wallcomment = [];

        while ($comment = mysqli_fetch_assoc($sql)) {
            $wallcomment[] = $comment;
        }

        return $wallcomment;
    }

    public static function save_member_commentDB($wallid, $memberid, $date, $description, $filetype = "", $filename = "")
    {
        $description = addslashes(trim($description));
        if ($filetype == "" && $filename == "") {
            $result = mysqli_query(self::$DB, "insert into `member-post-comment` (`commentid`, `wallid`, `memberid`, `date`, `description`) values (NULL,'$wallid', '$memberid', '$date', '$description')") or die(mysqli_error(self::$DB));
        }else{
            $result = mysqli_query(self::$DB, "insert into `member-post-comment` (`commentid`, `wallid`, `memberid`, `date`, `description`, `filetype`, `filename`) values (NULL,'$wallid', '$memberid', '$date', '$description', '$filetype', '$filename')") or die(mysqli_error(self::$DB));
        }

        return true;
    }

    public static function comment_get_files($commentid){
        $sql = mysqli_query(self::$DB, "select * from `member-post-comment` where `commentid` = '$commentid'");
        $data = [];

        while($files = mysqli_fetch_assoc($sql)){
            $data[] = $files['filename'];
        }

        return $data;
    }

    public static function load_member_commentDB($wallid, $memberid)
    {
        $result = mysqli_query(self::$DB, "select * from `member-post-comment` where `wallid` = '$wallid' && `memberid` = '$memberid' ORDER BY `commentid` DESC LIMIT 1") or die(mysqli_error(self::$DB));

        $data = [];

        while ($comment_tb = mysqli_fetch_assoc($result)) {
            $data[] = $comment_tb;
        }

        return $data;
    }

    public static function delete_member_commentDB($commentid, $memberid){
        $sql = mysqli_query(self::$DB, "delete from `member-post-comment` where `commentid` = '$commentid' && `memberid` = '$memberid'");

        return true;
    }

    public static function comment_containFile($commentid, $memberid){
        $sql = mysqli_query(self::$DB, "select * from `member-post-comment` where `commentid` = '$commentid' && `memberid` = '$memberid'");

        while($row = mysqli_fetch_assoc($sql)){
            if($row['filetype'] =="" && $row['filename'] == ""){
                return false;
            }else{
                return true;
            }
        }
    }
    /*POST COMMENT END*/

}
