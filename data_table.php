<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

// Users class
require_once BASE_PATH . '/lib/Users/Users.php';
$users = new Users();
$id = $users->getId();

$db = getDbInstance();
$db->where('id', $id);
$userprivillage = $db->getOne("user_privillage");
$columns = Array();
$col = Array();
$mails = Array();
$tables = Array();
$table_columns = Array();
$db = getDbInstance();
$tcl = $db->getOne("table_details");

if($userprivillage){
    if($userprivillage['tables'][0] == ""){
       
        $table_columns = array_push_assoc($table_columns, 'table', Array());
    }
	$col = json_decode($userprivillage['columns']);
	$mails   = json_decode($userprivillage['email_id']);
    $tables  = json_decode($userprivillage['tables']);
}
if(count($tables)>0){

}



// Get Input data from query string
// $del_id		= filter_input(INPUT_GET, 'del_id');
// $order_by	= filter_input(INPUT_GET, 'order_by');
// $order_dir	= filter_input(INPUT_GET, 'order_dir');
// $search_str	= filter_input(INPUT_GET, 'search_str');

// Per page limit for pagination
// $pagelimit = 25;

// Get current page
// $page = filter_input(INPUT_GET, 'page');
// if (!$page) {
// 	$page = 1;
// }

// // If filter types are not selected we show latest added data first
// if (!$order_by) {
// 	$order_by = 'id';
// }
// if (!$order_dir) {
// 	$order_dir = 'Desc';
// }

// Get DB instance. i.e instance of MYSQLiDB Library
$db = getDbInstance();
// $select = array('id', 'usernmae', 'smtp_host', 'smtp_port');

// Start building query according to input parameters
// If search string
// if ($search_str) {
// 	$db->where('Company_Name', '%' . $search_str . '%', 'like');
// }
// If order direction option selected
// if ($order_dir) {
// 	$db->orderBy($order_by, $order_dir);
// }

// Set pagination limit
// $db->pageLimit = $pagelimit;

// Get result of the query
$rows = $db->arraybuilder()->get('paxzone_client_master');
// $total_pages = $db->totalPages;
?>
<?php include BASE_PATH . '/includes/header.php'; ?>
<!-- Main container -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header">Email Table</h1>
        </div>
        <div class="col-lg-6">
            <div class="page-action-links text-right">
                <a href="add_email_data.php" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Add new</a>
            </div>
        </div>
    </div>
    <?php include BASE_PATH . '/includes/flash_messages.php'; ?>

    <?php
    if (isset($del_stat) && $del_stat == 1)
    {
        echo '<div class="alert alert-info">Successfully deleted</div>';
    }
    ?>
    
    <!-- Filters -->
    <hr>
    <!-- //Filters -->

    <!-- Table -->
    <table class="table table-striped table-bordered nowrap" id="mytable">
        <thead>
            <tr>
                <th width="5%">No.</th>
                <th width="10%">Company Name</th>
                <th width="5%">Company Address</th>
                <th width="5%">Contact Person</th>
                <th width="5%">Designation</th>
                <th width="10%">MobileNo</th>
                <th width="10%">Email Address</th>
                <th width="5%">ITManager</th>
                <th width="10%">ContactNo</th>
                <th width="10%">Email Address_IT</th>
                <th width="5%">Zone</th>
                <th width="10%">Remarks</th>
                <th width="5%">Status</th>
                <th width="5%">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['Company_Name']); ?></td>
                <td><?php echo htmlspecialchars($row['CompanyAddress']);?></td>
                <td><?php echo htmlspecialchars($row['ContactPerson']);?></td>
                <td><?php echo htmlspecialchars($row['Designation']);?></td>
                <td><?php echo htmlspecialchars($row['MobileNo']);?></td>
                <td><?php echo htmlspecialchars($row['EmailAddress']);?></td>
                <td><?php echo htmlspecialchars($row['ITManager']);?></td>
                <td><?php echo htmlspecialchars($row['ContactNo']);?></td>
                <td><?php echo htmlspecialchars($row['EmailAddress_IT']);?></td>
                <td><?php echo htmlspecialchars($row['Zone']);?></td>
                <td><?php echo htmlspecialchars($row['Remarks']);?></td>
                <td><?php echo htmlspecialchars($row['Status']);?></td>
                <td>
                    <a href="edit_mail_data.php?id=<?php echo $row['id']; ?>&operation=edit" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
                    <a href="#" class="btn btn-danger delete_btn" data-toggle="modal" data-target="#confirm-delete-<?php echo $row['id']; ?>"><i class="glyphicon glyphicon-trash"></i></a>
                </td>
            </tr>
            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="confirm-delete-<?php echo $row['id']; ?>" role="dialog">
                <div class="modal-dialog">
                    <form action="delete_email.php" method="POST">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Confirm</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="del_id" id="del_id" value="<?php echo $row['id']; ?>">
                                <p>Are you sure you want to delete this row?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default pull-left">Yes</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- //Delete Confirmation Modal -->
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- //Table -->

    <!-- Pagination -->
    <div class="text-center">
        <?php 
        // echo paginationLinks($page, $total_pages, 'data_table.php'); 
        ?>
    </div>
    <!-- //Pagination -->
</div>
<!-- //Main container -->
<?php include BASE_PATH . '/includes/footer.php'; ?>
