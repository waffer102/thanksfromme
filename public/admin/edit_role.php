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

if (!isset($_GET['id'])) {
    $session->set_message("Select a role to edit.", "warning");
    redirect_to("role_management.php");
} elseif (isset($_POST['submit'])) {
    $role = Role::find_by_id($_GET['id']);
    $role_perms = new Role_Perm;

    $role->role_name = $database->escape_value($_POST['role_name']);
    $role_perms->permissions = $_POST['perms'];
    $role->status_id = $_POST['status_id'];

    if ($role->update_role()) {
        if ($role_perms->update_perms($role->role_id)) {
            $session->set_message($role->role_name." was successfully updated.", "success");
            redirect_to("role_management.php");
        } else {
            echo "An error has occured updating the permissions in the database.";
        }
    } else {
        echo "An error has occured updating the role in the database."; 
    }
} else {
    $role = Role::find_by_id($_GET['id']);
    $role_perms = Role_Perm::get_role_perms($_GET['id']);
}

?>
<?php include_layout_template("header.php"); ?>
<?php include_layout_template("admin_sidebar.php"); ?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<?php echo output_message($session->get_message(), $session->get_alert_type()); ?>
<h2 class="sub-header">Edit Role</h2>
<p class="text-info">NOTE: Changing the name or permissions of the role will change the access information tied to each user.</p>
<form method="POST" action="edit_role.php?id=<?php echo $role->role_id; ?>">
    <div class="form-group">
        <label for="role_name">Role Name</label>
        <input type="text" class="form-control" id="role_name" name="role_name" value="<?php echo $role->role_name; ?>" required>
    </div>
    <label for="checkbox">Permissions</label>
    <?php
        $permissions = list_permissions();
        foreach($permissions as $permission) {
            echo "<div class=\"form-check\">";
            echo "<label class=\"form-check-label\">";
                if ($role_perms->permissions[$permission["perm_name"]] == 1) {
                    echo "<input type=\"checkbox\" name=\"perms[]\" value=\"{$permission["perm_id"]}\" checked=\"checked\"> ".$permission["perm_name"]." ({$permission["perm_type"]} permission)";
                } else {
                    echo "<input type=\"checkbox\" name=\"perms[]\" value=\"{$permission["perm_id"]}\"> ".$permission["perm_name"]." ({$permission["perm_type"]} permission)";
                }
            echo "</label></div>";
        }
    ?>
    <div class="form-group">
    <label for="status_id">Status</label>
        <select class="form-control" id="status_id" name="status_id">
            <option value="1" <?php if ($role->status_id == 1) { echo "selected"; } ?>>Active</option>
            <option value="2" <?php if ($role->status_id == 2) { echo "selected"; } ?>>Inactive</option>
        </select>
    </div>
    <br><a href="role_management.php"><button type="button" class="btn btn-danger">Cancel</button></a>  <input type="submit" class="btn btn-primary" value="Submit" name="submit">
</form>
</div>
<?php include_layout_template("admin_footer.php"); ?>