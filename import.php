<?php 
require_once 'config/config.php';
include 'lib/Excel/SimpleXLSX.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data_to_db = array_filter($_POST);
    $db = getDbInstance();
    $db->where('tables', $data_to_db['table']);
    $column = $db->getOne("table_details");
    $keys = json_decode($column['columns'], true);
    // unset($keys[0]);
    $xlsx = SimpleXLSX::parse($_FILES["file"]["tmp_name"]);
    $data = $xlsx->rows();
    // $data = Array(
    //     Array ("admin", "John", "Doe"),
    //     Array ("other", "Another", "User")
    // );
    $ids = $db->insertMulti($data_to_db['table'], $data, $keys);
    if(!$ids) {
        $_SESSION['failer'] = "Import failed! Error: ".$db->getLastError();
        header('location: database.php');
        exit;
    } else {
        $_SESSION['success'] = "Data import successfully";
        header('location: database.php');
        exit;
    }
}


?>