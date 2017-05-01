<?php
require_once("../../includes/initialize.php");

//verify user is logged in
if (!$session->is_logged_in()) {
    redirect_to("../login.php");
}
//load role permissions and check if they have access
$permissions = Role_Perm::get_role_perms($session->roleid);
if (!$permissions->permissions['Business Unit Management']){
    $session->set_message("You do not have access to Business Unit Management.", "danger");
    redirect_to("../main.php");
}

if (isset($_GET['id'])) {
    //delete
    if (Business_Unit::tbdelete($_GET['id'])) {
        $session->set_message("Business Unit was deleted.", "success"); //someday add the name of the user who was deleted
        redirect_to("businessunit_management.php");
    } else {
        $session->set_message("You cannot delete a business unit if it has ever been assigned to a user, you must inactivate it.", "danger");
        redirect_to("businessunit_management.php");
    }
} else {
    //do nothing and redirect to user management
    $session->set_message("Select a business unit to delete before proceeding.", "warning");
    redirect_to("businessunit_management.php");
}