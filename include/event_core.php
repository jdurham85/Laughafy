<?php
session_start();

require "core_file.php";
$event = new events_inc();
$db = new database();

if (!empty($_POST)) {

    switch (true) {
        case $_POST['CREATEEVENT']:

            if($event::create_event($_POST, $_FILES)){
                echo $event::parent_event_load();
            }
            break;

        case $_POST['myevent']:
            echo $event::parent_event_load();
            break;

        case $_POST['location-list']:

            break;
    }
}