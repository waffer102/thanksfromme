<?php
require_once("database.php");

class Import {
    
    public static function business_unit_id($bu_code) {
        global $database;
        $sql = "SELECT * FROM business_unit WHERE business_unit_code = \"{$bu_code}\"";
        $result = $database->query($sql);
        $row = $database->fetch_array($result);
        return $row['id'];
    }

    public static function department_id($department_code) {
        global $database;
        $sql = "SELECT * FROM department WHERE department_code = \"{$department_code}\"";
        $result = $database->query($sql);
        $row = $database->fetch_array($result);
        return $row['id'];
    }
    
    public static function status_id($status) {
        global $database;
        $sql = "SELECT * FROM status WHERE status_name = \"{$status}\"";
        $result = $database->query($sql);
        $row = $database->fetch_array($result);
        return $row['id'];
    }

    public static function role_id($role) {
        global $database;
        $sql = "SELECT * FROM roles WHERE role_name = \"{$role}\"";
        $result = $database->query($sql);
        $row = $database->fetch_array($result);
        return $row['role_id'];
    }

    public static function user_role($id) {
        global $database;
        $sql = "SELECT * FROM user_role WHERE user_id = \"{$id}\"";
        $result = $database->query($sql);
        $row = $database->fetch_array($result);
        return $row['role_id'];
    }

    public static function manager_id($manager) {
        global $database;
        $sql = "SELECT * FROM user WHERE employee_id = \"{$manager}\"";
        $result = $database->query($sql);
        $row = $database->fetch_array($result);
        return $row['id'];
    }

    public static function is_current_user($id) {
        global $database;
        $sql = "SELECT COUNT(*) FROM user WHERE employee_id = {$id}";
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }
    
}