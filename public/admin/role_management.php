<?php
require_once("../../includes/initialize.php");

//verify user is logged in
if (!$session->is_logged_in()) {
    redirect_to("../login.php");
}
//load role permissions and check if they have access
$permissions = Role_Perm::get_role_perms($session->roleid);
if (!$permissions->permissions['Role Management']){
    $session->set_message("You do not have access to Role Management.", "danger");
    redirect_to("../main.php");
}
?>
<?php 
$roles = list_roles();
?>
<?php include_layout_template("header.php"); ?>
<?php include_layout_template("admin_sidebar.php"); ?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <?php echo output_message($session->get_message(), $session->get_alert_type()); ?>
    <h2 class="sub-header">Role Management</h2>
    <a href="add_role.php"><button type="button" class="btn btn-primary">&#43; Add New Role</button></a><br><br>
    <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Role Name</th>
                <th>Permissions</th>
                <th>Status</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($roles as $role) { ?>
            <tr>
                <td><?php echo $role["role_name"]; ?></td>
                <td>(Add this later)</td>
                <td><?php if($role["status_id"] == 1) { echo "Active"; } else { echo "Inactive"; } ?></td>
        
                <td><a href="edit_role.php?id=<?php echo $role["role_id"]; ?>">Edit</a> | <a href="delete_role.php?id=<?php echo $role["role_id"]; ?>">Delete</a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</div>
<?php include_layout_template("admin_footer.php"); ?>