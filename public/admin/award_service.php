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

if (isset($_POST['submit'])) {
        $rec_id = $_POST['receiver_id'];
        $appreciation = new Appreciation();
        
        $category_points = $database->escape_value($_POST['category_points']);
        $explode_category_points = explode('|', $category_points);
        
        $appreciation->receiver_id = $rec_id;
        $appreciation->receiver_history_id = current_user_history($rec_id);
        $appreciation->giver_id = $session->userid;
        $appreciation->giver_history_id = current_user_history($session->userid);
        $appreciation->date_given = date('Y-m-d H:i:s');
        $appreciation->category_id = $explode_category_points[0];
        $appreciation->description = "Good job, you got a service award: ".get_category_name($explode_category_points[0]);
        $appreciation->point_value = $explode_category_points[1];
        $appreciation->paid_out = 0;
        $appreciation->is_public = 1;
        $appreciation->status_id = 3;
        
        if ($appreciation->create()) {
            $session->set_message("Appreciation sucessfully submitted.", "success");
            redirect_to("award_service.php"); 
        } else {
            $session->set_message("An error has occured adding the recognition to the database.", "danger");
            redirect_to("award_service.php");
        }
    
}
?>

<?php include_layout_template("header.php"); ?>
<?php include_layout_template("admin_sidebar.php"); ?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <?php echo output_message($session->get_message(), $session->get_alert_type()); ?>
    <h2 class="sub-header">Manually Add Service Award</h2>

    <form method="POST" action="award_service.php">
        <div class="form-group">
            <label for="receiver_id">Select a user:</label>
                <select id="receiver_id" name="receiver_id" class="form-control" placeholder="Select a recipient..." required>
                	<option value="">Select a user...</option>
                    <?php 
                    $sql = "SELECT * FROM user WHERE status_id=1 AND id <> {$session->userid} ORDER BY last_name"; 
                    $query = $database->query($sql);
                    while($row = $database->fetch_array($query)) {
                        $user_id = $row['id'];
                        $first_name = $row['first_name'];
                        $last_name = $row['last_name'];
                        echo "<option value=\"".$user_id."\">".$last_name.", ".$first_name."</option>";
                    }
                    ?>
                </select>
        </div>
        <div class="form-group">
        <label for="category_points">Choose a service award:</label>
            <select class="form-control" id="category_points" name="category_points" required>
                <?php 
                $sql = "SELECT * FROM category WHERE is_reward = 2"; 
                $query = $database->query($sql);
                while($row = $database->fetch_array($query)) {
                    $value = $row['id'];
                    $name = $row['category_name'];
                    $points = $row['category_value'];
                    //$cat_perms = Category_Perm::get_cat_perms($value)
                    //if ($cat_perms//this needs to be finished, write function to get user BU and role and compare) {
                        echo "<option value=\"".$value."|".$points."\">".$name." | ".$points." points</option>";
                    //}
                }
                ?>
            </select>
        </div>
        <br><a href="service_management.php"><button type="button" class="btn btn-danger">Cancel</button></a>  <input type="submit" class="btn btn-primary" value="Submit" name="submit">
    </form>

</div>
</div>
<?php include_layout_template("admin_footer.php"); ?>