<?php
$active = 'home';
if (isset($_GET['page'])){
    $active = $_GET['page'];
}
?>
<div class="navbar">
    <div class="banner" class="well">
        <h2>AID</h2>
        All IUTians Database
    </div>
    <div class="navbar-inner" style="border-radius: 0 0 4px 4px; border-top: 0;">
        <ul class="nav">
            <li class="<?php if ($active == 'home') echo 'active'; ?>"><a href="index.php?page=home"><i class="icon-home"></i> Home</a></li>
            <li class="<?php if ($active == 'profile') echo 'active'; ?>"><a href="index.php?page=profile"><i class="icon-user"></i> My Profile</a></li>
            <li class="<?php if ($active == 'adv_search') echo 'active'; ?>"><a href="index.php?page=adv_search"><i class="icon-search"></i> Advanced Search</a></li>
            <?php 
            
            if(hasAccess('backend_data_entry')){
            ?>
            <li class="<?php if ($active == 'be_data_entry') echo 'active'; ?>"><a href="index.php?page=be_data_entry"><i class="icon-search"></i> Data Entry</a></li>
            <?php
            }
            ?>
        </ul>
       <!--changed logout code here-->
        <ul class="nav pull-right">
            <li><a href="process.php?do=logout"><i class="icon-off"></i> Logout</a></li>
        </ul>
        <!--form class="navbar-form pull-right" style="padding: 0">
            <button type="submit" class="btn btn-danger"><i class="icon-off icon-white"></i> Logout</button>
        </form-->
    </div>
</div>