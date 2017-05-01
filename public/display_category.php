<?php
require_once("../includes/initialize.php");
global $database;

if (!$session->is_logged_in()) {
    redirect_to("login.php");
}

$explode_get = explode('|', $database->escape_value($_GET['id']));

$result = $database->query("SELECT category_description FROM category WHERE id=".$explode_get[0]." LIMIT 1");
$row = $database->fetch_array($result);
echo $row['category_description'];
?>