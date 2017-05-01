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

if (isset($_POST['submit'])) {
    $business_unit = new Business_Unit;

    $business_unit->business_unit_code = $database->escape_value($_POST['business_unit_code']);
    $business_unit->business_unit_name = $database->escape_value($_POST['business_unit_name']);
    if (!File_Upload::check_upload_error($_FILES['picture_id'])) {
        $file_extension = File_Upload::get_file_extention($_FILES['picture_id']);
        $filename_name = $business_unit->business_unit_code.".".$file_extension;
        $upload_result = File_Upload::upload_bu_pic($_FILES['picture_id'],$filename_name);
    } else {
        $filename_name = "default.jpg";
    }
    $business_unit->picture_id = $filename_name;
    $business_unit->status_id = $database->escape_value($_POST['status_id']);
    

    if ($business_unit->create()) {
        $session->set_message($business_unit->business_unit_name." was successfully saved.".$upload_result, "success");
        redirect_to("businessunit_management.php");
    } else {
        echo "An error has occured adding the business unit to the database.";
    }
}

?>
<?php include_layout_template("header.php"); ?>
<?php include_layout_template("admin_sidebar.php"); ?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<?php echo output_message($session->get_message(), $session->get_alert_type()); ?>
<h2 class="sub-header">Add New Business Unit</h2>
<form method="POST" enctype="multipart/form-data" action="add_businessunit.php">
    <div class="form-group">
        <label for="business_unit_code">Business Unit Code</label>
        <input type="text" class="form-control" id="business_unit_code" name="business_unit_code" required>
    </div>
    <div class="form-group">
        <label for="business_unit_name">Business Unit Name</label>
        <input type="text" class="form-control" id="business_unit_name" name="business_unit_name" required>
    </div>
    <div class="form-group">
    <label for="file_upload">Picture</label><br>
    <label class="btn btn-primary" for="picture_id">
        <input id="picture_id" name="picture_id" type="file" style="display:none;" onchange="$('#upload-file-info').html($(this).val());">
        Browse
    </label>
    <span class='label label-info' id="upload-file-info"></span>
    </div>
    <div class="form-group">
    <label for="status_id">Status</label>
        <select class="form-control" id="status_id" name="status_id">
            <option value="1">Active</option>
            <option value="2">Inactive</option>
        </select>
    </div>
    <br><a href="businessunit_management.php"><button type="button" class="btn btn-danger">Cancel</button></a>  <input type="submit" class="btn btn-primary" value="Submit" name="submit">
</form>
</div>
<?php include_layout_template("admin_footer.php"); ?>