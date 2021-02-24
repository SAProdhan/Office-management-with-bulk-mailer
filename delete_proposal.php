<?php 
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
$del_id = filter_input(INPUT_POST, 'del_id');
$db = getDbInstance();
// Delete a user using user_id
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $db->where('id', $del_id);
    $proposal = $db->getOne('proposals');
    if (file_exists($proposal['path'])) {
            unlink($proposal['path']);
        }
    $db->where('id', $del_id);
    $stat = $db->delete('proposals');
    if ($stat) {
        $_SESSION['info'] = "Task deleted successfully!";
        header('location: proposal.php');
        exit;
    }
}