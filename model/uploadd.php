<?php

/**
 * .
 * User: Jermaine Durham
 * Date: 7/10/18
 * Time: 10:53 PM
 */
class uploadd extends database {

    public static $NEW_FILEID = 0;
    public static $FILE_APPROVE_PENDING = 1;
    public static $FILE_APPROVE = 0;
    public static $FILE_DECLINED = 1;

    public static function save_tmp_file_DB($memberid, $filename, $filetype) {
        $sql = mysqli_query(self::$DB, "INSERT INTO `member-tmp-file`(`fileid`, `memberid`, `filename`, `filetype`, `date`) VALUES (NULL, '$memberid','$filename','$filetype','" . time() . "')") or die(mysqli_error(self::$DB));

        //self::$NEW_FILEID = mysqli_insert_id(self::$DB);

        if ($sql) {
            return true;
        } else {
            return false;
        }
    }

    public static function delete_tmp_file_DB($memberid, $fileid) {
        mysqli_query(self::$DB, "delete from `member-tmp-file` where `fileid` = '$fileid' && `memberid` = '$memberid'");
        return true;
    }

    public static function load_tmp_file_DB($parentid) {
        $result = mysqli_query(self::$DB, "select * from `member-tmp-file` where `memberid` = '$parentid'");

        $DATA = [];
        while ($rows = mysqli_fetch_assoc($result)) {
            $DATA[] = $rows;
        }
        return $DATA;
    }

    public static function add_member_photo_DB($parentid, $memberid, $description = "", $filetype = "", $filename = "") {
        $result = mysqli_query(self::$DB, "INSERT INTO `member-file`(`fileid`, `parentid`, `memberid`, `description`, `filetype`, `filename`, `status`) VALUES (NULL,'$parentid', '$memberid', '$description', '$filetype', '$filename', '" . self::$FILE_APPROVE_PENDING . "')") or die(mysqli_error(self::$DB));

        return true;
    }

    public static function load_member_photo_DB($memberid, $page = 0) {


        $result = mysqli_query(self::$DB, "select * from `member-file` where `memberid` = '$memberid' ORDER BY `fileid` DESC")or die(mysqli_error(self::$DB));

        $files = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $files[] = $row;
        }

        return $files;
    }

    public static function delete_member_photo_DB($parentid, $memberid, $fileid) {
        $sql = mysqli_query(self::$DB, "delete from `member-file` where `fileid` = '$fileid' && `memberid` = '$memberid'") or die(mysqli_error($parentid));

        return true;
    }

}
