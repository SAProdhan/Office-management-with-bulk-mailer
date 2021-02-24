<?php
session_start();
require "signature_creator.php";
require_once BASE_PATH . '/lib/Users/Users.php';
require "mailer/PHPMailer/PHPMailerAutoload.php";

function smtpmailer($to, $subject, $msg, $sender, $acc)
{
    $db = getDbInstance();
    $db->where("username", $sender);
    $mail_details = $db->getOne("email_details");
    if(!$mail_details){
        return $db->getLastError();
    }
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true; 
    $mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
        )
    );
    $mail->SMTPSecure = 'ssl'; 
    $mail->Host = $mail_details['smtp_host'];
    $mail->Port = $mail_details['smtp_port'];  
    $mail->Username = $mail_details['username'];
    $mail->Password = $mail_details['password'];
    if(isset($acc)){
        $mail->AddCC($acc);
    }
    for($i=0;$i<count($_FILES["files"]["name"]);$i++)
    {
        $mail->AddAttachment($_FILES["files"]["tmp_name"][$i], $_FILES["files"]["name"][$i]);
    }
    $mail->From=$mail_details['username'];
    $mail->FromName=$mail_details['from_name'];
    $mail->Subject = $subject;
    $mail->IsHTML(true);
    $mail->Body = $msg;
    $mail->AddAddress($to);
    if($mail->Send())
    {
        return true; 
    }
    return $mail->ErrorInfo;     
}
$users = new Users();
$suser = $users->CheckifSuperuser();
$id = $users->getId();
$mails = $users->getEmails();
$db = getDbInstance();
$db->where ("id", $id);
$admin_data=$db->getOne("admin_accounts");
$signature = CreateSignature($id);
// Serve POST method, After successful insert, redirect to customers.php page.
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    date_default_timezone_set('Asia/Dhaka');
    $d=date("Y-m-d h:m:sa", strtotime("now"));
    $data_to_db = array_filter($_POST);
    $db = getDbInstance();
    $db->where ("EmailAddress", $data_to_db['email']);
    $db->orWhere ("EmailAddress_IT", $data_to_db['email']);
    $client_data=$db->getOne("paxzone_client_master");
    // unset($data_to_db['mail_body']);
    $temp = $_FILES["files"]["tmp_name"][0];
    $name = $_FILES["files"]["name"][0];
    if(empty($temp))
    {
        $_SESSION['failure'] = 'Failed to upload proposal!';
        header('Location: proposal.php');
    	exit();
    }
    else{ 
        $ext = pathinfo($name, PATHINFO_EXTENSION); 
        $path = "upload/proposal/".basename($data_to_db['reference'].".".$ext);
        // move_uploaded_file($temp,"upload/proposal/".$name);
        $data = Array(
            'create_at'    => $d,
            'Company_Name' => isset($client_data['Company_Name'])? $client_data['Company_Name'] : " ",
            'ContactPerson'=> isset($client_data['ContactPerson'])? $client_data['ContactPerson'] : " ",
            'MobileNo'     => isset($client_data['MobileNo'])? $client_data['MobileNo'] : " ",
            'EmailAddress' => $data_to_db['email'],
            'reference'    => $data_to_db['reference'],
            'user_name'    => $data_to_db['user_name'],
            'path'         => $path
        );
        $result = $db->insert('proposals', $data);
        // $result = true;
        if ($result)
        {
            $body = $data_to_db['mail_body'].'<div>'.$data_to_db['signature'].'</div>';
            $mailStatus = smtpmailer($data_to_db['email'], $data_to_db['sub'], $body, $data_to_db['Sender'], $data_to_db['acc']);
            move_uploaded_file($temp, $path);
            if($mailStatus == true){
                $_SESSION['success'] = 'Proposal sent successfully!';
                // Redirect to the listing page
                header('Location: proposal.php');
                // Important! Don't execute the rest put the exit/die.
                exit();
            }
            else{
                $_SESSION['failure'] = 'Proposal not sent ! Error: '. $mailStatus;
                header('Location: proposal.php');
                exit();
            }
        }
        else
        {
            $_SESSION['failure'] = 'Insert failed: !'. $db->getLastError();
            header('Location: proposal.php');
            exit();
        }
    }
    $_SESSION['failure'] = 'Error!';
    header('Location: proposal.php');
	exit();
}
$db = getDbInstance();
$opt_arr = $db->get('admin_accounts');
// We are using same form for adding and editing. This is a create form so declare $edit = false.
$edit = false;
?>
<?php include BASE_PATH.'/includes/header.php'; ?>
<style>
	/* body{ font-family:sans-serif; } */
    #file_table>thead>tr>th {
        border: 1px dashed black;
        padding: 2px;
        border-collapse: collapse;
	}
    #file_table>tbody>tr>td {
        border: 1px dashed black;
        padding: 2px;
        border-collapse: collapse;
	}
</style>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Add Proposal</h2>
        </div>
    </div>
    <!-- Flash messages -->
    <?php include BASE_PATH.'/includes/flash_messages.php'; ?>
    <form class="form" method="post" id="proposal_form" enctype="multipart/form-data">
        <?php include BASE_PATH.'/forms/proposal_form.php'; ?>
    </form>
</div>
<script type="text/javascript">
    function fetch_data(un)  
    {   
        if(un==''){
            alert("Select an user!");  
            return false;
        }
        $.ajax({  
            url:"request_signature.php",  
            method:"POST",
            data:{un:un},  
            success:function(data){ 
                $('#signature').html(data);
            }  
        });  
    }
    var signature = '<?php echo $signature; ?>';
    $(document).ready(function(){
    // Validation
        $('#signature').html(signature);
        var editor = $("#txtEditor").Editor();

        $('#user_name').on('change', function() {
            var id = this.value;
            fetch_data(id);  
        }); 
        $('.submit').click(function(){
            var file_val = $('.file').val();
            var mail_body = $('#txtEditor').Editor("getText");
            var signature = $('#signature').html();
            if(file_val == "")
            {
                alert("Please Attached at least one file.");
                return false;
            }
            else if(mail_body == ""){
                alert("Mail body empty!");
                return false;
            }
            else if($('#user_name') == "" && signature == ""){
                alert("Select a user!");
                return false;
            }
            else if($('#reference') == ""){
                alert("Enter reference no!");
                return false;
            }
            else{
                $('#mail_body').val(mail_body);
                $('#signature_field').val(signature);
                // $('#proposal_form').attr('action', '');
                $('#proposal_form').submit();
            }
            });
                    
        // Append new row
        $('#file_table').on('click', "#add", function(e) {
            $('#file_table tbody').append('<tr class="add_row"><td>#</td><td><input name="files[]" type="file" multiple /></td><td class="text-center"><button type="button" class="btn btn-danger btn-sm" id="delete" title="Delete file">Delete file</button></td><tr>');
            e.preventDefault();
        });
                    
        // Delete row
        $('#file_table').on('click', "#delete", function(e) {
            if (!confirm("Are you sure you want to delete this file?"))
            return false;
            $(this).closest('tr').remove();
            e.preventDefault();
        });
    });
</script>
<?php include BASE_PATH.'/includes/footer.php'; ?>
