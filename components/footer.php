<div class="row-fluid footer">
    <div class="span12">
        <div class="row-fluid">
            <div class="span6 left-panel-footer">
                
                <ul class="nav nav-pills">
                    <li><a href="http://www.facebook.com/groups/184953321579021/?fref=ts">Copyright (C)IUTCS</a></li>
                    <li><a href="index.php?page=aboutus">about</a></li>
                </ul>
            </div>
            <div class="span6 right-panel-footer">
                <ul class="nav nav-pills">
                    <li><a href="index.php?page=help">help</a></li>
                    <?php if($_SESSION['logged_in'] == TRUE){?>
                    <li><a href="#FeedbackModal" data-toggle="modal">feedback</a></li>
                    <?php }?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="modal hide fade" id="FeedbackModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <!--TODO: Implement the process changePass.php -->
    <form method="POST" action="process.php?do=sendFeedback">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Feedback</h3>
        </div>


        <div class="modal-body">
                 <div class="row-fluid">
                 If you have any query or question about this website or need anything updated please give us your feedback here:<br/>
                 <br/>
             </div>
           
            
            <div class="row-fluid">
                 <textarea id="feedback" style="width: 100%" name="feedback" cols="40" rows="5"></textarea>
             </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" id="flag" type="submit">Send Feedback</button>
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
    </form>
</div>