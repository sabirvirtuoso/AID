<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/


$sqlendrow = "SELECT * FROM user_info WHERE user_id = :user_id";
$sthendrow = $dbconn->prepare($sqlendrow);
$sthendrow->execute(array(':user_id' => $_SESSION['view_user_id']));
$result = $sthendrow->fetch(PDO::FETCH_ASSOC);


$name_to=$result['first_name'].' '.$result['last_name'];
$name_from= $_SESSION['name'];
$batchadmin_email=getBatchAdmin($result['batch']);

$email=$result['email_primary'];




if(isset ($_GET['action'])&&$_GET['action']=='requpdate') {
    $subject="Please update your profile";
    $message=$_POST['f_description'];
    if($message=="") {
        $message="Please update your profile";
    }
    $bodyContent = file_get_contents('mail_templates/new_requestupdate.html');
    $_SESSION['msg_type'] = 's';
    $_SESSION['msg'] = 'You have requested '.$name_to.' to update his profile!!';
}
else if(isset ($_GET['action'])&&$_GET['action']=='flag') {
    $subject="Your account has been flagged";
    $message=$_POST['flag_description'];
    if($message=="") {
        $message="Your profile has been flagged for abusive content.";
    }
    $bodyContent = file_get_contents('mail_templates/new_flag.html');
    $_SESSION['msg_type'] = 's';
    $_SESSION['msg'] = 'You have successfully flagged the profile of '.$name_to;
}


$tags = array("##NAME_TO##", "##NAME_FROM##", "##MESSAGE##");
$values = array($name_to, $name_from, $message);
$body = str_replace($tags, $values, $bodyContent);

try {
    $sqlmail = "INSERT INTO mail_dispatcher (email_from,email_to,cc,subject,body) VALUES (:from, :to, :cc, :subject, :body)";
    $sthmail = $dbconn->prepare($sqlmail);
    $from="all.iutians.database@gmail.com";
    
    $sthmail->execute(array(':from' => $from, ':to' => $email, ':cc' => $batchadmin_email, ':subject' => $subject, ':body' => $body));
    
    
    header('location:index.php?page=profile&id='.$_SESSION['view_user_id']);

}catch(PDOException $e) {
    echo $e->getMessage();


}

?>
