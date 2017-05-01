<?php
require_once("../../includes/initialize.php");
require_once("../../includes/password_reset.php");

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

if (isset($_GET['id'])) {
    $user = User::find_by_id($database->escape_value($_GET['id']));
    
    if (Password_Reset::pw_reset_verify($user->username, $user->email_address)) {
        if (Password_Reset::generate_key($user->username, $user->email_address)) {
            $session->set_message("Password reset email was sent to ".$user->email_address.".", "success");
            redirect_to("user_management.php");
        } else {
            $session->set_message("Password reset failed.", "danger");
            redirect_to("user_management.php");
        }
    } else {
            $session->set_message("Password reset failed.", "danger");
            redirect_to("user_management.php");
    }

} else {
    //do nothing and redirect to user management
    $session->set_message("Select a user to reset password for before proceeding.", "warning");
    redirect_to("user_management.php");
}