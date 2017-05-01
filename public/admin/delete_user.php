<?php
require_once("../../includes/initialize.php");

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
    //delete
    if (User::tbdelete($_GET['id']) && role::delete_user($_GET['id']) && User_Configuration::tbdelete($_GET['id'])) {
        $session->set_message("User was deleted.", "success"); //someday add the name of the user who was deleted
        redirect_to("user_management.php");
    } else {
        $session->set_message("The user could not be deleted. If the user has ever received appreciation you can no longer delete the user.", "danger");
        redirect_to("user_management.php");
    }

} else {
    //do nothing and redirect to user management
    $session->set_message("Select a user to delete before proceeding.", "warning");
    redirect_to("user_management.php");
}