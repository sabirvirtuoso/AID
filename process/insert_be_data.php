<?php

$targetpath = $_SESSION['targetpath'];
$count = 1;
$errmessage = "";
$flag = true;
$f = fopen($targetpath, "r");

$row_start = getMaxIdFromTable('user_info', 'user_id');
$row_end=0;

$dbconn->beginTransaction();

while (($line = fgetcsv($f)) !== false) {
    $col=1;
    if ($count > 1) {   //Ignore CSV header line
        //Generate random 6 digit strong password, no MD5
        $user_password = getStrongPassword();
        $bodyContent = file_get_contents('mail_templates/new_registration.html');
        $tags = array("##NAME##", "##STUDENT_ID##", "##PASSWORD##", "##WEB##");

        $sql = "INSERT INTO user_info (role_id, role_meta, password, student_id,
                            batch, department, first_name, last_name,
                            position, employer, sector, nationality,
                            email_primary, email_alternative, phone_primary,
                            phone_alternative, city, country, mailing_address, blood_group,
                            iut_room_no, interest, awards)
                    VALUES(4,'','123'";

        foreach ($line as $cell) {

            $sql = $sql . "," . "'" . htmlspecialchars($cell) . "'";
            $col++;
        }
        $sql = $sql . ")";
        try {
            $sth = $dbconn->exec($sql);

            $sqlendrow = "SELECT * FROM user_info WHERE user_id = (SELECT max(user_id) FROM user_info)";
            $sthendrow = $dbconn->prepare($sqlendrow);
            $sthendrow->execute();
            $result = $sthendrow->fetch(PDO::FETCH_ASSOC);

            if($result['user_id']>$row_end) {
                $row_end = $result['user_id'];
            }

           $sqlmeta="INSERT INTO user_meta VALUES(:user_id, true, false, true, true,'false',null)";
           $sthmeta = $dbconn->prepare($sqlmeta);
           $sthmeta->execute(array(':user_id' => $result['user_id']));
            
           

            $st_name=$result['first_name'].$result['last_name'];
            $st_id=$result['student_id'];
            $st_email=$result['email_primary'];
            $values = array($st_name, $st_id, $user_password, $_SERVER['SERVER_NAME']);
            $body = str_replace($tags, $values, $bodyContent);

        
           $sqlmail = "INSERT INTO mail_dispatcher (email_from,email_to,subject,body) VALUES (:from, :to, :subject, :body)";
           $sthmail = $dbconn->prepare($sqlmail);
           $from="all.iutians.database@gmail.com";
           $subject = "Your account has been created";
           $sthmail->execute(array(':from' => $from, ':to' => $st_email, ':subject' => $subject, ':body' => $body));

           

          $sqlpassupdate='UPDATE user_info SET password=:password WHERE student_id=:student_id';
            $sthpassupdate = $dbconn->prepare($sqlpassupdate);
            $sthpassupdate->execute(array(':password' => md5($user_password), ':student_id' => $st_id));


        } catch (Exception $e) {
            $flag = false;
            
            if ($e->getCode() != "25P02") {
                $errmessage = $errmessage . "[STD_ID: <b>".substr($sql, 471, 6)."</b>]<br />".strstr($e->getMessage(),"ERROR: ")." <br />HELP: ".getHelpForSQLException($e->getCode());
            }
        }
    }




    $count++;
}

fclose($f);

if ($flag == true) {
    $dbconn->commit();
    unset($_SESSION['htmlOutput']);
    header("location:index.php?page=be_data_entry");
    $_SESSION['msg_type'] = 's';
    $_SESSION['msg'] = 'All data have been successfully inserted';
    
    unlink($targetpath);
    
    //LOG DATA INSERT WITH START AND END
    //$row_end = getMaxIdFromTable('user_info', 'user_id');
    $sqlog = 'INSERT INTO log_table(data_user_id, row_start, row_end, date_time, batch) 
            VALUES (:data_user_id, :row_start, :row_end, :date_time, :batch)';
    $sthlog = $dbconn->prepare($sqlog);
    $sthlog->execute(array(':data_user_id' => $_SESSION['user_id'], ':row_start' => $row_start, ':row_end' => $row_end, ':date_time' => date('m-d-Y'), ':batch' =>  $_SESSION['filename']));
    
} else {
    $dbconn->rollBack();
    //unset($_SESSION['htmlOutput']);
    header("location:index.php?page=be_data_entry&step=2");
    $_SESSION['msg_type'] = 'e';
    $_SESSION['msg'] = $errmessage;
}
//
?>
