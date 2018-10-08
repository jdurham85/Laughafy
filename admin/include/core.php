<?php
/**
 * Created by PhpStorm.
 * User: jermainedurham
 * Date: 9/12/18
 * Time: 6:36 PM
 */

session_start();
require "../../model/database.php";
require "../core/statistics.php";

require "../model/statisticsd.php";

$db = new database();
