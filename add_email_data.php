<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

// Users class
require_once BASE_PATH . '/lib/Users/Users.php';
$users = new Users();
$users->CheckSuperuser();
$user_id = $users->getId();
$edit = false;

// Serve POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	// Sanitize input post if we want
	$data_to_db = filter_input_array(INPUT_POST);

	// Check whether the email already exists
	$db = getDbInstance();
	$db->where('username', $data_to_db['username']);
	$db->get('email_details');

	if ($db->count >= 1)
	{
		$_SESSION['failure'] = 'Email already exists';
		header('location: add_email_data.php');
		exit;
	}

	$data_to_db['u_id'] = $user_id;
	// Reset db instance
	$db = getDbInstance();
	$last_id = $db->insert('email_details', $data_to_db);

	if ($last_id)
	{
		$_SESSION['success'] = 'Admin user added successfully';
		header('location: mail_list.php');
		exit;
	}
}
?>
<?php include BASE_PATH . '/includes/header.php'; ?>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h2 class="page-header"><?php echo (!$edit) ? 'Add' : 'Update'; ?> Email Data</h2>
		</div>
	</div>
	<?php include BASE_PATH. '/includes/flash_messages.php'; ?>
	<form class="well form-horizontal" action="" method="POST" id="email_form" enctype="multipart/form-data">
		<?php include BASE_PATH . '/forms/email_details_form.php'; ?>
	</form>
</div>
<?php include BASE_PATH . '/includes/footer.php'; ?>
