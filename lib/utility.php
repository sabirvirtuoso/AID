<?php

//This function checks whether the entered student ID format is okay or not
//include 'lib/dbconn.inc.php';

function checkStudentIDFormat($student_id){
	$num_array = str_split($student_id);
	$flag = true;
        
        //Check if each character is numeric
	foreach($num_array as $num){
            if (!is_numeric($num)){
                    $flag = false;
                    return $flag;
            }
	}   
        
        return $flag;
}

function getHelpForSQLException($code){
    $help = "";
    switch ($code){
        case "22001":
            $help = "The value for some field has exceeded its limit. Column sizes are listed below:<br />
                     5: batch, department, blood_group<br />
                     6: student_id<br />
                     20: city, country, nationality, phone_primary, phone_alternative<br />
                     50: email_primary, email_alternative<br />
                     100: position, employer, sector";
            break;
        case "42601";
            $help = "This is caused by a single quote (&#39;), please remove the quote from the data.";
            break;
        default:
            $help = "Sorry, no help is available at the moment, please contact site administrator with error code: ".$code;
            break;
    }
    return $help;
}

function getStrongPassword()
{
    $alphanum = "1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
    $password = "";
    $password_length=6;
    
    for($i = 0; $i < $password_length; $i++) {
        $password .= $alphanum[rand(0, strlen($alphanum))];
    }
    
    return $password;
}

function getMaxIdFromTable($tableName, $columnName){

    $host = 'localhost';
    $port = '5432';
    $dbname = 'aid_db';
    $username = 'postgres';
    $password = '123456';

    $dbconn = new PDO("pgsql:dbname=$dbname;host=$host;port=$port", $username, $password );
    $dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT MAX('.$columnName.') AS row_start FROM '.$tableName;
    $sth = $dbconn->prepare($sql);
    $sth->execute();
    return $sth->fetchColumn();
}

function setLoginToken($type){
    $host = 'localhost';
    $port = '5432';
    $dbname = 'aid_db';
    $username = 'postgres';
    $password = '123456';

    $dbconn = new PDO("pgsql:dbname=$dbname;host=$host;port=$port", $username, $password );
    $dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $login_token = uniqid();
    if ($type == ''){
        $login_token = '';
    }
    
    $sql = 'UPDATE user_meta SET login_token = :login_token WHERE user_id = :user_id';
    $sth = $dbconn->prepare($sql);
    $sth->execute(array(':login_token' => $login_token, ':user_id' => $_SESSION['user_id']));
    return $login_token;
}

function clearAuthCookies(){
    setLoginToken('');
    setcookie('AID_USER', '', time() - 1);
    setcookie('AID_TOKEN', '', time() - 1);
    setcookie('AID_AUTH', '', time() - 1);
}

function getBatchAdmin($batch)
{
    $host = 'localhost';
    $port = '5432';
    $dbname = 'aid_db';
    $username = 'postgres';
    $password = '123456';

    $dbconn = new PDO("pgsql:dbname=$dbname;host=$host;port=$port", $username, $password );
    $dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try {


        $sql = 'SELECT * FROM user_info WHERE role_id=2 AND batch=:batch';
        $sth = $dbconn->prepare($sql);

        $sth->execute(array(':batch' => $batch));

        $result = $sth->fetch(PDO::FETCH_ASSOC);

        return $result['email_primary'];
    }catch(PDOException $e) {
        return $e->getMessage();
    }

    
    
}

function checkCurrentStudent($id)
{
    $host = 'localhost';
    $port = '5432';
    $dbname = 'aid_db';
    $username = 'postgres';
    $password = '123456';

    $dbconn = new PDO("pgsql:dbname=$dbname;host=$host;port=$port", $username, $password );
    $dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try {


        $sql = 'SELECT * FROM user_info WHERE student_id=:student_id';
        $sth = $dbconn->prepare($sql);

        $sth->execute(array(':student_id' => $id));

        $result = $sth->fetch(PDO::FETCH_ASSOC);

        if($result['first_name']!=null)
        {
            return false;

        }
        else
        {
            return true;
        }
    }catch(PDOException $e) {
        return $e->getMessage();
    }

}
?>
