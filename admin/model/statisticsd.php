<?php

/**
 * Created by PhpStorm.
 * User: jermainedurham
 * Date: 9/12/18
 * Time: 6:33 PM
 */
class statisticsd extends database
{
    static function member_statistics(){
        $sql = mysqli_query(self::$DB, "select * from `member`");

        $memberid = [];

        while($id = mysqli_fetch_assoc($sql)){
            $memberid[] = $id;
        }

        return $memberid;
    }
}