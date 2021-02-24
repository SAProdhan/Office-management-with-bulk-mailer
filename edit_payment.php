<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH.'/includes/auth_validate.php';
require_once BASE_PATH . '/lib/Users/Users.php';

$users = new Users();
$suser = $users->CheckAdmin();
$id = $users->getId();

$db = getDbInstance();
$db->where("id", $id);
$admin_data=$db->getOne("admin_accounts");

$payment_id = filter_input(INPUT_GET, 'payment_id');
$account_id = filter_input(INPUT_GET, 'account_id');

$db->where("id", $account_id);
$account_details=$db->getOne("accounts");

$db->where("id", $payment_id);
$payment_details=$db->getOne("payment_details");

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{

    $data_to_db = array_filter($_POST);
    $data_to_db['account_id'] = $account_id;

    $data = Array(
        'due' => ($account_details['due']+($payment_details['amount']-$data_to_db['amount']))
    );
    $db->where("id", $account_id);
    $db->update('accounts', $data);
    $db->where("id", $payment_id);
    $result = $db->update('payment_details', $data_to_db);
    if ($result)
    {
        $_SESSION['success'] = 'Payment updated successfully!';
        header("Location: payment_details.php?account_id=".$account_id);
        exit();
    }
    else
    {
        $_SESSION['failure'] = 'Payment failed: !'. $db->getLastError();
        header("Location: payment_details.php?account_id=". $account_id);
        exit();
    }
}
$db = getDbInstance();
$opt_arr = $db->get('admin_accounts');
// We are using same form for adding and editing. This is a create form so declare $edit = false.
$edit = false;
?>
<?php include BASE_PATH.'/includes/header.php'; ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Payment</h2>
        </div>
    </div>
    <!-- Flash messages -->
    <?php include BASE_PATH.'/includes/flash_messages.php'; ?>
    <form class="form" method="post" id="payment_form" enctype="multipart/form-data">
        <fieldset>        
            <?php include BASE_PATH.'/forms/payment_form.php'; ?>
            <div class="form-group col-md-12 text-center">
                <label></label>
                <button type="submit" class="btn btn-warning submit" >Edit Payment<i class="glyphicon glyphicon-send"></i></button>
            </div>
        </fieldset>
    </form>
</div>

<?php include BASE_PATH.'/includes/footer.php'; ?>
<script type="text/javascript">
    $(document).ready(function(){
        if($('#method').val() == 'Cheque'){
            $('#cheque_details').show();
            $('#cheque_no').attr('required', true);  
            $('#bank').attr('required', true);  
        }else{
            $('#cheque_no').attr('required', false);  
            $('#bank').attr('required', false); 
            $('#cheque_details').hide();
        }
        $('#method').on('change', function() {
            if(this.value == 'Cheque'){
                $('#cheque_details').show();
                $('#cheque_no').attr('required', true);  
                $('#bank').attr('required', true);  
            }else{
                $('#cheque_no').attr('required', false);  
                $('#bank').attr('required', false); 
                $('#cheque_details').hide();
            }
        }); 
    });
</script>