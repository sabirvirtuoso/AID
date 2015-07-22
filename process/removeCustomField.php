<?php
$user_id = $_POST['user_id'];

/*if ($user_id == ''){
    $user_id = $_SESSION['user_id'];
}*/

try {
    $sql = 'DELETE FROM user_external_fields WHERE user_external_field_id = :user_id';
    $sth = $dbconn->prepare($sql);
    $sth->execute(array(':user_id' => $user_id));
    //$result = $sth->fetchAll(PDO::FETCH_ASSOC);
    echo 'SUCCESS';
} catch (PDOException $e){
    echo $e->getMessage();
}

?>
