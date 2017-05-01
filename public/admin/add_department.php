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

if (isset($_POST['submit'])) {
    $department = new Department;

    $department->department_code = $database->escape_value($_POST['department_code']);
    $department->department_name = $database->escape_value($_POST['department_name']);
    $department->status_id = $database->escape_value($_POST['status_id']);
    

    if ($department->create()) {
        $session->set_message($department->department_name." was successfully saved.", "success");
        redirect_to("department_management.php");
    } else {
        echo "An error has occured adding the department to the database."; 
    }
}

?>
<?php include_layout_template("header.php"); ?>
<?php include_layout_template("admin_sidebar.php"); ?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<?php echo output_message($session->get_message(), $session->get_alert_type()); ?>
<h2 class="sub-header">Add New Department</h2>
<form method="POST" action="add_department.php">
    <div class="form-group">
        <label for="department_code">Department Code</label>
        <input type="text" class="form-control" id="department_code" name="department_code" required>
    </div>
    <div class="form-group">
        <label for="department_name">Department Name</label>
        <input type="text" class="form-control" id="department_name" name="department_name" required>
    </div>
    <div class="form-group">
    <label for="status_id">Status</label>
        <select class="form-control" id="status_id" name="status_id">
            <option value="1">Active</option>
            <option value="2">Inactive</option>
        </select>
    </div>
    <br><a href="department_management.php"><button type="button" class="btn btn-danger">Cancel</button></a>  <input type="submit" class="btn btn-primary" value="Submit" name="submit">
</form>
</div>
<?php include_layout_template("admin_footer.php"); ?>