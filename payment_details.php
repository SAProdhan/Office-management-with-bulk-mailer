<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';
require_once BASE_PATH . '/lib/Users/Users.php';
$users = new Users();
$users->CheckAdmin();

$account_id = filter_input(INPUT_GET, 'account_id');
$db = getDbInstance();
$db->where("id", $account_id);
$account_details = $db->getone('accounts');
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
$db->where("account_id", $account_id);
$select = array('id', 'account_id', 'method', 'cheque_no', 'bank', 'amount', 'date');

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
$rows = $db->arraybuilder()->paginate('payment_details', $page, $select);
$total_pages = $db->totalPages;

?>
<?php include BASE_PATH . '/includes/header.php'; ?>
<!-- Main container -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h3 class="page-header">Payment details of <strong><?php echo $account_details['Company_Name']?></strong></h3>
        </div>
        <div class="col-lg-6">
            <div class="page-action-links text-right">
                <a href="add_payment.php?account_id=<?php echo $account_details['id']; ?>" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Add new</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <h5 class="page-header">Total amount: <strong><?php echo $account_details['total']?></strong></h5>
        </div>
        <div class="col-lg-6">
            <h5 class="page-header">Due amount: <strong><?php echo $account_details['due']?></strong></h5>
        </div>
    </div>
    <?php include BASE_PATH . '/includes/flash_messages.php'; ?>
    <!-- Filters -->
    <div class="well text-center filter-form">
        <form class="form form-inline" action="">
            <input type="hidden" name="account_id" value="<?php echo $account_details['id']?>">
            <label for="input_search">Search</label>
            <input type="text" class="form-control" id="input_search" name="search_str" value="<?php echo htmlspecialchars($search_str, ENT_QUOTES, 'UTF-8'); ?>">
            <label for="input_order">Filter By</label>
            <select name="order_by" id="order_by" class="form-control">
                <option value="cheque_no">Cheque</option>
                <option value="bank">Bank Name</option>
                <option value="date">Date</option>
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
                <th width="10%">Id</th>
                <th width="10%">Method</th>
                <th width="20%">Cheque No</th>
                <th width="30%">Bank</th>
                <th width="10%">Amount</th>
                <th width="10%">Date</th>
                <th width="10%">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['method']); ?></td>
                <td><?php echo htmlspecialchars($row['cheque_no']); ?></td>
                <td><?php echo htmlspecialchars($row['bank']);?></td>
                <td><?php echo htmlspecialchars($row['amount']);?></td>
                <td><?php echo htmlspecialchars($row['date']);?></td>
                <td>
                    <a href="edit_payment.php?payment_id=<?php echo $row['id']; ?>&account_id=<?php echo $account_details['id']; ?>" class="btn btn-primary" title="Click here to Edit"><i class="glyphicon glyphicon-edit"></i></a>
                    <a href="#" class="btn btn-danger delete_btn" data-toggle="modal" data-target="#confirm-delete-<?php echo $row['id']; ?>" title="Delete"><i class="glyphicon glyphicon-trash"></i></a>
                </td>
            </tr>
            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="confirm-delete-<?php echo $row['id']; ?>" role="dialog">
                <div class="modal-dialog">
                    <form action="delete_payment.php" method="POST">
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
    	<?php echo paginationLinks($page, $total_pages, 'admin_users.php'); ?>
    </div>
    <!-- //Pagination -->
</div>
<!-- //Main container -->
<?php include BASE_PATH . '/includes/footer.php'; ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#order_by').on('change', function() {
            if(this.value == 'date'){
                $('#input_search').attr("type", 'date');
            }else{
               $('#input_search').attr("type", 'text');
            }
        }); 
    });
</script>