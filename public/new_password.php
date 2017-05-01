<?php
require_once("../includes/initialize.php");
require_once("../includes/password_reset.php");

if ($session->is_logged_in()) {
    $session->set_message("You are already logged in.", "danger");
    redirect_to('main.php');
}

if (isset($_GET['username']) && isset($_GET['token'])) {
    $username = $_GET['username'];
    $token = $_GET['token'];
} else {
    $get_value = 1;
}

if (isset($_POST["submit"])) {
    $password = $database->escape_value($_POST['password']);
    $confirm_password = $database->escape_value($_POST['confirm_password']);
    if ($password != $confirm_password) {
        $limessage = "The passwords you entered did not match. Please try again.";
    } else {
        //verify username, token are correct
        if (Password_Reset::verify_token($database->escape_value($_POST['username']), $database->escape_value($_POST['token']))) {
            //verified, get user id
            $user_id = Password_Reset::get_user_id($database->escape_value($_POST['username']));
            //change password
            $new_password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            if (User::update_password($new_password, $user_id)) {
                redirect_to("login.php?change=yes");
            } else {
                $limessage = "An error occured while changing password.";
            }
        } else {
            //token not verified or expired
            $limessage = "Information is incorrect or password reset token has expired.";
        }
    }
} else {
    $limessage= "";
}
?>
<?php include_layout_template("login_header.php"); ?>
    <div class="container">
      <form class="form-signin" action="new_password.php" method="POST">
        <h2 class="form-signin-heading">Set New Password</h2>
        <?php echo output_message($limessage, "danger"); ?>
        <label for="username" class="sr-only">Username</label>
        <input type="text" id="username" class="form-control" placeholder="Username" <?php if ($get_value != 1) { echo "value=\"{$username}\" "; } ?>name="username" required<?php if ($get_value == 1) { echo " autofocus"; } ?>>
        <label for="token" class="sr-only">Token</label>
        <input type="text" id="token" class="form-control" placeholder="Token" <?php if ($get_value != 1) { echo "value=\"{$token}\" "; } ?>name="token" required>
        <label for="password" class="sr-only">Password</label>
        <input type="password" id="password" class="form-control" placeholder="Password" name="password" required<?php if ($get_value != 1) { echo " autofocus"; } ?>>
        <label for="confirm_password" class="sr-only">Confirm Password</label>
        <input type="password" id="confirm_password" class="form-control" placeholder="Confirm Password" name="confirm_password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Submit</button>
      </form>
    </div>
<?php include_layout_template("login_footer.php"); ?>