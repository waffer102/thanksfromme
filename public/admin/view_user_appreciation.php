<?php
require_once("../../includes/initialize.php");

//verify user is logged in
if (!$session->is_logged_in()) {
    redirect_to("../login.php");
}
//load role permissions and check if they have access
$permissions = Role_Perm::get_role_perms($session->roleid);
if (!$permissions->permissions['User Management']){
    $session->set_message("You do not have access to User Management", "danger");
    redirect_to("../main.php");
}
//check to see if a user was selected
if (isset($_GET['id'])) {
    $user_id = $database->escape_value($_GET['id']);
} else {
    redirect_to("../main.php");
}

//load all appreciation for a user, eventually add a filter option
$appreciations = Appreciation::find_by_sql("SELECT * FROM appreciation WHERE receiver_id = ".$user_id." ORDER BY date_given");
?>

<?php include_layout_template("header.php"); ?>
<?php include_layout_template("admin_sidebar.php"); ?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<?php echo output_message($session->get_message(), $session->get_alert_type()); ?>
<h2 class="sub-header">View User Appreciation - <?php echo get_full_name($user_id); ?></h2>

    <?php
    if (empty($appreciations)) {
        echo output_message("There is nothing to show here!", "success");
    } else { ?>
    <div class="modal fade" id="view-details" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">View Appreciation Details</h4>
                </div>
            
                <div class="modal-body">
                    
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Given By</th>
                    <th>Date Given</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Point Value</th>
                    <th>Status</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($appreciations as $appreciation) { ?>
                <tr>
                    <td><?php echo get_full_name($appreciation->giver_id); ?></td>
                    <td><?php echo $appreciation->date_given; ?></td>
                    <td><?php echo get_category_name($appreciation->category_id); ?></td>
                    <td><?php echo $appreciation->description; ?></td>
                    <td><?php echo $appreciation->point_value; ?></td>
                    <td><?php echo get_status_name($appreciation->status_id); ?></td>
                    <td><a href="edit_appreciation.php?id=<?php echo $appreciation->id; ?>">Edit</a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>

</div>
<?php include_layout_template("admin_footer.php"); ?>