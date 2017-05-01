<?php
require_once("../includes/initialize.php");

//check if logged in and redirect if not
if (!$session->is_logged_in()) {
    redirect_to("login.php");
}

//check to see if username was changed, if so update
if (isset($_POST['submitusername'])) {
    if (User::does_username_exist($_POST['username'])) {
        $session->set_message("This username is already being used, try again.", "warning");
        redirect_to("my_profile.php");
    } else {
        if (User::update_username($_POST['username'], $session->userid)) {
            $session->set_message("Your username was successfully updated.", "success");
            redirect_to("my_profile.php");
        } else {
            $session->set_message("There was an error updating your username.", "danger"); 
            redirect_to("my_profile.php");
        }
    }
}

//check to see if password was changed, if so update
if (isset($_POST['changepassword'])) {
    if ($_POST['password'] == $_POST['confirm-password']) {
        $new_password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        if (User::update_password($new_password, $session->userid)) {
            $session->set_message("Password changed successfully.", "success");
            redirect_to("my_profile.php");
        } else {
            $session->set_message("An error occured while changing password.", "warning");
            redirect_to("my_profile.php");
        }
    } else {
        $session->set_message("Your password did not match, try again.", "danger"); 
        redirect_to("my_profile.php");
    }
}

//check to see if a picture was changed, if so, update
if (isset($_POST['uploadpicture'])) {
    $user = User::find_by_id($session->userid);
    if (!File_Upload::check_upload_error($_FILES['picture_id'])) {
        $file_extension = File_Upload::get_file_extention($_FILES['picture_id']);
        $filename_name = $user->first_name.$user->last_name.$user->employee_id.".".$file_extension;
        $upload_result = File_Upload::upload_pic($_FILES['picture_id'],$filename_name);
        if ($upload_result !== true) {
            $session->set_message("We know you wanted to change your picture. " . $upload_result, "danger"); 
            redirect_to("my_profile.php");
        } else {
            if (User::update_picture_id($session->userid, $filename_name)) {
                $session->set_message("Your picture was successfully uploaded.", "success"); 
                redirect_to("my_profile.php");
            } else {
                $session->set_message("There was an error uploading your picture.", "danger"); 
                redirect_to("my_profile.php");
            }
        }
    } else {
        $session->set_message("There was an error uploading your picture.", "danger"); 
        redirect_to("my_profile.php");
    }
}

//get current logged in user and load their information
$user = User::find_by_id($session->userid);

?>

<?php include_layout_template("header.php"); ?>
<?php echo output_message($session->get_message(), $session->get_alert_type()); ?>
<div class="container-fluid">
<div class="row">
<!-- left sidebar column -->
<?php include_layout_template("user_sidebar.php"); ?>

<!-- right main column -->
    <div class="col-md-9">
        <div class="fk">
            <ul class="ca bqf bqg agk">
                
                <li class="tu b ahx">
                    <h2><?php echo $user->first_name; ?>'s Profile</h2>
                </li>
                
                <li class="tu b ahx">
                <form method="POST" enctype="multipart/form-data" action="my_profile.php">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo $user->username; ?>" required>
                        <input type="submit" class="btn btn-primary" value="Save Username" name="submitusername">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label><br>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                        <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="Confirm Password">
                        <input type="submit" class="btn btn-primary" value="Change Password" name="changepassword">
                    </div>
                    <div class="form-group">
                      <label for="file_upload">Picture</label><p class="small">Suppoted file types: gif, bmp, png, jpeg; Max file size: 1mb</p>
                    <label class="btn btn-primary" for="picture_id">
                        <input id="picture_id" name="picture_id" type="file" style="display:none;" onchange="$('#upload-file-info').html($(this).val());">
                        Browse
                    </label>
                    <span class='label label-info' id="upload-file-info"></span>
                    <input type="submit" class="btn btn-primary" value="Upload Picture" name="uploadpicture">
                    </div>
                    <br>
                    <div class="alert alert-info">
                      The following information cannot be edited, contact your system administrator to make updates.
                    </div>
                    <div class="form-group">
                        <label for="email_address">E-Mail Address</label>
                        <input type="email" class="form-control" id="email_address" name="email_address" value="<?php echo $user->email_address; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $user->first_name; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $user->last_name; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="hire_date">Hire Date</label>
                        <input class="form-control" type="date" value="<?php echo $user->hire_date; ?>" id="hire_date" name="hire_date" disabled>
                    </div>
                    <div class="form-group">
                        <label for="employee_id">Employee ID</label>
                        <input type="text" class="form-control" id="employee_id" name="employee_id" value="<?php echo $user->employee_id; ?>" disabled>
                    </div>
                    <div class="form-group">
                    <label for="business_unit_id">Business Unit</label>
                        <select class="form-control" id="business_unit_id" name="business_unit_id" disabled>
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
                        <select class="form-control" id="department_id" name="department_id" disabled>
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
                        <select class="form-control" id="manager_id" name="manager_id" disabled>
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
                        <select class="form-control" id="role_id" name="role_id" disabled>
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
                </form>
                </li>
            </ul>
        </div>
    </div>
    
</div>
</div>
<?php include_layout_template("footer.php"); ?>