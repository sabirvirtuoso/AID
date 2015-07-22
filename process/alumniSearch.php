<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/
$name=$_POST['name'];

$limit=$_POST['limit'];

$sqlendrow = "SELECT first_name,student_id,city,country FROM user_info WHERE lower(first_name) LIKE  lower('%".$name."%') LIMIT ".$limit;
$sthendrow = $dbconn->prepare($sqlendrow);
$sthendrow->execute();
$result = $sthendrow->fetchAll(PDO::FETCH_ASSOC);


echo json_encode($result);


?>
