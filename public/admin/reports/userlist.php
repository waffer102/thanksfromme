<?php
require_once("../../../includes/initialize.php");

//verify user is logged in
if (!$session->is_logged_in()) {
    redirect_to("../login.php");
}
//load role permissions and check if they have access
$permissions = Role_Perm::get_role_perms($session->roleid);
if (!$permissions->permissions['Report Management']){
    $session->set_message("You do not have access to Report Management", "danger");
    redirect_to("../main.php");
}

if (isset($_POST['submit'])) {
    global $database;
    
    // output headers so that the file is downloaded rather than displayed
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=data.csv');

    // create a file pointer connected to the output stream
    $output = fopen('php://output', 'W');
    
    // output the column headings
    fputcsv($output, array('Employee ID', 'Username', 'First Name', 'Last Name'));
    
    // fetch the data
    $sql = "SELECT employee_id, username, first_name, last_name FROM user";
    $rows = $database->query($sql);
    
    // loop over the rows, outputting them
    while ($row = $database->fetch_array($rows)) fputcsv($output, $row);
    fclose($output);
    die();
}