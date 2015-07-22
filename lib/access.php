<?php
/*
 1 Super Admin
 2 Batch Admin
 3 Data Admin
 4 General User
 */
function hasAccess($action){
    
    $access = array(
        '4'=> array(//General User
            //Action                    //Permission
            'profile/edit/self'         => true,
            'profile/edit/other'        => false,
            'profile/requestUpdate'     => false,
            'profile/flag'              => true,
            'backend_data_entry'        => false
            //----------------------------------
         ),
        '3'=> array(//Data Admin
            //Action                    //Permission
            'profile/edit/self'         => true,
            'profile/edit/other'        => false,
            'profile/requestUpdate'     => false,
            'profile/flag'              => false,
            'backend_data_entry'        => true
         ),
        '2'=> array(//Batch Admin
            //Action                    //Permission
            'profile/edit/self'         => true,
            'profile/edit/other'        => false,
            'profile/requestUpdate'     => true,
            'profile/flag'              => true,
            'backend_data_entry'        => false
         ),
        '1'=> array(//Super Admin
            //Action                    //Permission
            'profile/edit/self'         => true,
            'profile/edit/other'        => true,
            'profile/requestUpdate'     => true,
            'profile/flag'              => true,
            'backend_data_entry'        => true
         )
    );
    
    $role = $_SESSION['role'];
    return $access[$role][$action];
}
?>
