<?php
require_once("../../includes/initialize.php");

//verify user is logged in
if (!$session->is_logged_in()) {
    redirect_to("../login.php");
}
//load role permissions and check if they have access
$permissions = Role_Perm::get_role_perms($session->roleid);
if (!$permissions->permissions['Category Management']){
    $session->set_message("You do not have access to Category Management.", "danger");
    redirect_to("../main.php");
}

if (isset($_POST['submit'])) {
    $category = new Category;
    $cat_perm = new Category_Perm;

    $category->category_name = $database->escape_value($_POST['category_name']);
    $category->category_description = $database->escape_value($_POST['category_description']);
    $category->category_value = $database->escape_value($_POST['category_value']);
    $category->is_reward = 0;
    $category->status_id = $database->escape_value($_POST['status_id']);
    $category->is_editable = 0;
    $category->for_self = 0;
    $cat_perm->roleid_permissions = $_POST['perms_role'];
    $cat_perm->buid_permissions = $_POST['perms_bu'];
    

    if ($category->create()) {
        if ($cat_perm->add_cat_perms($category->id)) {
            $session->set_message($category->category_name." was successfully saved.", "success");
            redirect_to("category_management.php");
        } else {
            echo "An error has occured adding the category to the database.";
        }
    } else {
        echo "An error has occured adding the category to the database."; 
    }
}

?>
<?php include_layout_template("header.php"); ?>
<?php include_layout_template("admin_sidebar.php"); ?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<?php echo output_message($session->get_message(), $session->get_alert_type()); ?>
<h2 class="sub-header">Add New Category</h2>
<form method="POST" action="add_category.php">
    <div class="form-group">
        <label for="category_name">Category Name</label>
        <input type="text" class="form-control" id="category_name" name="category_name" required>
    </div>
    <div class="form-group">
        <label for="category_description">Category Description</label>
        <textarea class="form-control" id="category_description" name="category_description" rows="5" cols="40"></textarea>
    </div>
    <div class="form-group">
        <label for="category_value">Category Value</label>
        <input type="text" class="form-control" id="category_value" name="category_value" required>
    </div>
    <label for="role_permissions">Which roles can use this category?</label>
    <?php
        $roles = list_roles();
        foreach($roles as $role) {
            echo "<div class=\"form-check\">";
            echo "<label class=\"form-check-label\">";
            echo "<input type=\"checkbox\" name=\"perms_role[]\" value=\"{$role["role_id"]}\"> ".$role["role_name"];
            echo "</label></div>";
        }
    ?>
    <br><label for="role_permissions">Which Business Units can use this category?</label>
    <?php
        $businessunits = list_businessunits();
        foreach($businessunits as $businessunit) {
            echo "<div class=\"form-check\">";
            echo "<label class=\"form-check-label\">";
            echo "<input type=\"checkbox\" name=\"perms_bu[]\" value=\"{$businessunit["id"]}\"> ".$businessunit["business_unit_name"];
            echo "</label></div>";
        }
    ?><br>
    <div class="form-group">
    <label for="status_id">Status</label>
        <select class="form-control" id="status_id" name="status_id">
            <option value="1">Active</option>
            <option value="2">Inactive</option>
        </select>
    </div>
    <br><a href="category_management.php"><button type="button" class="btn btn-danger">Cancel</button></a>  <input type="submit" class="btn btn-primary" value="Submit" name="submit">
</form>
</div>
<?php include_layout_template("admin_footer.php"); ?>