<?php
require_once("../../includes/initialize.php");

//verify user is logged in
if (!$session->is_logged_in()) {
    redirect_to("../login.php");
}
//load role permissions and check if they have access
$permissions = Role_Perm::get_role_perms($session->roleid);
if (!$permissions->permissions['Business Unit Management']){
    $session->set_message("You do not have access to Business Unit Management.", "danger");
    redirect_to("../main.php");
}
?>
<?php 
$business_units = Business_Unit::find_all();
?>
<?php include_layout_template("header.php"); ?>
<?php include_layout_template("admin_sidebar.php"); ?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <?php echo output_message($session->get_message(), $session->get_alert_type()); ?>
    <h2 class="sub-header">Business Unit Management</h2>
    <a href="add_businessunit.php"><button type="button" class="btn btn-primary">&#43; Add New Business Unit</button></a><br><br>
    <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Business Unit Code</th>
                <th>Business Unit Name</th>
                <th>Status</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($business_units as $business_unit) { ?>
            <tr>
                <td><?php echo $business_unit->business_unit_code; ?></td>
                <td><?php echo $business_unit->business_unit_name; ?></td>
                <td><?php if($business_unit->status_id == 1) { echo "Active"; } else { echo "Inactive"; } ?></td>
        
                <td><a href="edit_businessunit.php?id=<?php echo $business_unit->id; ?>">Edit</a> | <a href="delete_businessunit.php?id=<?php echo $business_unit->id; ?>">Delete</a></td>
            </tr>
            <?php } ?>
        </tbody>
</table>
<?php include_layout_template("admin_footer.php"); ?>