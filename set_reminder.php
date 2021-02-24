<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH.'/includes/auth_validate.php';
// Serve POST method, After successful insert, redirect to customers.php page.
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $data_to_db = array_filter($_POST);
    $db = getDbInstance();
    $db->where ("id", $data_to_db['proposal_id']);
    $proposal=$db->getOne("proposals");
    // unset($data_to_db['mail_body']);
    $db->where ("id", $data_to_db['proposal_id']);
    $reminder=$db->getOne("reminder");
    $result = '';
    if($reminder){
        $data = Array(
        'message'      => $data_to_db['message'],
        'date'         => $data_to_db['date'],
        );
        $db = getDbInstance();
        $result = $db->update('reminder', $data);
    }
    else{
        $data = Array(
        'id'           => $data_to_db['proposal_id'],
        'Company_Name' => isset($proposal['Company_Name'])? $proposal['Company_Name'] : "",
        'user_name'    => $proposal['user_name'],
        'message'      => $data_to_db['message'],
        'date'         => $data_to_db['date'],
        );
        $db = getDbInstance();
        $result = $db->insert('reminder', $data);
    }

    if ($result)
    {
        $_SESSION['success'] = 'Reminder set successfully';
        // Redirect to the listing page
        header('Location: proposal.php');
        // Important! Don't execute the rest put the exit/die.
    	exit();
    }
    else
    {
        $_SESSION['danger'] = 'Error: '. $db->getLastError();
        // Redirect to the listing page
        header('Location: proposal.php');
        // Important! Don't execute the rest put the exit/die.
        exit();
    }
}
?>