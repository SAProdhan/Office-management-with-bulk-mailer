<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';
require_once BASE_PATH . '/lib/Users/Users.php';

// Users class
$users = new Users();
$users->CheckSuperuser();
$id = $users->getId();
// Create connection
$db = getDbInstance();

// get admin details
$db->where ("id", $id);
$admin_data=$db->getOne("admin_accounts");

//get user demailes
$task_id = filter_input(INPUT_GET, 'task_id');
$username = filter_input(INPUT_GET, 'username');
// $db->where ("id", $user_id);
// $user_data=$db->getOne ("admin_accounts");

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $data_to_db = filter_input_array(INPUT_POST);
    if($data_to_db['start_no'] > $data_to_db['ending_no']){
        $_SESSION['failure'] = 'Error! Start No can not be geater then ending no.';
        header('location: user_tasks.php');
        exit;
    }
    $data= Array(
		'tables' => $data_to_db['table'],
		'start_no' => $data_to_db['start_no'],
		'end_no' => $data_to_db['ending_no'],
        'assign_by' => $admin_data['user_name'],
        'assign_at' => $data_to_db['assign_date'],
    );
    $db->where('id', $task_id);
    $task = $db->update('tasks', $data);
    if($task){
        $_SESSION['success'] = 'User task Updated!';
    }
    else{
        $_SESSION['failure'] = 'Error! '. $db->getLastError();
    }

}
$table_column_list = $db->get("table_details");
$db->where('id', $task_id);
$tasks = $db->getOne('tasks');
?>
<?php include BASE_PATH . '/includes/header.php'; ?>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h2 class="page-header">Assign Task To <?php echo $username;?></h2>
		</div>
	</div>
	<?php include BASE_PATH . '/includes/flash_messages.php'; ?>
	<form class="well form-horizontal" action="" method="post" id="task_form" enctype="multipart/form-data">
		<?php include BASE_PATH . '/forms/edit_task_form.php'; ?>
	</form>
</div>
<?php include BASE_PATH . '/includes/footer.php'; ?>