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

?>
//add instructions to this page 

<?php include_layout_template("header.php"); ?>
<?php include_layout_template("admin_sidebar.php"); ?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <?php echo output_message($session->get_message(), $session->get_alert_type()); ?>
    <h2 class="sub-header">Import Users</h2>
    <form method="POST" enctype="multipart/form-data" target="_blank" action="process_import.php">
    <div class="form-group">
    <label for="file_upload">Choose Upload File, must be a CSV.</label><br>
    <label class="btn btn-primary" for="file">
        <input id="file" name="file" type="file" style="display:none;" onchange="$('#upload-file-info').html($(this).val());">
        Browse
    </label>
    <span class='label label-info' id="upload-file-info"></span>
    </div>
    <br><a href="user_management.php"><button type="button" class="btn btn-danger">Cancel</button></a>  <input type="submit" class="btn btn-primary" value="Submit" name="submit">
</form>
</div>
</div>
<?php include_layout_template("admin_footer.php"); ?>