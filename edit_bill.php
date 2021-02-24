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

$account_id = filter_input(INPUT_GET, 'account_id');
$operation = filter_input(INPUT_GET, 'operation', FILTER_SANITIZE_STRING);
($operation == 'edit') ? $edit = true : $edit = false;

$db->where("id", $account_id);
$account_details = $db->getone('accounts');
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $data_to_db = array_filter($_POST);
    $db = getDbInstance();
    $data = Array(
        'Company_Name'          => $data_to_db['Company_Name'],
        'ContactPerson'         => $data_to_db['ContactPerson'],
        'MobileNo'              => $data_to_db['MobileNo'],
        'work_order_date'       => $data_to_db['work_order_date'],
        'bill_submission_date'  => isset($data_to_db['bill_submission_date'])? $data_to_db['bill_submission_date'] : "Not submited",
        'total'                 => $data_to_db['total']
    );
    $total = $account_details['total'];
    if($total != $data_to_db['total']){
        $data['due'] = ($account_details['due']+($data_to_db['total']-$total));
    }
    $temp = $_FILES["path"]["tmp_name"];
    $name = $_FILES["path"]["name"];
    if(!empty($temp))
    {
        if(file_exists($account_details['file'])) {
            unlink($account_details['file']);
        }
        $ext = pathinfo($name, PATHINFO_EXTENSION); 
        $path = "upload/workorder/".basename( ($account_id)."_".$data_to_db['Company_Name'].".".$ext);
        move_uploaded_file($temp, $path);
        $data['file'] = $path;
    }
    
    $db->where("id", $account_id);
    $result = $db->update('accounts', $data);
    if ($result)
    {
        $_SESSION['success'] = 'Workorder updated successfully!';
        // Redirect to the listing page
        header('Location: account.php');
        // Important! Don't execute the rest put the exit/die.
        exit();
    }
    else
    {
        $_SESSION['failure'] = 'Update failed: !'. $db->getLastError();
        header('Location: account.php');
        exit();
    }
    $_SESSION['failure'] = 'Error!';
    header('Location: account.php');
	exit();
}


function path2url($file_path) 
    {
      $file_path=str_replace('\\','/',$file_path);
      $file_path=str_replace(' ', '%20',$file_path);
      $file_path=str_replace($_SERVER['DOCUMENT_ROOT'],'',$file_path);
      $file_path='http://'.$_SERVER['HTTP_HOST'].'/'.$file_path;
      return $file_path;
      // return $Protocol.$_SERVER['HTTP_HOST'].str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath($file));
   }

$path=path2url($account_details['file']);
$string = explode(".", $path); // Split string into an array
$ext = strtolower(array_pop($string));
$img_ext = Array('jpg','jpe','jpeg','png','gif');
// $img_ext = Array('jpg','jpe','jpeg','jfif','png','bmp','dib','gif');
// We are using same form for adding and editing. This is a create form so declare $edit = false.
?>
<?php include BASE_PATH.'/includes/header.php'; ?>
<style>
	/* body{ font-family:sans-serif; } */
    .doc_viewer{
        height: 500px;
    }
    iframe {
        width: 100%;
        height: 100%;
        padding: 0;
        margin: 0;
    }
</style>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Edit Account Details</h2>
        </div>
    </div>
    <!-- Flash messages -->
    <?php include BASE_PATH.'/includes/flash_messages.php'; ?>
    <div class="row">
        <div class="col-lg-12 doc_viewer">
            <?php if($ext == 'pdf'){ ?>
            <iframe src="<?php echo $path; ?>#toolbar=0" width="100%" height="500px">
            </iframe>
            
            <?php
            echo ($suser? '<a href="download.php?account_id='.urlencode($account_details["id"]).'">Download</a>' : '');
            }else if($ext == 'doc' || $ext == 'docx'){ ?>
            <iframe src="https://docs.google.com/gview?url=<?php echo $path; ?>&embedded=true" frameborder="0">
            </iframe>
            <?php 
            echo ($suser? '<a href="download.php?account_id='.urlencode($account_details["id"]).'">Download</a>' : '');
        }else{ ?>
            <p>File formate not supported!</p>
            <?php } ?>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <form class="form" method="post" id="account_form" enctype="multipart/form-data">
        <?php include BASE_PATH.'/forms/account_details_form.php'; ?>
    </form>
</div>
<?php include BASE_PATH.'/includes/footer.php'; ?>
