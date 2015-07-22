<?php
$newWidth = 200;
$image = null;
echo $_FILES['file']['tmp_name'];
switch ($_FILES['file']['type']){
    case 'image/jpeg':
        $image = imagecreatefromjpeg($_FILES['file']['tmp_name']);
        break;
    case 'image/png':
        $image = imagecreatefrompng($_FILES['file']['tmp_name']);
        break;
    case 'image/jpeg':
        $image = imagecreatefromgif($_FILES['file']['tmp_name']);
        break;
    default:
        break;
}

echo $image;
exit(0);

$origWidth = imagesx($image);
$origHeight = imagesy($image);
$newHeight = ($newWidth/$origWidth)*$origHeight;
$resImage = imagecreatetruecolor(180, $newHeight);
imagecopyresized($resImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
imagejpeg($resImage, 'tmp/tmp.jpg', 100);
imagedestroy($resImage);
imagedestroy($image);
$imagedata = base64_encode(file_get_contents('tmp/tmp.jpg'));
unlink('tmp/tmp.jpg');
//echo '<img src="data:image/jpeg;base64,'.$imagedata.'" />';

try{
    $stmt = $dbconn->prepare("UPDATE user_info SET photo = :photo WHERE user_id = :user_id");
    $stmt->execute(array(':photo' => $imagedata, ':user_id' => $_SESSION['user_id']));
    $_SESSION['msg_type'] = 's';
    $_SESSION['msg'] = 'Picture has been updated successfully!';
    header('location:index.php?page=profileEditSelf');
    exit(0);
}
catch(PDOException $e)
{
    $_SESSION['msg_type'] = 'e';
    $_SESSION['msg'] = $e->getMessage();
    header('location:index.php?page=profileEditSelf');
    exit(0);
}
?>
