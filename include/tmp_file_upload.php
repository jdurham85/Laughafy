<?php

/**
 * .
 * User: Jermaine Durham
 * Date: 7/10/18
 * Time: 11:19 PM
 */
session_start();

require 'core_file.php';

$config = new config();
$db = new database();

$up = new upload();

if (count($_FILES['file']['tmp_name'])) {
    $up::show_tmp_image($_FILES);
} else {
    if ($_POST['fileid'] && $_POST['filename']) {
        $up->delete_tmp_file($_POST['filename'], $_POST['fileid']);
    }
}


