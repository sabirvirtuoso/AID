<?php
//Check for cookie
if (isset($_GET['auth']) && $_GET['auth'] == 'cookie'){
   
    $aid_user = $_COOKIE['AID_USER'];
    $aid_token = $_COOKIE['AID_TOKEN'];
    
    $sql = 'SELECT login_token FROM user_meta WHERE user_id = :aid_user';
    $sth = $dbconn->prepare($sql);
    $sth->execute(array(':aid_user' => $aid_user));
    $db_token = $sth->fetchColumn();
    
    if ($aid_token == $db_token){
        $sql = 'SELECT first_name, last_name, user_id, student_id, batch, role_id, password, last_login FROM user_info WHERE user_id = :user_id';
        $sth = $dbconn->prepare($sql);
        $sth->execute(array(':user_id' => $aid_user));
        $result = $sth->fetch(PDO::FETCH_ASSOC);
    
        $_SESSION['logged_in'] = TRUE;
        $_SESSION['student_id'] = $result['student_id'];
        $_SESSION['user_id'] = $result['user_id'];
        $_SESSION['batch'] = $result['batch'];
        $_SESSION['role'] = $result['role_id'];
        $_SESSION['name']=$result['first_name'].' '.$result['last_name'];
        $_SESSION['email'] = $result['email_primary'];
        $_SESSION['department']=$result['department'];
        $_SESSION['blood_group']=$result['blood_group'];
        
        try {
            $sqllastlogin = 'UPDATE user_info SET last_login=:last_login WHERE user_id = :user_id';
            $sthlastlogin = $dbconn->prepare( $sqllastlogin);
            $sthlastlogin->execute(array(':user_id' => $_SESSION['user_id'],':last_login' => date('m-d-Y')));
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
        
        //to check the meta values in user_meta
        $sqlmeta = "SELECT * FROM user_meta WHERE user_id = :user_id";
        $sthmeta = $dbconn->prepare($sqlmeta);
        $sthmeta->execute(array(':user_id' =>  $_SESSION['user_id']));
        $usermeta = $sthmeta->fetch(PDO::FETCH_ASSOC);

        $sqlmeta2 = "UPDATE user_meta SET force_welcome=false,force_flash=null,force_pro_update=false,force_tour=false WHERE user_id = :user_id";
        $sthmeta2 = $dbconn->prepare($sqlmeta2);
        $sthmeta2->execute(array(':user_id' =>  $_SESSION['user_id']));

        /*Meta actions*/
        $_SESSION['info'] = array();
        if ($usermeta['force_welcome'] == 1){
            array_push($_SESSION['info'], 'Welcome to AID, Please go through the <a href="index.php?page=help">Help section</a>.');
        }

        if (strlen($usermeta['force_flash']) > 0){
            array_push($_SESSION['info'], '<b>NOTICE:</b> '.$usermeta['force_flash']);
        }

        if ($usermeta['force_pro_update'] == 1){
            array_push($_SESSION['info'], 'Please consider updating your profile. <a href="index.php?page=profileEditSelf">Click here</a> to Edit your profile.');
        }

        if ($usermeta['force_pass_change'] == 1){
            array_push($_SESSION['info'], 'Please consider changing your password. <a href="index.php?page=profileEditSelf">Click here</a> to Edit your profile.');
        }
        
        //Update cookies
        $ipMd5 = md5($_SERVER['REMOTE_ADDR']);
        $token = setLoginToken('NEW');
        setcookie('AID_USER', $result['user_id'], time() + 2592000);
        setcookie('AID_TOKEN', $token, time() + 2592000);
        setcookie('AID_AUTH', $ipMd5, time() + 2592000);

        $_SESSION['msg_type'] = 's';
        $_SESSION['msg'] = 'Welcome '.$result['first_name'].' '.$result['last_name'].'. You have logged in!';
        header('location:index.php?page=home');
        exit();
    } else {
        clearAuthCookies();
        $_SESSION['msg_type'] = 'e';
        $_SESSION['msg'] = 'Could not authenticate automatically, cookies have been reset!';
        header('location:login.php');
        exit();
    }
}


//If no cookie, proceed to normal login
$student_id = $_SESSION['student_id'] = $_POST['student_id'];
$pass = $_POST['pass'];

if ($student_id == ''){
    $_SESSION['msg_type'] = 'e';
    $_SESSION['msg'] = 'Please enter Student ID';
    header('location:login.php');
    exit();
}



if ($pass == ''){
    $_SESSION['msg_type'] = 'e';
    $_SESSION['msg'] = 'Please enter Password';
    header('location:login.php');
    exit();
}

$sql = 'SELECT first_name, last_name, user_id, student_id, batch, role_id, password, last_login, email_primary FROM user_info WHERE student_id = :student_id';
$sth = $dbconn->prepare($sql);
$sth->execute(array(':student_id' => $student_id));
$result = $sth->fetch(PDO::FETCH_ASSOC);
$dbPass = $result['password'];

if (md5($pass) == $dbPass){   
    $_SESSION['logged_in'] = TRUE;
    $_SESSION['student_id'] = $result['student_id'];
    $_SESSION['user_id'] = $result['user_id'];
    $_SESSION['batch'] = $result['batch'];
    $_SESSION['role'] = $result['role_id'];
    $_SESSION['name']=$result['first_name'].$result['last_name'];
    $_SESSION['email'] = $result['email_primary'];
    try {
        $sqllastlogin = 'UPDATE user_info SET last_login=:last_login WHERE user_id = :user_id';
        $sthlastlogin = $dbconn->prepare( $sqllastlogin);
        $sthlastlogin->execute(array(':user_id' => $_SESSION['user_id'],':last_login' => date('m-d-Y')));
    } catch(PDOException $e) {
        echo $e->getMessage();
    }

    //Cookie
    if ($_POST['remember'] == 'true'){
        $ipMd5 = md5($_SERVER['REMOTE_ADDR']);
        $token = setLoginToken('NEW');
        setcookie('AID_USER', $result['user_id'], time() + 2592000);
        setcookie('AID_TOKEN', $token, time() + 2592000);
        setcookie('AID_AUTH', $ipMd5, time() + 2592000);
    } else {
        clearAuthCookies();
    }
    

    //to check the meta values in user_meta
    $sqlmeta = "SELECT * FROM user_meta WHERE user_id = :user_id";
    $sthmeta = $dbconn->prepare($sqlmeta);
    $sthmeta->execute(array(':user_id' =>  $_SESSION['user_id']));
    $usermeta = $sthmeta->fetch(PDO::FETCH_ASSOC);

    $sqlmeta2 = "UPDATE user_meta SET force_welcome=false,force_flash=null,force_pro_update=false,force_tour=false WHERE user_id = :user_id";
    $sthmeta2 = $dbconn->prepare($sqlmeta2);
    $sthmeta2->execute(array(':user_id' =>  $_SESSION['user_id']));
    
    /*Meta actions*/
    $_SESSION['info'] = array();
    if ($usermeta['force_welcome'] == 1){
        array_push($_SESSION['info'], 'Welcome to AID, Please go through the <a href="index.php?page=help">Help section</a>.');
    }
    
    if (strlen($usermeta['force_flash']) > 0){
        array_push($_SESSION['info'], '<b>NOTICE:</b> '.$usermeta['force_flash']);
    }
    
    if ($usermeta['force_pro_update'] == 1){
        array_push($_SESSION['info'], 'Please consider updating your profile. <a href="index.php?page=profileEditSelf">Click here</a> to Edit your profile.');
    }
    
    if ($usermeta['force_pass_change'] == 1){
        array_push($_SESSION['info'], 'Please consider changing your password. <a href="index.php?page=profileEditSelf">Click here</a> to Edit your profile.');
    }

    $_SESSION['msg_type'] = 's';
    $_SESSION['msg'] = 'Welcome '.$result['first_name'].' '.$result['last_name'].'. You have logged in!';
    header('location:index.php?page=home');
    exit();
    
} else {
    $_SESSION['msg_type'] = 'e';
    $_SESSION['msg'] = 'Invalid credentials, please try again!';
    header('location:login.php');
    exit();
}



?>


