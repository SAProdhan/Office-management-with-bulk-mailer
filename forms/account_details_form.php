<fieldset>
    <div class="form-group col-md-6">
        <label for="Company_Name" class="col-md-6 text-right">Company Name:</label>
        <label class="col-md-6">
            <input type="text" name="Company_Name" placeholder="Company Name....." class="form-control" required="required" id = "Company_Name" value="<?php echo( $edit ? $account_details['Company_Name'] : '');?>">
        </label>
    </div>
    <div class="form-group col-md-6">
        <label for="ContactPerson" class="col-md-6 text-right">Contact Person:</label>
        <label class="col-md-6"><input type="text" name="ContactPerson" placeholder="Contact person name..." class="form-control" required="required" id = "ContactPerson" value="<?php echo( $edit ? $account_details['ContactPerson'] : '');?>"></label>
    </div> 

    <div class="form-group col-md-6">
        <label for="MobileNo" class="col-md-6 text-right">Contact Number:</label>
        <label class="col-md-6">
            <input type="tel" name="MobileNo" placeholder="Contact number..." class="form-control" required="required" id="MobileNo" value="<?php echo( $edit ? $account_details['MobileNo'] : '');?>">
        </label>
    </div>
    <div class="form-group col-md-6">
        <label for="work_order_date" class="col-md-6 text-right">WorkOrder Date:</label>
        <label class="col-md-6">
            <input type="date" name="work_order_date"  class="form-control" id="work_order_date" value="<?php echo( $edit ? date('Y-m-d', strtotime($account_details['work_order_date'])) : '');?>">
        </label>
    </div>  
    <div class="form-group col-md-6">
        <label for="bill_submission_date" class="col-md-6 text-right">Bill submission date:</label>
        <label class="col-md-6">
            <input type="date" name="bill_submission_date" class="form-control" id="bill_submission_date" value="<?php echo( $edit ? date('Y-m-d', strtotime($account_details['bill_submission_date'])) : '');?>">
        </label>
    </div>
    <div class="form-group col-md-6">
        <label for="total" class="col-md-6 text-right">Total amount:</label>
        <label class="col-md-6">
            <input type="number" name="total"  class="form-control" required="required" id="total" value="<?php echo( $edit ? $account_details['total'] : '');?>">
        </label>
    </div>
    <div class="form-group col-md-12">
        <label for="path" class="col-md-2 text-right">Work Order:</label>
        <label class="col-md-10">
            <input type="file" name="path"  class="form-control" id="path" <?php echo( $edit ? '': 'required="required"');?>>
        </label>
    </div>

    <div class="form-group col-md-12 text-center">
        <label></label>
        <button type="submit" class="btn btn-warning submit" >Save<i class="glyphicon glyphicon-send"></i></button>
    </div>
</fieldset>
