<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

// Users class
require_once BASE_PATH . '/lib/Users/Users.php';
$users = new Users();
$users->CheckSuperuser();

$edit = false;
// Create connection
$id = $users->getId();
$db = getDbInstance();
// get admin details
$db->where ("id", $id);
$admin_data=$db->getOne("admin_accounts");




// Serve POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	// Sanitize input post if we want
	$data_to_db = filter_input_array(INPUT_POST);

	// Check whether the user name already exists
	$db = getDbInstance();
	$db->where('user_name', $data_to_db['user_name']);
	$db->get('admin_accounts');
	$db1 = getDbInstance();
	$db1->where('email', $data_to_db['email']);
	$db1->get('admin_accounts');
	$temp = $_FILES["user_img"]["tmp_name"];
	$name = $_FILES["user_img"]["name"];
	if(empty($temp))
    {
        $_SESSION['failure'] = 'Failed to upload File! Error: Empty file';
        header('Location: account.php');
    	exit();
    }
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
	$ext = pathinfo($name, PATHINFO_EXTENSION); 
	$path = "upload/user_image/".basename($data_to_db['user_name'].".".$ext);
	$file_status = move_uploaded_file($temp, $path);
	// Encrypting the password
	$data_to_db['password'] = password_hash($data_to_db['password'], PASSWORD_DEFAULT);
	// Reset db instance
	$data = Array(
		'user_name'	=> $data_to_db['user_name'],
		'password' 	=> $data_to_db['password'],
		'admin_type'=> $data_to_db['admin_type'],
		'email'		=> $data_to_db['email']
	);
	if($file_status){
		$db = getDbInstance();
		$last_id = $db->insert('admin_accounts', $data);
		$db->where('user_name', $data_to_db['user_name']);
		$user = $db->getOne('admin_accounts');
		if ($last_id)
		{
			$data_user = Array(
				'id'			=> $user['id'],
				'name' 			=> $data_to_db['name'],
				'designation'	=> $data_to_db['designation'],
				'cell_no'		=> $data_to_db['cell_no'],
				'path'			=> $path
			);
			$db = getDbInstance();
			$user_details = $db->insert('user_details', $data_user);
			if($user_details){
				$_SESSION['success'] = 'Admin user added successfully';
				header('location: admin_users.php');
				exit;
			}
			else{
				$_SESSION['failure'] = 'Failed to insert data! Error: '. $db->getLastError();
				header('Location: account.php');
				exit();
			}
		}
		else{
			$_SESSION['failure'] = 'Failed to insert data! Error: '. $db->getLastError();
			header('Location: account.php');
			exit();
		}
	}
	else{
		$_SESSION['failure'] = 'Failed to upload File!';
        header('Location: account.php');
    	exit();
	}
	
}
?>
<?php include BASE_PATH . '/includes/header.php'; ?>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h2 class="page-header"><?php echo (!$edit) ? 'Add' : 'Update'; ?> User</h2>
		</div>
	</div>
	<?php include BASE_PATH . '/includes/flash_messages.php'; ?>
	<form class="well form-horizontal" action="" method="post" id="contact_form" enctype="multipart/form-data">
		<?php include BASE_PATH . '/forms/admin_users_form.php'; ?>
	</form>
</div>
<?php include BASE_PATH . '/includes/footer.php'; ?>
