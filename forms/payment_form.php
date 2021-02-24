    <div class="form-group col-md-12">
        <label for="method" class="col-md-3 text-right">Method:</label>
        <label class="col-md-9">
            <select name="method" id="method" class="form-control selectpicker" required>
                <option value="" disable>Please select a Method</option>
                    <option value="Cash" <?php echo( isset($payment_details['method']) ? ($payment_details['method']=="Cash" ? "selected" : "") : '');?>>Cash</option>
                    <option value="Cheque" <?php echo( isset($payment_details['method']) ? ($payment_details['method']=="Cheque" ? "selected" : "") : '');?>>Cheque</option>
            </select>
        </label>
    </div>
    <div id="cheque_details" style="display:none;">
        <div class="form-group col-md-6">
            <label for="cheque_no" class="col-md-6 text-right">Cheque No:</label>
            <label class="col-md-6"><input type="text" name="cheque_no" placeholder="Enter cheque number..." class="form-control" id = "cheque_no" value="<?php echo( isset($payment_details['cheque_no']) ? $payment_details['cheque_no'] : '');?>"></label>
        </div> 
        <div class="form-group col-md-6">
            <label for="bank" class="col-md-6 text-right">Bank name:</label>
            <label class="col-md-6"><input type="text" name="bank" placeholder="Enter bank name..." class="form-control" id = "bank" value="<?php echo( isset($payment_details['bank']) ? $payment_details['bank'] : '');?>"></label>
        </div> 
    </div>
    <div class="form-group col-md-6">
        <label for="amount" class="col-md-6 text-right">Amount:</label>
        <label class="col-md-6"><input type="number" name="amount" placeholder="Enter amount..." class="form-control" required="required" id = "amount" value="<?php echo( isset($payment_details['amount']) ? $payment_details['amount'] : '');?>"></label>
    </div> 

    <div class="form-group col-md-6">
        <label for="date" class="col-md-6 text-right">Date:</label>
        <label class="col-md-6">
            <input type="date" name="date"  class="form-control" id="date" value="<?php echo( isset($payment_details['date']) ? date('Y-m-d', strtotime($payment_details['date'])) : '');?>" required="required">
        </label>
    </div>  
    
