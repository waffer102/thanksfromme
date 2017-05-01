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

if (!isset($_GET['id'])) {
    $session->set_message("Select a business unit to edit before proceeding.", "warning");
    redirect_to("businessunit_management.php");
} elseif (isset($_POST['submit'])) {
    $business_unit = Business_Unit::find_by_id($_GET['id']);

    $business_unit->business_unit_code = $database->escape_value($_POST['business_unit_code']);
    $business_unit->business_unit_name = $database->escape_value($_POST['business_unit_name']);
    if (!File_Upload::check_upload_error($_FILES['picture_id'])) {
        $file_extension = File_Upload::get_file_extention($_FILES['picture_id']);
        $filename_name = $business_unit->business_unit_code.".".$file_extension;
        $upload_result = File_Upload::upload_bu_pic($_FILES['picture_id'],$filename_name);
    } else {
        $filename_name = $business_unit->picture_id;
    }
    $business_unit->picture_id = $filename_name;
    $business_unit->status_id = $database->escape_value($_POST['status_id']);
    
    if ($business_unit->update()) {
        $session->set_message($business_unit->business_unit_name." was successfully saved.", "success");
        redirect_to("businessunit_management.php");
    } else {
        echo "An error has occured editing the business unit in the database."; 
    }
} else {
    $business_unit = Business_Unit::find_by_id($_GET['id']);
}

?>
<?php include_layout_template("header.php"); ?>
<?php include_layout_template("admin_sidebar.php"); ?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<?php echo output_message($session->get_message(), $session->get_alert_type()); ?>
<h2 class="sub-header">Edit Business Unit</h2>
<p class="text-info">NOTE: Changing the code or name of the business unit will also change the history information tied to each user.</p>
<form method="POST" enctype="multipart/form-data" action="edit_businessunit.php?id=<?php echo $business_unit->id; ?>">
    <div class="form-group">
        <label for="business_unit_code">Business Unit Code</label>
        <input type="text" class="form-control" id="business_unit_code" name="business_unit_code" value="<?php echo $business_unit->business_unit_code; ?>" required>
    </div>
    <div class="form-group">
        <label for="business_unit_name">Business Unit Name</label>
        <input type="text" class="form-control" id="business_unit_name" name="business_unit_name" value="<?php echo $business_unit->business_unit_name; ?>" required>
    </div>
    <div class="form-group">
    <label for="file_upload">Picture</label><br>
    <label class="btn btn-primary" for="picture_id">
        <input id="picture_id" name="picture_id" type="file" style="display:none;" onchange="$('#upload-file-info').html($(this).val());">
        Browse
    </label>
    <span class='label label-info' id="upload-file-info"><?php echo $business_unit->picture_id; ?></span>
    </div>
    <div class="form-group">
    <label for="status_id">Status</label>
        <select class="form-control" id="status_id" name="status_id">
            <option value="1" <?php if ($business_unit->status_id == 1) { echo "selected"; } ?>>Active</option>
            <option value="2" <?php if ($business_unit->status_id == 2) { echo "selected"; } ?>>Inactive</option>
        </select>
    </div>
    <br><a href="businessunit_management.php"><button type="button" class="btn btn-danger">Cancel</button></a>  <input type="submit" class="btn btn-primary" value="Submit" name="submit">
</form>
</div>
<?php include_layout_template("admin_footer.php"); ?>