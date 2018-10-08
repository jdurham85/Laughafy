<?php
/**
 * .
 * User: Jermaine Durham
 * Date: 7/3/18
 * Time: 9:28 AM
 */

require "../model/database.php";

$db = new database();
$db::check_exist_account($_POST['email']);