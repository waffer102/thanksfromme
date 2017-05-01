<?php
require_once("../../includes/initialize.php");

//verify user is logged in
if (!$session->is_logged_in()) {
    redirect_to("../login.php");
}
//load role permissions and check if they have access
$permissions = Role_Perm::get_role_perms($session->roleid);
if (!$permissions->permissions['Service Award Management']){
    $session->set_message("You do not have access to Service Award Management.", "danger");
    redirect_to("../main.php");
}

//load current company configuration
$current_settings = Company_Configuration::load_config();

if (isset($_POST['submit'])) {
    $current_settings->auto_service_award = $database->escape_value($_POST['auto_award']);
    $current_settings->auto_service_from = $database->escape_value($_POST['default_user']);
    
    if ($current_settings->update()) {
        $session->set_message("Service award configuration has been updated.", "success");
        redirect_to("service_management.php");
    } else {
        $session->set_message("An error has occured while updating database.", "danger");
        redirect_to("service_management.php");
    }
}
?>
<?php include_layout_template("header.php"); ?>
<?php include_layout_template("admin_sidebar.php"); ?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <?php echo output_message($session->get_message(), $session->get_alert_type()); ?>
    <h2 class="sub-header">Service Award Configuration</h2>

    <form method="POST" action="config_service.php">
        <div class="form-group">
        <label for="auto_award">Do you want the system to automatically award service awards?</label>
            <select class="form-control" id="auto_award" name="auto_award" required>
                <option value="1"<?php if($current_settings->auto_service_award == 1) { echo " selected"; } ?>>Yes</option>
                <option value="0"<?php if($current_settings->auto_service_award == 0) { echo " selected"; } ?>>No</option>
            </select>
        </div>
        <div class="form-group">
            <label for="default_user">Who should automatic service awards come from?</label>
                <select id="default_user" name="default_user" class="form-control" placeholder="Select a recipient..." required>
                	<option value="">Select a user...</option>
                    <?php 
                    $sql = "SELECT * FROM user WHERE status_id=1 ORDER BY last_name"; 
                    $query = $database->query($sql);
                    while($row = $database->fetch_array($query)) {
                        $user_id = $row['id'];
                        $first_name = $row['first_name'];
                        $last_name = $row['last_name'];
                        echo "<option value=\"".$user_id."\"";
                        if ($current_settings->auto_service_from == $user_id) { echo " selected"; }
                        echo ">".$last_name.", ".$first_name."</option>";;
                    }
                    ?>
                </select>
        </div>
        <br><a href="service_management.php"><button type="button" class="btn btn-danger">Cancel</button></a>  <input type="submit" class="btn btn-primary" value="Submit" name="submit">
    </form>
    
</div>
<?php include_layout_template("admin_footer.php"); ?>