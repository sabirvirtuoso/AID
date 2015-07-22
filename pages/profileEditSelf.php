<?php
include 'lib/dbconn.inc.php';
include 'lib/utility.php';

$sql = 'SELECT * FROM user_info WHERE user_id = :user_id';
$sth = $dbconn->prepare($sql);
$sth->execute(array(':user_id' => $_SESSION['user_id']));
$result = $sth->fetch(PDO::FETCH_ASSOC);
?>
<div class="row-fluid">
    <div class="span4">
        <!--span class="overlay-search" style="margin-top: 150px;">
            <form>
                <form style="position">
                <input style="height: 25px;" size="7" style="" type="file">
            </form>
        </span-->
        <input id="new_batch" type="hidden" value="<?php echo $result['batch']; ?>" />
        <input id="new_department" type="hidden" value="<?php echo $result['department']; ?>" />
         <input id="new_blood_group" type="hidden" value="<?php echo $result['blood_group']; ?>" />
        <?php if ($result['photo'] == null) {?>
        <div class="row-fluid">
            <img src="img/user.png" class="profile-pic img-polaroid" />
        </div>
        <?php } else { ?>
        <div class="row-fluid">
            <img src="data:image/jpeg;base64,<?php echo $result['photo']; ?>" class="profile-pic img-polaroid" />
        </div>
        <?php } ?>
        <div class="row-fluid">
            <!-- TODO: File upload to database -->
            
                <form method="POST" action="process.php?do=changePic" enctype="multipart/form-data" style="padding: 5px 0 0 0;">
                <label class="fileInputButton">
                    <input id="demoButton" type="button" class="btn" value="Change">
                    <!--span>Change</span-->
                    <input class="fileInput" id="file" type="file"  name="file" >
                </label>
                <input id="picUpdatetext" type="text" style="display:none;" value="">
                <input id="picUpdatebutton" style="display:none;" class="btn" type="submit" value="Update"/>
                <input id="picUpdatecancel" style="display:none;" type="button" class="btn" value="Cancel">
            </form>
        </div>
        <!-- TODO: Get real data -->
       <div class="row-fluid profile-stats">
            <div class="row-fluid">
                <div class="span9">User last logged in: <?php echo $result['last_login']; ?></div>
            </div>
            <div class="row-fluid">
                <div class="span9">Last updated on: <?php echo $result['last_modified']; ?></div>
            </div>
        </div>
    </div>
    <div class="span8">
        <!--a class="btn btn-small" href="#"><i class="icon-print"></i> Print</a>
        <a class="btn btn-small" href="#requestUpdateModal" data-toggle="modal" role="button"><i class="icon-envelope"></i> Request Update</a>
        <a class="btn btn-small" href="#FlagModal" data-toggle="modal" role="button"><i class="icon-flag"></i> Flag</a-->
        <div class="btn-group" style="float: right;">
            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="icon-wrench"></i> Options
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dropdownMenu">
                <!--li><a tabindex="-1" href="#"><i class="icon-camera"></i> Change Picture</a></li-->
                <li class="disabled"><a tabindex="-1" href="#"><i class="icon-globe"></i> Update from facebook</a></li>
                <li><a tabindex="-1" href="#passChangeModal" data-toggle="modal" role="button"><i class="icon-lock"></i> Change Password</a></li>
            </ul>
        </div>
        <br />
        <br />
       <div class="row-fluid"><div class="span3">First Name:</div><div class="span9"><input name="edit_fname" type="text" value="<?php echo $result['first_name']; ?>" /></div></div>
        <div class="row-fluid"><div class="span3">Last Name:</div><div class="span9"><input name="edit_lname" type="text" value="<?php echo $result['last_name']; ?>" /></div></div>
        <legend>Academic Info</legend>
        <div class="row-fluid"><div class="span3">Student ID:</div><div class="span9"><input name="edit_stid" type="text" readonly value="<?php echo $result['student_id']; ?>"/></div></div>
        <!--<div class="row-fluid"><div class="span3">Batch:</div><div class="span9"><input name="edit_batch" type="text" value="<?php //echo $result['batch']; ?>"/></div></div>-->
       <div class="row-fluid"><div class="span3">Batch:</div><div class="span9">
       <select class="bootstrap-combo1" id="batch" name="edit_batch">
                            <option value="">Any</option>
                            <option value="1998">1998</option>
                            <option value="1999">1999</option>
                            <option value="2000">2000</option>
                            <option value="2001">2001</option>
                            <option value="2002">2002</option>
                            <option value="2003">2003</option>
                            <option value="2004">2004</option>
                            <option value="2005">2005</option>
                            <option value="2006">2006</option>
                            <option value="2007">2007</option>
                            <option value="2008">2008</option>
                            <option value="2009">2009</option>


        </select>
              </div>
        </div>

        <!--<div class="row-fluid"><div class="span3">Department:</div><div class="span9"><input name="edit_dept" type="text" value="<?php //echo $result['department']; ?>"/></div></div>-->
        <div class="row-fluid"><div class="span3">Department:</div><div class="span9">

                <select class="bootstrap-combo2" id="department" name="edit_dept">
                            <option value="">Any</option>
                            <option value="CEE">CEE</option>
                            <option value="CSE">CSE</option>
                            <option value="EEE">EEE</option>
                            <option value="MCE">MCE</option>
        </select>
              </div>
        </div>
        <legend>Career Info</legend>
        <div class="row-fluid"><div class="span3">Occupation/Position:</div><div class="span9"><input id="position" name="edit_pos" type="text" value="<?php echo $result['position']; ?>"/></div></div>
        <div class="row-fluid"><div class="span3">Employer/Institution:</div><div class="span9"><input id="employer" name="edit_emp" type="text" value="<?php echo $result['employer']; ?>"/></div></div>
        <div class="row-fluid"><div class="span3">Working Sector:</div><div class="span9"><input id="sector" name="edit_sec" type="text" value="<?php echo $result['sector']; ?>"/></div></div>
        <legend>Personal Details</legend>
        <div class="row-fluid"><div class="span3">City:</div><div class="span9"><input name="edit_city" type="text" value="<?php echo $result['city'];  ?>"/></div></div>
        <div class="row-fluid"><div class="span3">Country:</div><div class="span9"><input name="edit_country" type="text" value="<?php echo $result['country'];  ?>"/></div></div>
        <div class="row-fluid"><div class="span3">Nationality:</div><div class="span9"><input name="edit_nat" type="text" value="<?php echo $result['nationality']; ?>"/></div></div>
        <div class="row-fluid"><div class="span3">Primary Email:</div><div class="span9"><input name="edit_email_primary" type="text" value="<?php echo $result['email_primary'];  ?>"/></div></div>
        <div class="row-fluid"><div class="span3">Alternative Email:</div><div class="span9"><input name="edit_email_alternative" type="text" value="<?php echo $result['email_alternative'];  ?>"/></div></div>
        <div class="row-fluid"><div class="span3">Primary Phone No:</div><div class="span9"><input name="edit_phone_primary" type="text" value="<?php echo $result['phone_primary'];  ?>"/></div></div>
        <div class="row-fluid"><div class="span3">Alternative Phone No:</div><div class="span9"><input name="edit_phone_alternative" type="text" value="<?php echo $result['phone_alternative'];  ?>"/></div></div>
        <div class="row-fluid">
            <div class="span3">Mailing Address:</div>
                <div class="span9">
                    <address>
                        <input name="edit_addr" type="text" value="<?php echo $result['mailing_address']; ?>"/>
                    </address>
                </div>
            </div>
        <!--<div class="row-fluid"><div class="span3">Blood Group:</div><div class="span9"><input name="edit_bldgrp" type="text" value="<?php //echo $result['blood_group']; ?>"/></div></div>-->
        <div class="row-fluid"><div class="span3">Blood Group:</div><div class="span9">
        <select class="bootstrap-combo3" id="blood_group" name="edit_bldgrp">
                            <option value="">Any</option>
                            <option value="A+">A+</option>
                            <option value="AB+">AB+</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                        </select>
          </div></div>

        <legend>Miscellaneous</legend>
        <div class="row-fluid"><div class="span3">IUT Room#:</div><div class="span9"><input name="edit_iut_rm_no" type="text" value="<?php echo $result['iut_room_no']; ?>"/></div></div>
        <div class="row-fluid"><div class="span3">Interests:</div><div class="span9"><input name="edit_int" type="text" value="<?php echo $result['interest']; ?>"/></div></div>
        <div class="row-fluid"><div class="span3">Awards:</div><div class="span9"><input name="edit_awards" type="text" value="<?php echo $result['awards']; ?>"/></div></div>
        <button class="btn btn-small" id="updatebutton">Update</button>
         <legend>Custom External Fields</legend>
        <div id="placeholder_external_fields" style="display: none">
            
        </div>
        <a id="toggleCustomFieldForm" class="btn btn-small" href="#"><i class="icon-plus"></i> Add</a>
        <br/>
        <br/>
        <div id="placeholder_external_fields_form" style="display: none">
            <div class="row-fluid"><div class="span3">Field Title:</div><div class="span9"><input name="f_title" type="text" /></div></div>
            <div class="row-fluid"><div class="span3">Field Description (Optional):</div><div class="span9"><textarea name="f_description"></textarea></div></div>
            <div class="row-fluid"><div class="span3">Field Value:</div><div class="span9"><input name="f_value" type="text" /></div></div>
            <div class="row-fluid"><div class="span3">URL (Optional):</div><div class="span9"><input name="f_url" type="text" /></div></div>
            <div class="row-fluid"><div class="span3"></div><div class="span9"><a id="saveCustomField" class="btn btn-small" href="#">Save</a></div></div>
        </div>
        <br/>
        <!--div class="row-fluid"><div class="span3">Resume:</div><div class="span9"><a href="#">Fahad Hasan.pdf</a></div></div-->
    </div>
</div>

<!-- MODAL DEFINITIONS  FOR PASSWORD CHANGE-->
<div class="modal hide fade" id="passChangeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <!--TODO: Implement the process changePass.php -->
    <form method="POST" action="process.php?do=changePass" >
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Change Password</h3>
        </div>


        <div class="modal-body">
                <label>Old Password</label>
                <input type="password" name="old_pass" value="" id="old_password">
                <label>New Password</label>
                <input type="password" name="new_pass" value="" id="new_password">
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





<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">

 $('.bootstrap-combo1').combobox();
 $('.bootstrap-combo2').combobox();
  $('.bootstrap-combo3').combobox();


  $('select#department').val($('input#new_department').val());
  $('select#batch').val($('input#new_batch').val());
  $('select#blood_group').val($('input#new_blood_group').val());

$('#new_password').pstrength();

$('button#updatebutton').click(function(e){
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "process.php?do=updateUserInfo",
        dataType: 'html',
        data: { first_name: $('input[name=edit_fname]').val(), last_name: $('input[name=edit_lname]').val(), student_id: $('input[name=edit_stid]').val(), batch: $('select[name=edit_batch]').val(), department: $('select[name=edit_dept]').val(), position: $('input[name=edit_pos]').val(), employer: $('input[name=edit_emp]').val(), sector: $('input[name=edit_sec]').val(), city: $('input[name=edit_city]').val(), country: $('input[name=edit_country]').val(), nationality: $('input[name=edit_nat]').val(), email_primary: $('input[name=edit_email_primary]').val(), email_alternative: $('input[name=edit_email_alternative]').val(), phone_primary: $('input[name=edit_phone_primary]').val(),  phone_alternative: $('input[name=edit_phone_alternative]').val(), mailing_address: $('input[name=edit_addr]').val(), blood_group: $('select[name=edit_bldgrp]').val(), iut_room_no: $('input[name=edit_iut_rm_no]').val(), interest: $('input[name=edit_int]').val(), awards: $('input[name=edit_awards]').val()},
        success: function(returnHtml){
            console.log(returnHtml);

            if (returnHtml == 'SUCCESS'){

				
				window.location="index.php?page=profile";

            }
            else
            {
                window.location="index.php?page=profileEditSelf";
            }
        }
    });
});

$('a#toggleCustomFieldForm').click(function(e){
    e.preventDefault();

    $('div#placeholder_external_fields_form').toggle(function(){
        if ($('a#toggleCustomFieldForm').text() == ' Add'){
            $('a#toggleCustomFieldForm').html('<i class="icon-minus"></i> Close');
        } else {
            $('a#toggleCustomFieldForm').html('<i class="icon-plus"></i> Add');
        }
    });
});

$('a#saveCustomField').click(function(e){
    e.preventDefault();

    if($('input[name=f_title]').val()!=""&&$('input[name=f_value]').val()!="")
    {
        $.ajax({
            type: "POST",
            url: "process.php?do=addCustomField",
            dataType: 'html',
            data: { title: $('input[name=f_title]').val(), description: $('textarea[name=f_description]').val(), name: $('input[name=f_value]').val(), url: $('input[name=f_url]').val()},
            success: function(returnHtml){
                console.log(returnHtml);
                if (returnHtml == 'SUCCESS'){
                    generateCustomFields();
                    $('input[name=f_title]').val("");
                    $('textarea[name=f_description]').val("");
                    $('input[name=f_value]').val("");
                    $('input[name=f_url]').val("");
                }
            }
        });
    }
});

function generateCustomFields(){
    $('div#placeholder_external_fields').html('');
    $.ajax({
        type: "POST",
        url: "process.php?do=getCustomFields",
        dataType: 'json',
        data: { user_id: ''},
        success: function(jsonObject){
            $('div#placeholder_external_fields').css("display", "");
            $.each(jsonObject, function(i, object){
                var html = "";
                if (object.url != '' && object.url != null){
                    html = '<div class="custom_field" field_id="'+object.user_external_field_id+'" class="row-fluid"><div class="span3">' + object.title + ':</div><div class="span9"><a target="_blank" href="' +object.url+ '">' + object.name + '</a> <button style="display:none" onclick="removeCustomField('+object.user_external_field_id+');" class="btn btn-mini btn-danger pull-right"><i class="icon-remove icon-white"></i></button></div></div>';
                } else {
                    html = '<div class="custom_field" field_id="'+object.user_external_field_id+'" class="row-fluid"><div class="span3">' + object.title + ':</div><div class="span9">' + object.name + ' <button style="display:none" onclick="removeCustomField('+object.user_external_field_id+');" class="btn btn-mini btn-danger pull-right"><i class="icon-remove icon-white"></i></button></div></div>';
                }
                //var html = '<div class="custom_field" field_id="'+object.user_external_field_id+'" class="row-fluid"><div class="span3">' + object.title + ':</div><div class="span9">' + object.name + ' <button style="display:none" onclick="removeCustomField('+object.user_external_field_id+');" class="btn btn-mini btn-danger pull-right"><i class="icon-remove icon-white"></i></button></div></div>';
                $('div#placeholder_external_fields').append(html);
            });

            $('div.custom_field').hover(function(){
                $(this).find('button').show();
            }, function(){
                $(this).find('button').hide();
            });
        }
    });
}


function removeCustomField(field_id){
    $('div#placeholder_external_fields').find('div.custom_field[field_id='+field_id+']').remove();
    //alert(field_id + " has been removed!");
    $.ajax({
        type: "POST",
        url: "process.php?do=removeCustomField",
        dataType: 'html',
        data: { user_id: field_id},
        success: function(returnHTML){
            console.log(returnHTML);
        }
    });
}


generateCustomFields();

$('input.fileInput').change(function(){
    if ($(this).val() != ''){
        $('#picUpdatetext').val($(this).val());
        $('#picUpdatetext').show();
        $('#picUpdatecancel').show();
        $('#picUpdatebutton').show();
        $('#demoButton').hide();
    } else {
        $('#picUpdatetext').hide();
        $('#picUpdatecancel').hide();
        $('#picUpdatebutton').hide();
        $('#demoButton').show();
    }
})

$('#picUpdatecancel').click(function(){
    $('#demoButton').show();
    $('#picUpdatetext').hide();
    $('#picUpdatecancel').hide();
    $('#picUpdatebutton').hide();
});


$('input#position').typeahead().on('keyup', function(ev){

        ev.stopPropagation();
        ev.preventDefault();
        var minLength = 2;
        if($.inArray(ev.keyCode,[40,38,9,13,27]) === -1 && $(this).val().length >= minLength){

            var self = $(this);
            self.data('typeahead').source = [];

            if( !self.data('active') && self.val().length > 0){

                self.data('active', true);
                var arr = [];
                var j=0;

                $.getJSON("process.php?do=getSuggestions&type=position",{
                    q: $(this).val()
                }, function(data) {
                    self.data('active',true);

                    var arr = [],
                    i = data.length;

                    while(i--){
                        arr[i] = data[i].results;
                    }
                    self.data('typeahead').source = arr;
                    self.trigger('keyup');
                    self.data('active', false);

                });

            }
        }
    });

     $('input#employer').typeahead().on('keyup', function(ev){

        ev.stopPropagation();
        ev.preventDefault();
        var minLength = 2;
        if($.inArray(ev.keyCode,[40,38,9,13,27]) === -1 && $(this).val().length >= minLength){

            var self = $(this);
            self.data('typeahead').source = [];

            if( !self.data('active') && self.val().length > 0){

                self.data('active', true);
                var arr = [];
                var j=0;

                $.getJSON("process.php?do=getSuggestions&type=employer",{
                    q: $(this).val()
                }, function(data) {
                    self.data('active',true);

                    var arr = [],
                    i = data.length;

                    while(i--){
                        arr[i] = data[i].results;
                    }
                    self.data('typeahead').source = arr;
                    self.trigger('keyup');
                    self.data('active', false);

                });

            }
        }
    });

 $('input#sector').typeahead().on('keyup', function(ev){

        ev.stopPropagation();
        ev.preventDefault();
        var minLength = 2;
        if($.inArray(ev.keyCode,[40,38,9,13,27]) === -1 && $(this).val().length >= minLength){

            var self = $(this);
            self.data('typeahead').source = [];

            if( !self.data('active') && self.val().length > 0){

                self.data('active', true);
                var arr = [];
                var j=0;

                $.getJSON("process.php?do=getSuggestions&type=sector",{
                    q: $(this).val()
                }, function(data) {
                    self.data('active',true);

                    var arr = [],
                    i = data.length;

                    while(i--){
                        arr[i] = data[i].results;
                    }
                    self.data('typeahead').source = arr;
                    self.trigger('keyup');
                    self.data('active', false);

                });

            }
        }
    });

</script>