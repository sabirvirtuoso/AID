<?php
if (isset($_SESSION['htmlOutput']) && isset($_GET['step']) && $_GET['step'] == '2'){
    //unset($_GET['step']);
    $htmlOutput = $_SESSION['htmlOutput'];
    //unset($_SESSION['htmlOutput']);
?>
<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid" style="height: 450px; width: 940px; overflow: auto;">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>STUDENT_ID</th>
                        <th>BATCH</th>
                        <th>DEPARTMENT</th>
                        <th>FIRST_NAME</th>
                        <th>LAST_NAME</th>
                        <th>POSITION</th>
                        <th>EMPLOYER</th>
                        <th>SECTOR</th>
                        <th>NATIONALITY</th>
                        <th>EMAIL_PRIMARY</th>
                        <th>EMAIL_ALTERNATIVE</th>
                        <th>PHONE_PRIMARY</th>
                        <th>PHONE_SECONDARY</th>
                        <th>CITY</th>
                        <th>COUNTRY</th>
                        <th>MAILING_ADDRESS</th>
                        <th>BLOOD_GROUP</th>
                        <th>IUT_ROOM_NO</th>
                        <th>INTERESTS</th>
                        <th>AWARDS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $htmlOutput; ?>
                </tbody>
            </table>
            
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <form method="POST" action="process.php?do=insert_be_data">
            <input type="submit" value="Insert into Database" class="btn btn-primary pull-right" />
        </form>
    </div>
</div>
<?php
} else {
?>
<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="process.php?do=be_data_entry">
                <legend>Data Entry Back-end</legend>
                <div class="control-group">
                    <label class="control-label" for="inputEmail">Select file to upload</label>
                    <div class="controls">
                        <input name="filechooser" type="file" placeholder="Select file" value="">
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                    <button type="submit" class="btn">Next</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
}
?>
