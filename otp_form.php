<?php
session_start();
require_once 'config/config.php';
require "otp_handler.php"; 
// If User has already logged in, redirect to dashboard page.
$user_id = filter_input(INPUT_GET, 'user_id');
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === TRUE)
{
	header('Location: index.php');
}
// If user submit the form: 
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$data_to_db = filter_input_array(INPUT_POST);
		// Sanitize input post if we want
		$data_to_db = filter_input_array(INPUT_POST);
		// Check whether the otp matched or not
		$db = getDbInstance();
		$db->where('user_id', $data_to_db['user_id']);
		$db->where('otp', $data_to_db['otp']);
		$db->get('otp_expiry');
	
		if ($db->count >= 1)
		{
			$_SESSION['failure'] = 'Username already exists';
			header('location: add_admin.php');
			exit;
		}
		else if($db1->count >= 1){
			$_SESSION['failure'] = 'Email already exists';
			header('location: add_admin.php');
			exit;
		}
	
		// Encrypting the password
		$data_to_db['password'] = password_hash($data_to_db['password'], PASSWORD_DEFAULT);
		// Reset db instance
		$db = getDbInstance();
		$last_id = $db->insert('admin_accounts', $data_to_db);
		$db->where('user_name', $data_to_db['user_name']);
		$db->getOne('admin_accounts');
		if ($last_id)
		{
			$_SESSION['success'] = 'Admin user added successfully';
			header('location: admin_users.php');
			exit;
		}
}

?>
<?php include BASE_PATH.'/includes/header.php'; ?>
<div id="page-" class="col-md-4 col-md-offset-4">
	<form class="form loginform" method="POST" action="">
		<div class="login-panel panel panel-default">
			<div class="panel-heading">Please Enter Your OTP</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="control-label">OTP: </label>
					<input type="text" name="otp" class="form-control" required="required" >
                    <input type="text" name="user_id" class="form-control" value="<?php echo $user_id; ?>" hidden>
				</div>
				<?php if (isset($_SESSION['login_failure'])): ?>
				<div class="alert alert-danger alert-dismissable fade in">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<?php
					echo $_SESSION['login_failure'];
					unset($_SESSION['login_failure']);
					?>
				</div>
				<?php endif; ?>
				<button type="submit" class="btn btn-success loginField">Login</button>
			</div>
		</div>
	</form>
</div>
<?php include BASE_PATH.'/includes/footer.php'; ?>













































<?php
require_once 'config/config.php';
require "otp_handler.php"; 
require "mailer/mailer.php"; 
session_start();

$vc=new Mailer('sales@paxzonebd.com', 'pazoneelectronics','sg2plcpnl0221.prod.sin2.secureserver.net', 465);


if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	$username = filter_input(INPUT_POST, 'username');
	$password = filter_input(INPUT_POST, 'password');
	$remember = filter_input(INPUT_POST, 'remember');

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
			$db->where('id', $user_id);
			$user_privillage = $db->getOne('user_privillage');
			if($db->count >= 1){
				if($user_privillage['otp_on']){
					$otp = getVerificationCode();
					$msg = getHTMLMessage($otp);
					if(filter_var($user_privillage['otp_mail'], FILTER_VALIDATE_EMAIL)){
						if($vc->sendMail($user_privillage['otp_mail'], $msg, $sub)){
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

						}else{
							$_SESSION['login_failure'] = 'Error! Failed to send email!';
							header('Location: login.php');
						}
						
					}else{
						$_SESSION['login_failure'] = 'Error! Invalid email address!';
						header('Location: login.php');
					}
					
				}
			}
			

			
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
