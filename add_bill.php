<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH.'/includes/auth_validate.php';
require_once BASE_PATH . '/lib/Users/Users.php';
require "mailer/PHPMailer/PHPMailerAutoload.php";

$users = new Users();
$suser = $users->CheckAdmin();
$id = $users->getId();
$db = getDbInstance();
$db->where ("id", $id);
$admin_data=$db->getOne("admin_accounts");
// Serve POST method, After successful insert, redirect to customers.php page.
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $data_to_db = array_filter($_POST);
    $db = getDbInstance();
    $x = $db->getValue ("accounts", "max(id)");
    // unset($data_to_db['mail_body']);
    $temp = $_FILES["path"]["tmp_name"];
    $name = $_FILES["path"]["name"];
    if(empty($temp))
    {
        $_SESSION['failure'] = 'Failed to upload File!';
        header('Location: account.php');
    	exit();
    }
    else{
        $ext = pathinfo($name, PATHINFO_EXTENSION); 
        $path = "upload/workorder/".basename( ($x+1)."_".$data_to_db['Company_Name'].".".$ext);
        move_uploaded_file($temp, $path);
        $data = Array(
            'Company_Name'          => $data_to_db['Company_Name'],
            'ContactPerson'         => $data_to_db['ContactPerson'],
            'MobileNo'              => $data_to_db['MobileNo'],
            'work_order_date'       => $data_to_db['work_order_date'],
            'bill_submission_date'  => isset($data_to_db['bill_submission_date'])? $data_to_db['bill_submission_date'] : "Not submited",
            'total'                 => $data_to_db['total'],
            'due'                   => $data_to_db['total'],
            'file'                  => $path
        );
        $result = $db->insert('accounts', $data);
        if ($result)
        {
            $_SESSION['success'] = 'Workorder save successfully!';
            // Redirect to the listing page
            header('Location: account.php');
            // Important! Don't execute the rest put the exit/die.
            exit();
        }
        else
        {
            $_SESSION['failure'] = 'Insert failed: !'. $db->getLastError();
            header('Location: account.php');
            exit();
        }
    }
    $_SESSION['failure'] = 'Error!';
    header('Location: account.php');
	exit();
}

// We are using same form for adding and editing. This is a create form so declare $edit = false.
$edit = false;
?>
<?php include BASE_PATH.'/includes/header.php'; ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Add Account Details</h2>
        </div>
    </div>
    <!-- Flash messages -->
    <?php include BASE_PATH.'/includes/flash_messages.php'; ?>
    <form class="form" method="post" id="account_form" enctype="multipart/form-data">
        <?php include BASE_PATH.'/forms/account_details_form.php'; ?>
    </form>
</div>
<?php include BASE_PATH.'/includes/footer.php'; ?>
