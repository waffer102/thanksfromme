<?php
require_once("../includes/initialize.php");

//check if logged in and redirect if not
if (!$session->is_logged_in()) {
    redirect_to("login.php");
}

//get current logged in user and load their information
$user = User::find_by_id($session->userid);

//check to see if something was submitted, if so, update
if (isset($_POST['submit'])) {
    $user_config = new User_Configuration;
    $user_config->user_id = $session->userid;
    //get values from post and put in object
    ($_POST['rec_self'] == 1 ? $user_config->rec_self = 1 : $user_config->rec_self = 0);
    ($_POST['give_approved'] == 1 ? $user_config->give_approved = 1 : $user_config->give_approved = 0);
    ($_POST['give_denied'] == 1 ? $user_config->give_denied = 1 : $user_config->give_denied = 0);
    ($_POST['rec_direct_report'] == 1 ? $user_config->rec_direct_report = 1 : $user_config->rec_direct_report = 0);

    //update the configuration
    if ($user_config->update()) {
        $session->set_message("Configuration settings were successfully saved.", "success");
        redirect_to("my_configuration.php");
    } else {
        $session->set_message("An error occured updating configuration settings.", "danger");
        redirect_to("my_configuration.php");
    }
}

//load current configuration settings
$current_settings = User_Configuration::find_by_userid($session->userid);
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
                    <h2>Configuration</h2>
                </li>
                
                <li class="tu b ahx">
                    
                <form method="POST" action="my_configuration.php">
                    <div class="form-group">
                        <label for="checkbox">Which emails do you want to receive?</label>
                            <div class="form-check"><label class="form-check-label"><input class="form-check-input" type="checkbox" name="rec_self" value="1"<?php if($current_settings->rec_self == 1) { echo " checked=\"checked\""; } ?>> When I receive a recognition/reward</label></div>
                            <div class="form-check"><label class="form-check-label"><input class="form-check-input" type="checkbox" name="give_approved" value="1"<?php if($current_settings->give_approved == 1) { echo " checked=\"checked\""; } ?>> When a recognition/reward I give is approved</label></div>
                            <div class="form-check"><label class="form-check-label"><input class="form-check-input" type="checkbox" name="give_denied" value="1"<?php if($current_settings->give_denied == 1) { echo " checked=\"checked\""; } ?>> When a recognition/reward I give is denied</label></div>
                            <div class="form-check"><label class="form-check-label"><input class="form-check-input" type="checkbox" name="rec_direct_report" value="1"<?php if($current_settings->rec_direct_report == 1) { echo " checked=\"checked\""; } ?>> When one of my direct reports receives a recognition/reward</label></div>
                        
                        
                    <br><a href="main.php"><button type="button" class="btn btn-danger">Cancel</button></a>  <input type="submit" class="btn btn-primary" value="Submit" name="submit">
                    </div>
                </form>
                </li>
            </ul>
        </div>
    </div>
    
</div>
</div>
<?php include_layout_template("footer.php"); ?>