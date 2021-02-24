<?php
require_once 'config/config.php';
include 'lib/Excel/SimpleXLSXGen.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data_to_db = array_filter($_POST);
    $sql = "SELECT * FROM ".$data_to_db['table_name'];
    $db = getDbInstance();
    if(isset($data_to_db['start_id'])){
        $sql .= " WHERE id >= ".$data_to_db['start_id'];
        if(isset($data_to_db['end_id'])){
            $sql .= " AND id <= ".$data_to_db['end_id'];
        }
    }
    else if(isset($data_to_db['end_id'])){
        $sql .= " WHERE id <= ".$data_to_db['end_id'];
    }
    $data = $db->rawQuery($sql);
    if ($data) {
        $filename = 'Export_excel_' . $data_to_db['table_name'] . '.xlsx';
        $xlsx = new SimpleXLSXGen();
        $xlsx = SimpleXLSXGen::fromArray( $data );
        $xlsx->downloadAs($filename);
    }
    else{
        $_SESSION['failer'] = "Error! ".$db->getLastError();
        header('location: database.php');
        exit;
    }
}else{
    $_SESSION['failer'] = "No request found!";
    header('location: database.php');
    exit;
}
?>