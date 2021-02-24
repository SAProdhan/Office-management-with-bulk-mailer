<?php
//fetch.php;
session_start();
require_once 'config/config.php';
date_default_timezone_set('Asia/Dhaka');
$id = filter_input(INPUT_POST, 'id');
$db = getDbInstance();
$db->where('id', $id);
$reminder = $db->delete('reminder');
$output = '';
if($reminder)
{
 $output = true;
}else{
    $output = false;
}
// $update_query = "UPDATE comments SET comment_status = 1 WHERE comment_status = 0";
// mysqli_query($connect, $update_query);
echo $output;

?>