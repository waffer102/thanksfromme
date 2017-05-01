<?php
require_once("database.php");

class User_Configuration {
    public $user_id;
    public $rec_self;
    public $give_approved;
    public $give_denied;
    public $rec_direct_report;
    
    
    public static function find_all() {
        //return all records
        return static::find_by_sql("SELECT * FROM user_configuration");
    }
    
    public static function find_by_id($id=0) {
        //find record with specific userid
        $result_array = static::find_by_sql("SELECT * FROM user_configuration WHERE id={$id} LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }
    
    public static function find_by_userid($userid=0) {
        global $database;
        $sql = "SELECT * FROM user_configuration WHERE user_id={$userid} LIMIT 1";
        $result_set = $database->query($sql);
        $object_array = array();
        while ($row = $database->fetch_array($result_set)) {
            $object_array[] = static::instantiate($row);
        }
        return !empty($object_array) ? array_shift($object_array) : false;
    }
    
    public static function find_by_sql($sql="") {
        //run sql statement through instantiate method
        global $database;
        $result_set = $database->query($sql);
        $object_array = array();
        while ($row = $database->fetch_array($result_set)) {
            $object_array[] = static::instantiate($row);
        }
        return $object_array;
    }
    
    public static function count_all() {
        //count all records in table
        global $database;
        $sql = "SELECT COUNT(*) FROM user_configuration";
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }
    
    public static function instantiate($record) {
        //grab record and load values
        $object = new self;
        
        foreach ($record as $attribute=>$value) {
            $object->$attribute = $value;
        }
        return $object;
    }
    
    public function create() {
        //on create the default values will be loaded, all emails subscribed
        global $database;
        $sql = "INSERT INTO user_configuration (user_id, rec_self, give_approved, give_denied, rec_direct_report) VALUES ('";
        $sql .= $database->escape_value($this->user_id)."', '1', '1', '1', '1')";
        if ($database->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function update() {
        //update an existing record in the database
        global $database;
        
        $sql  = "UPDATE user_configuration SET ";
        $sql .= "rec_self = '".$database->escape_value($this->rec_self);
        $sql .= "', give_approved = '".$database->escape_value($this->give_approved);
        $sql .= "', give_denied = '".$database->escape_value($this->give_denied);
        $sql .= "', rec_direct_report = '".$database->escape_value($this->rec_direct_report);
        $sql .= "' WHERE user_id=".$database->escape_value($this->user_id);

        if ($database->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function tbdelete($id=0) {
        //delete a record from the database
        global $database;

        $sql  = "DELETE FROM user_configuration WHERE user_id=";
        $sql .= $database->escape_value($id);
        $sql .= " LIMIT 1";
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }
}