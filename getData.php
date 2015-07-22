<?php
session_start();
if ($_SESSION['logged_in'] == TRUE) {
    include 'lib/dbconn.inc.php';

    if ($_GET["action"] == "list") {
        $sqlCount = "SELECT COUNT(*) FROM user_info WHERE batch = '".$_SESSION['batch']."'";
        $sth = $dbconn->prepare($sqlCount);
        $sth->execute();
        $recordCount = $sth->fetchColumn();
        //Get records from database
        $sort = "ORDER BY first_name ASC";
        if ($_GET['jtSorting'] != ""){
            $sort = "ORDER BY ".$_GET['jtSorting'];
        }
        $sql = "SELECT user_id, batch, first_name, last_name, student_id, department, email_primary, photo FROM user_info WHERE batch = '".$_SESSION['batch']."' $sort LIMIT " . $_GET["jtPageSize"] . " OFFSET " . $_GET["jtStartIndex"];
        $sth = $dbconn->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        $rows = array();


        //Return result to jTable
        $jTableResult = array();
        $jTableResult['SQL'] = $sql;
        $jTableResult['Result'] = "OK";
        $jTableResult['TotalRecordCount'] = $recordCount;
        $jTableResult['Records'] = $result;
        print json_encode($jTableResult);
    }
}
?>
