<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

    $message=$_POST['feedback'];

    if($message!="")
        {

    $bodyContent = file_get_contents('mail_templates/new_feedback.html');
    $tags = array("##MESSAGE##", "##NAME##", "##STD_ID##");
    $values = array($message, $_SESSION['name'], $_SESSION['student_id']);
    $body = str_replace($tags, $values, $bodyContent);

    $sqlendrow = "SELECT * FROM user_info WHERE role_id=1";
    $sthendrow = $dbconn->prepare($sqlendrow);
    $sthendrow->execute();
    $result = $sthendrow->fetch(PDO::FETCH_ASSOC);

    $sqlmail = "INSERT INTO mail_dispatcher (email_from,email_to,cc,subject,body) VALUES (:from, :to, :cc, :subject, :body)";
    $sthmail = $dbconn->prepare($sqlmail);
    $subject="A new feedback has been posted";
    $sthmail->execute(array(':from' => $_SESSION['email'], ':to' => /*$result['email_primary']*/'all.iutians.database@gmail.com', ':cc' => '', ':subject' => $subject, ':body' => $body));

    $_SESSION['msg_type'] = 's';
    $_SESSION['msg'] = 'Your feedback has been successfully sent';
    header('location:index.php?page=home');

        }
        else
            {
            $_SESSION['msg_type'] = 'e';
            $_SESSION['msg'] = 'You did not provide any feedback';
            header('location:index.php?page=home');
        }
?>
