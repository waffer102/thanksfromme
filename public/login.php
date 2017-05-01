<?php
if(empty($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] !== "on") {
	header("Location: https://northstar.thanksfrom.me");
	exit();
}

require_once("../includes/initialize.php");

if ($session->is_logged_in()) {
    $session->set_message("You are already logged in.", "success");
    redirect_to('main.php');
}

if (isset($_POST["submit"])) {
    $found_user = User::authenticate($_POST['username'], $_POST['password']);
    if ($found_user) {
        $user_role = Role::check_user_role($found_user->id);
        $session->login($found_user, $user_role);
        if ($_POST['remember_me'] == "Yes") {
            User::set_remember_me($found_user->id);
        }
        redirect_to("main.php");
    } else {
        $limessage = "Username and/or password incorrect.";
        $username = $_POST['username'];
    }
} else {
    $username = "";
    $limessage= "";
}

if (USER::get_remember_me()) {
    redirect_to("main.php");
}

if ($_GET['change'] == "yes") {
    $limessage = "Your password has been changed.";
} elseif ($_GET['change'] == "reset") {
    $limessage = "An email with password reset information was sent if the username/email combination was correct.";
}

?>
<?php include_layout_template("login_header.php"); ?>
    <div class="container">
      <form class="form-signin" action="login.php" method="POST">
        <h2 class="form-signin-heading">Please sign in</h2>
        <?php echo output_message($limessage, "danger"); ?>
        <label for="username" class="sr-only">Username</label>
        <input type="text" id="username" class="form-control" placeholder="Username" name="username" value="<?php echo htmlentities($username); ?>" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" name="remember_me" value="Yes"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Sign in</button>
        <p><a href="reset_password.php">Forgot Password? Click here to reset.</a></p>
      </form>
    </div>
<?php include_layout_template("login_footer.php"); ?>