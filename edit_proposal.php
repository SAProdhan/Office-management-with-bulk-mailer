<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH.'/includes/auth_validate.php';
require_once BASE_PATH . '/lib/Users/Users.php';
$users = new Users();
$suser = $users->CheckifSuperuser();
$id = $users->getId();
$db = getDbInstance();
$db->where ("id", $id);
$admin_data=$db->getOne("admin_accounts");
$proposal_id = filter_input(INPUT_GET, 'proposal_id');
$db->where ("id", $proposal_id);
$proposal=$db->getOne("proposals");
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $data_to_db = array_filter($_POST);
    $temp = $_FILES["files"]["tmp_name"];
    $name = $_FILES["files"]["name"];
    $data = Array(
        'user_name'    => $data_to_db['user_name']
    );
    if(!empty($temp)){
        if (file_exists($proposal['path'])) {
            unlink($proposal['path']);
        }
        $path = "upload/proposal/".basename( $name);
        move_uploaded_file($temp,"upload/proposal/".$name);
        $data = Array(
            'user_name'    => $data_to_db['user_name'],
            'path'    => $path
        );
    }
    $db->where ("id", $proposal_id);
    $result = $db->update('proposals', $data);
    if ($result)
    {
        $_SESSION['success'] = 'Proposal updated successfully!';
        // Redirect to the listing page
        header('Location: proposal.php');
        // Important! Don't execute the rest put the exit/die.
        exit();
    }
    else
    {
        $_SESSION['failure'] = 'Insert failed: !'. $db->getLastError();
        header('Location: edit_proposal.php?proposal_id='.$proposal_id);
        exit();
    }
}
// We are using same form for adding and editing. This is a create form so declare $edit = false.
function path2url($file_path) 
    {
      $file_path=str_replace('\\','/',$file_path);
      $file_path=str_replace(' ', '%20',$file_path);
      $file_path=str_replace($_SERVER['DOCUMENT_ROOT'],'',$file_path);
      $file_path='http://'.$_SERVER['HTTP_HOST'].'/'.$file_path;
      return $file_path;
      // return $Protocol.$_SERVER['HTTP_HOST'].str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath($file));
   }

$path=path2url($proposal['path']);

$string = explode(".", $path); // Split string into an array
$ext = array_pop($string);

$opt_arr = $db->get('admin_accounts');
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
            <h2 class="page-header">Proposal <?php echo htmlspecialchars("for ".$proposal['Company_Name']);?></h2>
            <p>Reference:  <?php echo htmlspecialchars($proposal['reference']);?></p>
        </div>
        <div class="col-lg-12 doc_viewer">
            <?php if($ext == 'pdf'){ ?>
            <iframe src="<?php echo $path; ?>#toolbar=0" width="100%" height="500px">
            </iframe>
            
            <?php
            echo ($suser? '<a href="download.php?proposal_id='.urlencode($proposal["id"]).'">Download</a>' : '');
         }else if($ext == 'doc' || $ext == 'docx'){ ?>
            <iframe src="https://docs.google.com/gview?url=<?php echo $path; ?>&embedded=true" frameborder="0">
            </iframe>
            <?php 
            echo ($suser? '<a href="download.php?proposal_id='.urlencode($proposal["id"]).'">Download</a>' : '');
        }else{ ?>
            <p>File formate not supported!</p>
            <?php } ?>
        </div>
    </div>
    <br>
    <br>
    <br>
    <div class="row">
        <form class="form" method="post" id="proposal_form" enctype="multipart/form-data">
            <fieldset>
                <div class="form-group col-md-12">
                    <label for="reference" class="col-md-3 text-right">Change proposal file:</label>
                    <label class="col-md-9">
                        <input type="file" name="files" value="<?php echo htmlspecialchars($proposal['path'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Add Referance here..." class="form-control" required="required" id="files">
                    </label>
                </div>
                <?php if($suser){?>
                <div class="form-group col-md-12">
                    <label for="user_name" class="col-md-3 text-right">Change User: </label>
                    <label class="col-md-9">
                    <select name="user_name" id="user_name" class="form-control selectpicker" required>
                        <option value="" disable>Please select a user</option>
                        <?php foreach ($opt_arr as $opt) {?>
                            <option value="<?php echo $opt['user_name'];?>" <?php echo $opt['user_name']==$proposal['user_name'] ? "selected": "";?>> <?php echo $opt['user_name'];?></option>
                        <?php }?>
                    </select>
                    </label>
                </div>
                <?php }else{ echo '<input type="hidden" id="user_name" name="user_name" value="'.$admin_data["user_name"].'">';}?>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-warning submit" >Save<i class="glyphicon glyphicon-send"></i></button>
                </div>
            </fieldset>
        </form>
    </div>
    
    <!-- Flash messages -->
    <?php include BASE_PATH.'/includes/flash_messages.php'; ?>
</div>
<script>
    $("#files").change(function () {
        var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'doc', 'docx', 'pdf'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            alert("Only formats are allowed : "+fileExtension.join(', '));
            $(this).val(null);
            return false;
        }
    });
</script>
<?php include BASE_PATH.'/includes/footer.php'; ?>
