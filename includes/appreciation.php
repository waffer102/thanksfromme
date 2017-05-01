<?php
require_once("database.php");
require_once("send_mail.php");

class Appreciation {
    public $id;
    public $receiver_id;
    public $receiver_history_id;
    public $giver_id;
    public $giver_history_id;
    public $date_given;
    public $date_approved;
    public $approved_by_id;
    public $last_edited_by_id;
    public $last_edited_by_date;
    public $category_id;
    public $description;
    public $point_value;
    public $paid_out;
    public $is_public;
    public $redeem_date;
    public $status_id;
    
    public static function find_all() {
        //return all records
        return static::find_by_sql("SELECT * FROM appreciation");
    }
    
    public static function find_by_id($id=0) {
        //find record with specific id
        $result_array = static::find_by_sql("SELECT * FROM appreciation WHERE id={$id} LIMIT 1");
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

    public static function find_for_livefeed($num_to_show=10) {
        //run sql statement through instantiate method
        global $database;
        $sql = "SELECT receiver_id, giver_id, date_approved, category_id, description FROM appreciation WHERE status_id=4 AND is_public=1 ORDER BY date_approved DESC LIMIT {$num_to_show}";
        $result_set = $database->query($sql);
        $object_array = array();
        while ($row = $database->fetch_array($result_set)) {
            $object_array[] = static::instantiate($row);
        }
        return $object_array;
    }
    
    public static function sidebar_user_stats_left($user_id) {
        global $database;
        //get number of appreciation given during current year
        $sql = "SELECT COUNT(*) AS value_sum FROM appreciation WHERE YEAR(date_given) = YEAR(CURDATE()) AND status_id = 4 AND giver_id = {$user_id}";
        $result = $database->query($sql); 
        $row = $database->fetch_array($result); 
        $given_year = $row['value_sum'];
        //get number of appreciation received during current year
        $sql = "SELECT COUNT(*) AS value_sum FROM appreciation WHERE YEAR(date_given) = YEAR(CURDATE()) AND status_id = 4 AND receiver_id = {$user_id}";
        $result = $database->query($sql); 
        $row = $database->fetch_array($result); 
        $received_year = $row['value_sum'];
        //last 5 appreciation received
        $sql = "SELECT giver_id, date_approved, category_id FROM appreciation WHERE status_id=4 AND receiver_id = {$user_id} ORDER BY date_approved DESC LIMIT 5";
        $result_set = $database->query($sql);
        $object_array = array();
        while ($row = $database->fetch_array($result_set)) {
            $object_array[] = static::instantiate($row);
        }
        //return all the stats
        return $stat_array = array($given_year, $received_year, $object_array);
    }
    
    public static function sidebar_user_stats_right($user_id) {
        global $database;
        //get paints available to redeem
        $sql = "SELECT SUM(point_value) AS value_sum FROM appreciation WHERE status_id = 4 AND paid_out = 0 AND receiver_id = {$user_id}";
        $result = $database->query($sql); 
        $row = $database->fetch_array($result); 
        $available = $row['value_sum'];
        //get points recieved last 7 days
        $sql = "SELECT SUM(point_value) AS value_sum FROM appreciation WHERE status_id = 4 AND date_approved > CURDATE() - 7 AND receiver_id = {$user_id}";
        $result = $database->query($sql); 
        $row = $database->fetch_array($result); 
        $lastweek = $row['value_sum'];
        //get company average last 7 days
        $sql = "SELECT ROUND(AVG(point_value)) AS value_sum FROM appreciation WHERE status_id = 4 AND date_approved > CURDATE() - 7";
        $result = $database->query($sql); 
        $row = $database->fetch_array($result); 
        $companyave = $row['value_sum'];
        //get total appreciation all time
        $sql = "SELECT SUM(point_value) AS value_sum FROM appreciation WHERE status_id = 4 AND receiver_id = {$user_id}";
        $result = $database->query($sql); 
        $row = $database->fetch_array($result); 
        $totapp = $row['value_sum'];
        //get top 5 appreciated
        $sql = "select receiver_id, count(receiver_id) as number from appreciation WHERE MONTH(date_given) = MONTH(CURDATE()) AND status_id = 4 group by receiver_id order by 2 desc limit 5";
        $result_set = $database->query($sql);
        $object_array_rec = array();
        while ($row = $database->fetch_array($result_set)) {
            $object_array_rec[] = static::instantiate($row);
        }
        //get top 5 appreciator
        $sql = "select giver_id, count(giver_id) as number from appreciation WHERE MONTH(date_given) = MONTH(CURDATE()) AND status_id = 4 group by giver_id order by 2 desc limit 5";
        $result_set = $database->query($sql);
        $object_array_giv = array();
        while ($row = $database->fetch_array($result_set)) {
            $object_array_giv[] = static::instantiate($row);
        }
        //return everything
        return $stat_array = array($available, $lastweek, $companyave, $totapp, $object_array_rec, $object_array_giv);
    }
    
    public static function count_all() {
        //count all records in table
        global $database;
        $sql = "SELECT COUNT(*) FROM appreciation";
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
        $sql = "INSERT INTO appreciation (receiver_id, receiver_history_id, giver_id, giver_history_id, date_given, category_id, description, point_value, paid_out, is_public, status_id) VALUES ('";
        $sql .= $database->escape_value($this->receiver_id)."', '";
        $sql .= $database->escape_value($this->receiver_history_id)."', '";
        $sql .= $database->escape_value($this->giver_id)."', '";
        $sql .= $database->escape_value($this->giver_history_id)."', '";
        $sql .= $database->escape_value($this->date_given)."', '";
        $sql .= $database->escape_value($this->category_id)."', '";
        $sql .= $database->escape_value($this->description)."', '";
        $sql .= $database->escape_value($this->point_value)."', '";
        $sql .= $database->escape_value($this->paid_out)."', '";
        $sql .= $database->escape_value($this->is_public)."', '";
        $sql .= $database->escape_value($this->status_id)."')";
        if ($database->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function process_appreciation($id, $approver_id, $status) {
        //approve or deny an appreciation
        global $database;
        $sql  = "UPDATE appreciation SET ";
        $sql .= "date_approved = '".date('Y-m-d H:i:s');
        $sql .= "', approved_by_id = '".$database->escape_value($approver_id);
        $sql .= "', status_id = '".$status;
        $sql .= "' WHERE id=".$database->escape_value($id);

        if ($database->query($sql)) {
            if ($status == 4) {
                $sql_delete = "DELETE FROM appreciation_decline_reasons WHERE appreciation_id = ".$id;
                $database->query($sql_delete);
            }
            return true;
        } else {
            return false;
        }
    }
    
    public static function process_app_email ($app_id) {
        global $database;
        //get rec information
        $sql = "SELECT id, first_name, last_name, email_address, manager_id FROM user WHERE id = (SELECT receiver_id FROM appreciation WHERE id={$app_id})";
        $result = $database->query($sql);
        $row = $database->fetch_array($result);
        $rec_config = User_Configuration::find_by_userid($row['id']);
        //get sender information
        $sql_give = "SELECT id, first_name, last_name, email_address FROM user WHERE id = (SELECT giver_id FROM appreciation WHERE id={$app_id})";
        $result_give = $database->query($sql_give);
        $row_give = $database->fetch_array($result_give);
        $give_config = User_Configuration::find_by_userid($row_give['id']);
        //check if user has manager, get manager configuration information, else zero
        if ($row['manager_id'] != 0) { 
            $manager_config = User_Configuration::find_by_userid($row['manager_id']);
            $manager_info = User::find_by_id($row['manager_id']);
        } else {
            $manager_config = 0;
        }
        //get appreciation information
        $appreciation = Appreciation::find_by_id($app_id);
        $category = get_category_name($appreciation->category_id);
        //check if for self
        $sql_self = "SELECT for_self FROM category WHERE id = {$appreciation->category_id}";
        $result_self = $database->query($sql_self);
        $row_self = $database->fetch_array($result_self);
        //array of information for emails
        $mail_info = array($row['first_name'], $row['last_name'], $row['email_address'], $row_give['first_name'], $row_give['last_name'], $row_give['email_address'], $category, $appreciation->description, $appreciation->point_value, $manager_info->first_name, $manager_info->last_name, $manager_info->email_address);
        //check to see if the receiver wants an email, if so, send
        if ($rec_config->rec_self == 1 && $row_self['for_self'] == 0) {
            $send_mail = new Send_Mail;
            $send_mail->recieve_appreciation($mail_info);
        }
        if ($rec_config->rec_self == 1 && $row_self['for_self'] == 1) {
            $send_mail = new Send_Mail;
            $send_mail->self_reward($mail_info);
        }
        //check to see if the giver wants an email, if so, send
        if ($give_config->give_approved == 1 && $row_self['for_self'] == 0) {
            $send_mail_giver = new Send_Mail;
            $send_mail_giver->appreciation_approved($mail_info);
        }
        //check to see if the manager wants an email, if so, send
        if ($manager_config->rec_direct_report == 1 && $row_self['for_self'] == 0) {
            $send_mail_manager = new Send_Mail;
            $send_mail_manager->appreciation_approved_manager($mail_info);
        }
    }
    
    public static function process_deny_email ($app_id) {
        global $database;
        //get rec information
        $sql = "SELECT id, first_name, last_name, email_address, manager_id FROM user WHERE id = (SELECT receiver_id FROM appreciation WHERE id={$app_id})";
        $result = $database->query($sql);
        $row = $database->fetch_array($result);
        //get sender information
        $sql_give = "SELECT id, first_name, last_name, email_address FROM user WHERE id = (SELECT giver_id FROM appreciation WHERE id={$app_id})";
        $result_give = $database->query($sql_give);
        $row_give = $database->fetch_array($result_give);
        $give_config = User_Configuration::find_by_userid($row_give['id']);
        //get appreciation information
        $appreciation = Appreciation::find_by_id($app_id);
        $category = get_category_name($appreciation->category_id);
        //get deny reason
        $sql_decline = "SELECT decline_description FROM appreciation_decline_reasons WHERE appreciation_id = {$app_id}";
        $result_decline = $database->query($sql_decline);
        $row_decline = $database->fetch_array($result_decline);
        //array of information for emails
        $mail_info = array($row['first_name'], $row['last_name'], $row['email_address'], $row_give['first_name'], $row_give['first_name'], $row_give['email_address'], $category, $appreciation->description, $appreciation->point_value);
        //check to see if the giver wants an email, if so, send
        if ($give_config->give_approved == 1) {
            $send_mail_giver = new Send_Mail;
            $send_mail_giver->appreciation_denied($mail_info, $row_decline['decline_description']);
        }
    }
    
    public static function add_deny_reason($appreciation_id, $decline_description) {
        global $database;
        $sql_delete = "DELETE FROM appreciation_decline_reasons WHERE appreciation_id = ".$appreciation_id;
        $sql  = "INSERT INTO appreciation_decline_reasons (appreciation_id, decline_description) VALUES (";
        $sql .= $database->escape_value($appreciation_id).", '";
        $sql .= $database->escape_value($decline_description)."')";

        if ($database->query($sql_delete) && $database->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function get_deny_reason($appreciation_id) {
        global $database;
        $sql = "SELECT decline_description FROM appreciation_decline_reasons WHERE appreciation_id = ".$appreciation_id;
        $result = $database->query($sql);
        $row = $database->fetch_array($result);
        return $row['decline_description'];
    }
    
    public static function cancel_appreciation($appreciation_id, $user_id) {
        global $database;
        $sql = "UPDATE appreciation SET ";
        $sql .= "status_id = 6";
        $sql .= ", last_edited_by_id = ".$user_id;
        $sql .= ", last_edited_by_date = '".date('Y-m-d H:i:s');
        $sql .= "' WHERE id = ".$database->escape_value($appreciation_id);
        if ($database->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function redeem_appreciation($appreciation_id) {
        global $database;
        $sql = "UPDATE appreciation SET ";
        $sql .= "paid_out = 1";
        $sql .= ", redeem_date = '".date('Y-m-d H:i:s');
        $sql .= "' WHERE id = ".$database->escape_value($appreciation_id);
        if ($database->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function update_appreciation() {
        //update an appreciation
        global $database;
        $sql  = "UPDATE appreciation SET ";
        $sql .= "category_id = '".$database->escape_value($this->category_id);
        $sql .= "', point_value = '".$database->escape_value($this->point_value);
        $sql .= "', paid_out = '".$database->escape_value($this->paid_out);
        $sql .= "', description = '".$database->escape_value($this->description);
        $sql .= "', is_public = '".$database->escape_value($this->is_public);
        $sql .= "', last_edited_by_id = '".$database->escape_value($this->last_edited_by_id);
        $sql .= "', last_edited_by_date = '".date('Y-m-d H:i:s');
        $sql .= "' WHERE id=".$database->escape_value($this->id);

        if ($database->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
    
}