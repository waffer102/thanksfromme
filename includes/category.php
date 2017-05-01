<?php
require_once("database.php");

class Category {
    public $id;
    public $category_name;
    public $category_description;
    public $category_value;
    public $is_reward;
    public $for_self;
    public $is_editable = 0;
    public $status_id;
    
    
    public static function find_all($type = 3) {
        //return all records that are of a specific type. type1=categories, type2=rewards, type3=all, type4=service
        if ($type==1){
            return static::find_by_sql("SELECT * FROM category WHERE is_reward=0");
        } elseif ($type==2) {
            return static::find_by_sql("SELECT * FROM category WHERE is_reward=1");
        } elseif ($type==4) {
            return static::find_by_sql("SELECT * FROM category WHERE is_reward=2");
        } else {
            return static::find_by_sql("SELECT * FROM category");
        }
        
    }
    
    public static function find_by_id($id=0) {
        //find record with specific id
        $result_array = static::find_by_sql("SELECT * FROM category WHERE id={$id} LIMIT 1");
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
        $sql = "SELECT COUNT(*) FROM category";
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
        $sql = "INSERT INTO category (category_name, category_description, category_value, is_reward, for_self, is_editable, status_id) VALUES ('";
        $sql .= $database->escape_value($this->category_name)."', '";
        $sql .= $database->escape_value($this->category_description)."', ";
        $sql .= $database->escape_value($this->category_value).", ";
        $sql .= $database->escape_value($this->is_reward).", ";
        $sql .= $database->escape_value($this->for_self).", ";
        $sql .= $database->escape_value($this->is_editable).", ";
        $sql .= $database->escape_value($this->status_id).")";
        
        if ($database->query($sql)) {
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }
    }
    
    public function update() {
        //update an existing record in the database
        global $database;
        $sql  = "UPDATE category SET ";
        $sql .= "category_name = '".$database->escape_value($this->category_name);
        $sql .= "', category_description = '".$database->escape_value($this->category_description);
        $sql .= "', category_value = '".$database->escape_value($this->category_value);
        $sql .= "', is_reward = '".$database->escape_value($this->is_reward);
        $sql .= "', for_self = '".$database->escape_value($this->for_self);
        $sql .= "', is_editable = '".$database->escape_value($this->is_editable);
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
        
        //first check appreciation table to see if it has ever been used
        $hx_result = $database->query("SELECT * FROM appreciation WHERE category_id={$id}");
        if ($database->num_rows($hx_result) == 0) {
            $sql  = "DELETE FROM category WHERE id=";
            $sql .= $database->escape_value($id);
            $sql .= " LIMIT 1";
            if ($database->query($sql)) {
                return true;
            } else {
                return false;
            }
        }
        //if so, don't delete
        return false;
    }
    
}