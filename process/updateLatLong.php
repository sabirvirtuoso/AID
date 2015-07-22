<?php
$lat = $_POST['lat'];
$long = $_POST['long'];

$sql = "UPDATE user_info SET latitude = :latitude, longitude = :longitude WHERE user_id = :user_id";
$sth = $dbconn->prepare($sql);
$sth->execute(array(':latitude' => $lat, ':longitude' => $long, ':user_id' =>  $_SESSION['user_id']));
$_SESSION['latlong'] = 'true';
echo 'SUCCESS';
?>
