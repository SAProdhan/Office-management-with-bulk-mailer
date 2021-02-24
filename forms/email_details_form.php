<!-- Email Address -->
<div class="form-group">
    <label class="col-md-4 control-label">Email Address</label>
    <div class="col-md-4 inputGroupContainer">
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input type="email" name="username" placeholder="Email Address" class="form-control" required="" value="<?php echo ($edit) ? $email_account['username'] : ''; ?>" autocomplete="off">
        </div>
    </div>
</div>
<!-- Password input -->
<div class="form-group">
    <label class="col-md-4 control-label">Password</label>
    <div class="col-md-4 inputGroupContainer">
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input type="password" name="password" placeholder="Password" class="form-control" required="" value="<?php echo ($edit) ? $email_account['password'] : ''; ?>" autocomplete="off">
        </div>
    </div>
</div>
<!-- Sender input -->
<div class="form-group">
    <label class="col-md-4 control-label">Sender:</label>
    <div class="col-md-4 inputGroupContainer">
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input type="test" name="from_name" placeholder="Your company name" class="form-control" required="" value="<?php echo ($edit) ? $email_account['from_name'] : ''; ?>" autocomplete="off">
        </div>
    </div>
</div>
<!-- SMTP Host -->
<div class="form-group">
    <label class="col-md-4 control-label">SMTP Host</label>
    <div class="col-md-4 inputGroupContainer">
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-link"></i></span>
            <input type="text" name="smtp_host" placeholder="Enter SMTP Host" class="form-control" required="" value="<?php echo ($edit) ? $email_account['smtp_host'] : ''; ?>" autocomplete="off">
        </div>
    </div>
</div>
<!-- SMTP Port -->
<div class="form-group">
    <label class="col-md-4 control-label">SMTP Port</label>
    <div class="col-md-4 inputGroupContainer">
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-modal-window"></i></span>
            <input type="number" name="smtp_port" placeholder="Enter SMTP Host" class="form-control" required="" value="<?php echo ($edit) ? $email_account['smtp_port'] : ''; ?>" autocomplete="off">
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
