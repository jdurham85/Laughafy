<?php
/**
 * .
 * User: Jermaine Durham
 * Date: 7/3/18
 * Time: 8:24 AM
 */

require "../model/database.php";

$db = new database();
$db::getCity($_POST['regioncode']);