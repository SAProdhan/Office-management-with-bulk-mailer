<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';
require_once BASE_PATH . '/lib/Users/Users.php';
$users = new Users();
$users->CheckAdmin();

// Get Input data from query string
$del_id		= filter_input(INPUT_GET, 'del_id');
$order_by	= filter_input(INPUT_GET, 'order_by');
$order_dir	= filter_input(INPUT_GET, 'order_dir');
$search_str	= filter_input(INPUT_GET, 'search_str');

// Per page limit for pagination
$pagelimit = 15;

// Get current page
$page = filter_input(INPUT_GET, 'page');
if (!$page) {
	$page = 1;
}

// If filter types are not selected we show latest added data first
if (!$order_by) {
	$order_by = 'id';
}
if (!$order_dir) {
	$order_dir = 'Desc';
}

// Get DB instance. i.e instance of MYSQLiDB Library
$db = getDbInstance();
$select = array('id', 'Company_Name', 'ContactPerson', 'MobileNo', 'work_order_date', 'bill_submission_date', 'total', 'due', 'file');

// Start building query according to input parameters
// If search string
if ($search_str) {
	$db->where($order_by, '%' . $search_str . '%', 'like');
}
// If order direction option selected
if ($order_dir) {
	$db->orderBy($order_by, $order_dir);
}

// Set pagination limit
$db->pageLimit = $pagelimit;

// Get result of the query
$rows = $db->arraybuilder()->paginate('accounts', $page, $select);
$total_pages = $db->totalPages;

?>
<?php include BASE_PATH . '/includes/header.php'; ?>
<!-- Main container -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header">Account details</h1>
        </div>
        <div class="col-lg-6">
            <div class="page-action-links text-right">
                <a href="add_bill.php" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Add new</a>
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
    <div class="well text-center filter-form">
        <form class="form form-inline" action="">
            <label for="input_search">Search</label>
            <input type="text" class="form-control" id="input_search" name="search_str" value="<?php echo htmlspecialchars($search_str, ENT_QUOTES, 'UTF-8'); ?>">
            <label for="input_order">Filter By</label>
            <select name="order_by" class="form-control" id="order_by">
                <option value="Company_Name" <?php echo($order_by=='Company_Name' ? "selected" : ""); ?>>Company Name</option>
                <option value="work_order_date" <?php echo($order_by=='work_order_date' ? "selected" : ""); ?>>Work Order</option>
                <option value="bill_submission_date" <?php echo($order_by=='bill_submission_date' ? "selected" : ""); ?>>Bill Submission</option>
            </select>
            <select name="order_dir" class="form-control" id="input_order">
                <option value="Asc" <?php
if ($order_dir == 'Asc') {
	echo 'selected';
}
?> >Asc</option>
                <option value="Desc" <?php
if ($order_dir == 'Desc') {
	echo 'selected';
}
?>>Desc</option>
            </select>
            <input type="submit" value="Go" class="btn btn-primary">
        </form>
    </div>
    <hr>
    <!-- //Filters -->
    
    <!-- Table -->
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th width="20%">Company Name</th>
                <th width="10%">Contact Person</th>
                <th width="10%">Contact No</th>
                <th width="10%">Work Order</th>
                <th width="10%">Bill Submission</th>
                <th width="10%">Total</th>
                <th width="10%">Due</th>
                <th width="10%">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['Company_Name']); ?></td>
                <td><?php echo htmlspecialchars($row['ContactPerson']); ?></td>
                <td><?php echo htmlspecialchars($row['MobileNo']); ?></td>
                <td><?php echo htmlspecialchars($row['work_order_date']);?></td>
                <td><?php echo htmlspecialchars($row['bill_submission_date']);?></td>
                <td><?php echo htmlspecialchars($row['total']);?></td>
                <td><?php echo htmlspecialchars($row['due']);?></td>
                <td>
                    <a href="edit_bill.php?account_id=<?php echo $row['id']; ?>&operation=edit" class="btn btn-primary" title="Click here to Edit"><i class="glyphicon glyphicon-edit"></i></a>
                    <a href="#" class="btn btn-danger delete_btn" data-toggle="modal" data-target="#confirm-delete-<?php echo $row['id']; ?>" title="Delete"><i class="glyphicon glyphicon-trash"></i></a>
                    <a href="payment_details.php?account_id=<?php echo $row['id']; ?>" class="btn btn-primary otp_btn" title="Payment details"><i class="fa fa-money" ></i></a>
                </td>
            </tr>
            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="confirm-delete-<?php echo $row['id']; ?>" role="dialog">
                <div class="modal-dialog">
                    <form action="delete_account.php" method="POST">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Confirm</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="del_id" id="del_id" value="<?php echo $row['id']; ?>">
                                <p>Are you sure you want to delete this workorder?</p>
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
    	<?php echo paginationLinks($page, $total_pages, 'admin_users.php'); ?>
    </div>
    <!-- //Pagination -->
</div>
<!-- //Main container -->
<?php include BASE_PATH . '/includes/footer.php'; ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#order_by').on('change', function() {
            if(this.value == 'work_order_date' || this.value == 'bill_submission_date'){
                $('#input_search').attr("type", 'date');
            }else{
               $('#input_search').attr("type", 'text');
            }
        }); 
    });
</script>