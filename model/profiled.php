<?php

/**
 * .
 * User: Jermaine Durham
 * Date: 7/10/18
 * Time: 10:36 PM
 */
class profiled extends database
{

    public static function update_member_cityid($memberid, $cityid)
    {
        $sql = mysqli_query(self::$DB, "update `member` set `city` = '$cityid' where `memberid` = '$memberid'") or die(mysqli_error(self::$DB));
        return true;
    }

    public static function update_member_stateid($memberid, $stateid)
    {
        $sql = mysqli_query(self::$DB, "update `member` set `state` = '$stateid' where `memberid` = '$memberid'") or die(mysqli_error(self::$DB));
        return true;
    }

    public static function update_member_countryid($memberid, $countryid)
    {
        $sql = mysqli_query(self::$DB, "update `member` set `country` = '$countryid' where `memberid` = '$memberid'") or die(mysqli_error(self::$DB));
        return true;
    }

    public static function update_member_location($memberid, $longitude, $latatude)
    {

    }

    public static function get_member_current_location($memberid)
    {

    }

    public static function set_profile_picture($memberid, $filename)
    {
        $sql = mysqli_query(self::$DB, "update `member` set `profile-picture` = '$filename' where `memberid` = '$memberid'");
    }

    public static function MemberCountry($memberid)
    {
        $sql = mysqli_query(self::$DB, "select * from `member` where `memberid` = '$memberid'");

        return self::getCountryNameByID(mysqli_fetch_assoc($sql)['country']);
    }

    public static function MemberCountryName($memberid)
    {
        $sql = mysqli_query(self::$DB, "select * from `member` where `memberid` = '$memberid'");

        return self::getCountryNameByID(mysqli_fetch_assoc($sql)['country'])['name'];
    }

    public static function MemberRegion($memberid)
    {
        $sql = mysqli_query(self::$DB, "select * from `member` where `memberid` = '$memberid'");

        return self::getRegionNameByID(mysqli_fetch_assoc($sql)['state']);
    }

    public static function MemberRegionName($memberid)
    {
        $sql = mysqli_query(self::$DB, "select * from `member` where `memberid` = '$memberid'");

        return self::getRegionNameByID(mysqli_fetch_assoc($sql)['state'])['name'];
    }

    public static function MemberCity($memberid)
    {
        $sql = mysqli_query(self::$DB, "select * from `member` where `memberid` = '$memberid'");

        return self::getCityNameByID(mysqli_fetch_assoc($sql)['city']);
    }

    public static function MemberCityName($memberid)
    {
        $sql = mysqli_query(self::$DB, "select * from `member` where `memberid` = '$memberid'");

        return self::getCityNameByID(mysqli_fetch_assoc($sql)['city'])['name'];
    }

    public static function MemberFirstName($memberid)
    {
        $sql = mysqli_query(self::$DB, "select * from `member` where `memberid` = '$memberid'") or die(mysqli_error(self::$DB));
        return mysqli_fetch_assoc($sql)['first'];
    }

    public static function MemberLastName($memberid)
    {
        $sql = mysqli_query(self::$DB, "select * from `member` where `memberid` = '$memberid'") or die(mysqli_error(self::$DB));
        return mysqli_fetch_assoc($sql)['last'];
    }

    public static function MemberFullName($memberid)
    {
        $sql = mysqli_query(self::$DB, "select * from `member` where `memberid` = '$memberid'") or die(mysqli_error(self::$DB));

        $data = mysqli_fetch_assoc($sql);

        return $data['first'] . " " . $data['last'];
    }

    public static function MemberGender($memberid)
    {
        $sql = mysqli_query(self::$DB, "select * from `member` where `memberid` = '$memberid'") or die(mysqli_error(self::$DB));
        return mysqli_fetch_assoc($sql)['gender'];
    }

    public static function MemberProfilePic($memberid)
    {

        $sql = mysqli_query(self::$DB, "select * from `member` where `memberid` = '$memberid'") or die(mysqli_error(self::$DB));
        while ($p = mysqli_fetch_assoc($sql)) {
            if ($p['profile-picture'] == "") {
                if (self::MemberGender($memberid) == "female") {
                    echo "image/no-profile-picture-female.jpg";
                } else {
                    echo "image/no-profile-picture-male.jpg";
                }
            } else {
                echo "views/profile/" . $memberid . "/profile-picture/" . $p['profile-picture'];
            }
        }
    }

    public static function MemberDeletePhoto($fileid, $filename)
    {
        $result = mysqli_query(self::$DB, "delete from `member-file` where `fileid` = '$fileid' && `filename` = '$filename'");

        return true;
    }

    public static function MemberBirthday($memberid)
    {
        $sql = mysqli_query(self::$DB, "select `dob` from `member` where `memberid` = '$memberid'");

        return mysqli_fetch_assoc($sql)['dob'];
    }
}
