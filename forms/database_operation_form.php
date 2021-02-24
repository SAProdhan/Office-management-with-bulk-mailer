    <div class="form-group col-md-6">
        <label for="user_name" class="col-md-3 text-right">Database:</label>
        <label class="col-md-9">
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
        <label class="col-md-9"><input type="number" name="start_id" placeholder="Enter start ID" class="form-control" id = "start_id"></label>
    </div> 
    <div class="form-group col-md-6">
        <label for="end_id" class="col-md-3 text-right">End to:</label>
        <label class="col-md-9">
            <input type="number" name="end_id" placeholder="Enter ending ID" class="form-control" required="required" id="sub">
        </label>
    </div>    

