<!-- Text input -->
<div class="form-group">
    <label class="col-md-4 control-label">Username</label>
    <div class="col-md-4 inputGroupContainer">
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input type="text" name="user_name" placeholder="Username" class="form-control" required="" value="<?php echo ($admin_account['user_name']) ? $admin_account['user_name'] : ''; ?>" autocomplete="off" readonly>
        </div>
    </div>
</div>
<!-- Email input -->
<div class="form-group">
    <label class="col-md-4 control-label">Email</label>
    <div class="col-md-4 inputGroupContainer">
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input type="email" name="email" placeholder="Email" class="form-control" value="<?php echo ($admin_account['email']) ? $admin_account['email'] : ''; ?>" autocomplete="off" readonly>
        </div>
    </div>
</div>
<!-- Password input -->
<!-- <div class="form-group">
    <label class="col-md-4 control-label">OTP</label>
    <div class="col-md-4 inputGroupContainer">
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input type="text" name="otp" placeholder="OTP" class="form-control" required="" value="" autocomplete="off" readonly>
        </div>
    </div>
</div> -->
<!-- Radio checks -->
<div class="form-group">
    <label class="col-md-4 control-label">Set OTP</label>
    <div class="col-md-4">
        <div class="radio">
            <label>
                <input type="checkbox" name="otp_on" value="1"  <?php echo ($otp_on) ? "checked" : " " ; ?>> OTP on
                <input type="email" name="otp_mail" placeholder="Email to send OTP" class="form-control" value="<?php echo ($otp_mail) ? $otp_mail : ''; ?>" autocomplete="off">
            </label>
        </div>
    </div>
</div>
<!-- Radio checks for Email-->
<div class="form-group">
    <label class="col-md-4 control-label">Select Email</label>
    <div class="col-md-4">
    <?php if(count($mail_list) > 0){
        foreach($mail_list as $mail_data){?>
        <div class="radio">
            <label>
                <input type="checkbox" name="mail[]" value="<?php echo $mail_data['username'];?>"  <?php echo (in_array($mail_data['username'], $mails)) ? "checked": " " ; ?>> <?php echo $mail_data['username'];?>
            </label>
        </div>
    <?php }}else{ ?>   
        <div class="radio">
            <label>
                No email data! please save your email first
            </label>
        </div>
    <?php } ?>       
    </div>
</div>
<!-- Radio checks for column-->
<!-- Radio checks for table-->
<?php foreach($table_column_list as $tc){?>
<div class="form-group">
    <label class="col-md-4 control-label">Select Table</label>
    <div class="col-md-4">
        <div class="radio">
            <label>
                <input type="checkbox" class="table_name" name="table[]" value="<?php echo $tc['tables']; ?>"  <?php echo (in_array($tc['tables'], $tables)) ? "checked": " " ; ?>> <?php echo $tc['tables']; ?>
            </label>
            <br><br>
            <div class="column">
                <label><strong><u>Select column &#8595;</u></strong></label><br>
                <?php $cols = json_decode($tc['columns']);
                    foreach($cols as $col){?>
                <div class="row">
                    <div class="radio">
                        <label>
                            <input type="checkbox" name="<?php echo $tc['tables']; ?>[]" value="<?php echo $col; ?>"  <?php echo (in_array($col, $columns)) ? "checked": " " ; ?>> <?php echo $col; ?>
                        </label>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<!-- Radio checks for column-->
<!-- Submit button -->
<div class="form-group">
    <label class="col-md-4 control-label"></label>
    <div class="col-md-4">
        <button type="submit" class="btn btn-warning">Save <i class="glyphicon glyphicon-send"></i></button>
    </div>
</div>
