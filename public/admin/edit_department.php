<?php
require_once("../../includes/initialize.php");

//verify user is logged in
if (!$session->is_logged_in()) {
    redirect_to("../login.php");
}
//load role permissions and check if they have access
$permissions = Role_Perm::get_role_perms($session->roleid);
if (!$permissions->permissions['Department Management']){
    $session->set_message("You do not have access to Department Management.", "danger");
    redirect_to("../main.php");
}

if (!isset($_GET['id'])) {
    $session->set_message("Select a department to edit.", "warning");
    redirect_to("department_management.php");
} elseif (isset($_POST['submit'])) {
    $department = Department::find_by_id($_GET['id']);

    $department->department_code = $database->escape_value($_POST['department_code']);
    $department->department_name = $database->escape_value($_POST['department_name']);
    $department->status_id = $database->escape_value($_POST['status_id']);
    
    if ($department->update()) {
        $session->set_message($department->department_name." was successfully saved.", "success");
        redirect_to("department_management.php");
    } else {
        echo "An error has occured editing the department in the database."; 
    }
} else {
    $department = Department::find_by_id($_GET['id']);
}

?>
<?php include_layout_template("header.php"); ?>
<?php include_layout_template("admin_sidebar.php"); ?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<?php echo output_message($session->get_message(), $session->get_alert_type()); ?>
<h2 class="sub-header">Edit Department</h2>
<p class="text-info">NOTE: Changing the code or name of the department will also change the history information tied to each user.</p>
<form method="POST" action="edit_department.php?id=<?php echo $department->id; ?>">
    <div class="form-group">
        <label for="department_code">Department Code</label>
        <input type="text" class="form-control" id="department_code" name="department_code" value="<?php echo $department->department_code; ?>" required>
    </div>
    <div class="form-group">
        <label for="department_name">Department Name</label>
        <input type="text" class="form-control" id="department_name" name="department_name" value="<?php echo $department->department_name; ?>" required>
    </div>
    <div class="form-group">
    <label for="status_id">Status</label>
        <select class="form-control" id="status_id" name="status_id">
            <option value="1" <?php if ($department->status_id == 1) { echo "selected"; } ?>>Active</option>
            <option value="2" <?php if ($department->status_id == 2) { echo "selected"; } ?>>Inactive</option>
        </select>
    </div>
    <br><a href="department_management.php"><button type="button" class="btn btn-danger">Cancel</button></a>  <input type="submit" class="btn btn-primary" value="Submit" name="submit">
</form>
</div>
<?php include_layout_template("admin_footer.php"); ?>