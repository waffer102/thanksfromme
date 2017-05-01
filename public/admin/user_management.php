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

$users = User::find_all();
?>
<?php include_layout_template("header.php"); ?>
<?php include_layout_template("admin_sidebar.php"); ?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    Confirm Deletion
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this user?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>
            
    <?php echo output_message($session->get_message(), $session->get_alert_type()); ?>
    <h2 class="sub-header">User Management</h2>
    <a href="add_user.php"><button type="button" class="btn btn-primary">&#43; Add New User</button></a> <a href="import_users.php"><button type="button" class="btn btn-primary">&#43; Import Users</button></a><br><br>
    <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Business Unit</th>
                <th>Department</th>
                <th>Reports To</th>
                <th>Role</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($users as $user) { ?>
            <tr>
                <td><?php echo $user->employee_id; ?></td>
                <td><?php echo $user->last_name; ?></td>
                <td><?php echo $user->first_name; ?></td>
                <td><?php echo get_businessunit_name($user->business_unit_id); ?></td>
                <td><?php echo get_department_name($user->department_id); ?></td>
                <td><?php echo get_reportsto_name($user->manager_id); ?></td>
                <td><?php echo display_user_role($user->id); ?></td>
                <td><a href="edit_user.php?id=<?php echo $user->id; ?>">Edit</a> | <a href="reset_password.php?id=<?php echo $user->id; ?>">Reset Password</a> | <a href="#" data-href="delete_user.php?id=<?php echo $user->id; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a> | <a href="view_user_appreciation.php?id=<?php echo $user->id; ?>">View Appreciation</a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</div>

<script>
    $('#confirm-delete').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
</script>
<?php include_layout_template("admin_footer.php"); ?>