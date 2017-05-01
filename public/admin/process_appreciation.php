<?php
require_once("../../includes/initialize.php");

//verify user is logged in
if (!$session->is_logged_in()) {
    redirect_to("../login.php");
}
//load role permissions and check if they have access
$permissions = Role_Perm::get_role_perms($session->roleid);
if (!$permissions->permissions['Approve']){
    $session->set_message("You do not have access to do approvals.", "danger");
    redirect_to("../main.php");
}

if (isset($_GET['id'])) {
    if(isset($_GET['type'])) {
        if ($_GET['type'] == a) {
            //approve
            if (Appreciation::process_appreciation($_GET['id'], $session->userid, 4)) {
                Appreciation::process_app_email($_GET['id']);
                $session->set_message("Appreciation was approved.", "success");
                redirect_to("approval_management.php");
            } else {
                $session->set_message("There was an issue processing the appreciation, please try again.", "danger");
                redirect_to("approval_management.php");
            } 
        } elseif ($_GET['type'] == d) {
            //deny
            if (isset($_POST['submit'])) {
                if (Appreciation::process_appreciation($_GET['id'], $session->userid, 5) && Appreciation::add_deny_reason($_GET['id'], $_POST['deny_description'])) {
                    Appreciation::process_deny_email($_GET['id']);
                    $session->set_message("Appreciation was denied.", "success");
                    redirect_to("approval_management.php");
                } else {
                    $session->set_message("There was an issue processing the appreciation, please try again.", "danger");
                    redirect_to("approval_management.php");
                } 
            } else {
                $session->set_message("Please enter a change reason to deny an appreciation.", "danger");
                redirect_to("approval_management.php");
            }
        } else {
            //error
            $session->set_message("You didn't select whether you wanted to approve or deny the appreciation.", "warning");
            redirect_to("approval_management.php");
        }
    } else {
        //error
        $session->set_message("You didn't select whether you wanted to approve or deny the appreciation.", "warning");
        redirect_to("approval_management.php");
    }
} else {
    //do nothing and redirect to user management
    $session->set_message("Select an approval before proceeding.", "warning");
    redirect_to("approval_management.php");
}