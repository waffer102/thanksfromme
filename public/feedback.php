<?php
require_once("../includes/initialize.php");
require_once ("../includes/phpmailer/PHPMailerAutoload.php");

//check if logged in and redirect if not
if (!$session->is_logged_in()) {
    redirect_to("login.php");
}

if (isset($_POST['submit'])) {

    //get POST details
    $subject_form = $_POST['type'];
    $body_form = $_POST['comments'];
    $name_form = get_full_name($session->userid);
    echo "test";
    //send mail
    $mail = new PHPMailer;
    
    //$mail->SMTPDebug = 3;                               // Enable verbose debug output
    
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'mail.thanksfrom.me';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'feedback@thanksfrom.me';                 // SMTP username
    $mail->Password = 'bNm)cs&0@kNw';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 25;                                    // TCP port to connect to
    
    $mail->setFrom('feedback@thanksfrom.me', 'Feedback');
    $mail->addAddress('chadhauf@gmail.com');     // Add a recipient
    
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = $subject_form;
    $mail->Body    = 'From the website:<br><br><b>Subject:</b> '.$subject_form.'<br><br><b>Comments:</b>'.$body_form.'<br><br><b>From:</b> '.$name_form;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        $session->set_message("Feedback was successfully sent.", "success");
        redirect_to("main.php");
    }
}
?>

<form method="POST" action="feedback.php">
    <div class="form-group">
    <label for="type">Select a category</label>
        <select class="form-control" id="type" name="type">
            <option value="Feedback">Feedback</option>
            <option value="Feature request">Feature request</option>
            <option value="Report a bug">Report a bug</option>
            <option value="general">General</option>
        </select>
    </div>
    <div class="form-group">
        <label for="comments">Comments</label>
        <textarea class="form-control" id="comments" name="comments" rows="5" cols="40"></textarea>
    </div>
    <input type="submit" class="btn btn-primary" value="Submit" name="submit">
</form>