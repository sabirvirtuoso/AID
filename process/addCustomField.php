<?php
$user_id = $_SESSION['user_id'];
$title = $_POST['title'];
$description = $_POST['description'];
$name = $_POST['name'];
$url = $_POST['url'];

try {
    $sql = 'INSERT INTO user_external_fields(user_id, title, description, name, url) VALUES (:user_id, :title, :description, :name, :url)';
    $sth = $dbconn->prepare($sql);
    $sth->execute(array(':user_id' => $user_id, ':title' => $title, ':description' => $description, ':name' => $name, ':url' => $url ));
    echo 'SUCCESS';
    } catch (PDOException $e){
    echo $e->getMessage();
}

?>