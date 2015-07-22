<?php
session_start();
//error_reporting(0);
define('REDIRECT_PAGE', 'login.php');

if ($_SESSION['logged_in'] == TRUE || $_GET['do'] == 'login' || $_GET['do'] == 'forgotPassword' || $_GET['do'] == 'alumniSearch' || $_GET['do'] == 'signUp'){
    if (isset($_GET['do'])){
        $do = $_GET['do'];
 
            if(file_exists('process/'.$do.'.php')) {
                    $include = 'process/'.$do.'.php';
                    include 'lib/dbconn.inc.php';
                    include 'lib/utility.php';
					include 'lib/access.php';
                    include $include;
            }
    } /*else {
       header('location:'.REDIRECT_PAGE);
    }*/
} /*else {
    header('location:'.REDIRECT_PAGE);
}*/
?>
