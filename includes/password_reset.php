<?php
require_once("database.php");
require_once("send_mail.php");

class Password_Reset {

    public static function pw_reset_verify($username, $email) {
        global $database;
        $result = $database->query("SELECT 1 FROM user where username = \"{$username}\" AND email_address = \"{$email}\"");
        if ($result && $database->num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function generate_key($username, $email) {
        global $database;
        //generate key
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $temp_key = '';
        for ($p = 0; $p < 8; $p++) {
            $temp_key .= $characters[mt_rand(0, strlen($characters)-1)];
        }
         
        //generate expiration date
        $expiration = date("Y-m-d H:i:s", strtotime('+8 hours'));
         
        //write to database
        $sql = "INSERT INTO password_reset (username, temp_key, expiration_date) VALUES ('{$username}', '{$temp_key}', '{$expiration}')";
        if ($database->query($sql)) {
            $reset_mail = new Send_Mail;
            if ($reset_mail->Password_Reset($username, $email, $temp_key)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    public static function verify_token($username, $temp_key) {
        global $database;
        //get information from database
        $result = $database->query("SELECT * FROM password_reset WHERE username = \"{$username}\" AND temp_key = \"{$temp_key}\"");
        $result_array = $database->fetch_array($result);
        if ($result && $database->num_rows($result) == 1) {
            //if a result is found, make sure it isn't expired
            $time_now = date("Y-m-d H:i:s");
            if ($result_array['expiration_date'] < $time_now) {
                //expired
                return false;
            } else {
                //good
                return true;
            }
        } else {
            //no result found
            return false;
        }
    }
    
    public static function get_user_id($username) {
        global $database;
        //get information from database
        $result = $database->query("SELECT id FROM user WHERE username = \"{$username}\" LIMIT 1");
        $row = $database->fetch_array($result);
        return $row['id'];
    }
}