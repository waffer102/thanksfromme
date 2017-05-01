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

$categorys = Category::find_all(4);
?>
<?php include_layout_template("header.php"); ?>
<?php include_layout_template("admin_sidebar.php"); ?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <?php echo output_message($session->get_message(), $session->get_alert_type()); ?>
    <h2 class="sub-header">Service Award Management</h2>
    <a href="add_service.php"><button type="button" class="btn btn-primary">&#43; Add New Service Award</button></a> <a href="award_service.php"><button type="button" class="btn btn-primary">&#43; Manually Award Service Award</button></a> <a href="config_service.php"><button type="button" class="btn btn-primary">Configuration</button></a><br><br>
    <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Service Award Name</th>
                <th>Years of Service</th>
                <th>Service Award Value</th>
                <th>Status</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
    <?php foreach($categorys as $category) { ?>
            <tr>
                <td><?php echo $category->category_name; ?></td>
                <td><?php echo $category->category_description; ?></td>
                <td><?php echo $category->category_value; ?></td>
                <td><?php if($category->status_id == 1) { echo "Active"; } else { echo "Inactive"; } ?></td>
                <td><a href="edit_service.php?id=<?php echo $category->id; ?>">Edit</a> | <a href="delete_service.php?id=<?php echo $category->id; ?>">Delete</a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</div>
<?php include_layout_template("admin_footer.php"); ?>