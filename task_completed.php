<?php 
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
date_default_timezone_set('Asia/Dhaka');
$del_id = filter_input(INPUT_POST, 'com_id');
$assign_at = filter_input(INPUT_POST, 'assign_at');
$db = getDbInstance();

// Delete a user using user_id
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $d=date("Y-m-d", strtotime("now"));
    $db->where('timestamp', $d . '%', 'like');
    $db->where('user_id', $del_id);
    $counter = $db->getOne("mailcounter", "sum(counter) as cnt");
    $db->where('assign_at', $d . '%', 'like');
    $db->where('user_id', $del_id);
    $task = $db->getOne("tasks");
    $status = "no task";
    $id = null;
    if($task){
        $id = $task['id'];
        $mail_assign = $task['end_no'] - $task['start_no'];
        $mail_send = $counter['cnt'];
        $p = $mail_send/$mail_assign*100;
        $status = $p."% done";
        $complete=date("Y-m-d h:m:sa", strtotime("now"));
        $task['status'] = ($p>100)? "Over smart":$p."% done";
        $task['completed_at'] = $complete;
        $task['remarks'] .= "Extar Send:".$mail_send;
        unset($task["id"]);
        $db->where('id', $id);
        $stat = $db->update('tasks', $task);
        if ($stat) {
            $_SESSION['success'] = "Task successfully completed";
            header('location: user_tasks.php');
            exit;
        }
    }
    $_SESSION['danger'] = "Error".$db->getLastError();
    header('location: user_tasks.php');
    exit;

}