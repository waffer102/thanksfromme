<?php
require_once("../../includes/initialize.php");

//verify user is logged in
if (!$session->is_logged_in()) {
    redirect_to("../login.php");
}
//load role permissions and check if they have access
$permissions = Role_Perm::get_role_perms($session->roleid);
if (!$permissions->permissions['Approve']){
    $session->set_message("You do not have access to do approvals.", "danger");
    redirect_to("../main.php");
}

if (!isset($_GET['id'])) {
    $session->set_message("Select an appreciation to edit before proceeding.", "warning");
    redirect_to("appreciation_management.php");
} elseif (isset($_POST['submit'])) {
    //pull all the values from the form
    $appreciation = Appreciation::find_by_id($_GET['id']);
    
    $category_points = $database->escape_value($_POST['category_points']);
    $explode_category_points = explode('|', $category_points);

    $appreciation->last_edited_by_id = $session->userid;
    $appreciation->category_id = $explode_category_points[0];
    $appreciation->description = $database->escape_value($_POST['description']);
    if ($_POST['give_points'] == 1) {
        $appreciation->point_value = $explode_category_points[1];
        $appreciation->paid_out = 0;
    } else {
        $appreciation->point_value = 0;
        $appreciation->paid_out = 1;
    }
    $appreciation->is_public = $database->escape_value($_POST['is_public']);
    
    if ($_POST['status_id'] == 3) {
        //update and close
        if ($appreciation->update_appreciation()) {
            $session->set_message("Appreciation was successfully saved.", "success");
            redirect_to("approval_management.php");
        } else {
            echo "An error has occured editing the business unit in the database."; 
        } 
    } elseif ($_POST['status_id'] == 4) {
        //update and approve
        if ($appreciation->update_appreciation()) {
            if (Appreciation::process_appreciation($_GET['id'], $session->userid, 4)) {
                $session->set_message("Appreciation was successfully saved and approved.", "success");
                redirect_to("approval_management.php");
            } else {
                $session->set_message("Appreciation was successfully saved but there was an error with the approval.", "success");
                redirect_to("approval_management.php");           
            }
        } else {
            echo "An error has occured editing the business unit in the database."; 
        }
    } elseif ($_POST['status_id'] == 5) {
        //deny
        if ($appreciation->update_appreciation()) {
            if (Appreciation::process_appreciation($_GET['id'], $session->userid, 5) && Appreciation::add_deny_reason($_GET['id'], $_POST['deny_description'])) {
                $session->set_message("Appreciation was saved and denied.", "success");
                redirect_to("approval_management.php");
            } else {
                $session->set_message("There was an issue processing the appreciation, please try again.", "danger");
                redirect_to("approval_management.php");
            }
        } else {
            echo "An error has occured editing the business unit in the database."; 
        } 
    } else {
        $session->set_message("An error has occured, please try again.", "warning");
        redirect_to("approval_management.php");
    }
} else {
    $appreciation = Appreciation::find_by_id($_GET['id']);
    if ($appreciation->status_id == 5) {
        $deny_reason_desc = Appreciation::get_deny_reason($_GET['id']);
    }
}


?>


<?php include_layout_template("header.php"); ?>
<?php include_layout_template("admin_sidebar.php"); ?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <?php echo output_message($session->get_message(), $session->get_alert_type()); ?>
    <?php if ($appreciation->paid_out == 1 && $appreciation->point_value != 0) { echo output_message("You cannot edit an appreciation that has already been paid out.", "danger"); } ?>
    <h2 class="sub-header">Approvals</h2>
    <form method="POST" action="edit_appreciation.php?id=<?php echo $_GET['id']; ?>">
        <div class="form-group">
            <label for="receiver_id">Who do you want to recognize: <em>(this cannot be edited)</em></label>
                <select id="receiver_id" name="receiver_id[]" multiple class="form-control" disabled>
                	<option value="">Select a user...</option>
                    <?php 
                    $sql = "SELECT * FROM user WHERE id={$appreciation->receiver_id} LIMIT 1"; 
                    $query = $database->query($sql);
                    while($row = $database->fetch_array($query)) {
                        $user_id = $row['id'];
                        $first_name = $row['first_name'];
                        $last_name = $row['last_name'];
                        echo "<option value=\"".$user_id."\" selected>".$first_name." ".$last_name."</option>";
                    }
                    ?>
                </select>
                <script>
                	$('#receiver_id').selectize({
                	    delimiter: ',',
                	    persist: false
                	});
                </script>
        </div>
        <div class="form-group">
        <label for="category_points">Choose a Category:</label>
            <select class="form-control" id="category_points" name="category_points" required>
                <?php 
                $sql = "SELECT * FROM category WHERE status_id=1 ORDER BY category_name"; 
                $query = $database->query($sql);
                while($row = $database->fetch_array($query)) {
                    $value = $row['id'];
                    $name = $row['category_name'];
                    $points = $row['category_value'];
                    echo "<option value=\"".$value."|".$points."\"";
                    if ($row['id'] == $appreciation->category_id) { echo "selected"; }
                    echo ">".$name." | ".$points." points</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="value">Do you want to give for points?</label><br>
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-primary <?php if ($appreciation->point_value != 0) { echo "active"; } ?>">
                    <input type="radio" name="give_points" id="give_points" value="1" autocomplete="off" <?php if ($appreciation->point_value != 0) { echo "checked"; } ?>> Yes
                </label>
                <label class="btn btn-primary <?php if ($appreciation->point_value == 0) { echo "active"; } ?>">
                    <input type="radio" name="give_points" id="give_points" value="0" autocomplete="off" <?php if ($appreciation->point_value == 0) { echo "checked"; } ?>> No
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="is_public">Do you want this to be public or private?</label><br>
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-primary <?php if ($appreciation->is_public != 0) { echo "active"; } ?>">
                    <input type="radio" name="is_public" id="is_public" value="1" autocomplete="off" <?php if ($appreciation->is_public != 0) { echo "checked"; } ?>> Yes
                </label>
                <label class="btn btn-primary <?php if ($appreciation->is_public == 0) { echo "active"; } ?>">
                    <input type="radio" name="is_public" id="is_public" value="0" autocomplete="off" <?php if ($appreciation->is_public == 0) { echo "checked"; } ?>> No
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="description">What do you want to say?</label>
            <textarea class="form-control" id="description" name="description" rows="5" cols="40" required><?php echo $appreciation->description; ?></textarea>
        </div>
        <script type="text/javascript">
            $(function () {
                $("#status_id").change(function () {
                    if ($(this).val() == "5") {
                        $("#dvDeny").show();
                    } else {
                        $("#dvDeny").hide();
                    }
                });
            });
        </script>
        <div class="form-group">
        <label for="status_id">Status:</label>
            <select class="form-control" id="status_id" name="status_id">
                <option value="3" <?php if ($appreciation->status_id == 3) { echo "selected"; } ?>>Pending Approval</option>
                <option value="4" <?php if ($appreciation->status_id == 4) { echo "selected"; } ?>>Approved</option>
                <option value="5" <?php if ($appreciation->status_id == 5) { echo "selected"; } ?>>Denied</option>
            </select>
        </div>
        <div class="form-group" id="dvDeny" <?php if ($appreciation->status_id != 5) { echo "style=\"display: none\""; } ?>>
            <label for="deny_description">Deny Reason:</label>
            <textarea class="form-control" id="deny_description" name="deny_description" rows="5" cols="40" required><?php echo $deny_reason_desc; ?></textarea>
        </div>
        <br><a href="approval_management.php"><button type="button" class="btn btn-danger">Cancel</button></a>  <?php if ($appreciation->paid_out == 0 || $appreciation->point_value == 0) { echo "<input type=\"submit\" class=\"btn btn-primary\" value=\"Save and Process\" name=\"submit\">"; } ?>
</form>
<?php include_layout_template("admin_footer.php"); ?>