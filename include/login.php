<?php
/**
 * .
 * User: Jermaine Durham
 * Date: 7/2/18
 * Time: 9:23 AM
 */

require "../model/database.php";

$login_db = new database();

$login_db::login($_POST);

