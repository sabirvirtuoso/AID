<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

$email=$_POST['email'];
$student_id=$_POST['student_id'];

$sql = 'SELECT email_primary,email_alternative,first_name,last_name,user_id FROM user_info WHERE student_id = :student_id';
$sth = $dbconn->prepare($sql);
$sth->execute(array(':student_id' => $student_id));
$result = $sth->fetch(PDO::FETCH_ASSOC);

if($email==null||$student_id==null) {
    $_SESSION['msg_type'] = 'e';
    $_SESSION['msg'] = 'Some of the desired fields are left empty.Please fill up the necessary fields.';
    header('location:login.php');
}
else {

    if($result['email_primary']==$email||$result['email_alternative']==$email) {

        $pass=getStrongPassword();
        $name=$result['first_name'].$result['last_name'];

        $sqlpassupdate='UPDATE user_info SET password=:password WHERE student_id=:student_id';
        $sthpassupdate = $dbconn->prepare($sqlpassupdate);
        $sthpassupdate->execute(array(':password' => md5($pass), ':student_id' => $student_id));

        $bodyContent = file_get_contents('mail_templates/new_forgotpass.html');
        $tags = array("##NAME##", "##STUDENT_ID##", "##PASSWORD##", "##WEB##");
        $values = array($name, $student_id, $pass, $_SERVER['SERVER_NAME']);
        $body = str_replace($tags, $values, $bodyContent);

        $sqlmail = "INSERT INTO mail_dispatcher (email_from,email_to,subject,body) VALUES (:from, :to, :subject, :body)";
        $sthmail = $dbconn->prepare($sqlmail);
        $from="all.iutians.database@gmail.com";
        $subject = "Your password has been reset";
        $sthmail->execute(array(':from' => $from, ':to' => $email, ':subject' => $subject, ':body' => $body));

        $sqlmeta="UPDATE user_meta SET force_pass_change=true WHERE user_id=:user_id";
        $sthmeta = $dbconn->prepare($sqlmeta);
        $sthmeta->execute(array(':user_id' => $result['user_id']));

        $_SESSION['msg_type'] = 's';
        $_SESSION['msg'] = 'Password updated successfully.Please check your mail for the new credentials';
        header('location:login.php');



    }

    else {
        $_SESSION['msg_type'] = 'e';
        $_SESSION['msg'] = 'Email provided does not match corresponding student id.Please check your credentials again.';
        header('location:login.php');
    }

}

?>
