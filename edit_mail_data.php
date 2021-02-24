<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

// Users class
require_once BASE_PATH . '/lib/Users/Users.php';
$users = new Users();
$users->CheckSuperuser();
$user_id = $users->getId();
// User ID for which we are performing operation
$data_id = filter_input(INPUT_GET, 'id');
$operation = filter_input(INPUT_GET, 'operation', FILTER_SANITIZE_STRING);
($operation == 'edit') ? $edit = true : $edit = false;

// Serve POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	// Sanitize input post if we want
	$data_to_db = filter_input_array(INPUT_POST);

	// Check whether the user name already exists
	$db = getDbInstance();
	$db->where('username', $data_to_db['username']);
	$db->where('id', $data_id, '!=');
	//print_r($data_to_db['user_name']);die();
	$row = $db->getOne('email_details');
	//print_r($data_to_db['user_name']);
	//print_r($row); die();

	if (!empty($row['username']))
	{
		$_SESSION['failure'] = 'Username already exists';
		$query_string = http_build_query(array(
			'admin_user_id' => $data_id,
			'operation' => $operation,
		));
		header('location: edit_admin.php?'.$query_string );
		exit;
	}

	$data_id = filter_input(INPUT_GET, 'data_id', FILTER_VALIDATE_INT);

	// Reset db instance
	$db = getDbInstance();
	$db->where('id', $data_id);
	$stat = $db->update('email_details', $data_to_db);

	if ($stat)
	{
        $_SESSION['success'] = 'Email data has been updated successfully';
        
	} else {
        $_SESSION['failure'] = 'Failed to update Email Data: ' . $db->getLastError();
        header('location: edit_mail_data.php');
	    exit;
	}

	header('location: mail_list.php');
	exit;
}

// Select where clause
$db = getDbInstance();
$db->where('id', $data_id);

$email_account = $db->getOne("email_details");

// Set values to $row
?>
<?php include BASE_PATH . '/includes/header.php'; ?>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h2 class="page-header"><?php echo (!$edit) ? 'Add' : 'Update'; ?> Email Data</h2>
		</div>
	</div>
	<?php include BASE_PATH . '/includes/flash_messages.php'; ?>
	<form class="well form-horizontal" action="" method="post" id="contact_form" enctype="multipart/form-data">
		<?php include BASE_PATH . '/forms/email_details_form.php'; ?>
	</form>
</div>
<?php include BASE_PATH . '/includes/footer.php'; ?>
