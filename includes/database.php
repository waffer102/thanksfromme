<?php
require_once("config.php");

class MySQLiDatabase {
    
    public $connection;
    public $last_query;
    
    function __construct() {
        $this->open_connection();
    }
    
    public function open_connection() {
        $this->connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        
        if(mysqli_connect_errno()) {
            die ("Database connection failed: " . mysqli_connect_errno(). mysqli_error($this->connection));
        }
    }
    
    public function close_connection() {
        if (isset($this->connection)) {
            mysqli_close($this->connection);
            unset($this->connection);
        }
    }
    
    public function query($sql) {
        $this->last_query = $sql;
        $result = mysqli_query($this->connection, $sql);
        $this->confirm_query($result);
        return $result;
    }
    
    private function confirm_query($result) {
        if (!$result) {
            $error_mess = "There was a query error: " . mysqli_error($this->connection);
            die ($error_mess);
        }
    }
    
    public function escape_value($value) {
        return mysqli_real_escape_string($this->connection, $value);
    }
    
    public function affected_rows() {
        return mysqli_affected_rows($this->connection);
    }
    
    public function num_rows($result_set) {
        return mysqli_num_rows($result_set);
    }
    
    public function fetch_array($result_set) {
        return mysqli_fetch_array($result_set, MYSQLI_ASSOC);
    }
    
    public function insert_id() {
        // get the last id inserted over the current db connection
        return mysqli_insert_id($this->connection);
  }
}

$database = new MySQLiDatabase();