<?php

class searchd extends database
{
    public static function search($searchtxt, $searchtype = '')
    {

        //$searchtxt = htmlspecialchars($searchtxt);
       // $searchResult = explode(" ", $searchtxt);


        $sql = mysqli_query(self::$DB, "select `memberid` from `member` where `first` like '%$searchtxt' or `last` like '%$searchtxt' or `email` = '$searchtxt'") or die(mysqli_error(self::$DB));


        $data = [];
        if(mysqli_num_rows($sql) > 0){
            while ($s = mysqli_fetch_assoc($sql)) {
                $data[] = $s;
            }
        }
        else{
            $data["NORESULT"] = "There is nothing for " . $searchtxt;
        }

        return $data;
    }
}

?>