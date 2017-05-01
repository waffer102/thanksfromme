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

    $start_date_post = $database->escape_value($_POST['start_date']) . " 00:00:00";
    $start_date = date('Y-m-d H:i:s', strtotime($start_date_post));
    $end_date_post = $database->escape_value($_POST['end_date']) . " 23:59:59";
    $end_date = date('Y-m-d H:i:s', strtotime($end_date_post));

    // output headers so that the file is downloaded rather than displayed
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=data.csv');

    // create a file pointer connected to the output stream
    $output = fopen('php://output', 'W');

    // output the column headings
    fputcsv($output, array('Unique ID','Point Value', 'Message', 'Date Given', 'Date Approved', 'Date Redeemed', 'Recipient', 'Employee ID', 'Email Address', 'Business Unit', 'Department', 'Category', 'From'));

    // fetch the data
    $sql = "SELECT DISTINCT appreciation.id, appreciation.point_value, appreciation.description, appreciation.date_given, appreciation.date_approved, appreciation.redeem_date,  CONCAT(user.first_name, \" \", user.last_name) AS Recipient, user.employee_id, user.email_address, business_unit.business_unit_name, department.department_name, category.category_name, CONCAT(f.first_name, \" \", f.last_name) AS Appreciator FROM appreciation JOIN user ON user.id = appreciation.receiver_id JOIN user f ON f.id = appreciation.giver_id JOIN user_history ON user_history.id = appreciation.receiver_history_id JOIN business_unit ON business_unit.id = user_history.business_unit_id JOIN department ON department.id = user_history.department_id JOIN category ON category.id = appreciation.category_id WHERE appreciation.paid_out = 1 AND appreciation.status_id = 4 AND appreciation.point_value > 0 AND appreciation.redeem_date BETWEEN '".$start_date."' AND '".$end_date."'";
    $rows = $database->query($sql);

    // loop over the rows, outputting them
    while ($row = $database->fetch_array($rows)) fputcsv($output, $row);
    fclose($output);
    die();
}