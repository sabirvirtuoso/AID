<?php
if (isset($_SESSION['msg_type']) && isset($_SESSION['msg'])){
    $msg_type = $_SESSION['msg_type'];
    $msg = $_SESSION['msg'];
    unset($_SESSION['msg_type']);
    unset($_SESSION['msg']);
?>
<?php
    if ($msg_type == "s"){
?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <h4>Success!</h4>
        <?php echo $msg; ?>
    </div>
<?php
    } else if ($msg_type == "e"){
?>
    <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <h4>Error!</h4>
        <?php echo $msg; ?>
    </div>
<?php
    } else if ($msg_type == "i"){
?>
    <div class="alert alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <h4>Info!</h4>
        <?php echo $msg; ?>
    </div>
<?php
    }
}

if (isset($_SESSION['info']) && is_array($_SESSION['info']) && count($_SESSION['info']) > 0){
?>
    <div class="alert alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <h4>Info!</h4>
        <?php 
        foreach ($_SESSION['info'] as $info){
            echo $info.'<br/>'; 
        }
        ?>
    </div>
<?php
    unset($_SESSION['info']);
}
?>