<?php 
require_once("../includes/initialize.php");
$session->logout();
if (isset($_COOKIE['rm_token'])) {
    unset($_COOKIE['rm_token']);
    setcookie('rm_token', '', time() - 3600); // empty value and old timestamp
}
redirect_to("login.php"); //need to delete the cookies and the entry in the database
?>