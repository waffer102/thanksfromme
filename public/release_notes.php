<?php
require_once("../includes/initialize.php");

//check if logged in and redirect if not
if (!$session->is_logged_in()) {
    redirect_to("login.php");
}
?>

<?php include_layout_template("header.php"); ?>
<?php echo output_message($session->get_message(), $session->get_alert_type()); ?>
<div class="container-fluid">
<div class="row">
<!-- left sidebar column -->
<?php include_layout_template("user_sidebar.php"); ?>

<!-- right main column -->
    <div class="col-md-9">
        <div class="fk">
            <ul class="ca bqf bqg agk">
                
                <li class="tu b ahx">
                    <h2>Release Notes</h2>
                </li>
                
                <li class="tu b ahx">
                    <p><strong>03/02/2017</strong> - There will be something here someday.</p>
                </li>
            </ul>
        </div>
    </div>
    
</div>
</div>
<?php include_layout_template("footer.php"); ?>