<?php
/**
 * .
 * User: Jermaine Durham
 * Date: 7/2/18
 * Time: 8:14 AM
 */

require_once "core/config.php";
require "core/controller.php";
require "model/database.php";
require "model/profiled.php";

$config = new config();


$controller = new controller();
$controller->addURL("createaccount");

$controller->addURL("test");
$controller->addURL("user");

$controller->autoload();

$database = new database();

//$view = new views();
