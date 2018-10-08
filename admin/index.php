<?php
/**
 * Created by PhpStorm.
 * User: jermainedurham
 * Date: 9/10/18
 * Time: 3:25 PM
 */
session_start();
require "../core/meta.php";
?>
<!doctype html>
<html>
<head>
    <title>Laughafy Admin</title>
    <?php meta::meta_data(); ?>

    <link rel="stylesheet" href="css/style1.css" />
    <link rel="stylesheet" href="../css/bootstrap-reboot.css" />
    <link rel="stylesheet" href="../css/bootstrap-grid.min.css" />
    <link rel="stylesheet" href="../css/bootstrap.min.css" />

    <script type="text/javascript" src="js/canvasjs.min.js"></script>
    <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../js/bootstrap.bundle.min.js" type="text/javascript"></script>
</head>
<body>
<?php require "admin-route.php";?>
</body>
</html>