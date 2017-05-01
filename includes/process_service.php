<?php
require_once("database.php");
require_once("functions.php");
require_once("appreciation.php");
require_once("company_configuration.php");

global $database;

//check to see if company turned on auto awards
$current_settings = Company_Configuration::load_config();
//if so, run. if not, don't
if($current_settings->auto_service_award == 1) {
    //get all service awards, check each member record for match, if found add value to appreciation table as pending
    $sql = "SELECT id, category_name, category_description, category_value FROM category WHERE is_reward = 2";
    $result_set = $database->query($sql);
    echo date('Y-m-d'); echo "<br>";
    while ($row = $database->fetch_array($result_set)) {
        print_r($row);
        echo "<br>";
        
        $date = date('Y-m-d', strtotime('-'.$row['category_description'].' years'));
        echo "<br>";
        
        //get list of users who have the right hire date
        $sql_emp = "SELECT id, hire_date FROM user WHERE hire_date = '".$date."'";
        $result_set_emp = $database->query($sql_emp);
        while ($row_emp = $database->fetch_array($result_set_emp)) {
            print_r($row_emp);
            
            //create appreciation for user
            $appreciation = new Appreciation();
            $appreciation->receiver_id = $row_emp['id'];
            $appreciation->receiver_history_id = current_user_history($row_emp['id']);
            $appreciation->giver_id = $current_settings->auto_service_from;
            $appreciation->giver_history_id = current_user_history($current_settings->auto_service_from);
            $appreciation->date_given = date('Y-m-d H:i:s');
            $appreciation->category_id = $row['id'];
            $appreciation->description = "Good job, you got a service award: ".$row['category_name'];
            $appreciation->point_value = $row['category_value'];
            $appreciation->paid_out = 0;
            $appreciation->is_public = 1;
            $appreciation->status_id = 3;
            print_r($appreciation);
            $appreciation->create();
        }
    }
} else {
    echo "Company settings have turned off auto processing.";
}