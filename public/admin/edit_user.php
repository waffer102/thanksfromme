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

if (!isset($_GET['id'])) {
    $session->set_message("Select a user to edit before proceeding.", "warning");
    redirect_to("user_management.php");
} elseif (isset($_POST['submit'])) {
    $user = User::find_by_id($_GET['id']);

    if ($user->username != $_POST['username']) {
        if (User::does_username_exist($_POST['username'])) {
            $session->set_message("This username is already being used, try again.", "warning");
            redirect_to("edit_user.php?id=".$_GET['id']);
        }//checking for username does not work right now
    }

    $user->username = $database->escape_value($_POST['username']);
    $user->first_name = $database->escape_value($_POST['first_name']);
    $user->last_name = $database->escape_value($_POST['last_name']);
    $user->hire_date = $database->escape_value($_POST['hire_date']);
    $user->employee_id = $database->escape_value($_POST['employee_id']);
    $user->email_address = $database->escape_value($_POST['email_address']);
    $user->business_unit_id = $database->escape_value($_POST['business_unit_id']);
    $user->department_id = $database->escape_value($_POST['department_id']);
    $user->manager_id = $database->escape_value($_POST['manager_id']);
    if (!File_Upload::check_upload_error($_FILES['picture_id'])) {
        $file_extension = File_Upload::get_file_extention($_FILES['picture_id']);
        $filename_name = $user->first_name.$user->last_name.$user->employee_id.".".$file_extension;
        $upload_result = File_Upload::upload_pic($_FILES['picture_id'],$filename_name);
    } else {
        $filename_name = $user->picture_id;
    }
    $user->picture_id = $filename_name;
    $user->status_id = $database->escape_value($_POST['status_id']);

    if ($user->update()) {
        $role = new Role;
        $role->user_id = $user->id;
        $role->role_id = $database->escape_value($_POST['role_id']);
        if ($role->update_user()) {
            $session->set_message($user->full_name()." was successfully saved.".$upload_result, "success");
            redirect_to("user_management.php");
        } else {
            echo output_message("An error has occured adding the user role to the database.", "danger");
        }
    } else {
        echo output_message("An error has occured adding the user to the database.", "danger"); 
    }
} else {
    $user = User::find_by_id($_GET['id']);
}

?>
<?php include_layout_template("header.php"); ?>
<?php include_layout_template("admin_sidebar.php"); ?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<?php echo output_message($session->get_message(), $session->get_alert_type()); ?>
<h2 class="sub-header">Edit User</h2>
<form method="POST" enctype="multipart/form-data" action="edit_user.php?id=<?php echo $user->id; ?>">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" value="<?php echo $user->username; ?>" required>
    </div>
    <div class="form-group">
        <label for="first_name">First Name</label>
        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $user->first_name; ?>" required>
    </div>
    <div class="form-group">
        <label for="last_name">Last Name</label>
        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $user->last_name; ?>" required>
    </div>
    <div class="form-group">
        <label for="hire_date">Hire Date</label>
        <input class="form-control" type="date" value="<?php echo $user->hire_date; ?>" id="hire_date" name="hire_date" required>
    </div>
    <div class="form-group">
        <label for="employee_id">Employee ID</label>
        <input type="text" class="form-control" id="employee_id" name="employee_id" value="<?php echo $user->employee_id; ?>" required>
    </div>
    <div class="form-group">
        <label for="email_address">E-Mail Address</label>
        <input type="email" class="form-control" id="email_address" name="email_address" value="<?php echo $user->email_address; ?>" required>
    </div>
    <div class="form-group">
    <label for="business_unit_id">Business Unit</label>
        <select class="form-control" id="business_unit_id" name="business_unit_id">
            <?php 
            $sql = "SELECT * FROM business_unit WHERE status_id=1 ORDER BY business_unit_name"; 
            $query = $database->query($sql);
            while($row = $database->fetch_array($query)) {
                $value = $row['id'];
                $name = $row['business_unit_name'];
                echo "<option value=\"".$value."\" ";
                if ($row['id'] == $user->business_unit_id) { echo "selected"; }
                echo ">".$name."</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
    <label for="department_id">Department</label>
        <select class="form-control" id="department_id" name="department_id">
            <?php 
            $sql = "SELECT * FROM department WHERE status_id=1 ORDER BY department_name"; 
            $query = $database->query($sql);
            while($row = $database->fetch_array($query)) {
                $value = $row['id'];
                $name = $row['department_name'];
                echo "<option value=\"".$value."\" ";
                if ($row['id'] == $user->department_id) { echo "selected"; }
                echo ">".$name."</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
    <label for="manager_id">Reports To</label>
        <select class="form-control" id="manager_id" name="manager_id">
            <option value="0">No One</option>
            <?php
            $sql = "SELECT * FROM user ORDER BY last_name"; 
            $query = $database->query($sql);
            while($row = $database->fetch_array($query)) {
                $value = $row['id'];
                $name = $row['last_name'].", ".$row['first_name'];
                echo "<option value=\"".$value."\" ";
                if ($row['id'] == $user->manager_id) { echo "selected"; }
                echo ">".$name."</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
    <label for="role_id">Role</label>
        <select class="form-control" id="role_id" name="role_id">
            <?php 
            $sql = "SELECT * FROM roles"; 
            $query = $database->query($sql);
            while($row = $database->fetch_array($query)) {
                $value = $row['role_id'];
                $name = $row['role_name'];
                echo "<option value=\"".$value."\" ";
                if ($row['role_id'] == ROLE::check_user_role($user->id)) { echo "selected"; }
                echo ">".$name."</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
    <label for="file_upload">Picture</label><br>
    <label class="btn btn-primary" for="picture_id">
        <input id="picture_id" name="picture_id" type="file" style="display:none;" onchange="$('#upload-file-info').html($(this).val());">
        Browse
    </label>
    <span class='label label-info' id="upload-file-info"><?php echo $user->picture_id; ?></span>
    </div>
    <div class="form-group">
    <label for="status_id">Status</label>
            <select class="form-control" id="status_id" name="status_id">
                <option value="1" <?php if ($user->status_id == 1) { echo "selected"; } ?>>Active</option>
                <option value="2" <?php if ($user->status_id == 2) { echo "selected"; } ?>>Inactive</option>
            </select>
    </div>
    <br><a href="user_management.php"><button type="button" class="btn btn-danger">Cancel</button></a>  <input type="submit" class="btn btn-primary" value="Submit" name="submit">
</form>

</div>
<?php include_layout_template("admin_footer.php"); ?>