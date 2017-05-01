<?php
require_once("../includes/initialize.php");

if (!$session->is_logged_in()) {
    redirect_to("login.php");
}

//load role permissions and check if they have access
$permissions = Role_Perm::get_role_perms($session->roleid);
if (!$permissions->permissions['Give Appreciation']){
    $session->set_message("You do not have access to give appreciation.", "danger");
    redirect_to("main.php");
}

if (isset($_POST['submit'])) {
    if (empty($_POST['receiver_id'])) {
        $session->set_message("You must select a user to appreciate.", "danger");
        redirect_to("recognize.php");
    }
    
    foreach ($_POST['receiver_id'] as $rec_id) {
        $appreciation = new Appreciation();
        
        $category_points = $database->escape_value($_POST['category_points']);
        $explode_category_points = explode('|', $category_points);
        
        $appreciation->receiver_id = $rec_id;
        $appreciation->receiver_history_id = current_user_history($rec_id);
        $appreciation->giver_id = $session->userid;
        $appreciation->giver_history_id = current_user_history($session->userid);
        $appreciation->date_given = date('Y-m-d H:i:s');
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
        $appreciation->status_id = 3;
        
        if ($appreciation->create()) {
            $successful_result = true;
        } else {
            $session->set_message("An error has occured adding the recognition to the database.", "danger");
            redirect_to("recognize.php");
        }
    }
    
    if($successful_result) {
        $session->set_message("Appreciation sucessfully submitted.", "success");
        redirect_to("recognize.php");  
    }
    
}
?>

<?php include_layout_template("header.php"); ?>
<?php echo output_message($session->get_message(), $session->get_alert_type()); ?>
<div class="container-fluid">
<div class="row">
<!-- left sidebar column -->
<?php include_layout_template("user_sidebar.php"); ?>

<!-- right main column -->
    <div class="col-md-6">
        <div class="fk">
            <ul class="ca bqf bqg agk">
                
                <li class="tu b ahx">
                    
                    <h2>Recognize Someone</h2>
                </li>
                
                <li class="tu b ahx">

            <form method="POST" action="recognize.php">
                <div class="form-group">
                    <label for="receiver_id">Who do you want to recognize:</label>
                        <select id="receiver_id" name="receiver_id[]" multiple class="form-control" placeholder="Start typing to select a recipient..." required>
                        	<option value="">Select a user...</option>
                            <?php 
                            $sql = "SELECT * FROM user WHERE status_id=1 AND id <> {$session->userid} ORDER BY first_name"; 
                            $query = $database->query($sql);
                            while($row = $database->fetch_array($query)) {
                                $user_id = $row['id'];
                                $first_name = $row['first_name'];
                                $last_name = $row['last_name'];
                                echo "<option value=\"".$user_id."\">".$first_name." ".$last_name."</option>";
                            }
                            ?>
                        </select>
                        <script>
                        	$('#receiver_id').selectize({
                        	    plugins: ['remove_button'],
                        	    delimiter: ',',
                        	    persist: false
                        	});
                        </script>
                </div>
                    <script type="text/javascript">
                     $(document).ready(function() {
                        $("#category_points").change(function() {  
                          var id = $(this).find(":selected").val();
                          $.ajax({    //create an ajax request to load_page.php
                            type: "GET",
                            url: "display_category.php",
                            data: "id="+id,            
                            dataType: "html",   //expect html to be returned                
                            success: function(data){                    
                                $("#responsecontainer").html(data); 
                                //alert(response);
                            }
                        });
                    });
                    });
                    </script>
                <div class="form-group">
                <label for="category_points">Choose a Category:</label>
                    <select class="form-control" id="category_points" name="category_points" required>
                        <?php 
                        $sql = "SELECT DISTINCT category.* FROM user JOIN user_role ON user_role.user_id = user.id JOIN category_perm_bu ON category_perm_bu.bu_id = user.business_unit_id JOIN category_perm_role ON category_perm_role.role_id = user_role.role_id JOIN category ON category.id = category_perm_role.category_id AND category.id = category_perm_bu.category_id  WHERE user.id = ".$session->userid." AND category.is_reward = 0"; 
                        $query = $database->query($sql);
                        while($row = $database->fetch_array($query)) {
                            $value = $row['id'];
                            $name = $row['category_name'];
                            $points = $row['category_value'];
                            //$cat_perms = Category_Perm::get_cat_perms($value)
                            //if ($cat_perms//this needs to be finished, write function to get user BU and role and compare) {
                                echo "<option value=\"".$value."|".$points."\">".$name." | ".$points." points</option>";
                            //}
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="value">Do you want to give for points?</label><br>
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-primary active">
                            <input type="radio" name="give_points" id="give_points" value="1" autocomplete="off" checked> Yes
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="give_points" id="give_points" value="0" autocomplete="off"> No
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="is_public">Do you want this to be public or private?</label><br>
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-primary active">
                            <input type="radio" name="is_public" id="is_public" value="1" autocomplete="off" checked> Public
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="is_public" id="is_public" value="0" autocomplete="off"> Private
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description">What do you want to say?</label>
                    <textarea class="form-control" id="description" name="description" rows="5" cols="40" required></textarea>
                </div>
                <br><a href="main.php"><button type="button" class="btn btn-danger">Cancel</button></a>  <input type="submit" class="btn btn-primary" value="Submit" name="submit">
        </form>
        </li>
        </ul>
        </div>
    </div>

    <div class="col-md-3">
        <div class="fh">
            <div class="rp agk ayf">
                <div class="rq">
                    <h4 class="agd">Category Description</h4>
                    <ul class="bqf bqg">
                        <li class="tu afw">
                            <div class="tv" id="responsecontainer">Choose a category to view the description.</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
<?php include_layout_template("footer.php"); ?>