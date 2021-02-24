<!-- Text input -->
<div class="form-group">
    <label class="col-md-4 control-label">Select Table</label>
    <div class="col-md-4 inputGroupContainer">
        <div class="input-group">
            <label for="table">
            <select name="table" required>
                <option value=''>-----SELECT-----</option>
                <?php foreach($table_column_list as $tc){?>
                <option value='<?php echo $tc['tables']; ?>'><?php echo $tc['tables']; ?></option>
                <?php } ?>
            </select> 
            </label>
        </div>
    </div>
</div>
<!-- Email input -->
<div class="form-group">
    <label class="col-md-4 control-label">Start from Serial No:</label>
    <div class="col-md-4 inputGroupContainer">
        <div class="input-group">
            <input type="number" name="start_no" class="form-control" required>
        </div>
    </div>
</div>
<!-- Password input -->
<div class="form-group">
    <label class="col-md-4 control-label">End to Serial No:</label>
    <div class="col-md-4 inputGroupContainer">
        <div class="input-group">
            <input type="number" name="ending_no" class="form-control" required>
        </div>
    </div>
</div>
<!-- Password input -->
<div class="form-group">
    <label class="col-md-4 control-label">Assign for date:</label>
    <div class="col-md-4 inputGroupContainer">
        <div class="input-group">
            <input type="date" name="assign_date" class="form-control" required>
        </div>
    </div>
</div>
<!-- Submit button -->
<div class="form-group">
    <label class="col-md-4 control-label"></label>
    <div class="col-md-4">
        <button type="submit" class="btn btn-warning">Save <i class="glyphicon glyphicon-send"></i></button>
    </div>
</div>
