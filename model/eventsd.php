<?php
/**
 * Created by PhpStorm.
 * User: jermainedurham
 * Date: 10/1/18
 * Time: 3:31 AM
 */
class eventsd extends database
{
    static function event_save($memberid, $eventlevel, $eventName, $eventDescription, $event_file = [], $month, $day, $year, $time, $location)
    {

        $date = $month . "/" . $day . "/" . $year;

        if (count($event_file) == 0) {
            $sql = mysqli_query(self::$DB, "INSERT INTO `events`(`eventid`, `memberid`, `event-level`, `title`, `description`, `date`, `time`, `location`) VALUES (null, '$memberid', '$eventlevel', '$eventName', '$eventDescription', '$date', '$time', '$location')") or die(mysqli_error(self::$DB));
        } else {
            
        }
    }

    static function parent_event_load($memberid)
    {
        $sql = mysqli_query(self::$DB, "select * from `events` where `memberid` = '$memberid'");

        $events = [];
        while($e = mysqli_fetch_assoc($sql)){
            $events[] = $e;
        }

        //$events = (count($events) == 0 ? NULL : $events);

        return $events;
    }

    static function event_update()
    {

    }
}