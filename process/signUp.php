<?php

$student_id=$_POST['student_id'];
$email_from=$_POST['email'];
$phone=$_POST['phone'];

unset($_POST['student_id']);
unset($_POST['email']);
unset($_POST['phone']);

if($student_id!='' && $email_from!='' && $phone!='') {

    $num_array = str_split($student_id);

    if($num_array[0]=="0") {
        $batch="20".$num_array[0].$num_array[1];

    }
    else {
        $batch="19".$num_array[0].$num_array[1];
    }


    if(checkCurrentStudent($student_id)==true) {
        $email_to=getBatchAdmin($batch);

        if($email_to=="") {
            $_SESSION['msg_type'] = 'e';
            $_SESSION['msg'] = 'Sorry!There is no admin for your batch.Try again later.';
            header('location:login.php');
        } else {
            $bodyContent = file_get_contents('mail_templates/new_signup.html');
            $tags = array("##BATCH##", "##STUDENT_ID##", "##EMAIL##","##PHONE##");
            $values = array($batch,$student_id,$email_from,$phone);
            $body = str_replace($tags, $values, $bodyContent);

            $sqlmail = "INSERT INTO mail_dispatcher (email_from,email_to,cc,subject,body) VALUES (:from, :to, :cc, :subject, :body)";
            $sthmail = $dbconn->prepare($sqlmail);
            $from="all.iutians.database@gmail.com";
            $subject="New signup request";
            $sthmail->execute(array(':from' => $from, ':to' => $email_to, ':cc' => '', ':subject' => $subject, ':body' => $body));

            $_SESSION['msg_type'] = 's';
            $_SESSION['msg'] = 'Your Batch Admin has been informed.You will be contacted by email/phone for sign-up procedure.Thank you for your interest in All IUTian Database';
            header('location:login.php');

        }
    }
    else {
        $_SESSION['msg_type'] = 'e';
        $_SESSION['msg'] = 'Sorry! You are already registered to All IUTian Database';
        header('location:login.php');

    }






}
else {
    $_SESSION['msg_type'] = 'e';
    $_SESSION['msg'] = 'Some fields are blank.Please fill up the credentials properly.';
    header('location:login.php');
}


?>
