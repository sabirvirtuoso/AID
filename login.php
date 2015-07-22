<?php
session_start();
include 'lib/dbconn.inc.php';

$sql = "(SELECT sector, COUNT(sector) as count FROM user_info WHERE sector <> '' GROUP BY sector ORDER BY count(sector) DESC LIMIT 5) UNION (SELECT 'Other' as sector, SUM(count) as count FROM (SELECT sector, count(sector) as count FROM user_info GROUP BY sector ORDER BY count(sector) DESC OFFSET 5) AS SUM_TABLE)";
$sth = $dbconn->prepare($sql);
$sth->execute();
$result = $sth->fetchAll(PDO::FETCH_ASSOC);
//print_r($_COOKIE);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Islamic University of Technology (IUT) :: Alumni Database</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="css/bootstrap.css" />
        <link rel="stylesheet" href="css/custom.css" />
        <script type="text/javascript" src="js/jquery.min.js" ></script>
        <script type="text/javascript" src="js/bootstrap.js" ></script>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript">
            google.load("visualization", "1", {packages:["corechart"]});
            google.setOnLoadCallback(drawChart);
            function drawChart() {
                var json = JSON.parse(document.getElementById('chart_json').value);
                var array = [['Sector', 'Count']];

                for (var i = 0; i < json.length; i++){
                    array[i+1] = [json[i].sector, parseInt(json[i].count)];
                }
                console.log(array);
                var data = google.visualization.arrayToDataTable(array);

                var options = {
                    title: 'IUTians in different sectors'
                };

                var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
                chart.draw(data, options);
            }
        </script>
        <style>
            @media print
            {
                .navbar {display: none;}
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row-fluid" style="margin-bottom: 70px;">
                <div class="span12">
                    <div class="row-fluid">
                        <div class="span6 left-panel">
                            <!--TODO: Implement Alumni Simple search-->
                            <!--span class="overlay-search">
                                <form>
                                    <input type="text" placeholder="Alumni search">
                                    <button type="submit" class="btn">
                                        <i class="icon-search"></i>
                                    </button>
                                </form>
                            </span-->
                            <div class="row-fluid gallery">
                                <img src="img/banner.jpg" />
                                <!--div id="myCarousel" class="carousel slide">
                                    <div class="carousel-inner">
                                        <div class="active item">
                                            <img src="banner-img/iut_01.JPG" />
                                        </div>
                                        <div class="item">
                                            <img src="banner-img/iut_01.JPG" />
                                        </div>
                                        <div class="item">
                                            <img src="banner-img/iut_01.JPG" />
                                        </div>
                                    </div>
                                    <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
                                    <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
                                </div-->
                            </div>
                            <div class="row-fluid flash-news">
                                <span class="article-text span12">
                                    <h3>Welcome to IUTAA Database</h3>
                                    This is the database of all IUTians home and abroad.<br />
                                    <!--Please sign-up now and/or--> Please login to start searching.<br /><br />
                                    <!--<a class="btn" href="#signUpModal" data-toggle="modal" role="button" >Sign-up</a>
                                    <!--TODO: Facebook connect-->
                                    <!--button style="float: right;" class="social-fb">connect using facebook</button-->
                                </span>

                            </div>
                        </div>
                        <div class="span6 right-panel">
                            <div class="row-fluid">
                                <form action="process.php?do=login" method="POST">
                                    <legend>Sign in</legend>
                                    <?php include 'components/notification.php'; ?>
                                    <input name="student_id" type="text" placeholder="Student ID" value="<?php echo $_SESSION['student_id']; ?>">
                                    <input name="pass" type="password" placeholder="Password">
                                    <label class="checkbox">
                                        <input name="remember" value="true" type="checkbox"> Remember me
                                    </label>
                                    <br />
                                    <a href="index.php?page=home"><input type="submit" class="btn primary" value="Sign-in" id="signin"/></a>
                                    <a href="#forgotPasswordModal" class="btn btn-link" data-toggle="modal">Forgot password?</a>
                                </form>
                            </div>
                            <div class="row-fluid">
                                <textarea id="chart_json" style="display:none"><?php echo json_encode($result); ?></textarea>
                                <div id="chart_div" class="span12" style="height: 200px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'components/footer.php'; ?>
        </div>
        <!-- MODAL DEFINITIONS -->
        <div class="modal hide fade" id="signUpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
             <form method="POST" action="process.php?do=signUp">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Sign-up</h3>
                </div>
                <div class="modal-body">
                        <label>Student ID</label>
                        <input type="text" id="student_id" name="student_id" value="">
                        <label>Email</label>
                        <input type="text" id="email" name="email" value="">
                        <label>Phone</label>
                        <input type="text" id="phone" name="phone" value="">
                        <label class="checkbox">
                            <input name="cur_student" value="TRUE" type="checkbox">Current Student
                        </label>
                        <br/>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Sign-up</button>
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                </div>
            </form>
        </div>

        <div class="modal hide fade" id="forgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <!--TODO: Implement the process changePass.php -->
    <form method="POST" action="process.php?do=forgotPassword">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Forgot Password</h3>
        </div>


        <div class="modal-body">
                <label>E-mail</label>
                <input type="text" name="email" value="" id="email" >
                <label>Student ID</label>
                <input  type="text" name="student_id" value="" id="student_id">
                <br/>
        </div>
        <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Request Password</button>
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                </div>
    </form>
</div>
    </body>

</html>


