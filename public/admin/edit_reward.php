<?php
require_once("../../includes/initialize.php");

//verify user is logged in
if (!$session->is_logged_in()) {
    redirect_to("../login.php");
}
//load role permissions and check if they have access
$permissions = Role_Perm::get_role_perms($session->roleid);
if (!$permissions->permissions['Reward Management']){
    $session->set_message("You do not have access to Reward Management.", "danger");
    redirect_to("../main.php");
}
if (!isset($_GET['id'])) {
    $session->set_message("Select a reward to edit.", "warning");
    redirect_to("reward_management.php");
} elseif (isset($_POST['submit'])) {
    $category = Category::find_by_id($_GET['id']);
    $cat_perm = new Category_Perm;

    $category->category_name = $database->escape_value($_POST['category_name']);
    $category->category_description = $database->escape_value($_POST['category_description']);
    $category->category_value = $database->escape_value($_POST['category_value']);
    $category->is_reward = 1;
    $category->status_id = $database->escape_value($_POST['status_id']);
    $category->is_editable = $database->escape_value($_POST['is_editable']);
    $cat_perm->roleid_permissions = $_POST['perms_role'];
    $cat_perm->buid_permissions = $_POST['perms_bu'];


    if ($category->update()) {
        if ($cat_perm->update_cat_perms($category->id)) {
            $session->set_message($category->category_name." was successfully saved.", "success");
            redirect_to("reward_management.php");
        } else {
            echo "An error has occured editing the reward in the database.";
        }
    } else {
        echo "An error has occured editing the reward in the database."; 
    }
} else {
    $category = Category::find_by_id($_GET['id']);
    $cat_perms = Category_Perm::get_cat_perms($_GET['id']);
}

?>
<?php include_layout_template("header.php"); ?>
<?php include_layout_template("admin_sidebar.php"); ?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<?php echo output_message($session->get_message(), $session->get_alert_type()); ?>
<h2 class="sub-header">Edit Reward</h2>
<form method="POST" action="edit_reward.php?id=<?php echo $category->id; ?>">
    <div class="form-group">
        <label for="category_name">Reward Name</label>
        <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo $category->category_name; ?>" required>
    </div>
    <div class="form-group">
        <label for="category_description">Reward Description/Instruction</label>
        <textarea class="form-control" id="category_description" name="category_description" rows="5" cols="40"><?php echo $category->category_description; ?></textarea>
    </div>
    <div class="form-group">
        <label for="category_value">Default Reward Value</label>
        <input type="text" class="form-control" id="category_value" name="category_value" value="<?php echo $category->category_value; ?>" required>
    </div>
    <div class="form-group">
    <label for="is_editable">Can users edit the reward value?</label>
        <select class="form-control" id="is_editable" name="is_editable">
            <option value="1" <?php if ($category->is_editable == 1) { echo "selected"; } ?>>Yes</option>
            <option value="0" <?php if ($category->is_editable == 0) { echo "selected"; } ?>>No</option>
        </select>
    </div>
    <div class="form-group">
    <label for="for_self">Will users request this reward for themselves or others?</label>
        <select class="form-control" id="for_self" name="for_self">
            <option value="0" <?php if ($category->for_self == 0) { echo "selected"; } ?>>For Others</option>
            <option value="1" <?php if ($category->for_self == 1) { echo "selected"; } ?>>For Self</option>
        </select>
    </div>
    <label for="role_permissions">Which roles can use this reward?</label>
    <?php
        $roles = list_roles();
        foreach($roles as $role) {
            echo "<div class=\"form-check\">";
            echo "<label class=\"form-check-label\">";
                if ($cat_perms->roleid_permissions[$role["role_id"]] == 1) {
                    echo "<input type=\"checkbox\" name=\"perms_role[]\" value=\"{$role["role_id"]}\" checked=\"checked\"> ".$role["role_name"];
                } else {
                    echo "<input type=\"checkbox\" name=\"perms_role[]\" value=\"{$role["role_id"]}\"> ".$role["role_name"];
                }
            echo "</label></div>";
        }
    ?>
    <br><label for="role_permissions">Which Business Units can use this reward?</label>
    <?php
        $businessunits = list_businessunits();
        foreach($businessunits as $businessunit) {
            echo "<div class=\"form-check\">";
            echo "<label class=\"form-check-label\">";
                if ($cat_perms->buid_permissions[$businessunit["id"]] == 1) {
                    echo "<input type=\"checkbox\" name=\"perms_bu[]\" value=\"{$businessunit["id"]}\" checked=\"checked\"> ".$businessunit["business_unit_name"];
                } else {
                    echo "<input type=\"checkbox\" name=\"perms_bu[]\" value=\"{$businessunit["id"]}\"> ".$businessunit["business_unit_name"];
                }
            echo "</label></div>";
        }
    ?><br>
    <div class="form-group">
    <label for="status_id">Status</label>
        <select class="form-control" id="status_id" name="status_id">
            <option value="1" <?php if ($category->status_id == 1) { echo "selected"; } ?>>Active</option>
            <option value="2" <?php if ($category->status_id == 2) { echo "selected"; } ?>>Inactive</option>
        </select>
    </div>
    <br><a href="reward_management.php"><button type="button" class="btn btn-danger">Cancel</button></a>  <input type="submit" class="btn btn-primary" value="Submit" name="submit">
</form>
</div>
<?php include_layout_template("admin_footer.php"); ?>