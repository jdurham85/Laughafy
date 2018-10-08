<?php
/**
 * Created by PhpStorm.
 * User: jermainedurham
 * Date: 9/12/18
 * Time: 2:36 PM
 */

$APP_DIR = $_SERVER['DOCUMENT_ROOT'];
$APP_NAME = "laughfy";

//CORE
require "core/statistics.php";

//MODEL
require "../model/database.php";
require "model/statisticsd.php";

$db = new database();
$s = new statistics();


$dataPoints = $s::member_statistic_chart();

?>
<script type="text/javascript">
    $(function () {
        var chart = new CanvasJS.Chart("chartContainer", {
            theme: "theme1",
            animationEnabled: true,
            title: {
                text: "Client's Growth"
            },
            data: [
                {
                    type: "line",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }
            ]
        });
        chart.render();
    });
</script>
<div id="admin_dashboard_body">
    <div id="admin_new_user_pl">Today New Users: 234</div>
    <div id="admin_feedback-rating_pl">Feedback Rating: A+</div>
    <div id="admin_container-chart">
        <div id="chartContainer"></div>
    </div>
</div>
