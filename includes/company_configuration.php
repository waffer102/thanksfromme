<?php
require_once("database.php");

class Company_Configuration {
    public $id = 1;
    public $company_name;
    public $company_logo;
    public $auto_service_award;
    public $auto_service_from;
    
    public static function load_config() {
        global $database;
        $sql = "SELECT * FROM company_configuration WHERE id=1 LIMIT 1";
        $result_set = $database->query($sql);
        $object_array = array();
        while ($row = $database->fetch_array($result_set)) {
            $object_array[] = static::instantiate($row);
        }
        return !empty($object_array) ? array_shift($object_array) : false;
    }
    
    public static function instantiate($record) {
        //grab record and load values
        $object = new self;
        
        foreach ($record as $attribute=>$value) {
            $object->$attribute = $value;
        }
        return $object;
    }
    
    public function update() {
        //update an existing record in the database
        global $database;
        
        $sql  = "UPDATE company_configuration SET ";
        $sql .= "company_name = '".$this->company_name;
        $sql .= "', company_logo = '".$this->company_logo;
        $sql .= "', auto_service_award = ".$this->auto_service_award;
        $sql .= ", auto_service_from = ".$this->auto_service_from;
        $sql .= " WHERE id = 1";

        if ($database->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
    
}