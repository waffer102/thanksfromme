<?php
require_once("../../includes/initialize.php");

//verify user is logged in
if (!$session->is_logged_in()) {
    redirect_to("../login.php");
}
//load role permissions and check if they have access
$permissions = Role_Perm::get_role_perms($session->roleid);
if (!$permissions->permissions['Reward Management']){
    $session->set_message("You do not have access to Reward Management", "danger");
    redirect_to("../main.php");
}

if (isset($_GET['id'])) {
    //delete
    if (Category::tbdelete($_GET['id'])) {
        if (Category_Perm::delete_cat_perms($_GET['id'])) {
            $session->set_message("Reward was deleted.", "success"); //someday add the name of the user who was deleted
            redirect_to("reward_management.php");
        } else {
            $session->set_message("An error has occured deleting the permissions from the database.", "success");
            redirect_to("reward_management.php");
        }
    } else {
        $session->set_message("You cannot delete a reward if it has ever been assigned to a user, you must inactivate it.", "danger");
        redirect_to("reward_management.php");
    }
} else {
    //do nothing and redirect to reward management
    $session->set_message("Select a reward to delete before proceeding.", "warning");
    redirect_to("reward_management.php");
}