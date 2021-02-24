<!-- Text input -->
<div class="form-group">
    <label class="col-md-4 control-label">Select Table</label>
    <div class="col-md-4 inputGroupContainer">
        <div class="input-group">
            <label for="table">
            <select required readonly>
                <option value=''>-----SELECT-----</option>
                <?php foreach($table_column_list as $tc){?>
                <option value="<?php echo $tc['tables']; ?>" <?php echo ($tasks['tables']? "selected": ""); ?>><?php echo $tc['tables']; ?></option>
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
            <input type="number" class="form-control" value="<?php echo($tasks['start_no']); ?>" readonly>
        </div>
    </div>
</div>
<!-- Password input -->
<div class="form-group">
    <label class="col-md-4 control-label">End to Serial No:</label>
    <div class="col-md-4 inputGroupContainer">
        <div class="input-group">
            <input type="number" class="form-control" value="<?php echo($tasks['end_no']); ?>" readonly>
        </div>
    </div>
</div>
<!-- Password input -->
<div class="form-group">
    <label class="col-md-4 control-label">Assign for date:</label>
    <div class="col-md-4 inputGroupContainer">
        <div class="input-group">
            <input type="date" class="form-control" value="<?php echo(date("Y-m-d", strtotime($tasks['assign_at']))); ?>" readonly>
        </div>
    </div>
</div>
<!-- Password input -->
<div class="form-group">
    <label class="col-md-4 control-label">Completed at:</label>
    <div class="col-md-4 inputGroupContainer">
        <div class="input-group">
            <input type="date" class="form-control" value="<?php echo(isset($tasks['completed_at'])? date("Y-m-d", strtotime($tasks['completed_at'])): "No Submit yet"); ?>" readonly>
        </div>
    </div>
</div>
<!-- Password input -->
<div class="form-group">
    <label class="col-md-4 control-label">Status:</label>
    <div class="col-md-4 inputGroupContainer">
        <div class="input-group">
            <input type="text" name="status" class="form-control" value="<?php echo(isset($tasks['status'])? $tasks['status']: "No Submited yet"); ?>">
        </div>
    </div>
</div>
<!-- Password input -->
<div class="form-group">
    <label class="col-md-4 control-label">Target :</label>
    <div class="col-md-4 inputGroupContainer">
        <div class="input-group">
            <input type="text"  class="form-control" value="<?php echo(isset($tasks['start_no'])? ($tasks['end_no']-$tasks['start_no']): "No Submited yet"); ?>" readonly>
        </div>
    </div>
</div>
<!-- Password input -->
<div class="form-group">
    <label class="col-md-4 control-label">Sent mail:</label>
    <div class="col-md-4 inputGroupContainer">
        <div class="input-group">
            <input type="text" class="form-control" value="<?php echo(isset($counter['cnt'])? $counter['cnt']: "No result"); ?>" readonly>
        </div>
    </div>
</div>
<!-- Password input -->
<div class="form-group">
    <label class="col-md-4 control-label">Remarks:</label>
    <div class="col-md-4 inputGroupContainer">
        <div class="input-group">
            <textarea name="remarks" class="form-control"><?php echo(isset($tasks['remarks'])? $tasks['remarks']: "Your comments please..."); ?></textarea>
            <input type="hidden" name="id" class="form-control" value="<?php echo($task_id); ?>">
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
