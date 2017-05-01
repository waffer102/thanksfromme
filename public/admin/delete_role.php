<?php
require_once("../../includes/initialize.php");

//verify user is logged in
if (!$session->is_logged_in()) {
    redirect_to("../login.php");
}
//load role permissions and check if they have access
$permissions = Role_Perm::get_role_perms($session->roleid);
if (!$permissions->permissions['Role Management']){
    $session->set_message("You do not have access to Role Management.", "danger");
    redirect_to("../main.php");
}

if (isset($_GET['id'])) {
    //delete
    if (Role::delete_role($_GET['id'])) {
        $session->set_message("Role was deleted.", "success"); //someday add the name of the user who was deleted
        redirect_to("role_management.php");
    } else {
        $session->set_message("You cannot delete a role if it is currently assigned to an active or inactive user, you must inactivate the role instead.", "danger");
        redirect_to("role_management.php");
    }
} else {
    //do nothing and redirect to user management
    $session->set_message("Select a role to delete before proceeding.", "warning");
    redirect_to("role_management.php");
}