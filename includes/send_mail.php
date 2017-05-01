<?php
require_once("phpmailer/PHPMailerAutoload.php");

class Send_Mail {
    public $host;
    public $SMTPAuth;
    public $username;
    public $password;
    public $SMTPSecure;
    public $port;

    function __construct() {
        $this->host = 'host'; //actual value removed removed
        $this->SMTPAuth = true;
        $this->username = 'user'; //actual value removed removed
        $this->password = 'password'; //actual value removed removed
        $this->SMTPSecure = "tls";
        $this->port = 25;
    }
    
    public function Password_Reset ($username, $email, $temp_key) {
        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host = $this->host;
        $mail->SMTPAuth = $this->SMTPAuth;
        $mail->Username = $this->username;
        $mail->Password = $this->password;
        $mail->SMTPSecure = $this->SMTPSecure;
        $mail->Port = $this->port; 
        $mail->isHTML(true);
        
        $mail->setFrom('appreciation@thanksfrom.me', 'ThanksFromMe Mail');
        $mail->addAddress($email);     // recipient

        $mail->Subject = 'Password Reset';
        $mail->Body    = 'A password reset has been requested. Use the following link to create a new password.<br><br>https://northstar.thanksfrom.me/new_password.php?username='.$username.'&token='.$temp_key.'<br><br>Token: '.$temp_key;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
        if(!$mail->send()) {
            return false;
        } else {
            return true;
        }
    }
    
    public function recieve_appreciation ($mail_info) {
        //array is rec first name, rec last name, rec email, giver first name, giver last name, giver email, category, description, point value
        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host = $this->host;
        $mail->SMTPAuth = $this->SMTPAuth;
        $mail->Username = $this->username;
        $mail->Password = $this->password;
        $mail->SMTPSecure = $this->SMTPSecure;
        $mail->Port = $this->port; 
        $mail->isHTML(true);
        
        $mail->setFrom('appreciation@thanksfrom.me', 'ThanksFromMe Mail');
        $mail->addAddress($mail_info[2]);

        $mail->Subject = 'You have been recognized for '.$mail_info[6].'!';
        $mail->Body    = $mail_info[0].', you got an appreciation from '.$mail_info[3].' '.$mail_info[4].' for '.$mail_info['6'].'!<br><br>Point Value: '.$mail_info[8].'<br><br>Description: '.$mail_info[7];
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
        if(!$mail->send()) {
            return false;
        } else {
            return true;
        }
    }
    
    public function self_reward ($mail_info) {
        //array is rec first name, rec last name, rec email, giver first name, giver last name, giver email, category, description, point value
        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host = $this->host;
        $mail->SMTPAuth = $this->SMTPAuth;
        $mail->Username = $this->username;
        $mail->Password = $this->password;
        $mail->SMTPSecure = $this->SMTPSecure;
        $mail->Port = $this->port; 
        $mail->isHTML(true);
        
        $mail->setFrom('appreciation@thanksfrom.me', 'ThanksFromMe Mail');
        $mail->addAddress($mail_info[2]);

        $mail->Subject = 'Your Reward has been Approved!';
        $mail->Body    = $mail_info[0].', you reward for '.$mail_info['6'].' has been approved!<br><br>Point Value: '.$mail_info[8].'<br><br>Description: '.$mail_info[7];
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
        if(!$mail->send()) {
            return false;
        } else {
            return true;
        }
    }
    
    public function appreciation_approved ($mail_info) {
        //array is rec first name, rec last name, rec email, giver first name, giver last name, giver email, category, description, point value, manager first name, manager last name, manager email
        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host = $this->host;
        $mail->SMTPAuth = $this->SMTPAuth;
        $mail->Username = $this->username;
        $mail->Password = $this->password;
        $mail->SMTPSecure = $this->SMTPSecure;
        $mail->Port = $this->port; 
        $mail->isHTML(true);
        
        $mail->setFrom('appreciation@thanksfrom.me', 'ThanksFromMe Mail');
        $mail->addAddress($mail_info[5]);

        $mail->Subject = 'Your Appreciation has been Approved!';
        $mail->Body    = 'The appreciation you gave to '.$mail_info[0].' '.$mail_info[1].' for '.$mail_info[6].' has been approved!<br><br>Point Value: '.$mail_info[8].'<br><br>Description: '.$mail_info[7];
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
        if(!$mail->send()) {
            return false;
        } else {
            return true;
        }
    }

    public function appreciation_approved_manager ($mail_info) {
        //array is rec first name, rec last name, rec email, giver first name, giver last name, giver email, category, description, point value, manager first name, manager last name, manager email
        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host = $this->host;
        $mail->SMTPAuth = $this->SMTPAuth;
        $mail->Username = $this->username;
        $mail->Password = $this->password;
        $mail->SMTPSecure = $this->SMTPSecure;
        $mail->Port = $this->port; 
        $mail->isHTML(true);
        
        $mail->setFrom('appreciation@thanksfrom.me', 'ThanksFromMe Mail');
        $mail->addAddress($mail_info[11]);

        $mail->Subject = 'Your Direct Report Got Appreciated!';
        $mail->Body    = 'Your direct report '.$mail_info[0].' '.$mail_info[1].' was appreciated for '.$mail_info[6].'!<br><br>Description: '.$mail_info[7];
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
        if(!$mail->send()) {
            return false;
        } else {
            return true;
        }
    }
    
    public function appreciation_denied ($mail_info, $decline_desc) {
        //array is rec first name, rec last name, rec email, giver first name, giver last name, giver email, category, description, point value, manager first name, manager last name, manager email
        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host = $this->host;
        $mail->SMTPAuth = $this->SMTPAuth;
        $mail->Username = $this->username;
        $mail->Password = $this->password;
        $mail->SMTPSecure = $this->SMTPSecure;
        $mail->Port = $this->port; 
        $mail->isHTML(true);
        
        $mail->setFrom('appreciation@thanksfrom.me', 'ThanksFromMe Mail');
        $mail->addAddress($mail_info[5]);

        $mail->Subject = 'Your appreciation has been denied';
        $mail->Body    = 'The appreciation you gave to '.$mail_info[0].' '.$mail_info[1].' for '.$mail_info[6].' has been denied!<br><br>Reason for Decline: '.$decline_desc.'<br><br>Point Value: '.$mail_info[8].'<br><br>Description: '.$mail_info[7];
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
        if(!$mail->send()) {
            return false;
        } else {
            return true;
        }
    }

}