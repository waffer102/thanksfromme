<?php
require_once("../includes/initialize.php");

//check if logged in and redirect if not
if (!$session->is_logged_in()) {
    redirect_to("login.php");
}

//check to see if there is an appreciation GET
if (isset($_GET['id'])) {
    $appreciation_id = $database->escape_value($_GET['id']);
} else {
    echo "There was an error displaying the appreciation.";
}

//get current logged in user and load their information
$user = User::find_by_id($session->userid);

//load the appreciation
$appreciation = Appreciation::find_by_id($appreciation_id);

//make sure the logged in user is the owner of the appreciation
if ($appreciation->receiver_id == $session->userid) {
    echo "<strong>Category:</strong> ".get_category_name($appreciation->category_id)."<br>";
    echo "<strong>Point Value:</strong> ".$appreciation->point_value."<br>";
    echo "<strong>Description:</strong> ".$appreciation->description."<br>";
    echo "<strong>Given By:</strong> ".get_full_name($appreciation->giver_id)."<br>";
    echo "<strong>Date Given:</strong> ".$appreciation->date_given."<br>";
    echo "<strong>Date Approved:</strong> ".$appreciation->date_approved."<br>";
    echo "<strong>Approved By:</strong> ".get_full_name($appreciation->approved_by_id)."<br>";
    if (!is_null($appreciation->last_edited_by_date)) {
        echo "<strong>Last Edited On:</strong> ".$appreciation->last_edited_by_date."<br>";
        echo "<strong>Last Edited By:</strong> ".get_full_name($appreciation->last_edited_by_id)."<br>";
    }
    if (!is_null($appreciation->redeem_date)) {
        echo "<strong>Redeemed On:</strong> ".$appreciation->redeem_date."<br>";
    }
} else {
    echo "You do not have access to this appreciation.";
}

?>