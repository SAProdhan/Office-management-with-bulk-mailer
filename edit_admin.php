<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

// Users class
require_once BASE_PATH . '/lib/Users/Users.php';
$users = new Users();
$users->CheckSuperuser();

// User ID for which we are performing operation
$admin_user_id = filter_input(INPUT_GET, 'admin_user_id');
$operation = filter_input(INPUT_GET, 'operation', FILTER_SANITIZE_STRING);
($operation == 'edit') ? $edit = true : $edit = false;
// Select where clause
$db = getDbInstance();
// $db->where('id', $admin_user_id);
// $admin_account = $db->getOne("admin_accounts");

$db->join("user_details u", "p.id=u.id", "LEFT");
$db->where("p.id", $admin_user_id);
$admin_account = $db->getOne ("admin_accounts p");

// Serve POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	// Sanitize input post if we want
	$data_to_db = filter_input_array(INPUT_POST);

	// Check whether the user name already exists
	$db = getDbInstance();
	$db->where('user_name', $data_to_db['user_name']);
	$db->where('id', $admin_user_id, '!=');
	//print_r($data_to_db['user_name']);die();
	$row = $db->getOne('admin_accounts');
	//print_r($data_to_db['user_name']);
	//print_r($row); die();

	if (!empty($row['user_name']) || !empty($row['email']))
	{
		$_SESSION['failure'] = 'Username or Email already exists';
		$query_string = http_build_query(array(
			'admin_user_id' => $admin_user_id,
			'operation' => $operation,
		));
		header('location: edit_admin.php?'.$query_string );
		exit;
	}

	$admin_user_id = filter_input(INPUT_GET, 'admin_user_id', FILTER_VALIDATE_INT);

	// Reset db instance
	$data = Array(
		'user_name'	=> $data_to_db['user_name'],
		'admin_type'=> $data_to_db['admin_type'],
		'email'		=> $data_to_db['email']
	);
	if(!empty($data_to_db['password'])){
		// Encrypting the password
		$data_to_db['password'] = password_hash($data_to_db['password'], PASSWORD_DEFAULT);
		$data['password'] = $data_to_db['password'];
	}
	$db = getDbInstance();
	$db->where('id', $admin_user_id);
	$stat = $db->update('admin_accounts', $data);

	if ($stat)
	{
		$temp = $_FILES["user_img"]["tmp_name"];
		$name = $_FILES["user_img"]["name"];
		$data_user = Array(
			'name' 			=> $data_to_db['name'],
			'designation'	=> $data_to_db['designation'],
			'cell_no'		=> $data_to_db['cell_no'],
		);
		if(!empty($temp))
		{
			if(file_exists($admin_account['path'])) {
				unlink($admin_account['path']);
			}
			$ext = pathinfo($name, PATHINFO_EXTENSION); 
			$path = "upload/user_image/".basename($data_to_db['user_name'].".".$ext);
			$file_status = move_uploaded_file($temp, $path);
			$data_user['path'] = $path;
		}
		$db = getDbInstance();
		$db->where("id", $admin_user_id);
		$user_details = $db->update('user_details', $data_user);
		if($user_details){
			$_SESSION['success'] = 'User updated successfully';
		}
		else{
			$_SESSION['failure'] = 'Failed to update data! Error: '. $db->getLastError();
		}
	} else {
		$_SESSION['failure'] = 'Failed to update Admin user: ' . $db->getLastError();
	}

	header('location: admin_users.php');
	exit;
}


// Set values to $row
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
