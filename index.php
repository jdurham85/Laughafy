<?php
/**
 * .
 * User: Jermaine Durham
 * Date: 7/2/18
 * Time: 8:14 AM
 */

session_start();
require_once "core/config.php";
require_once "core/meta.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laughfy</title>
    <link rel="stylesheet" href="css/bootstrap-reboot.css">
    <link rel="stylesheet" href="css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/theme1.css">
    <link rel="stylesheet" href="css/post.css">
    <link rel="stylesheet" href="css/profile_style.css">
    <link rel="stylesheet" href="css/notification.css">
    <link rel="stylesheet" href="css/message.css">
    <link rel="stylesheet" href="css/friend_style.css">
    <link rel="stylesheet" href="css/search.css">
    <?php meta::meta_data(); ?>
</head>
<script type="text/javascript" src="js/account-setting_inc.js"></script>
<script src="js/jquery-3.3.1.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/bootstrap.bundle.min.js" type="text/javascript"></script>
<body>
<?php
include "route.php";
?>
</body>
</html>
