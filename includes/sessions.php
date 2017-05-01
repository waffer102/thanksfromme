<?php

class Session {
    
    private $logged_in = false;
    public $userid;
    public $roleid;
    public $message;
    public $alert_type;
    
    function __construct() {
        session_start();
        $this->check_message();
        $this->check_login();
        if ($this->logged_in) {
            //todo if yes
        } else {
            //todo if no
        }
    }
    
    public function is_logged_in() {
        return $this->logged_in;
    }
    
    public function login($user, $roleid) {
        if($user) {
            $this->userid = $_SESSION['user_id'] = $user->id;
            $this->roleid = $_SESSION['role_id'] = $roleid;
            $this->logged_in = true;
        }
    }
    
    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['role_id']);
        unset($this->userid);
        unset($this->roleid);
        $this->logged_in = false;
    }
    
    public function get_message() {
        return $this->message;
    }
    
    public function get_alert_type() {
        return $this->alert_type;
    }
    
    public function set_message($msg, $alert_type) {
        $_SESSION['message'] = $msg;
        $_SESSION['alert_type'] = $alert_type;
    }
    
    private function check_login() {
        if (isset($_SESSION['user_id']) && isset($_SESSION['role_id'])) {
            $this->userid = $_SESSION['user_id'];
            $this->roleid = $_SESSION['role_id'];
            $this->logged_in = true;
        } else {
            unset($this->userid);
            unset($this->roleid);
            $this->logged_in = false;
        }
    }
    
    private function check_message() {
        if (isset($_SESSION['message'])) {
            $this->message = $_SESSION['message'];
            $this->alert_type = $_SESSION['alert_type'];
            unset($_SESSION['message']);
            unset($_SESSION['alert_type']);
        } else {
            $this->message = "";
            $this->alert_type = "";
        }
    }
}

$session = new Session();
$message = $session->get_message();