<?php
require_once("database.php");

class Role_Perm {
    
    public $permissions;
    
    protected function __contruct() {
        $this->permissions = array();
    }
    
    public static function get_role_perms($role_id=1) {
        global $database;
        $role = new Role_Perm();
        $sql = "SELECT t2.perm_name FROM role_perm AS t1 JOIN permissions AS t2 ON t1.perm_id = t2.perm_id WHERE t1.role_id = {$role_id}";
        $results = $database->query($sql);
        while ($row = $database->fetch_array($results)) {
            $role->permissions[$row["perm_name"]] = true;
        }
        return $role;
    }
    
    public function add_perms($role_id) {
        global $database;
        
        $sql = "INSERT INTO role_perm (role_id, perm_id) VALUES ";
        foreach ($this->permissions as $permission) {
            $sql .= "({$role_id}, {$permission}), ";
        }
        $sql = rtrim($sql, ", ");
        if ($database->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function update_perms($role_id) {
        global $database;
        //first delete all permissions for role_id
        $sql = "DELETE FROM role_perm WHERE role_id={$role_id}";
        if (!$database->query($sql)) {
            return false;
        }
        
        //now add the correct permissions
        $sql = "INSERT INTO role_perm (role_id, perm_id) VALUES ";
        foreach ($this->permissions as $permission) {
            $sql .= "({$role_id}, {$permission}), ";
        }
        $sql = rtrim($sql, ", ");
        if ($database->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function delete_perms($role_id) {
        global $database;
        
        $sql = "DELETE FROM role_perm WHERE role_id={$role_id}";
        if ($database->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function has_perm($permission) {
        return isset($this->permissions[$permission]);
    }
}