<?php
require_once("database.php");

class Role {
    
    public $role_id;
    public $role_name;
    public $status_id;
    public $user_id;

    public static function find_by_id($role_id=0) {
        global $database;
        $sql = "SELECT * FROM roles WHERE role_id={$role_id} LIMIT 1";
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

    public function add_role() {
        global $database;
        $sql = "INSERT INTO roles (role_name, status_id) VALUES (\"".$this->role_name."\", ".$this->status_id.")";
        if ($database->query($sql)) {
            $this->role_id = $database->insert_id();
            return true;
        } else {
            return false;
        }
    }
    
    public function update_role() {
        //update an existing record in the database
        global $database;
        $sql  = "UPDATE roles SET ";
        $sql .= "role_name = '".$database->escape_value($this->role_name);
        $sql .= "', status_id = '".$database->escape_value($this->status_id);
        $sql .= "' WHERE role_id=".$database->escape_value($this->role_id);

        if ($database->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function delete_role($id=0) {
        //delete a record from the database
        global $database;
        
        //first check user_role table to see if it is currently being used
        $hx_result = $database->query("SELECT * FROM user_role WHERE role_id={$id}");
        if ($database->num_rows($hx_result) == 0) {
            $sql  = "DELETE FROM roles WHERE role_id=";
            $sql .= $database->escape_value($id);
            $sql .= " LIMIT 1";
            $database->query($sql);
            if ($database->affected_rows() == 1) {
                //delete all permissions for role_id
                $delsql = "DELETE FROM role_perm WHERE role_id={$id}";
                if ($database->query($delsql)) {
                    //delete all category permission references
                    $sql = "DELETE FROM category_perm_role WHERE role_id={$id}";
                    if ($database->query($sql)) {
                        return true;
                    } else {
                        return true;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    public function add_user() {
        //adds user information to user_role table
        global $database;
        
        $sql = "INSERT INTO user_role (user_id, role_id) VALUES (";
        $sql .= $this->user_id.", ".$this->role_id.")";
        if($database->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function update_user() {
        //adds user information to user_role table
        global $database;
        
        $sql = "UPDATE user_role SET role_id = ";
        $sql .= $this->role_id." WHERE user_id = ";
        $sql .= $this->user_id;
        if($database->query($sql)) {
            return true;
        } else {
            echo mysqli_error($database->connection);
            echo $sql;
            return false;
        }
    }
    
    public static function delete_user($id=0) {
        //delete all roles for a user in the user_role table
        global $database;
        
        $sql = "DELETE FROM user_role WHERE user_id=";
        $sql .= $database->escape_value($id);
        if ($database->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function check_user_role($id) {
        //checks which role user is assigned to and returns the role_id
        global $database;
        
        $sql = "SELECT * FROM user_role WHERE user_id=";
        $sql .= $database->escape_value($id);
        $result = $database->query($sql);
        $row = $database->fetch_array($result);
        return $row['role_id'];
    }
}