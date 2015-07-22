<?php
$searchString = $_POST['searchString'];
$limit = $_POST['limit'];
$offset = $_POST['offset'];
$count = $_POST['count'];

$conditionArray = explode("&", $searchString);
$whereClause = "";
$first = TRUE;
$whereClauseValue = array();

foreach ($conditionArray as $key => $condition) {
    $conditionExploded = explode("=", $condition);
    if ($first){
        $first = false;
        $whereClause = 'lower('.$conditionExploded[0].') = lower(:'.$conditionExploded[0].')';
        if ($conditionExploded[0] == 'first_name'){
            $whereClause = $whereClause . 'OR lower(last_name) = lower(:first_name)';
        }
    } else {
        $whereClause = $whereClause.' AND lower('.$conditionExploded[0].') = lower(:'.$conditionExploded[0].')';
        if ($conditionExploded[0] == 'first_name'){
            $whereClause = $whereClause . 'OR lower(last_name) = lower(:first_name)';
        }
    }
    $conditionKeyPairValue = array(':'.$conditionExploded[0] => $conditionExploded[1]);
    $whereClauseValue = array_merge($whereClauseValue, $conditionKeyPairValue);
}

//print_r($whereClauseValue);
//echo $whereClause;

$sql = 'SELECT user_id, batch, first_name, last_name, student_id, department,email_primary,photo FROM user_info';
if ($whereClause != ""){
    $sql = $sql.' WHERE '.$whereClause."AND NOT student_id='".$_SESSION['student_id']."'" ;
}

if ($limit != '' && $offset != ''){
    $sql = $sql." LIMIT ".$limit." OFFSET ".$offset;
}

try {

    $sth = $dbconn->prepare($sql);
    $sth->execute($whereClauseValue);
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);

    if ($count == 'true'){
        echo $sth->rowCount();
    } else {
        echo json_encode($result);

    }

} catch(PDOException $e){
    echo "FAILED:".$e->getMessage();
}

/*
$imageData = base64_decode($result['photo']);

$ifp = fopen("tmp/user.jpg", "wb");
fwrite( $ifp, base64_decode( $imageData) );
fclose( $ifp );

$newWidth = 32;
$image = null;


$image=imagecreatefromjpeg('tmp/tmp.jpg');

$origWidth = imagesx($image);
$origHeight = imagesy($image);
$newHeight = ($newWidth/$origWidth)*$origHeight;
$resImage = imagecreatetruecolor(32, $newHeight);
$white = imagecolorallocate($resImage, 255, 255, 255);
imagefill($resImage, 0, 0, $white);

imagecopyresized($resImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
imagejpeg($resImage, 'tmp/tmp.jpg', 100);
imagedestroy($resImage);
imagedestroy($image);
$imagedata = base64_encode(file_get_contents('tmp/tmp.jpg'));
unlink('tmp/tmp.jpg');
$result['photo']=$imagedata;
*/

?>
