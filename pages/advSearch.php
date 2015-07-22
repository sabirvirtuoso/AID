<div class="row-fluid">
    <div class="span12">
        <form class="form-horizontal">
            <div class="row-fluid">
                <div class="control-group span6">
                    <label class="control-label" for="inputEmail">Name</label>
                    <div class="controls">
                        <input type="text" id="name" value="" data-provide="typeahead">
                        <!--button type="button" class="btn pull-right btn-danger" title="Remove Filter"><i class="icon-minus-sign icon-white"></i></button-->
                    </div>
                </div>
                <div class="control-group span6">
                    <label class="control-label" for="inputEmail">Student ID</label>
                    <div class="controls">
                        <input type="text" id="student_id" value="">
                        <!--button type="button" class="btn pull-right btn-danger" title="Remove Filter"><i class="icon-minus-sign icon-white"></i></button-->
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="control-group span6">
                    <label class="control-label" for="inputEmail">Batch</label>
                    <div class="controls">
                        <input type="text" id="batch" value="">
                        <!--button type="button" class="btn pull-right btn-danger" title="Remove Filter"><i class="icon-minus-sign icon-white"></i></button-->
                    </div>
                </div>
                <div class="control-group span6">
                    <label class="control-label" for="inputEmail">Department</label>
                    <div class="controls">
                        <select class="bootstrap-combo" id="department">
                            <option value="">Any</option>
                            <option value="CEE">CEE</option>
                            <option value="CSE">CSE</option>
                            <option value="EEE">EEE</option>
                            <option value="MCE">MCE</option>
                        </select>
                        <!--button type="button" class="btn pull-right btn-danger" title="Remove Filter"><i class="icon-minus-sign icon-white"></i></button-->
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="control-group span6">
                    <label class="control-label" for="inputEmail">Occupation/Position</label>
                    <div class="controls">
                        <input type="text" id="position" value="">
                        <!--button type="button" class="btn pull-right btn-danger" title="Remove Filter"><i class="icon-minus-sign icon-white"></i></button-->
                    </div>
                </div>
                <div class="control-group span6">
                    <label class="control-label" for="inputEmail">Employer/Institution</label>
                    <div class="controls">
                        <input type="text" id="employer" value="">
                        <!--button type="button" class="btn pull-right btn-danger" title="Remove Filter"><i class="icon-minus-sign icon-white"></i></button-->
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="control-group span6">
                    <label class="control-label" for="inputEmail">Working Sector</label>
                    <div class="controls">
                        <input type="text" id="sector" value="">
                        <!--button type="button" class="btn pull-right btn-danger" title="Remove Filter"><i class="icon-minus-sign icon-white"></i></button-->
                    </div>
                </div>

                <div class="control-group span6">
                    <label class="control-label" for="inputEmail">Nationality</label>
                    <div class="controls">
                        <select class="bootstrap-combo" id="nationality">
                            <option value="">Any</option>
                            <option value="BD">Bangladeshi</option>
                            <option value="IN">Indonesian</option>
                            <option value="SM">Somalian</option>
                        </select>
                        <!--button type="button" class="btn pull-right btn-danger" title="Remove Filter"><i class="icon-minus-sign icon-white"></i></button-->
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="control-group span6">
                    <label class="control-label" for="inputEmail">City</label>
                    <div class="controls">
                        <input type="text" id="city" value="">
                        <!--button type="button" class="btn pull-right btn-danger" title="Remove Filter"><i class="icon-minus-sign icon-white"></i></button-->
                    </div>
                </div>

                <div class="control-group span6">
                    <label class="control-label" for="inputEmail">Country</label>
                    <div class="controls">
                        <input type="text" id="country" value="">
                        <!--button type="button" class="btn pull-right btn-danger" title="Remove Filter"><i class="icon-minus-sign icon-white"></i></button-->
                    </div>
                </div>
                
                
            </div>
            <div class="row-fluid">
                <div class="control-group span12">
                    <label class="control-label" for="inputEmail">Blood Group</label>
                    <div class="controls">
                        <select class="bootstrap-combo" id="blood_group">
                            <option value="">Any</option>
                            <option value="A+">A+</option>
                            <option value="AB+">AB+</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                        </select>
                        <!--button type="button" class="btn pull-right btn-danger" title="Remove Filter"><i class="icon-minus-sign icon-white"></i></button-->
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="control-group span12">
                    <label class="control-label" for="inputEmail">IUT Room #</label>
                    <div class="controls">
                        <input type="text" id="iut_room_no" value="">
                        <!--button type="button" class="btn pull-right btn-danger" title="Remove Filter"><i class="icon-minus-sign icon-white"></i></button-->
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="control-group span12">
                    <label class="control-label" for="inputEmail">Interests</label>
                    <div class="controls">
                        <input type="text" id="interests" value="">
                        <!--button type="button" class="btn pull-right btn-danger" title="Remove Filter"><i class="icon-minus-sign icon-white"></i></button-->
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <button type="button" class="btn" onclick="PrepareSearchString()"><i class="icon-search"></i> Search</button>
                <button type="button" class="btn" onclick="resetAction()"><i class="icon-refresh"></i> Reset</button>
            </div>
        </form>
    </div>
</div>

<div id="countresults" align="center" class="body">

</div>

<div class="btn-toolbar pull-right" style="display: none" id="buttons">
    <div id="pagination" class="btn-group">

        <button id="first" onclick="loadFirstPage();" class="btn"><i class="icon-step-backward"></i></button>
        <button id="prev" onclick="loadPreviousPage();" class="btn"><i class="icon-chevron-left"></i></button>
        <button id="next" onclick="loadNextPage();" class="btn"><i class="icon-chevron-right"></i></button>
        <button id="last" onclick="loadLastPage();" class="btn"><i class="icon-step-forward"></i></button>
    </div>
</div>

<table id="searchDisplay" class="table table-hover" style="display: none">
    <thead>
        <tr>
            <th>&nbsp;<i class="icon-user"></i></th>
            <th>Batch</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Std. ID</th>
            <th>Dept.</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr id="noData">
            <td colspan="7" style="text-align: center"><img src="img/ajax-loader.gif"/></td>
        </tr>
    </tbody>
</table>

<script type="text/javascript">


    $('.bootstrap-combo').combobox();

    var count = 0;
    var limitInput = 5;
    var offsetInput = 0;
    var curPage = 1;
    var maxPage = 1;

    function PrepareSearchString(){

        var SearchString='';
        var i;
        var str="";



        if($('input#name').val()!="")
        {
            var fullname = $('input#name').val();
           /* var arr = fullname.split(" ");
            if (arr.length > 1){
                SearchString=SearchString+'first_name='+arr[0]+'&';

                for(i=0;i<arr.length;i++)
                {
                    if(i>0)
                    {
                        str=str+arr[i]+" ";
                    }
                }
                var last_name=str.substring(0,str.length-1);
                SearchString=SearchString+'last_name='+last_name+'&';
            } else {*/
                SearchString=SearchString+'first_name='+fullname+'&';
           // }
        }
        if($('input#student_id').val()!="")
        {
            SearchString=SearchString+'student_id='+$('input#student_id').val()+'&';
        }
        if($('input#batch').val()!="")
        {
            SearchString=SearchString+'batch='+$('input#batch').val()+'&';
        }
        if($('select#department').val()!="")
        {
            SearchString=SearchString+'department='+$('select#department').val()+'&';
        }
        if($('input#position').val()!="")
        {
            SearchString=SearchString+'position='+$('input#position').val()+'&';
        }
        if($('input#employer').val()!="")
        {
            SearchString=SearchString+'employer='+$('input#employer').val()+'&';
        }
        if($('input#sector').val()!="")
        {
            SearchString=SearchString+'sector='+$('input#sector').val()+'&';
        }
        if($('input#city').val()!="")
        {
            SearchString=SearchString+'city='+$('input#city').val()+'&';
        }
        if($('input#country').val()!="")
        {
            SearchString=SearchString+'country='+$('input#country').val()+'&';
        }
        if($('select#nationality').val()!="")
        {
            SearchString=SearchString+'nationality='+$('select#nationality').val()+'&';
        }
        if($('input#iut_room_no').val()!="")
        {
            SearchString=SearchString+'iut_room_no='+$('input#iut_room_no').val()+'&';
        }
        if($('input#interests').val()!="")
        {
            SearchString=SearchString+'interest='+$('input#interests').val()+'&';
        }
        if($('select#blood_group').val()!="")
        {
            SearchString=SearchString+'blood_group='+$('select#blood_group').val()+'&';
        }
        SearchString=SearchString.substring(0,SearchString.length-1);
        getSearchResults(SearchString, limitInput, offsetInput);
    }

    function getSearchResults(searchStringInput, limitInput, offsetInput){
        $('table#searchDisplay tbody').html('<tr id="noData">'+
            '<td colspan="7" style="text-align: center"><img src="img/ajax-loader.gif"/>'+
            '</tr>');

        $.ajax({
            type: "POST",
            url: "process.php?do=search",
            dataType: 'html',
            data: {
                searchString: searchStringInput,
                count: 'true'
            },
            success: function(htmlResult){

                count = htmlResult;
                maxPage = Math.ceil(count / limitInput);
                
                if (htmlResult.indexOf("FAILED") < 0){
                    $.ajax({
                        type: "POST",
                        url: "process.php?do=search",
                        dataType: 'json',
                        data: {
                            searchString: searchStringInput,
                            limit: limitInput,
                            offset: offsetInput,
                            count: 'false'
                        },
                        success: function(jsonObject){
						if(jsonObject.length>0)
					{
                            $('div#buttons').css("display", "");
                            $('table#searchDisplay').css("display", "");
                            $('tr#noData').remove();
                            $.each(jsonObject, function(i, user_info){

                            var user_id=user_info.user_id;

                            $('tr#noData').remove();
                            if(i!='photo')
                            {


                                if(user_info.photo!=null)
                                {
                                    var rowTemplate =
                                        '<tr>'+
                                        '<td><div style="height:32px; width: 32px; overflow: hidden;"><img src="data:image/jpeg;base64,'+user_info.photo+'" style="width: 32px; height: auto;"></div></td>'
                                }
                                else
                                {
                                    var rowTemplate =
                                        '<tr>'+
                                        '<td><img src="img/user.png" style="width: 32px; height: 32px;"></td>';
                                }
                                rowTemplate =
                                    rowTemplate+
                                    '<td>'+user_info.batch+'</td>'+
                                    '<td>'+user_info.first_name+'</td>'+
                                    '<td>'+user_info.last_name+'</td>'+
                                    '<td>'+user_info.student_id+'</td>'+
                                    '<td>'+user_info.department+'</td>'+
                                    '<td>'+
                                    '<div class="btn-group">'+
                                    '<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">'+
                                    'Options '+
                                    '<span class="caret"></span>'+
                                    '</a>'+
                                    '<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">'+
                                    // '<li><a tabindex="-1" href="#">Action</a></li>'+
                                /// '<li><a tabindex="-1" href="#">Another action</a></li>'+
                                // '<li><a tabindex="-1" href="#">Something else here</a></li>'+
                                // '<li class="divider"></li>'+
                                '<li><a tabindex="-1" href="index.php?page=profile&id='+user_id+'">View Profile</a></li>'+
                                    '</ul>'+
                                    '</div>'+
                                    '</td>'+
                                    '</tr>';
                                }

                                $('table#searchDisplay tbody').append(rowTemplate);
                                if (curPage == 1){
                                    $('div#pagination button#first').attr('disabled', 'disabled');
                                    $('div#pagination button#prev').attr('disabled', 'disabled');
                                } else {
                                    $('div#pagination button#first').removeAttr('disabled');
                                    $('div#pagination button#prev').removeAttr('disabled');
                                }

                                if (curPage == maxPage){
                                    $('div#pagination button#last').attr('disabled', 'disabled');
                                    $('div#pagination button#next').attr('disabled', 'disabled');
                                } else {
                                    $('div#pagination button#last').removeAttr('disabled');
                                    $('div#pagination button#next').removeAttr('disabled');
                                }

                                $('#pageCount').text("Page: "+curPage+"/"+maxPage);
                            });
                    }
					else
					{
					  $('table#searchDisplay tbody').html('<tr id="noData">'+
						'<td colspan="7" style="text-align: center">Search returned no results!</td>'+
						'</tr>');
					}
						}
                    });
                } else {
                    $('div#countresults').html("Invalid entry, please check your query again!");
                }
            }
        });

    }

    function loadFirstPage(){
        if (curPage > 1){
            offsetInput = 0;
            curPage = 1;
            getSearchResults('batch='+$('input#batch').val()+'&enabled=yes', limitInput, offsetInput);
        }
    }

    function loadNextPage(){
        if (curPage < maxPage){
            curPage = curPage + 1;
            offsetInput = limitInput * (curPage - 1);
            getSearchResults('batch='+$('input#batch').val()+'&enabled=yes', limitInput, offsetInput);
        }
    }

    function loadPreviousPage(){
        if (curPage > 1){
            curPage = curPage - 1;
            offsetInput = limitInput * (curPage - 1);
            getSearchResults('batch='+$('input#batch').val()+'&enabled=yes', limitInput, offsetInput);
        }
    }

    function loadLastPage(){
        if (curPage < maxPage){
            curPage = maxPage;
            offsetInput = limitInput * (curPage - 1);
            getSearchResults('batch='+$('input#batch').val()+'&enabled=yes', limitInput, offsetInput);
        }
    }

    function resetAction()
    {
        

        $('input#name').val("");

        $('input#student_id').val("");

        $('input#batch').val("");

        $('select#department').val("");

        $('input#position').val("");

        $('input#employer').val("");

        $('input#sector').val("");

        $('input#city').val("");

        $('input#country').val("");

        $('select#nationality').val("");

        $('input#iut_room_no').val("");

        $('input#interests').val("");

        $('select#blood_group').val("");

    }


    $('input#name').typeahead().on('keyup', function(ev){

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

                $.getJSON("process.php?do=getSuggestions&type=name",{
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


     $('input#city').typeahead().on('keyup', function(ev){

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

                $.getJSON("process.php?do=getSuggestions&type=city",{
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


 $('input#country').typeahead().on('keyup', function(ev){

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

                $.getJSON("process.php?do=getSuggestions&type=country",{
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