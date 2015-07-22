<?php
error_reporting(0);
session_start();
//print_r($_COOKIE);
include 'lib/access.php';
//Sample use: if (hasAccess('profile/edit/self')) {//do something}
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == TRUE || $_GET['page']=='help' || $_GET['page']=='aboutus'){
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Islamic University of Technology (IUT) :: Alumni Database</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="css/jquery-ui.css" />
        <link rel="stylesheet" href="css/bootstrap.css" />
        <link rel="stylesheet" href="css/bootstrap-combobox.css" />
        <link rel="stylesheet" href="css/custom.css" />
        <script type="text/javascript" src="js/jquery.min.js" ></script>
        <script type="text/javascript" src="js/jquery-ui.min.js" ></script>
        <script type="text/javascript" src="js/bootstrap.js" ></script>
        <script type="text/javascript" src="js/bootstrap-combobox.js" ></script>
        <script type="text/javascript" src="js/jquery.pstrength-min.1.2.js"></script>
        <script type="text/javascript" src="js/bootstrap-typeahead.js"></script>
        <!-- jTable Scripts -->
        <link rel="stylesheet" href="js/jtable/themes/metro/blue/jtable.min.css" />
        <script type="text/javascript" src="js/jtable/jquery.jtable.min.js"></script>
		
		<style>

		@media print
		  {
		  div.navbar {display:none;}
		  div.footer {display:none;}
		  a.btn {display:none;}
		  
		  
		  
		  }

		</style>
    </head>
	
    <body>
        <div class="container">
            <div class="row-fluid">
                <div class="span12">
                    <div class="row-fluid">
                        <?php $_SESSION['temp']=$_GET['id']; ?>
                        <?php if($_SESSION['logged_in'] == TRUE){include 'components/navbar.php';}?> 
                        <?php include 'components/notification.php'; ?>
                        <?php
                        $include = null;
                        if (isset($_GET['page'])){
                            $page = $_GET['page'];
                            if (file_exists('pages/'.$page.'.php') && $_SESSION['logged_in'] || $_GET['page']=='help' || $_GET['page']=='aboutus'){
                                $include = $page;
                            } else {
                                $include = '404';
                            }
                        } else {
                            $include = 'home';
                        }
                        include 'pages/'.$include.'.php';
                        ?>
                        <?php //include 'pages/search_results.php'; ?>
                        <?php //include 'pages/profile.php'; ?>
                    </div>
                </div>
            </div>
            <?php include 'components/footer.php'; ?>
        </div>
    </body>
    
</html>
<?php
} else if (isset($_COOKIE['AID_USER']) && $_COOKIE['AID_USER'] != ''){
    if (md5($_SERVER['REMOTE_ADDR']) == $_COOKIE['AID_AUTH']){
        header('location:process.php?do=login&auth=cookie');
    }
} else {
    header('location:login.php');
}
?>