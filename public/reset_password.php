<?php
require_once("../includes/initialize.php");
require_once("../includes/password_reset.php");

if ($session->is_logged_in()) {
    $session->set_message("You are already logged in.", "danger");
    redirect_to('main.php');
}

if (isset($_POST["submit"])) {
    if (Password_Reset::pw_reset_verify($database->escape_value($_POST['username']), $database->escape_value($_POST['email_address']))) {
        if (Password_Reset::generate_key($database->escape_value($_POST['username']), $database->escape_value($_POST['email_address']))) {
            redirect_to("login.php?change=reset");
        } else {
            $limessage= "There was an error resetting your password, please try again.";
        }
    } else {
        $limessage = "An email with password reset information was sent if the username/email combination was correct.";
    }
} else {
    $limessage= "";
}
?>
<?php include_layout_template("login_header.php"); ?>
    <div class="container">
      <form class="form-signin" action="reset_password.php" method="POST">
        <h2 class="form-signin-heading">Password Reset</h2>
        <?php echo output_message($limessage, "info"); ?>
        <label for="username" class="sr-only">Username</label>
        <input type="text" id="username" class="form-control" placeholder="Username" name="username" required autofocus>
        <label for="email_address" class="sr-only">Email Address</label>
        <input type="email" id="inputemail" class="form-control" placeholder="Email Address" name="email_address" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Reset Password</button>
      </form>
    </div>
<?php include_layout_template("login_footer.php"); ?>