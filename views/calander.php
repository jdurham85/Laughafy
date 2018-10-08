<?php
/**
 * Created by PhpStorm.
 * User: jermainedurham
 * Date: 10/4/18
 * Time: 4:56 PM
 */

require "inner_header.php";
require "core/events_inc.php";

$event = new events_inc();

$event->header();
$event->calander_page();
