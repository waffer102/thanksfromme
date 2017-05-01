<?php
require_once("database.php");

class Business_Unit {
    public $id;
    public $business_unit_code;
    public $business_unit_name;
    public $picture_id;
    public $status_id;
    
    
    public static function find_all() {
        //return all records
        return static::find_by_sql("SELECT * FROM business_unit");
    }
    
    public static function find_by_id($id=0) {
        //find record with specific id
        $result_array = static::find_by_sql("SELECT * FROM business_unit WHERE id={$id} LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
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
        $sql = "SELECT COUNT(*) FROM business_unit";
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
        global $database;
        $sql = "INSERT INTO business_unit (business_unit_code, business_unit_name, picture_id, status_id) VALUES ('";
        $sql .= $database->escape_value($this->business_unit_code)."', '";
        $sql .= $database->escape_value($this->business_unit_name)."', '";
        $sql .= $database->escape_value($this->picture_id)."', ";
        $sql .= $database->escape_value($this->status_id).")";
        if ($database->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function update() {
        //update an existing record in the database
        global $database;
        $sql  = "UPDATE business_unit SET ";
        $sql .= "business_unit_code = '".$database->escape_value($this->business_unit_code);
        $sql .= "', business_unit_name = '".$database->escape_value($this->business_unit_name);
        $sql .= "', picture_id = '".$database->escape_value($this->picture_id);
        $sql .= "', status_id = '".$database->escape_value($this->status_id);
        $sql .= "' WHERE id=".$database->escape_value($this->id);

        if ($database->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function tbdelete($id=0) {
        //delete a record from the database
        global $database;
        
        //first check history table to see if it has ever been used
        $hx_result = $database->query("SELECT * FROM user_history WHERE business_unit_id={$id}");
        if ($database->num_rows($hx_result) == 0) {
            $sql  = "DELETE FROM business_unit WHERE id=";
            $sql .= $database->escape_value($id);
            $sql .= " LIMIT 1";
            $database->query($sql);
            return ($database->affected_rows() == 1) ? true : false;
        } else {
            return false;
        }
    }
    
    public static function get_picture_id($user_id) {
        global $database;
        $sql = "SELECT business_unit.picture_id FROM user INNER JOIN business_unit ON business_unit.id = user.business_unit_id WHERE user.id={$user_id}";
        $result = $database->query($sql);
        $row = $database->fetch_array($result);
        return $row['picture_id'];
    }
}