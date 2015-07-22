<?php
$host = 'localhost';
$port = '5432';
$dbname = 'aid_db';
$username = 'postgres';
$password = '123456';

$dbconn = new PDO("pgsql:dbname=$dbname;host=$host;port=$port", $username, $password );
$dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
