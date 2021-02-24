<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

// Users class
require_once BASE_PATH . '/lib/Users/Users.php';
$users = new Users();
$users->CheckSuperuser();
// Per page limit for pagination
$db = getDbInstance();
$table_column_list = $db->get("table_details");

?>
<?php include BASE_PATH . '/includes/header.php'; ?>
<!-- Main container -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header">Database Opertion</h1>
        </div>
        <div class="col-lg-6">
            <!-- <div class="page-action-links text-right">
                <a href="add_admin.php" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Add new</a>
            </div> -->
        </div>
    </div>
    <?php include BASE_PATH . '/includes/flash_messages.php'; ?>
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <a href="#" id="import_button">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-download fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">Import</div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6">
            <a href="#" id="export_button">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-upload fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">Export</div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6">
        
        </div>
        <div class="col-lg-3 col-md-6">
            
        </div>
    </div>
    <div id="export_form_worper" style="display:none;">
        <h3 class="text-center">Database Export Form</h3>
        <form class="form" method="POST" id="export_form" action="export.php" enctype="multipart/form-data">
            <fieldset>
                <div class="form-group col-md-12">
                    <!-- <label for="user_name" class="col-md-2 text-right">Database:</label> -->
                    <label class="col-md-12">
                        <select name="table_name" id="table_name" class="form-control selectpicker" required>
                            <option value="" disable>Please select a database</option>
                            <?php foreach ($table_column_list as $tbl) {?>
                                <option value="<?php echo $tbl['tables'];?>" > <?php echo $tbl['tables'];?></option>
                            <?php }?>
                        </select>
                    </label>
                </div>
                <div class="form-group col-md-6">
                    <label for="start_id" class="col-md-3 text-right">Start from:</label>
                    <label class="col-md-9"><input type="number" name="start_id" placeholder="Enter start ID" class="form-control" id="start_id"></label>
                </div> 
                <div class="form-group col-md-6">
                    <label for="end_id" class="col-md-3 text-right">End to:</label>
                    <label class="col-md-9">
                        <input type="number" name="end_id" placeholder="Enter ending ID" class="form-control" required="required" id="end_id">
                    </label>
                </div>    
                <div class="form-group text-center col-md-12">
                    <label></label>
                    <button type="button" class="btn btn-warning submit" id="exp_submit">Export <i class="glyphicon glyphicon-open-file"></i></button>
                </div>
            </fieldset>
        </form>
    </div>
    <div id="import_form_worper" style="display:none;">
        <h3 class="text-center">Database Import Form</h3>
        <form class="form" method="POST" id="import_form" action="import.php" enctype="multipart/form-data">
            <fieldset>
                <div class="form-group col-md-12">
                    <!-- <label for="user_name" class="col-md-2 text-right">Database:</label> -->
                    <label class="col-md-12">
                        <select name="table" id="table" class="form-control selectpicker" required>
                            <option value="" disable>Please select a database</option>
                            <?php foreach ($table_column_list as $tbl) {?>
                                <option value="<?php echo $tbl['tables'];?>" > <?php echo $tbl['tables'];?></option>
                            <?php }?>
                        </select>
                    </label>
                </div>
                <div class="form-group col-md-12">
                    <label for="start_id" class="col-md-3 text-right">File:</label>
                    <label class="col-md-9"><input type="file" name="file" class="form-control" id="file"></label>
                </div>     
                <div class="form-group text-center col-md-12">
                    <label></label>
                    <button type="button" class="btn btn-warning submit" id="imp_submit">Import <i class="glyphicon glyphicon-open-file"></i></button>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<!-- //Main container -->
<?php include BASE_PATH . '/includes/footer.php'; ?>
<script type="text/javascript">
    $(document).ready(function(){
    // Validation
        $('#import_button').click(function(){
            $('#import_form_worper').toggle();
            if($('#import_form_worper').is(':visible')){
                $('#export_form_worper').hide();
            }
        });
        $('#export_button').click(function(){
            $('#export_form_worper').toggle();
            if($('#export_form_worper').is(':visible')){
                $('#import_form_worper').hide();
            }
        });
        $('#exp_submit').click(function(){
            var table_name = $('#table_name').val();
            var start_id = $('#start_id').val();
            var end_id = $('#end_id').val();
            var msg = "Export table: "+table_name;
            if(table_name == "")
            {
                alert("Please select a database!");
                return false;
            }
            if(start_id != ""){
                msg += " from ID: "+start_id;
            }
            if(end_id != ""){
                msg += " to ID: "+end_id;
            }
            if(confirm(msg+"?")){
                $("#export_form").submit();
            }
            return false;            
        });
        $("#file").change(function () {
            var fileExtension = ['xlsx'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                alert("Only formats are allowed : "+fileExtension.join(', '));
            }
        });
        $('#imp_submit').click(function(){
            var table_name = $('#table').val();
            var file = $('#file').val();
            var msg = "Import table: "+table_name;
            if(table_name == "")
            {
                alert("Please select a database!");
                return false;
            }
            if(file == "")
            {
                alert("Please upload a file!");
                return false;
            }

            if(confirm(msg+"?")){
                $("#import_form").submit();
            }
            return false;            
        });
    });
</script>