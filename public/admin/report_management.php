<?php
require_once("../../includes/initialize.php");

//verify user is logged in
if (!$session->is_logged_in()) {
    redirect_to("../login.php");
}
//load role permissions and check if they have access
$permissions = Role_Perm::get_role_perms($session->roleid);
if (!$permissions->permissions['Report Management']){
    $session->set_message("You do not have access to Report Management", "danger");
    redirect_to("../main.php");
}
?>

<?php include_layout_template("header.php"); ?>
<?php include_layout_template("admin_sidebar.php"); ?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <?php echo output_message($session->get_message(), $session->get_alert_type()); ?>
    <h2 class="sub-header">Report Management</h2>
    <!-- <a href="add_report.php"><button type="button" class="btn btn-primary">&#43; Add New Report</button></a><br><br> -->
    <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Report Name</th>
                <th>Report Description</th>
                <td>Criteria</td>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <form method="POST" action="reports/userlist.php" target="_blank">
                <td>User List</td>
                <td>Displays a basic list of users.</td>
                <td>None Available</td>
                <td><input type="submit" class="btn btn-primary" value="Run" name="submit"></td>
                </form>
            </tr>
            <tr>
                <td>Redeemed Appreciation List</td>
                <td>Displays appreciation redeemed between two dates.</td>
                <td>
                    <form method="POST" action="reports/redeemed_appreciation.php" target="_blank" class="form-inline">
                    <label for="start_date">Start Date:</label><div class="form-group"><input class="form-control" type="date" id="start_date" name="start_date" required></div>
                    <label for="end_date">End Date:</label><div class="form-group"><input class="form-control" type="date" id="end_date" name="end_date" required></div></td>
                <td><input type="submit" class="btn btn-primary" value="Run" name="submit"></td>
                </form>
            </tr>
        </tbody>
    </table>
</div>
</div>
<?php include_layout_template("admin_footer.php"); ?>