<?php
//fetch.php;
session_start();
require_once 'config/config.php';
date_default_timezone_set('Asia/Dhaka');
$user_name = filter_input(INPUT_POST, 'user_name');
$date = date("Y-m-d", strtotime("now"));
$db = getDbInstance();
$db->where('user_name', $user_name);
$db->where('date', $date);
$reminder = $db->getOne('reminder');
$output = '';
if($reminder)
{
 $output .= '
 <div class="alert alert_default">
  <a href="#" id="closeR" class="close" data-dismiss="alert" aria-label="close"  >&times;</a>
  <h5><strong>'.$reminder["Company_Name"].'</strong></h5>
  <p><small><em>'.$reminder["message"].'</em></small></p><br>
  <input type="button" value="Done" id="deleteReminder" data-id1="'.$reminder["id"].'">
 </div>
 ';
}else{
    $output .= $db->getLastError();
}
// $update_query = "UPDATE comments SET comment_status = 1 WHERE comment_status = 0";
// mysqli_query($connect, $update_query);
echo $output;

?>