<?php
include 'lib/dbconn.inc.php';
include 'lib/utility.php';

$user_id=$_SESSION['user_id'];
if ($user_id==''||isset ($_GET['id']))
{
    $user_id=$_GET['id'];
    $_SESSION['view_user_id']=$_GET['id'];
}

$sql = 'SELECT * FROM user_info WHERE user_id = :user_id';
$sth = $dbconn->prepare($sql);
$sth->execute(array(':user_id' => $user_id));
$result = $sth->fetch(PDO::FETCH_ASSOC);

?>
<script src="http://maps.google.com/maps/api/js?key=AIzaSyAwrQOUHRH80MM8MX_At3QCY9BTv2KFmno&sensor=false" type="text/javascript"></script>
<input id="latitude" type="hidden" value="<?php echo $result['latitude']; ?>" />
<input id="longitude" type="hidden" value="<?php echo $result['longitude']; ?>" />
<input id="user_id" type="hidden" value="<?php echo $user_id; ?>" />
<div class="row-fluid">
    <div class="span4">
        <div class="row-fluid">
            <?php
            if (strlen($result['photo']) > 0){
            ?>
            <img src="data:image/jpeg;base64,<?php echo $result['photo']; ?>" class="profile-pic img-polaroid" />
            <?php 
            } else {
            ?>
            <img src="img/user.png" class="profile-pic img-polaroid" />
            <?php
            }
            ?>
        </div>
        <!-- TODO: Get real data -->
        <div class="row-fluid profile-stats">
            <div class="row-fluid">
                <div class="span9">Last logged in: <?php echo $result['last_login']; ?></div>
            </div>
            <div class="row-fluid">
                <div class="span9">Last updated on: <?php echo $result['last_modified']; ?></div>
            </div>
            <div class="row-fluid location">
                <div class="span10">Last tagged location:</div>
            </div>
            <div class="row-fluid">
                <div class="span10" id="map_canvas" style="height: 250px"></div>
            </div>
        </div>
        <script type="text/javascript">
        var lati = document.getElementById('latitude').value;
        var longi = document.getElementById('longitude').value;
        
        if (lati != '' && longi != ''){
            var mapOptions = {
                backgroundColor: '#FFFFFF',
                mapTypeControl: false,
                center: new google.maps.LatLng(lati, longi),
                zoom: 12,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            var map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(lati, longi),
                animation: google.maps.Animation.DROP,
                icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png',
                map: map
            });
        } else {
            $('div.location').hide();
        }
        </script>
    </div>
    <div class="span8">
        <a class="btn btn-small" href="javascript:window.print()"><i class="icon-print"></i> Print</a>
          <?php if(isset($_GET['id']) && hasAccess('profile/requestUpdate')==true)  {       ?>
        <a class="btn btn-small" href="#requestUpdateModal" data-toggle="modal" role="button"><i class="icon-envelope"></i> Request Update</a>
        <?php } ?>
         <?php if(isset($_GET['id']) && hasAccess('profile/flag')==true)  {       ?>
        <a class="btn btn-small" href="#FlagModal" data-toggle="modal" role="button"><i class="icon-flag"></i> Flag</a>
          <?php } ?>
        <?php if(!isset($_GET['id']) || $_SESSION['user_id']==$_GET['id']) { ?>
        <div class="btn-group" style="float: right;" id="option">
            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="icon-wrench"></i> Options
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dropdownMenu">
                <li><a tabindex="-1" href="index.php?page=profileEditSelf"><i class="icon-edit"></i> Edit Profile</a></li>
                <!--li><a tabindex="-1" href="#"><i class="icon-camera"></i> Change Picture</a></li-->
                <!--li><a tabindex="-1" href="#"><i class="icon-globe"></i> Update from facebook</a></li-->
                <!--li><a tabindex="-1" href="#passChangeModal" data-toggle="modal" role="button"><i class="icon-lock"></i> Change Password</a></li-->
            </ul>
        </div>
        <?php } ?>
        <h2><?php echo $result['first_name'].' '.$result['last_name'] ?></h2>
        <legend>Academic Info</legend>
        <div class="row-fluid"><div class="span3">Student ID:</div><div class="span9"><?php echo $result['student_id']; ?></div></div>
        <div class="row-fluid"><div class="span3">Batch:</div><div class="span9"><?php echo $result['batch']; ?></div></div>
        <div class="row-fluid"><div class="span3">Department:</div><div class="span9"><?php echo $result['department']; ?></div></div>
        <legend>Career Info</legend>
        <div class="row-fluid"><div class="span3">Occupation/Position:</div><div class="span9"><?php echo $result['position']; ?></div></div>
        <div class="row-fluid"><div class="span3">Employer/Institution:</div><div class="span9"><?php echo $result['employer']; ?></div></div>
        <div class="row-fluid"><div class="span3">Working Sector:</div><div class="span9"><?php echo $result['sector']; ?></div></div>
        <legend>Personal Details</legend>
        <div class="row-fluid"><div class="span3">Current Location:</div><div class="span9"><?php if ($result['city'] != '') { echo $result['city'].', ';} echo $result['country']; ?></div></div>
        <div class="row-fluid"><div class="span3">Nationality:</div><div class="span9"><?php echo $result['nationality']; ?></div></div>
        <div class="row-fluid"><div class="span3">Email:</div><div class="span9"><?php echo $result['email_primary']; if ($result['email_alternative'] != '') { echo ', '.$result['email_alternative'];}  ?></div></div>
        <div class="row-fluid"><div class="span3">Phone:</div><div class="span9"><?php echo $result['phone_primary']; if ($result['phone_alternative'] != '') { echo ', '.$result['phone_alternative'];}  ?></div></div>
        <div class="row-fluid">
            <div class="span3">Mailing Address:</div>
                <div class="span9">
                    <address>
                        <?php echo $result['mailing_address']; ?>
                    </address>
                </div>
            </div>
        <div class="row-fluid"><div class="span3">Blood Group:</div><div class="span9"><?php echo $result['blood_group']; ?></div></div>
        <legend>Miscellaneous</legend>
        <div class="row-fluid"><div class="span3">IUT Room#:</div><div class="span9"><?php echo $result['iut_room_no']; ?></div></div>
        <div class="row-fluid"><div class="span3">Interests:</div><div class="span9"><?php echo $result['interest']; ?></div></div>
        <div class="row-fluid"><div class="span3">Awards:</div><div class="span9"><?php echo $result['awards']; ?></div></div>
        <!--div class="row-fluid"><div class="span3">Resume:</div><div class="span9"><a href="#">Fahad Hasan.pdf</a></div></div-->
        <!--Added this code for extra information-->
        <legend>Custom External Fields</legend>
        <div id="placeholder_external_fields" style="display: none">

        </div>   
    </div>
</div>
<!-- MODAL DEFINITIONS  FOR PASSWORD CHANGE-->
<div class="modal hide fade" id="passChangeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <!--TODO: Implement the process changePass.php -->
    <form method="POST" >
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Change Password</h3>
        </div>
        
        
        <div class="modal-body">
                <label>Old Password</label>
                <input type="password" name="old_pass" value="" id="old_password">
                <label>New Password</label>
                <input class="password" type="password" name="new_pass" value="" id="new_password">
                <label>Confirm New Password</label>
                <input type="password" name="new_pass_conf" value="" id="confirm_new_password">&nbsp;&nbsp;<span id="passConf"></span>
                <br/>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" id="change_password" disabled="disabled">Change Password</button>
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
    </form>
</div>

<!-- MODAL DEFINITIONS  FOR REQUEST UPDATE-->
<div class="modal hide fade" id="requestUpdateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <!--TODO: Implement the process changePass.php -->
    <form method="POST" action="process.php?do=requestUpdateOrFlag&action=requpdate">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Request Update</h3>
        </div>


         <div class="modal-body">
             <div class="row-fluid">
                 Are you sure you want to request an update to this profile?<br/>
                 Please note that the user will be informed via email.<br/>
                 <br/>
                 Post your comment below :
             </div>
            <div class="row-fluid">
                 <textarea style="width: 100%" rows="5" id="f_description" name="f_description" cols="40"></textarea>
             </div>
             
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" id="request_update" type="submit">Request Update</button>
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
    </form>
</div>


<!-- MODAL DEFINITIONS  FOR FLAG-->
<div class="modal hide fade" id="FlagModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <!--TODO: Implement the process changePass.php -->
    <form method="POST" action="process.php?do=requestUpdateOrFlag&action=flag">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Flag</h3>
        </div>


        <div class="modal-body">
                 <div class="row-fluid">
                 Are you sure you want to flag this profile?<br/>
                 Please note that the user will be informed via email.<br/>
                 <br/>
                 Post your comment below :
             </div>
            <div class="row-fluid">
                 <textarea style="width: 100%" rows="5" id="flag_description" name="flag_description" cols="40"></textarea>
             </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" id="flag" type="submit">Flag</button>
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
    </form>
</div>
<script type="text/javascript">
$('.password').pstrength();

function generateCustomFields(){
    $('div#placeholder_external_fields').html('');
    $.ajax({
        type: "POST",
        url: "process.php?do=getCustomFields",
        dataType: 'json',
        data: { user_id: $('input#user_id').val() },
        success: function(jsonObject){
            $('div#placeholder_external_fields').css("display", "");
            if (jsonObject.length > 0){
                $.each(jsonObject, function(i, object){
                    var html = "";
                    if (object.url != '' && object.url != null){
                        html = '<div class="custom_field" field_id="'+object.user_external_field_id+'" class="row-fluid"><div class="span3">' + object.title + ':</div><div class="span9"><a target="_blank" href="' +object.url+ '">' + object.name + '</a> <button style="display:none" onclick="removeCustomField('+object.user_external_field_id+');" class="btn btn-mini btn-danger pull-right"><i class="icon-remove icon-white"></i></button></div></div>';
                    } else {
                        html = '<div class="custom_field" field_id="'+object.user_external_field_id+'" class="row-fluid"><div class="span3">' + object.title + ':</div><div class="span9">' + object.name + ' <button style="display:none" onclick="removeCustomField('+object.user_external_field_id+');" class="btn btn-mini btn-danger pull-right"><i class="icon-remove icon-white"></i></button></div></div>';
                    }
                    $('div#placeholder_external_fields').append(html);
                });
            } else {
                $('div#placeholder_external_fields').prev().css("display", "none");
                $('div#placeholder_external_fields').css("display", "none");
            }
        }
    });
}

generateCustomFields();

$('button#change_password').click(function(){
    //$(this).hide();
    $.ajax({
        type: "POST",
        url: "process.php?do=changePass",
        dataType: 'html',
        data: {
            old_password: $('input#old_password').val(),
            new_password: $('input#new_password').val(),
            confirm_new_password: $('input#confirm_new_password').val()
        }
    });

});

$('input[name=new_pass_conf]').keyup(function(){
        new_pass_var=$("input[name=new_pass]").val();
        new_pass_conf_var=$("input[name=new_pass_conf]").val();

        if(new_pass_var != new_pass_conf_var)  {
            $('span#passConf').html('<font color="red">Password not matched</font>');
        }
        else{
            $('span#passConf').html('<font color="green">Passwored Matched</font>');
        }
        
});
</script>