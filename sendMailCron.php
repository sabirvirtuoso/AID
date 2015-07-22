<?php
//Settings
$limit = 5;
$mail_host = 'smtp.gmail.com';
$mail_port = 587;//465;
$mail_auth_user = 'all.iutians.database@gmail.com';
$mail_auth_pass = 'Pa$$w0rd123';
$mail_from = 'aid@aid.com';
$mail_from_name = 'AID Database';
$mail_alt_body = 'This email requires HTML enabled client, please consider upgrading.';
$email_reply_to = 'aid@aid.com';
$email_reply_to_name = 'AID Database';

include 'lib/dbconn.inc.php';
include 'lib/PHPMailer/class.phpmailer.php';
include 'lib/PHPMailer/class.smtp.php';

$sql = "SELECT * FROM mail_dispatcher WHERE status = 'P' ORDER BY mail_id LIMIT ".$limit;
$sth = $dbconn->prepare($sql);
$sth->execute();
$result = $sth->fetchAll(PDO::FETCH_ASSOC);

foreach ($result as $mail_item) {
    $mail_id = $mail_item['mail_id'];
    $mail = new PHPMailer(true);

    $bodyContent = $mail_item['body'];
    $mail->MsgHTML($bodyContent);

    $mail->IsSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";//ssl"; 
    $mail->Host = $mail_host;
    $mail->Port = $mail_port;
    
    $mail->Username = $mail_auth_user;
    $mail->Password = $mail_auth_pass;

    $mail->From = ('' == $mail_item['email_from']) ? $mail_from : $mail_item['email_from'];
    $mail->FromName = $mail_from_name;
    $mail->Subject = $mail_item['subject'];
    $mail->AltBody = $mail_alt_body;
    $mail->WordWrap = 50;

    $toSend = true;
    $mail->AddReplyTo($email_reply_to, $email_reply_to_name);
    try {
        $mail->AddAddress($mail_item['email_to']);
    } catch(phpmailerException $e)
    {
        $toSend = false;
        $dbconn->exec("UPDATE mail_dispatcher SET status = 'E' WHERE mail_id = ".$mail_id);
    }
    
    if ($mail_item['cc'] != ''){
        $mail->AddCC($mail_item['cc']);
    }

    $mail->IsHTML(true);
    
    if ($toSend){
        if ($mail->Send()) {
            $dbconn->exec("UPDATE mail_dispatcher SET status = 'S' WHERE mail_id = ".$mail_id);
            //echo 'MAIL SENT<br/>';
        }
    }
}
?>
