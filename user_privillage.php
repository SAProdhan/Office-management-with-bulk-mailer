<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';
require_once BASE_PATH . '/lib/Users/Users.php';

// Users class
$users = new Users();
$users->CheckSuperuser();
$id = $users->getId();
$columns = Array();
$mails = Array();
$tables = Array();
$tcl = Array();
$otp_on = false;
$otp_mail = null;
$db = getDbInstance();
$mail_list = $db->get('email_details');
// User ID for which we are performing operation
$admin_user_id = filter_input(INPUT_GET, 'admin_user_id');
// Serve POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	array_push($columns,'');
	array_push($mails,'');
	array_push($tables,'');
	// Sanitize input post if we want
	$data_to_db = filter_input_array(INPUT_POST);
	
	
	if(array_key_exists('mail', $data_to_db)){
		$mails = $data_to_db['mail'];
	}
	if(array_key_exists('table', $data_to_db)){
		$tables = $data_to_db['table'];
		foreach($tables as $table){
			if(array_key_exists($table, $data_to_db)){
			$tcl[$table] = $data_to_db[$table];
			}
		}
	}
	if(array_key_exists('otp_on', $data_to_db)){
		$otp_on = $data_to_db['otp_on'];
	}
	if(array_key_exists('otp_mail', $data_to_db)){
		$otp_mail = $data_to_db['otp_mail'];
	}
		
	$data= Array(
		'id'=>$admin_user_id,
		'admin_id'=>$id,
		'tables_columns' => json_encode($tcl),
		'email_id' => json_encode($mails),
		'otp_on' => $otp_on,
		'otp_mail' => $otp_mail,
	);
	$db->where ("id", $admin_user_id);
	$db->getOne ("user_privillage");
	if($db->count >= 1){
		unset($data["id"]);
		$db->where ('id', $admin_user_id);
		$userdata = $db->update ('user_privillage', $data);
		if($userdata){
			$_SESSION['success'] = 'User privilege Updated!';
		}
		else{
			$_SESSION['failure'] = 'Error! '. $db->getLastError();
		}
	}
	else{
		$userdata = $db->insert('user_privillage', $data);
		if($userdata){
			$_SESSION['success'] = 'User privilege saved!';
		}
		else{
			$_SESSION['failure'] = 'Error! '. $db->getLastError();
		}
	}
	
	// $columns = $columns;
	// $mails   = $mails;
	// $tables  = $tables;
	// header('location: admin_users.php');
	// exit;
}
$db = getDbInstance();
$table_column_list = $db->get("table_details");
// Select where clause
$db = getDbInstance();
$db->where('id', $admin_user_id);
$admin_account = $db->getOne("admin_accounts");

$db->where('id', $admin_user_id);
$userprivillage = $db->getOne("user_privillage");
if($userprivillage){
	$otp_on = $userprivillage['otp_on'];
	$otp_mail = $userprivillage['otp_mail'];
	$tcl = json_decode($userprivillage['tables_columns'], true);
	$mails   = json_decode($userprivillage['email_id']);
	$tables  = array_keys($tcl);
	foreach($tcl as $table){
		if(count($table)>0){
			foreach($table as $col){
				array_push($columns, $col);
			}
		}
	}

}
// Set values to $row
?>
<?php include BASE_PATH . '/includes/header.php'; ?>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h2 class="page-header">Set User Privilege</h2>
		</div>
	</div>
	<?php include BASE_PATH . '/includes/flash_messages.php'; ?>
	<form class="well form-horizontal" action="" method="post" id="contact_form" enctype="multipart/form-data">
		<?php include BASE_PATH . '/forms/user_privillage_form.php'; ?>
	</form>
</div>
<?php include BASE_PATH . '/includes/footer.php'; ?>
