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
$user_id = filter_input(INPUT_GET, 'admin_user_id');
$db->where ("id", $user_id);
$user_data=$db->getOne ("admin_accounts");

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $data_to_db = filter_input_array(INPUT_POST);
    if($data_to_db['start_no'] > $data_to_db['ending_no']){
        $_SESSION['failure'] = 'Error! Start No can not be geater then ending no.';
        header('location: assign_tasks.php?admin_user_id='.$user_id);
        exit;
    }
    $data= Array(
		'user_id'=>$user_id,
		'username'=>$user_data['user_name'],
		'tables' => $data_to_db['table'],
		'start_no' => $data_to_db['start_no'],
		'end_no' => $data_to_db['ending_no'],
		'assign_by' => $admin_data['user_name'],
		'assign_at' => $data_to_db['assign_date'],
    );
    $task = $db->insert('tasks', $data);
    if($task){
        $_SESSION['success'] = 'User task assigned!';
    }
    else{
        $_SESSION['failure'] = 'Error! '. $db->getLastError();
    }

}
$table_column_list = $db->get("table_details");
?>
<?php include BASE_PATH . '/includes/header.php'; ?>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h2 class="page-header">Assign Task To <?php echo $user_data['user_name'];?></h2>
		</div>
	</div>
	<?php include BASE_PATH . '/includes/flash_messages.php'; ?>
	<form class="well form-horizontal" action="" method="post" id="task_form" enctype="multipart/form-data">
		<?php include BASE_PATH . '/forms/assign_tasks_form.php'; ?>
	</form>
</div>
<?php include BASE_PATH . '/includes/footer.php'; ?>