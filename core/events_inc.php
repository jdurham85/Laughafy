<?php

class events_inc
{
    static function header()
    {
        require_once "core/friend.php";
        require_once "model/friendd.php";
        ?>
        <link rel="stylesheet" href="css/events.css">
        <script type="text/javascript" src="js/events.js"></script>
        <div id="event_menu">
            <div class="event_menu_btn" onclick="location = 'events'">Events</div>
            <div class="event_menu_btn" onclick="location = 'birthday'">Birthdays</div>
            <div class="event_menu_btn" onclick="location = 'calander'">Calander</div>
        </div>
        <?php
    }

    public static function event_page()
    {
        ?>
        <button id="event_add_btn" onclick="event_add_tb_show();">Create Event</button>
        <div id="event_add_tb">
            <form id="eventFrm">
                <div class="event_title">Create Event</div>
                <input type="hidden" id="CREATEEVENT" name="CREATEEVENT" value="TRUE"/>
                <select id="event-level" name="event-level">
                    <option value="Public">Public - Everyone get to see this event.</option>
                    <option value="Private">Private - Invite guest like friends or anyone.</option>
                </select>
                <input type="text" id="event_title" name="event_title" placeholder="Add Title Here"/>
                <textarea id="event-description" name="event-description"
                          placeholder="Add Event Description here"></textarea>
                <input type="datetime-local" id="event-datetime" name="event-datetime"/>
                <input type="text" id="event-location" name="event-location" placeholder="Add Location"/>
                <button type="submit" id="event_frm_add_btn" name="event_frm_add_btn" class="btn-block btn">Add Event
                </button>
            </form>
        </div>
        <script type="text/javascript">
            function event_menu_close() {
                $("#event_add_tb").fadeOut();
            }

            function event_menu_show() {
                $("#event_add_tb").fadeIn();
            }
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $(".event_menu_btn:eq(0)").css("border-bottom", "6px black solid");
            });
        </script>
        <div class="event_item" style="display: none;"></div>
        <?php
        //self::parent_event_load();
    }

    public static function birthday_page()
    {
        ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $(".event_menu_btn:eq(1)").css("border-bottom", "6px black solid");
            });
        </script>
        <?php
    }

    public static function calander_page()
    {
        ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $(".event_menu_btn:eq(2)").css("border-bottom", "6px black solid");
            });
        </script>
        <div id="calander_box">

        </div>
        <?php
    }

    static function parent_event_load()
    {

        /*if(file_exists("model/eventsd.php")){
            require_once "model/eventsd.php";
        }elseif(file_exists("../model/eventsd.php")){
            require_once "../model/eventsd.php";
        }*/

        $myevents = eventsd::parent_event_load(config::get_member_id());
        //$myevents = null;
        if (count($myevents) != 0) {
            /*
             *
        Array
                (
                    [eventid] =&gt; 4
                    [memberid] =&gt; 1
                    [event-level] =&gt; Public
                    [title] =&gt; Birthday Party
                    [description] =&gt; Birthday will be held in Downtown Henderson on Main St.
                    [date] =&gt; 10/20/2018
                    [time] =&gt; 22:00
                    [location] =&gt; Henderson, North Carolina
                )
             */
        }
        for ($i = 0; $i < count($myevents); $i++) {

            $hour = explode(":", $myevents[$i]['time'])[0];
            $min = explode(":", $myevents[$i]['time'])[1];

            $am_pm = (($hour > 12 || 23 < $hour) ? "PM" : "AM");

            $hour = self::time_12_format($hour);

            $time = $hour . ":" . $min . " " . $am_pm;
            ?>
            <div class="event_box" id="eventbox<?php echo $myevents[$i]['eventid']; ?>">
                <?php
                echo '<div class="event_item" style="border-bottom: none; border-bottom: 2px black solid; line-height: 1px; font-size: 16px; text-align: center;"> Hosted By: ' . profiled::MemberFullName($myevents[$i]['memberid']) . '</div>';
                echo '<div class="event_title" style="border-bottom: none;  line-height: 50px; font-size: 22px;">' . $myevents[$i]['title'] . '</div>';
                echo '<div class="event_item" style="text-align: center; font-size: 16px; padding: .6em;">' . $myevents[$i]['date'] . ' @ ' . $time . '</div>';
                echo '<div class="event_item" style="text-align: center; font-size: 16px; padding: .6em;"> ' . $myevents[$i]['location'] . '</div>';
                echo '<div class="event_item" style="text-align: center; font-size: 16px; padding: .6em;">' . $myevents[$i]['description'] . '</div>';
                ?>
            </div>
            <?php
        }
        if (count($myevents) == 0) {
            ?>
            <div class="event_item">
                No event added.
            </div>
            <?php
        }
    }

    static function create_event($events, $event_file = [])
    {
        $eventlevel = $events['event-level'];
        $eventName = $events['event_title'];
        $eventDescription = config::word_filter($events['event-description']);
        $datetime = explode("T", $events['event-datetime']);
        $location = $events['event-location'];

//$date = array();
        $year['year'] = explode("-", $datetime[0])[0];
        $month['month'] = explode("-", $datetime[0])[1];
        $day['date'] = explode("-", $datetime[0])[2];

        $time = $datetime[1];

        if (count($event_file) > 0) {
            eventsd::event_save(config::get_member_id(), $eventlevel, $eventName, $eventDescription, $event_file, $month['month'], $day['date'], $year['year'], $time, $location);
        } else {
            eventsd::event_save(config::get_member_id(), $eventlevel, $eventName, $eventDescription, $event_file, $month['month'], $day['date'], $year['year'], $time, $location);
        }

//eventsd::event_save(config::get_member_id(), $eventlevel, $eventName, $eventDescription, $event_file, $month, $day, $year, $time, $location);

        return true;
    }

    static function location_list($location)
    {

    }

    /*static function getmemberid()
    {
        $sql = mysqli_query(database::$DB, "select * from `member`");

        $memberid = [];

        while ($id = mysqli_fetch_assoc($sql)) {
            if ($id['memberid'] != "1") {
                $memberid[] = $id['memberid'];
            }
        }

        return $memberid;
    }*/

    private static function birthday_date_format($birthday)
    {
        $month = ['null', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        if (strpos($birthday, "/")) {
            $birth = explode("/", $birthday);
            return $month[$birth[0]] . ", " . $birth[1];
        }
    }

    static function birthday_list()
    {
        $myfriendid = friend::my_friends_birthday_list();

        //sort($myfriendid, "dob");

        $month = date("m");
        $day = date("n");
        $year = date("Y");

        ?>
        <div class="birthday-title" style="text-align: center; font-weight: bold;">Today - Birthday</div><?php

        foreach ($myfriendid as $friendbirthday) {
            $friend_birth_month = explode("/", $friendbirthday['dob'])[0];
            $friend_birth_day = explode("/", $friendbirthday['dob'])[1];

            if ($month == $friend_birth_month && $day == $friend_birth_day) {
                ?>
                <div class="birthday-title">
                    <img class="birthday_ico" src="image/birthday_ico.png"/>
                    <?php echo profiled::MemberFullName($friendbirthday['frommemberid']); ?>
                </div>
                <?php
            }
        }


        ?>
        <div class="birthday-title" style="text-align: center; font-weight: bold;">Upcoming - Birthday</div><?php
        foreach ($myfriendid as $friendbirthday) {
            $friend_birth_month = explode("/", $friendbirthday['dob'])[0];
            $friend_birth_day = explode("/", $friendbirthday['dob'])[1];

            $friend_birthday = $friend_birth_month . "/" . $friend_birth_day;

            if ($month == $friend_birth_month && $day != $friend_birth_day) {
                ?>
                <div class="birthday-title">
                    <img class="birthday_ico" src="image/birthday_ico.png"/>
                    <?php echo profiled::MemberFullName($friendbirthday['frommemberid']) . " " . self::birthday_date_format($friend_birthday); ?>
                </div>
                <?php

            }
        }
    }

    private static function time_12_format($hour)
    {
        //if($hour > "00" && "09" < $hour){
        switch ($hour) {
            case "00":
                return "12";
                break;

            case "01":
                return "1";
                break;

            case "02":
                return "2";
                break;

            case "03":
                return "3";
                break;

            case "04":
                return "4";
                break;

            case "05":
                return "5";
                break;

            case "06":
                return "6";
                break;

            case "07":
                return "7";
                break;

            case "08":
                return "8";
                break;

            case "09":
                return "9";
                break;

            case "10":
                return "10";
                break;

            case "11":
                return "11";
                break;

            case "12":
                return "12";
                break;

            case "13":
                return "1";
                break;

            case "14":
                return "2";
                break;

            case "15":
                return "3";
                break;

            case "16":
                return "4";
                break;

            case "17":
                return "5";
                break;

            case "18":
                return "6";
                break;

            case "19":
                return "7";
                break;

            case "20":
                return "8";
                break;

            case "21":
                return "9";
                break;

            case "22":
                return "10";
                break;

            case "23":
                return "11";
                break;

            case "default": {

                return $hour;
                break;
            }

        }
        //}else{
        //return $hour;
        //}
    }
}

?>