<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$q=$_POST['q'];
$type=$_GET['type'];

if($type=="name")
{
    $sqlendrow = "SELECT first_name AS results FROM user_info WHERE lower(first_name) LIKE  lower('%".$q."%') UNION SELECT last_name AS results FROM user_info WHERE lower(last_name) LIKE  lower('%".$q."%')";
}
else if($type=="city")
{
    $sqlendrow = "SELECT city AS results FROM user_info WHERE lower(city) LIKE  lower('%".$q."%')";
}

else if($type=="country")
{
    $sqlendrow = "SELECT country AS results FROM user_info WHERE lower(country) LIKE  lower('%".$q."%')";
}

else if($type=="position")
{
    $sqlendrow = "SELECT position AS results FROM user_info WHERE lower(position) LIKE  lower('%".$q."%')";
}

else if($type=="employer")
{
    $sqlendrow = "SELECT employer AS results FROM user_info WHERE lower(employer) LIKE  lower('%".$q."%')";
}

else if($type=="sector")
{
    $sqlendrow = "SELECT sector AS results FROM user_info WHERE lower(sector) LIKE  lower('%".$q."%')";
}


$sthendrow = $dbconn->prepare($sqlendrow);
$sthendrow->execute();
$result = $sthendrow->fetchAll(PDO::FETCH_ASSOC);


echo json_encode($result);



?>

