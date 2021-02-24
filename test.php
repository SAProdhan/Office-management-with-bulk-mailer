<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';
require_once BASE_PATH . '/lib/Users/Users.php';
date_default_timezone_set('Asia/Dhaka');
//Get DB instance. function is defined in config.php
$users = new Users();
$id = $users->getId();
$tb = $users->getTabledetails();
$db = getDbInstance();
// get admin details
$db->where ("id", $id);
$admin_data=$db->getOne("admin_accounts");
//Get Dashboard information
$numCustomers = $db->getValue ("customers", "count(*)");
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $data_to_db = filter_input_array(INPUT_POST);
    $d=date("Y-m-d ha", strtotime("now"));
    $data = Array(
        'user_id'   => $id,
        'user_name' => $admin_data['user_name'],
        'counter'   => $data_to_db['counter'],
        'timestamp' => $d
    );
    $db->where ("user_id", $id);
    $db->where ("timestamp", $d);
    $tsk = $db->getOne("mailcounter");
    if($tsk){
        $data = Array(
            'user_id' => $id,
            'counter' => ($data_to_db['counter']+$tsk['counter']),
            'timestamp' => $d
        );
        $db->where ("user_id", $id);
        $db->update('mailcounter', $data);
    }else{
        $db->insert('mailcounter', $data);
    }
}
include_once('includes/header.php');
echo((empty($tb))? "No table": "Table"); 
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Dashboard</h1>
            <form class="form form-inline" action="" method="POST">
                <input type="number" name="counter" class="btn btn-primary">
                <input type="submit" value="Go" class="btn btn-primary">
            </form>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<?php include_once('includes/footer.php'); ?>
