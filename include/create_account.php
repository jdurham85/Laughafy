<?php
/**
 * .
 * User: Jermaine Durham
 * Date: 7/2/18
 * Time: 9:22 AM
 */

require "../core/config.php";

$config = new config();

require "../model/database.php";
$db_create_acc = new namespace\database();

$db_create_acc::create_account($_POST);