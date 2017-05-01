<?php

function redirect_to($new_location) {
    header ("Location: " . $new_location);
    exit;
}

function output_message($message="", $alert_type="success") {
    if (!empty($message)) {
        //alert_type must be one of:  success, info, warning, danger
        return "<div class=\"alert alert-{$alert_type}\" role=\"alert\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>{$message}</div>";
    } else {
        return "";
    }
}

function get_businessunit_name($id) {
    global $database;
    $sql = "SELECT * FROM business_unit WHERE id={$id}";
    $result = $database->query($sql);
    $row = $database->fetch_array($result);
    return $row['business_unit_name'];
}

function list_businessunits() {
    global $database;
    $sql = "SELECT * FROM business_unit";
    $result = $database->query($sql);
    $result_array = array();
    while ($row = $database->fetch_array($result)) {
        $result_array[] = $row;
    }
    return $result_array;
}

function get_full_name($id) {
    //return full name as "First Last"
    global $database;
    $result = $database->query("SELECT * FROM user WHERE id={$id} LIMIT 1");
    $row = $database->fetch_array($result);
    return $row['first_name']." ".$row['last_name'];
}

function get_category_name($id) {
    //return category
    global $database;
    $result = $database->query("SELECT category_name FROM category WHERE id={$id} LIMIT 1");
    $row = $database->fetch_array($result);
    return $row['category_name'];
}

function get_department_name($id) {
    global $database;
    $sql = "SELECT * FROM department WHERE id={$id}";
    $result = $database->query($sql);
    $row = $database->fetch_array($result);
    return $row['department_name'];
}

function get_reportsto_name($id=0) {
    global $database;
    if ($id==0) {
        return "No One";
    } else {
        $sql = "SELECT * FROM user WHERE id={$id}";
        $result = $database->query($sql);
        $row = $database->fetch_array($result);
        return $row['last_name'].", ".$row['first_name'];        
    }
}

function get_status_name($id) {
    //return status
    global $database;
    $result = $database->query("SELECT status_name FROM status WHERE id={$id} LIMIT 1");
    $row = $database->fetch_array($result);
    return $row['status_name'];
}

function display_user_role($id) {
    global $database;
    $sql = "SELECT t2.role_name FROM `user_role` AS t1 INNER JOIN `roles` AS t2 ON t1.role_id = t2.role_id WHERE t1.user_id = {$id}";
    $result = $database->query($sql);
    $row = $database->fetch_array($result);
    return $row['role_name'];
}

function list_roles() {
    global $database;
    $sql = "SELECT * FROM roles";
    $result = $database->query($sql);
    $result_array = array();
    while ($row = $database->fetch_array($result)) {
        $result_array[] = $row;
    }
    return $result_array;
}

function list_permissions() {
    global $database;
    $sql = "SELECT * FROM permissions";
    $result = $database->query($sql);
    $result_array = array();
    while ($row = $database->fetch_array($result)) {
        $result_array[] = $row;
    }
    return $result_array;
}

function include_layout_template($template="") {
	include(SITE_ROOT.DS.'public'.DS.'layouts'.DS.$template);
}

function include_css($css="") {
    return DS.'css'.DS.$css;
}

function include_js($js="") {
    return DS.'js'.DS.$js;
}

function admin_sidebar_active($link1="", $link2="", $link3="", $link4="") {
    if (strcmp(basename($_SERVER['PHP_SELF']),$link1)==0) { 
        return "class=\"active\"";
    } elseif (strcmp(basename($_SERVER['PHP_SELF']),$link2)==0) {
        return "class=\"active\"";
    } elseif (strcmp(basename($_SERVER['PHP_SELF']),$link3)==0) {
        return "class=\"active\"";
    } elseif (strcmp(basename($_SERVER['PHP_SELF']),$link4)==0) {
        return "class=\"active\"";
    } else {
        return "";
    }
}

function current_user_history($user_id) {
    global $database;
    $hx_result = $database->query("SELECT * FROM user_history WHERE user_id={$user_id} ORDER BY id DESC LIMIT 1");
    $result = $database->fetch_array($hx_result);
    return $result['id'];
}