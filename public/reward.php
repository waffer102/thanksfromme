<?php
require_once("../includes/initialize.php");

if (!$session->is_logged_in()) {
    redirect_to("login.php");
}

//check to see if the form was submitted, if so, process the reward and redirect to main, if not, check get
if (isset($_POST['submit'])) {
    if (empty($_POST['receiver_id'])) {
        $session->set_message("You must select a user to appreciate.", "danger");
        redirect_to("reward.php");
    }
    
    foreach ($_POST['receiver_id'] as $rec_id) {
        $appreciation = new Appreciation();
        
        $appreciation->receiver_id = $rec_id;
        $appreciation->receiver_history_id = current_user_history($rec_id);
        $appreciation->giver_id = $session->userid;
        $appreciation->giver_history_id = current_user_history($session->userid);
        $appreciation->date_given = date('Y-m-d H:i:s');
        $appreciation->category_id = $database->escape_value($_GET['id']);
        $appreciation->description = $database->escape_value($_POST['description']);
        $appreciation->point_value = $database->escape_value($_POST['category_value']);
        $appreciation->paid_out = 0;
        $appreciation->is_public = $database->escape_value($_POST['is_public']);
        $appreciation->status_id = 3;
        
        if ($appreciation->create()) {
            $successful_result = true;
        } else {
            $session->set_message("An error has occured adding the recognition to the database.", "danger");
            redirect_to("main.php");
        }
    }
    
    if($successful_result) {
        $session->set_message("The Reward sucessfully submitted for approval.", "success");
        redirect_to("main.php");  
    }
}

//check for a get, if none, redirect
if (!isset($_GET['id'])) {
    $session->set_message("You need to select a reward before you can request one.", "danger");
    redirect_to("main.php"); 
}

//load role permissions and check if they have access
$permissions = Role_Perm::get_role_perms($session->roleid);
if (!$permissions->permissions['Request Rewards']){
    $session->set_message("You do not have access to rewards.", "danger");
    redirect_to("main.php");
}

//load reward permission and check if they have access to specific reward
$reward_permission = $database->query("SELECT DISTINCT category.id FROM user JOIN user_role ON user_role.user_id = user.id JOIN category_perm_bu ON category_perm_bu.bu_id = user.business_unit_id JOIN category_perm_role ON category_perm_role.role_id = user_role.role_id JOIN category ON category.id = category_perm_role.category_id WHERE user.id = ".$session->userid." AND category.id = ".$_GET['id']);
if ($database->num_rows($reward_permission) == 0) {
    $session->set_message("You do not have access to request this reward.", "danger");
    redirect_to("main.php");  
}

//load category information
$category = Category::find_by_id($_GET['id']);
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
                    
                    <h2>Request Reward - <?php echo $category->category_name; ?></h2>
                </li>

            <li class="tu b ahx">
            <form method="POST" action="reward.php?id=<?php echo $_GET['id']; ?>">
            <?php 
            if ($category->for_self == 0) {
            echo "
                <div class=\"form-group\">
                    <label for=\"receiver_id\">Who do you want to reward:</label>
                        <select id=\"receiver_id\" name=\"receiver_id[]\" multiple class=\"form-control\" placeholder=\"Start typing to select a recipient...\" required>
                        	<option value=\"\">Select a user...</option>";

                                $sql = "SELECT * FROM user WHERE status_id=1 AND id <> {$session->userid} ORDER BY first_name"; 
                                $query = $database->query($sql);
                                while($row = $database->fetch_array($query)) {
                                    $user_id = $row['id'];
                                    $first_name = $row['first_name'];
                                    $last_name = $row['last_name'];
                                    echo "<option value=\"".$user_id."\">".$first_name." ".$last_name."</option>";
                                }
            echo "
                        </select>
                        <script>
                        	$('#receiver_id').selectize({
                        	    plugins: ['remove_button'],
                        	    delimiter: ',',
                        	    persist: false
                        	});
                        </script>
                </div>";
            } else {
                echo "<input type=\"hidden\" name=\"receiver_id[]\" id=\"receiver_id\" readonly value=\"{$session->userid}\">";
            }
            ?>
                <input type="hidden" name="category_id" id="category_id" readonly value="<?php echo $category->id; ?>">
                <?php if ($category->is_editable == 1) {
                    echo "<div class=\"form-group\">
                        <label for=\"category_value\">What is the value of the reward?</label>
                        <input type=\"text\" class=\"form-control\" id=\"category_value\" name=\"category_value\" value=\"{$category->category_value}\" required>
                    </div>";
                } else {
                    echo "<input type=\"hidden\" name=\"category_value\" id=\"category_value\" readonly value=\"{$category->category_value}\">";
                }
                ?>
                <?php 
                if ($category->for_self == 0) {
                    echo "<div class=\"form-group\">
                        <label for=\"is_public\">Do you want this to be public or private?</label><br>
                        <div class=\"btn-group\" data-toggle=\"buttons\">
                            <label class=\"btn btn-primary active\">
                                <input type=\"radio\" name=\"is_public\" id=\"is_public\" value=\"1\" autocomplete=\"off\" checked> Public
                            </label>
                            <label class=\"btn btn-primary\">
                                <input type=\"radio\" name=\"is_public\" id=\"is_public\" value=\"0\" autocomplete=\"off\"> Private
                            </label>
                        </div>
                    </div>";
                } else {
                    echo "<input type=\"hidden\" name=\"is_public\" id=\"is_public\" readonly value=\"0\">";
                }
                ?>
                <div class="form-group">
                    <label for="description"><?php if ($category->for_self == 0) { echo "What do you want to say?"; } else { echo $category->category_description; } ?></label>
                    <textarea class="form-control" id="description" name="description" rows="5" cols="40" required></textarea>
                </div>
                <br><a href="main.php"><button type="button" class="btn btn-danger">Cancel</button></a>  <input type="submit" class="btn btn-primary" value="Submit" name="submit">
        </form>
        </li>
        </ul>
        </div>
    </div>


</div>
</div>
<?php include_layout_template("footer.php"); ?>