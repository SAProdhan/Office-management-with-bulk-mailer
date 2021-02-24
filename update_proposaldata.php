<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH.'/includes/auth_validate.php';

$email = filter_input(INPUT_GET, 'email');
$proposal_id = filter_input(INPUT_GET, 'proposal_id');

$db = getDbInstance();
$db->where("EmailAddress", $email);
$db->orWhere("EmailAddress_IT", $email);
$client_data=$db->getOne("paxzone_client_master");

$data = Array(
    'Company_Name' => isset($client_data['Company_Name'])? $client_data['Company_Name'] : " ",
    'ContactPerson'=> isset($client_data['ContactPerson'])? $client_data['ContactPerson'] : " ",
    'MobileNo'     => isset($client_data['MobileNo'])? $client_data['MobileNo'] : " "
);
$db->where ("id", $proposal_id);
$result = $db->update('proposals', $data);
if ($result)
{
    $_SESSION['success'] = 'Client data updated successfully!';
    // Redirect to the listing page
    header('Location: proposal.php');
    // Important! Don't execute the rest put the exit/die.
    exit();
}
else
{
    $_SESSION['failure'] = 'Data update failed! Error: '. $db->getLastError();
    header('Location: proposal.php');
    exit();
}
?>