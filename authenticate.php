<?php
require_once 'config/config.php';
require "otp_handler.php"; 

session_start();

date_default_timezone_set("Asia/Dhaka");

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	$username = filter_input(INPUT_POST, 'username');
	$password = filter_input(INPUT_POST, 'password');
	$remember = filter_input(INPUT_POST, 'remember');
	$otp = null;
	
	// Get DB instance.
	$db = getDbInstance();
	$db->where('user_name', $username);
	$row = $db->getOne('admin_accounts');
	if ($db->count >= 1)
    {
		$db_password = $row['password'];
		$user_id = $row['id'];

		if (password_verify($password, $db_password))
        {
			// if(checkOTP($user_id)){
			// 	if(filter_input(INPUT_POST, 'otp')){
			// 		$otp = filter_input(INPUT_POST, 'otp');
			// 		if(!verifyOTP($user_id, $otp)){
			// 			header('Location: login.php?user_id='.$user_id.'&username='.$username.'&password='.$password.'&need_otp=true');
			// 			exit;
			// 		}
			// 	}else if(sentOTP($user_id, $row['email'])){
			// 		header('Location: login.php?user_id='.$user_id.'&username='.$username.'&password='.$password.'&need_otp=true');
			// 		exit;
			// 	}
			// }
			
			$_SESSION['user_logged_in'] = TRUE;
			$_SESSION['admin_type'] = $row['admin_type'];
            $_SESSION['user_id'] = $row['id'];

			if ($remember)
            {
				$series_id = randomString(16);
				$remember_token = getSecureRandomToken(20);
				$encryted_remember_token = password_hash($remember_token,PASSWORD_DEFAULT);

				$expiry_time = date('Y-m-d H:i:s', strtotime(' + 30 days'));
				$expires = strtotime($expiry_time);

				setcookie('series_id', $series_id, $expires, '/');
				setcookie('remember_token', $remember_token, $expires, '/');

				$db = getDbInstance();
				$db->where ('id',$user_id);

				$update_remember = array(
					'series_id'=> $series_id,
					'remember_token' => $encryted_remember_token,
					'expires' =>$expiry_time
				);
				$db->update('admin_accounts', $update_remember);
			}
			// Authentication successfull redirect user
			if($_SESSION['admin_type']=='user'){
				header('Location: mailer/index.php');
			}
			else{
				header('Location: index.php');
			}
		}
        else
        {
			$_SESSION['login_failure'] = 'Invalid user name or password';
			header('Location: login.php');
		}
		exit;
	}
    else
    {
		$_SESSION['login_failure'] = 'Invalid user name or password';
		header('Location: login.php');
		exit;
	}
}
else
{
	die('Method Not allowed');
}
