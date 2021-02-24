<?php 
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
$del_id = filter_input(INPUT_POST, 'del_id');
$db = getDbInstance();

// Delete a user using user_id
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $db->where('id', $del_id);
    $account_details = $db->getOne('accounts');
    if(file_exists($account_details['file'])) {
        unlink($account_details['file']);
    }
    $db->where('id', $del_id);
    $stat = $db->delete('accounts');
    if ($stat) {
        $_SESSION['info'] = "Account details deleted successfully!";
        header('location: account.php');
        exit;
    }
    else{
        $_SESSION['failer'] = "Error! ".$db->getLastError();
        header('location: account.php');
        exit;
    }
}