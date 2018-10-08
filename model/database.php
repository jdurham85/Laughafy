<?php

/**
 * .
 * User: Jermaine Durham
 * Date: 7/2/18
 * Time: 8:55 AM
 */
class database
{
    public static $DB_HOST = "localhost";
    public static $DB_USER = "jermaine";
    public static $DB_PASSWORD = "******";
    public static $DB_NAME = "laughafy";
    public static $DB = "";

    function __construct()
    {
        self::$DB = new mysqli(self::$DB_HOST, self::$DB_USER, self::$DB_PASSWORD, self::$DB_NAME) or die("DATABASE ERROR");
    }

    public static function createaccount($data)
    {
        $data['first'] = trim($data['first']);
        $data['last'] = trim($data['last']);
        $data['email'] = trim($data['email']);
        $data['pass'] = md5(trim($data['pass']));

        $dob = $data['dobDay'] . "/" . $data['dobMonth'] . "/" . $data['dobYear'];

        //$dob = strtotime($dob . " 12:00");

        $signdate = time();

        $query = "INSERT INTO `member`(`first`, `last`, `email`, `password`, `country`, `state`, `city`, `gender`, `dob`, `signdate`) VALUES ('" . $data['first'] . "', '" . $data['last'] . "', '" . $data['email'] . "', '" . $data['pass'] . "', '" . $data['country'] . "', '" . $data['region'] . "', '" . $data['city'] . "', '" . $data['gender'] . "', '$dob', '$signdate')";

        $sql = mysqli_query(self::$DB, $query) or die(mysqli_error(self::$DB));

        $memberid = mysqli_insert_id(self::$DB);

        //print_r($data);

        require_once "../core/session_cookie_managerment.php";

        $sm = new session_cookie_managerment();

        $sm::create_session($memberid, $data['pass']);
        $sm::create_cookie();

        echo 1;
    }

    public static function login($data)
    {
        $data['email'] = trim($data['email']);
        $data['pass'] = md5($data['pass']);

        $sql = mysqli_query(self::$DB, "select * from `member` where `email` = '" . $data['email'] . "' && `password` = '" . $data['pass'] . "' ") or die(mysqli_error(self::$DB));

        if (mysqli_num_rows($sql) > 0) {

            while ($d = mysqli_fetch_array($sql)) {
                require_once "../core/session_cookie_managerment.php";

                $sm = new session_cookie_managerment();

                $sm::create_session($d['memberid'], $d['password']);
                $sm::create_cookie();

                echo 1;
            }
        } else {
            echo 0;
        }
    }

    public static function check_exist_account($email)
    {
        $sql = mysqli_query(self::$DB, "select * from `members` where `email` = '$email'") or die();
        echo mysqli_num_rows($sql);
    }

    public static function getCountryNameByID($countryid)
    {
        $sql = mysqli_query(self::$DB, "select * from `countries` where `id` = '$countryid'");

        while ($row = mysqli_fetch_assoc($sql)) {
            return ($row);
        }

    }

    public static function getRegionNameByID($regionid)
    {
        $sql = mysqli_query(self::$DB, "select * from `regions` where `id` = '$regionid'");

        while ($row = mysqli_fetch_assoc($sql)) {
            return $row;
        }

    }

    public static function getCityNameByID($cityid)
    {
        $sql = mysqli_query(self::$DB, "select * from `cities` where `id` = '$cityid'");

        while ($row = mysqli_fetch_assoc($sql)) {
            return $row;
        }

    }

    public static function getCountry()
    {
        $sql = mysqli_query(self::$DB, "select * from `countries`") or die();
        while ($d = mysqli_fetch_array($sql)) {
            echo "<option value='" . $d['id'] . "'>" . $d['name'] . "</option>";
        }
    }

    public static function getRegion($countrycode)
    {
        $sql = mysqli_query(self::$DB, "select * from `regions` where `country_id` = '$countrycode'") or die();
        while ($d = mysqli_fetch_array($sql)) {
            echo "<option value='" . $d['id'] . "'>" . $d['name'] . "</option>";
        }
    }

    public static function getCity($regioncode)
    {
        $sql = mysqli_query(self::$DB, "select * from `cities` where `region_id` = '$regioncode'") or die();
        while ($d = mysqli_fetch_array($sql)) {
            echo "<option value='" . $d['region_id'] . "'>" . $d['name'] . "</option>";
        }
    }
}