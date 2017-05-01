<?php
require_once("../../includes/initialize.php");

if (!$session->is_logged_in()) {
    redirect_to("../login.php");
}

$permissions = Role_Perm::get_role_perms($session->roleid);

if (!$permissions->permissions['Admin Menu']){
    $session->set_message("You do not have access to view this page", "danger");
    redirect_to("../main.php");
}

global $database;
//get data for bar chart
$sql  = "SELECT DISTINCT user_history.business_unit_id, business_unit.business_unit_code, SUM(appreciation.point_value)";
$sql .= "FROM appreciation";
$sql .= " JOIN user_history";
$sql .= " ON appreciation.receiver_history_id = user_history.id";
$sql .= " INNER JOIN business_unit";
$sql .= " ON user_history.business_unit_id = business_unit.id";
$sql .= " WHERE appreciation.status_id = 4";
$sql .= " GROUP BY user_history.business_unit_id";
$result = $database->query($sql);
while ($row = $database->fetch_array($result)) {
    $bar_label .= "\"".$row['business_unit_code']."\", ";
    $bar_data .= $row['SUM(appreciation.point_value)'].", ";
}

//get data for line chart
$sql_line  = "SELECT MONTHNAME(date_approved), SUM(point_value)";
$sql_line .= " FROM appreciation";
$sql_line .= " WHERE status_id = 4 AND date_approved <= NOW() AND date_approved >= DATE_ADD(NOW(),INTERVAL - 12 month)";
$sql_line .= " GROUP BY YEAR(date_approved), MONTH(date_approved)";
$result_line = $database->query($sql_line);
while ($row = $database->fetch_array($result_line)) {
    $line_label .= "\"".$row['MONTHNAME(date_approved)']."\", ";
    $cum_points = $cum_points + $row['SUM(point_value)'];
    $line_data .= $cum_points.", ";
}

?>
<?php include_layout_template("header.php"); ?>
<?php include_layout_template("admin_sidebar.php"); ?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<?php echo output_message($session->get_message(), $session->get_alert_type()); ?>
<h1 class="page-header">Dashboard</h1>

<section class="row text-center placeholders">
    <div class="col-6 col-sm-6 placeholder">
        <label for = "myChart">Total Points by Business Unit<br /></label>
        <canvas id="myChart"></canvas>
        <script>
        
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: [<?php echo rtrim($bar_label, ", "); ?>],
            datasets: [
                {
                    backgroundColor: "rgba(153,255,51,1)",
                    data: [<?php echo rtrim($bar_data, ", "); ?>]
                }
            ]
          },
          options: {
          legend: {
            display: false,
              labels: {
                display: false
              }
          }
        }  
        });
        </script>

    </div>
    <div class="col-6 col-sm-6 placeholder">
        <label for = "myChart">Total Points Prior 12 Months<br /></label>
        <canvas id="linechart"></canvas>
        <script>
        
        var ctx = document.getElementById("linechart").getContext('2d');
        var linechart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: [<?php echo rtrim($line_label, ", "); ?>],
            datasets: [
                {
                    backgroundColor: "rgba(153,255,51,1)",
                    data: [<?php echo rtrim($line_data, ", "); ?>]
                }
            ]
          },
          options: {
          legend: {
            display: false,
              labels: {
                display: false
              }
          }
        }  
        });
        </script>
    </div>
</section>


<?php include_layout_template("admin_footer.php"); ?>