<?php
require_once("../../includes/initialize.php");
require_once("../../includes/import.php");

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
global $database;

if (!File_Upload::upload_user_list($_FILES['file'])) {
    //first check to see if it is a good file type
    echo "File type not supported.";
} else {
    //if so, run the import
    if(isset($_POST["submit"])) {
        $filename = $_FILES["file"]["tmp_name"];
        
        if($_FILES["file"]["size"] > 0){
        $file = fopen($filename, "r");
        fgetcsv($file);
        $num_new = 0;
        $num_updated = 0;
        $num_errors = 0;
        $num_nochange = 0;
            while(($filesop = fgetcsv($file, 10000, ",")) !== FALSE){ 
                $business_unit_code = $filesop[4]; 
                $department_code = $filesop[5];
                $status_name = $filesop[8];
                $role_name = $filesop[9];
                if ($filesop[7] == 0 || $filesop[7] == null) {
                    $manager_number = 0;
                } else {
                    $manager_number  = $filesop[7];
                }
                
                $username  = strtolower($filesop[1]);  //by default, username and email address will be the same
                $password = null;  //no password will be set, will send a password reset email
                $first_name  = $filesop[2];
                $last_name  = $filesop[3];
                $hire_date = date('Y-m-d', strtotime($filesop[6]));
                $employee_id  = $filesop[0];
                $email_address  = $filesop[1];
                $business_unit_id = Import::business_unit_id($business_unit_code);
                $department_id = Import::department_id($department_code);
                $manager_id  = Import::manager_id($manager_number);
                $picture_id = "default.png"; //default to generic picture
                $status_id  = Import::status_id($status_name);
                $role_id = Import::role_id($role_name);
                
                switch (Import::is_current_user($employee_id) == 1) {
                    case 0:
                        //new user
                        $user = new User;
                        $user->username = $username;
                        $user->first_name = $first_name;
                        $user->last_name = $last_name;
                        $user->hire_date = $hire_date;
                        $user->employee_id = $employee_id;
                        $user->email_address = $email_address;
                        $user->business_unit_id = $business_unit_id;
                        $user->department_id = $department_id;
                        $user->manager_id = $manager_id;
                        $user->picture_id = $picture_id;
                        $user->status_id = $status_id;
    
                        if ($user->create()) {
                            $user_config = new User_Configuration;
                            $user_config->user_id = $user->id;
                            $user_config->create();
                            
                            $role = new Role;
                            $role->user_id = $user->id;
                            $role->role_id = $role_id;
                    
                            if ($role->add_user()) {
                                echo "<table border=\"1\"><tr><td colspan=\"3\">{$first_name} {$last_name} - New User</td></tr><td>Field</td><td>Old Data</td><td>New Data</td><tr>";
                                echo "<tr><td>Username</td><td></td><td>".$user->username."</td></tr>";
                                echo "<tr><td>First Name</td><td></td><td>".$user->first_name."</td></tr>";
                                echo "<tr><td>Last Name</td><td></td><td>".$user->last_name."</td></tr>";
                                echo "<tr><td>Hire Date</td><td></td><td>".$user->hire_date."</td></tr>";
                                echo "<tr><td>Employee ID</td><td></td><td>".$user->employee_id."</td></tr>";
                                echo "<tr><td>Email Address</td><td></td><td>".$user->email_address."</td></tr>";
                                echo "<tr><td>Business Unit ID</td><td></td><td>".$user->business_unit_id."</td></tr>";
                                echo "<tr><td>Department ID</td><td></td><td>".$user->department_id."</td></tr>";
                                echo "<tr><td>Manager ID</td><td></td><td>".$user->manager_id."</td></tr>";
                                echo "<tr><td>Picture ID</td><td></td><td>".$user->picture_id."</td></tr>";
                                echo "<tr><td>Status ID</td><td></td><td>".$user->status_id."</td></tr>";
                                echo "<tr><td>Role ID</td><td></td><td>".$role_id."</td></tr>";
                                echo "</table><br>";
                                $num_new++;
                            } else {
                                echo "<table border=\"1\"><tr><td colspan=\"3\">{$first_name} {$last_name} - Error Importing</td></tr><td>Field</td><td>Old Data</td><td>New Data</td><tr></table>";
                                $num_errors++;
                            }
                        } else {
                            echo "<table border=\"1\"><tr><td colspan=\"3\">{$first_name} {$last_name} - Error Importing</td></tr><td>Field</td><td>Old Data</td><td>New Data</td><tr></table>";
                            $num_errors++;
                        }
                        break;
                    case 1:
                        //current user
                        $user = User::find_by_field("employee_id", $employee_id);
                        $user_role_id = Import::user_role($user->id);
                        $is_updated = 0;
    
                        echo "<table border=\"1\"><tr><td colspan=\"3\">{$first_name} {$last_name}</td></tr><td>Field</td><td>Old Data</td><td>New Data</td><tr>";
                        //if username is blank skip, otherwise, update
                        if ($username == null) { $user->username = $username; }
                        //the next if statements will check to see if there is a match, if not, update
                        if ($first_name != $user->first_name) {
                            echo "<tr><td>First Name</td><td>".$user->first_name."</td><td>".$first_name."</td></tr>";
                            $user->first_name = $first_name; $is_updated = 1;
                        }
                        if ($last_name != $user->last_name) {
                            echo "<tr><td>Last Name</td><td>".$user->last_name."</td><td>".$last_name."</td></tr>";
                            $user->last_name = $last_name; $is_updated = 1;
                        }
                        if ($hire_date != $user->hire_date) {
                            echo "<tr><td>Hire Date</td><td>".$user->hire_date."</td><td>".$hire_date."</td></tr>";
                            $user->hire_date = $hire_date; $is_updated = 1;
                        }
                        if ($employee_id != $user->employee_id) {
                            echo "<tr><td>Employee ID</td><td>".$user->employee_id."</td><td>".$employee_id."</td></tr>";
                            $user->employee_id = $employee_id; $is_updated = 1;
                        }
                        if ($email_address != $user->email_address) {
                            echo "<tr><td>Email Address</td><td>".$user->email_address."</td><td>".$email_address."</td></tr>";
                            $user->email_address = $email_address; $is_updated = 1;
                        }
                        if ($business_unit_id != $user->business_unit_id) {
                            echo "<tr><td>Business Unit ID</td><td>".$user->business_unit_id."</td><td>".$business_unit_id."</td></tr>";
                            $user->business_unit_id = $business_unit_id; $is_updated = 1;
                        }
                        if ($department_id != $user->department_id) {
                            echo "<tr><td>Department ID</td><td>".$user->department_id."</td><td>".$department_id."</td></tr>";
                            $user->department_id = $department_id; $is_updated = 1;
                        }
                        if ($manager_id != $user->manager_id) {
                            echo "<tr><td>Manager ID</td><td>".$user->manager_id."</td><td>".$manager_id."</td></tr>";
                            $user->manager_id = $manager_id; $is_updated = 1;
                        }
                        if ($status_id != $user->status_id) {
                            echo "<tr><td>Status ID</td><td>".$user->status_id."</td><td>".$status_id."</td></tr>";
                            $user->status_id = $status_id; $is_updated = 1;
                        }
                        if ($role_id != $user_role_id) {
                            echo "<tr><td>Role ID</td><td>".$user->role_id."</td><td>".$role_id."</td></tr>";
                            $user_role_id = $role_id; $is_updated = 1;
                        }
                        if ($is_updated == 1) {
                            //update database
                            if ($user->update()) {
                                $role = new Role;
                                $role->user_id = $user->id;
                                $role->role_id = $role_id;
                                if ($role->update_user()) {
                                    echo "</table><br>";
                                    $num_updated++;
                                } else {
                                    echo "An error has occured updating user.</table><br>";
                                    $num_errors++;
                                }
                            } else {
                                echo "An error has occured updating user.</table><br>";
                                $num_errors++;
                            }
                        } else { 
                            echo "<tr><td colspan=\"3\">No Changes</td></tr></table><br>";
                            $num_nochange++;
                        }
                        break;
                    default:
                        echo "An error has occured, check your import file and try again.";
                }
            }
        }
        fclose($file);
        
        echo "<br><br>";
        echo $num_new." New User(s)<br>";
        echo $num_updated." Updated User(s)<br>";
        echo $num_nochange." User(s) Not Changed<br>";
        echo $num_errors." Import Error(s)";
    
    } else {
        echo "Error Importing File.";
    }
}