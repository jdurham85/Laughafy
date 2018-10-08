<?php
require "inner_header.php";

$config = new config();

function getmemberid()
{
    $sql = mysqli_query(database::$DB, "select * from `member`");

    $memberid = [];

    while ($id = mysqli_fetch_assoc($sql)) {
        //if ($id['memberid'] != "1" || $id['memberid'] != "2") {
        $memberid[] = $id['memberid'];
        //}
    }

    return $memberid;
}

$memberid = getmemberid();

for ($i = 0; $i < count($memberid); $i++) {
    //$month = rand(1, 12);
    //$day = rand(1, 31);
    //$year = rand(1950, 2000);

    //$dob = $month . "/" . $day . "/" . $year;

    //$query = "update `member` set `dob` = '$dob' where `memberid` = '".$memberid[$i]."'";

    if($memberid[$i] != $config->get_session_id()){
        $query = "INSERT INTO `member-friends`(`tomemberid`, `frommemberid`, `status`) VALUES ('" . $memberid[$i] . "', '" . $config->get_session_id() . "', '2')";

        mysqli_query(database::$DB, $query);

        $query = "INSERT INTO `member-friends`(`tomemberid`, `frommemberid`, `status`) VALUES ('" . $config->get_session_id() . "', '" . $memberid[$i] . "', '2')";

        mysqli_query(database::$DB, $query);
    }
}


?>