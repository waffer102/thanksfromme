<?php
require_once("database.php");
//require_once("sessions.php");

class User {
    
    protected static $db_fields = array('id', 'username', 'password', 'first_name', 'last_name', 'hire_date', 'employee_id', 'email_address', 'business_unit_id', 'department_id', 'manager_id', 'picture_id', 'status_id');
    
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $hire_date;
    public $employee_id;
    public $email_address;
    public $business_unit_id;
    public $department_id;
    public $manager_id;
    public $picture_id;
    public $status_id;
    
    public function full_name() {
        if (isset($this->first_name) && isset($this->last_name)) {
            return $this->first_name." ".$this->last_name;
        } else {
            return "";
        }
    }
    
    public static function authenticate($username="", $password="") {
        global $database;
        $username = strtolower($database->escape_value($username));

        $sql  = "SELECT * FROM user";
        $sql .= " WHERE username='{$username}'";
        $sql .= " LIMIT 1";
        
        $result_array = self::find_by_sql($sql);
        if (password_verify($password, $result_array[0]->password)) {
            return !empty($result_array) ? array_shift($result_array) : false;
        } else {
            return false;
        }
    }
    
    public static function set_remember_me($user_id) {
        global $database;
        //generate key
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $temp_key = '';
        for ($p = 0; $p < 120; $p++) {
            $temp_key .= $characters[mt_rand(0, strlen($characters)-1)];
        }
        setcookie('rm_token',$temp_key,time() + (86400 * 60)); // 86400 = 1 day
        $expiration = date("Y-m-d H:i:s", strtotime('+60 days'));
        //write to database
        $sql  = "INSERT INTO remember_me (user_id, session_token, expiration_date) VALUES ('";
        $sql .= $user_id."', '";
        $sql .= $temp_key."', '";
        $sql .= $expiration."')";
        $database->query($sql);
    }
    
    public static function get_remember_me() {
        global $database;
        //get cookie key
        $token = $_COOKIE['rm_token'];
        //get key from database
        $result = $database->query("SELECT * FROM remember_me WHERE session_token='{$token}' LIMIT 1");
        $row = $database->fetch_array($result);
        //check expiration date
        if ($database->num_rows($result) == 1 && $row['expiration_date'] > date("Y-m-d H:i:s")) {
            $rm_user = new User;
            $session = new Session;
            $rm_user->id = $row['user_id'];
            $user_role = Role::check_user_role($row['user_id']);
            $session->login($rm_user, $user_role);
            return true;
        } else {
            return false;
        }
        
    }
    
    public static function find_all() {
        //return all records
        return static::find_by_sql("SELECT * FROM user");
    }
    
    public static function find_by_id($id=0) {
        //find record with specific id
        $result_array = static::find_by_sql("SELECT * FROM user WHERE id={$id} LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }
    
    public static function find_by_field($field="id", $id=0) {
        //find record with specific id
        $result_array = static::find_by_sql("SELECT * FROM user WHERE {$field}={$id} LIMIT 1");
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
        $sql = "SELECT COUNT(*) FROM user";
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }
    
    public static function instantiate($record) {
        //grab record and load values
        $object = new self;
        
        foreach ($record as $attribute=>$value) {
            if ($object->has_attribute($attribute)) {
                $object->$attribute = $value;
            }
        }
        return $object;
    }
    
    private function has_attribute($attribute) {
        //checking to see if an attribute exists
        return array_key_exists($attribute, $this->attributes());
    }
    
    public function attributes() {
        //return an array of attribute names and their values
        $attributes = array();
        foreach(self::$db_fields as $field) {
            if(property_exists($this, $field)) {
                $attributes[$field] = $this->$field;
            }
        }
        return $attributes;
    }
    
    protected function sanitized_attributes() {
        //sanitize each value before sending to the database
        global $database;
        $clean_attributes = array();
        foreach ($this->attributes() as $key=>$value) {
            $clean_attributes[$key] = $database->escape_value($value);
        }
        return $clean_attributes;
    }
    
    public function create() {
        //create a new record in the database
        global $database;
        $this->username = strtolower($this->username);  //store username as lower
        $this->hire_date = date('Y-m-d', strtotime($this->hire_date));  //make sure date is in the right format
        $attributes = $this->sanitized_attributes();
        $sql  = "INSERT INTO user (";
        $sql .= join(", ", array_keys($attributes));
        $sql .= ") VALUES ('";
        $sql .= join("', '", array_values($attributes));
        $sql .= "')";
        
        if ($database->query($sql)) {
            $this->id = $database->insert_id();
            $sqlhx = "INSERT INTO user_history (user_id, business_unit_id, department_id, manager_id) VALUES (";
            $sqlhx .= $database->escape_value($this->id);
            $sqlhx .= ", ".$database->escape_value($this->business_unit_id);
            $sqlhx .= ", ".$database->escape_value($this->department_id);
            $sqlhx .= ", ".$database->escape_value($this->manager_id);
            $sqlhx .= ")";
            if ($database->query($sqlhx)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    public static function update_username($username, $id) {
        //updated the username only
        global $database;
        $sql = "UPDATE user SET username = '".strtolower($database->escape_value($username));
        $sql .= "' WHERE id=".$database->escape_value($id);
        if ($database->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function update_password($password, $id) {
        //updated the password only
        global $database;
        $sql = "UPDATE user SET password = '".$password;
        $sql .= "' WHERE id=".$database->escape_value($id);
        if ($database->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function update() {
        //update an existing record in the database
        global $database;
        $this->hire_date = date('Y-m-d', strtotime($this->hire_date)); //make sure date is in the right format
        $sql  = "UPDATE user SET ";
        $sql .= "username = '".strtolower($database->escape_value($this->username));
        $sql .= "', first_name = '".$database->escape_value($this->first_name);
        $sql .= "', last_name = '".$database->escape_value($this->last_name);
        $sql .= "', hire_date = '".$database->escape_value($this->hire_date);
        $sql .= "', employee_id = '".$database->escape_value($this->employee_id);
        $sql .= "', email_address = '".$database->escape_value($this->email_address);
        $sql .= "', business_unit_id = '".$database->escape_value($this->business_unit_id);
        $sql .= "', department_id = '".$database->escape_value($this->department_id);
        $sql .= "', manager_id = '".$database->escape_value($this->manager_id);
        $sql .= "', status_id = '".$database->escape_value($this->status_id);
        $sql .= "', picture_id = '".$database->escape_value($this->picture_id);
        $sql .= "' WHERE id=".$database->escape_value($this->id);
        
        $sqlhx = "INSERT INTO user_history (user_id, business_unit_id, department_id, manager_id) VALUES (";
        $sqlhx .= $database->escape_value($this->id);
        $sqlhx .= ", ".$database->escape_value($this->business_unit_id);
        $sqlhx .= ", ".$database->escape_value($this->department_id);
        $sqlhx .= ", ".$database->escape_value($this->manager_id);
        $sqlhx .= ")";
        if ($database->query($sql) && $database->query($sqlhx)) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function tbdelete($id=0) {
        //delete a record from the database
        global $database;
        //check if there has ever been appreciation, if so, do not delete
        $hx_result = $database->query("SELECT receiver_id FROM appreciation WHERE receiver_id={$id} OR giver_id={$id}");
        if ($database->num_rows($hx_result) == 0) {
            $sql  = "DELETE FROM user WHERE id=";
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
        $sql = "SELECT picture_id FROM user WHERE id={$user_id}";
        $result = $database->query($sql);
        $row = $database->fetch_array($result);
        return $row['picture_id'];
    }
    
    public static function update_picture_id($user_id, $picture_id) {
        //update an existing record in the database
        global $database;
        $sql  = "UPDATE user SET ";
        $sql .= "picture_id = '".$database->escape_value($picture_id);
        $sql .= "' WHERE id=".$database->escape_value($user_id);

        if ($database->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function does_username_exist($new_username) {
        //returns whether a username is already actice in the database
        global $database;
        $sql = "SELECT username FROM user WHERE username='";
        $sql .= strtolower($database->escape_value($new_username));
        $sql .= "'";
        $result = $database->query($sql);

        if ($database->num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

}