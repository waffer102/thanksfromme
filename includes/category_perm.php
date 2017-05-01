<?php
require_once("database.php");

class Category_Perm {
    
    public $roleid_permissions;
    public $buid_permissions;
    
    protected function __contruct() {
        $this->roleid_permissions = array();
        $this->buid_permissions = array();
    }
    
    public function add_cat_perms($category_id) {
        global $database;
        
        //insert role permissions, start with roles and then do business units if that succeeds. 
        $role_sql = "INSERT INTO category_perm_role (category_id, role_id) VALUES ";
        foreach ($this->roleid_permissions as $role_permission) {
            $role_sql .= "({$category_id}, {$role_permission}), ";
        }
        $role_sql = rtrim($role_sql, ", ");
        if ($database->query($role_sql)) {
            $bu_sql = "INSERT INTO category_perm_bu (category_id, bu_id) VALUES ";
            foreach ($this->buid_permissions as $bu_permission) {
                $bu_sql .= "({$category_id}, {$bu_permission}), ";
            }
            $bu_sql = rtrim($bu_sql, ", ");   
            if ($database->query($bu_sql)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    public function update_cat_perms($category_id) {
        global $database;
        //first delete all permissions for category id
        $sql = "DELETE FROM category_perm_role WHERE category_id={$category_id}";
        if ($database->query($sql)) {
            $sql = "DELETE FROM category_perm_bu WHERE category_id={$category_id}";
            if ($database->query($sql)) {
                //if both deletions worked, add the correct permissions
                if ($this->add_cat_perms($category_id)) {
                    return true;
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

    public static function get_cat_perms($category_id=1) {
        global $database;
        $cat_perm = new Category_Perm();
        //load role information
        $sql = "SELECT role_id FROM category_perm_role WHERE category_id = {$category_id}";
        $results = $database->query($sql);
        while ($row = $database->fetch_array($results)) {
            $cat_perm->roleid_permissions[$row["role_id"]] = true;
        }
        
        //load bu information
        $sql_bu = "SELECT bu_id FROM category_perm_bu WHERE category_id = {$category_id}";
        $results_bu = $database->query($sql_bu);
        while ($row_bu = $database->fetch_array($results_bu)) {
            $cat_perm->buid_permissions[$row_bu["bu_id"]] = true;
        }
        
        return $cat_perm;
    }

    public static function get_cat_perms_role($category_id=1) {
        //only gets role permissions
        global $database;
        $cat_perm_role = new Category_Perm();
        $sql = "SELECT role_id FROM category_perm_role WHERE category_id = {$category_id}";
        $results = $database->query($sql);
        while ($row = $database->fetch_array($results)) {
            $cat_perm_role->roleid_permissions[$row["role_id"]] = true;
        }
        return $cat_perm_role;
    }

    public static function get_cat_perms_bu($category_id=1) {
        //only gets bu permissions
        global $database;
        $cat_perm_bu = new Category_Perm();
        $sql = "SELECT bu_id FROM category_perm_bu WHERE category_id = {$category_id}";
        $results = $database->query($sql);
        while ($row = $database->fetch_array($results)) {
            $cat_perm_bu->buid_permissions[$row["bu_id"]] = true;
        }
        return $cat_perm_bu;
    }
    
    public static function delete_cat_perms($category_id) {
        global $database;
        
        $sql = "DELETE FROM category_perm_role WHERE category_id={$category_id}";
        if ($database->query($sql)) {
            $sql = "DELETE FROM category_perm_bu WHERE category_id={$category_id}";
            if ($database->query($sql)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    public function has_perm($permission) {
        return isset($this->permissions[$permission]);
    }
    
}