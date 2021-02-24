<?php 
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
$del_id = filter_input(INPUT_POST, 'del_id');
$db = getDbInstance();

// Delete a user using user_id
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $db->where('id', $del_id);
    $payment_details=$db->getOne("payment_details");
    $db = getDbInstance();
    $db->where('id', $del_id);
    $stat = $db->delete('payment_details');
    if ($stat) {
        $db->where("id", $payment_details['account_id']);
        $account_details=$db->getOne("accounts");
        $data = Array(
            'due' => ($account_details['due']+$payment_details['amount'])
        );
        $db->where("id", $payment_details['account_id']);
        $db->update('accounts', $data);
        $_SESSION['info'] = "Payment deleted successfully!";
        header('location: payment_details.php?account_id='.$payment_details['account_id']);
        exit;
    }
    else{
        $_SESSION['failer'] = "Error! ".$db->getLastError();
        header('location: payment_details.php?account_id='.$payment_details['account_id']);
        exit;
    }
}