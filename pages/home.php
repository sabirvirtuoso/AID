<?php
if (!isset($_SESSION['latlong'])) {
    $_SESSION['latlong'] = false;
    ?>
    <script type="text/javascript">
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position){
                $.ajax({
                    type: "POST",
                    url: "process.php?do=updateLatLong",
                    data: { 'lat': position.coords.latitude, 'long': position.coords.longitude}
                });
            });
        }
    </script>
    <?php
}
?>
<span class="label label-success"><i class="icon-search icon-white"></i> Search</span>
Showing friends of batch <?php echo $_SESSION['batch']; ?>!
<input id="batch" type="hidden" value="<?php echo $_SESSION['batch']; ?>" />
<?php if (isset($_GET['pass'])) { ?>
    <script type="text/javascript">
        alert("Please change your default password");
    </script>
<?php } ?>
<!--div class="btn-toolbar pull-right" >
    <div id="pagination" class="btn-group">

        <button id="first" onclick="loadFirstPage();" class="btn"><i class="icon-step-backward"></i></button>
        <button id="prev" onclick="loadPreviousPage();" class="btn"><i class="icon-chevron-left"></i></button>
        <button id="next" onclick="loadNextPage();" class="btn"><i class="icon-chevron-right"></i></button>
        <button id="last" onclick="loadLastPage();" class="btn"><i class="icon-step-forward"></i></button>
    </div>
</div-->
<br /><br />
<div id="searchDisplayBatch"></div>
<br /><br />

<script type="text/javascript">
    $(document).ready(function () {
        $("div#searchDisplayBatch").jtable({
            title: 'Student Details',
            paging: true,
            pageSize: 5,
            sorting: true,
            defaultSorting: 'Name ASC',
            actions: {
                listAction: 'getData.php?action=list'//,
                //createAction: 'PersonActionsPagedSorted.php?action=create',
                //updateAction: 'PersonActionsPagedSorted.php?action=update',
                //deleteAction: 'PersonActionsPagedSorted.php?action=delete'
            },
            fields: {
                user_id: {
                    key: true,
                    list: false
                },
                first_name: {
                    title: 'Name',
                    width: '40%',
                    display: function(row){
                        return row.record.first_name + " " + row.record.last_name;
                    }
                },
                student_id: {
                    title: 'Student ID'
                },
                department: {
                    title: 'Department'
                }
            }
        });

        //Load person list from server
        $('div#searchDisplayBatch').jtable('load');
    });
</script>
<!--script type="text/javascript">
    var count = 0;
    var limitInput = 5;
    var offsetInput = 0;
    var curPage = 1;
    var maxPage = 1;



    function getSearchResults(searchStringInput, limitInput, offsetInput){
        $('table#searchDisplay tbody').html('<tr id="noData">'+
                       
            '<td colspan="7" style="text-align: center"><img src="img/ajax-loader.gif"/>'+
                        
            '</tr>');
                        
                        

        $.ajax({
            type: "POST",
            url: "process.php?do=search",
            dataType: 'html',
            data: {
                //
                searchString: 'batch='+$('input#batch').val()+'&enabled=yes',
                count: 'true'
            },
            success: function(htmlResult){
                //console.log('Total Rows: '+count);
                count = htmlResult;
                                
                maxPage = Math.ceil(count / limitInput);
                $('count').text(htmlResult);
                $.ajax({
                    type: "POST",
                    url: "process.php?do=search",
                    dataType: 'json',
                    data: {
                        searchString: 'batch='+$('input#batch').val()+'&enabled=yes',
                        limit: limitInput,
                        offset: offsetInput,
                        count: 'false'
                    },
                    success: function(jsonObject){
                        //console.log('Currently Displaying: '+jsonObject);
                                                if(jsonObject.length>0)
                                        {
                        $.each(jsonObject, function(i, user_info){
                            //console.log(user_info);
                            var user_id=user_info.user_id;

                            $('tr#noData').remove();
                                                        //$('div#load').remove();
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

    getSearchResults('batch='+$('input#batch').val()+'&enabled=yes', limitInput, offsetInput);

</script-->