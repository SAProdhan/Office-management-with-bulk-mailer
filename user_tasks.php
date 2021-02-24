<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';
require_once BASE_PATH . '/lib/Tasks/Tasks.php';
// Users class
require_once BASE_PATH . '/lib/Users/Users.php';
$users = new Users();
$suser = $users->CheckifSuperuser();
// Users class
$id = $users->getId();
$db = getDbInstance();
// get admin details
$db->where ("id", $id);
$admin_data=$db->getOne("admin_accounts");
$task = new Tasks();

// Get Input data from query string
$del_id		= filter_input(INPUT_GET, 'del_id');
$order_by	= filter_input(INPUT_GET, 'order_by');
$order_dir	= filter_input(INPUT_GET, 'order_dir');
$search_str	= filter_input(INPUT_GET, 'search_str');
$filter_by	= filter_input(INPUT_GET, 'filter_by');

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
$select = array('id', 'username', 'tables', 'start_no', 'end_no', 'assign_at', 'completed_at', 	'assign_by', 'remarks', 'status');

// Start building query according to input parameters
// If search string
if(!$suser){
    $db->where('user_id', $users->getId());
}
if ($search_str) {
	$db->where($filter_by, $search_str .'%', 'like');
}
// If order direction option selected
if ($order_dir) {
	$db->orderBy($order_by, $order_dir);
}

// Set pagination limit
$db->pageLimit = $pagelimit;

// Get result of the query
$rows = $db->arraybuilder()->paginate('tasks', $page, $select);
$total_pages = $db->totalPages;
?>
<?php include BASE_PATH . '/includes/header.php'; ?>
<!-- Main container -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header">Task List</h1>
        </div>
        <div class="col-lg-6">
            <!-- <div class="page-action-links text-right">
                <a href="add_admin.php" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Add new</a>
            </div> -->
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
            <input type="date" class="form-control" id="input_search" name="search_str" value="<?php echo htmlspecialchars($search_str, ENT_QUOTES, 'UTF-8'); ?>">
            <label for="input_order">Order By</label>
            <select name="order_by" class="form-control">
                <?php
                    foreach ($task->setOrderingValues() as $opt_value => $opt_name):
                        ($order_by === $opt_value) ? $selected = 'selected' : $selected = '';
                        echo ' <option value="' . $opt_value . '" ' . $selected . '>' . $opt_name . '</option>';
                    endforeach;
                ?>
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
            <?php if($suser == true){ ?>
            <label for="input_order">Filter By</label>
            <select name="filter_by" class="form-control">
                <?php
                    foreach ($task->setFilteringValues() as $opt_value => $opt_name):
                        ($order_by === $opt_value) ? $selected = 'selected' : $selected = '';
                        echo ' <option value="' . $opt_value . '" ' . $selected . '>' . $opt_name . '</option>';
                    endforeach;
                ?>
            </select>
            <?php } ?>
            <input type="submit" value="Go" class="btn btn-primary">
        </form>
    </div>
    <hr>
    <!-- //Filters -->

    <!-- Table -->
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <?php if($suser){ ?>
            <tr>
                <th width="9%">Assign To</th>
                <th width="9%">Assign By</th>
                <th width="10%">Assign At</th>
                <th width="12%">Table Name</th>
                <th width="10%">Start No</th>
                <th width="10%">Ending No</th>
                <th width="10%">Completed At</th>
                <th width="10%">Remarks</th>
                <th width="10%">Status</th>
                <th width="10%">Action</th>
            </tr>
            <?php }else{ ?>
            <tr>
                <th width="15%">Assign At</th>
                <th width="15%">Table Name</th>
                <th width="10%">Start No</th>
                <th width="10%">Ending No</th>
                <th width="10%">Completed At</th>
                <th width="15%">Remarks</th>
                <th width="10%">Status</th>
                <th width="15%">Action</th>
            </tr>
            <?php } ?>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
            <tr>
                <?php if($suser){ ?>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td><?php echo htmlspecialchars($row['assign_by']); ?></td>
                <?php } ?>
                <td><?php echo htmlspecialchars($row['assign_at']); ?></td>
                <td><?php echo htmlspecialchars($row['tables']); ?></td>
                <td><?php echo htmlspecialchars($row['start_no']);?></td>
                <td><?php echo htmlspecialchars($row['end_no']);?></td>
                <td><?php echo htmlspecialchars($row['completed_at']);?></td>
                <td><?php echo htmlspecialchars($row['remarks']);?></td>
                <td><?php echo htmlspecialchars($row['status']);?></td>
                <td>
                <?php if($suser){ ?>
                    <a href="edit_task.php?task_id=<?php echo $row['id']; ?>&username=<?php echo $row['username']; ?>" class="btn btn-primary" title="Edit Task"><i class="glyphicon glyphicon-edit"></i></a>
                    <a href="review_task.php?task_id=<?php echo $row['id']; ?>&operation=edit" class="btn btn-info" title="Review this Task"><i class="glyphicon glyphicon-check"></i></a>
                    <a href="#" class="btn btn-danger delete_btn" data-toggle="modal" data-target="#confirm-delete-<?php echo $row['id']; ?>" title="Click here to Delete this Task"><i class="glyphicon glyphicon-trash"></i></a>
                <?php } ?>
                    <a href="#" class="btn btn-success con_btn" data-toggle="modal" data-target="#confirm-up-<?php echo $row['id']; ?>" title="Mark as completed?"><i class="fa fa-check-circle"></i></a>
                </td>
            </tr>
            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="confirm-delete-<?php echo $row['id']; ?>" role="dialog">
                <div class="modal-dialog">
                    <form action="delete_task.php" method="POST">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Confirm</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="del_id" id="del_id" value="<?php echo $row['id']; ?>">
                                <p>Are you sure you want to delete this Tasks?</p>
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
            <!-- Completed Confirmation Modal -->
            <div class="modal fade" id="confirm-up-<?php echo $row['id']; ?>" role="dialog">
                <div class="modal-dialog">
                    <form action="task_completed.php" method="POST">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Confirm</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="com_id" id="com_id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="assign_at" id="assign_at" value="<?php echo $row['assign_at']; ?>">
                                <p>Are want to mark the task as completed?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default pull-left">Yes</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- //Completed Confirmation Modal -->
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
