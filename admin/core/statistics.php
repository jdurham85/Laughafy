<?php

/**
 * Created by PhpStorm.
 * User: jermainedurham
 * Date: 9/12/18
 * Time: 6:34 PM
 */
class statistics
{
    static function member_statistics()
    {

    }

    static function member_statistic_chart()
    {
        $ms = statisticsd::member_statistics();

        /*//array("y" => 6, "label" => date()),
            array("y" => 4, "label" => "Mango"),
            array("y" => 5, "label" => "Orange"),
            array("y" => 7, "label" => "Banana"),
            array("y" => 4, "label" => "Pineapple"),
            array("y" => 6, "label" => "Pears"),
            array("y" => 7, "label" => "Grapes"),
            array("y" => 5, "label" => "Lychee"),
            array("y" => 4, "label" => "Jackfruit")
            );*/

        $startdate = "";

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        $Current_Year = date("Y");

        $data = [];
        $dataPoints = [];

        //echo date("M d, Y", $ms[0]['signdate']);
        //echo date("M", $ms['date']);

        $total_member_each_month = 0;

        //for ($i = 0; $i < count($ms); $i++) {
        for ($m = 0; $m < count($months); $m++) {
            while ($months[$m] == date("M", $ms['signdate'])) {
                $total_member_each_month++;
            }

            $data = array("y" => $total_member_each_month, "label" => $months[$m]);
            $total_member_each_month = 0;
        }
        //}

        $dataPoints = $data;

        return $dataPoints;
    }
}