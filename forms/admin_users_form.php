<!-- Text input -->
<div class="form-group">
    <label class="col-md-4 control-label">Username</label>
    <div class="col-md-4 inputGroupContainer">
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input type="text" name="user_name" placeholder="Username" class="form-control" required="" value="<?php echo ($edit) ? $admin_account['user_name'] : ''; ?>" autocomplete="off">
        </div>
    </div>
</div>
<!-- Full name input -->
<div class="form-group">
    <label class="col-md-4 control-label" for="name">Full Name</label>
    <div class="col-md-4 inputGroupContainer">
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input type="text" name="name" placeholder="Enter full name..." class="form-control" required value="<?php echo ($edit) ? $admin_account['name'] : ''; ?>" autocomplete="off">
        </div>
    </div>
</div>
<!-- Email input -->
<div class="form-group">
    <label class="col-md-4 control-label">Email</label>
    <div class="col-md-4 inputGroupContainer">
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
            <input type="email" name="email" placeholder="Email" class="form-control" required="" value="<?php echo ($edit) ? $admin_account['email'] : ''; ?>" autocomplete="off">
        </div>
    </div>
</div>
<!-- Mobile No input -->
<div class="form-group">
    <label class="col-md-4 control-label" for="cell_no">Cell No:</label>
    <div class="col-md-4 inputGroupContainer">
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
            <input type="tel" name="cell_no" placeholder="Enter mobile number..." class="form-control" required="" value="<?php echo ($edit) ? $admin_account['cell_no'] : ''; ?>" autocomplete="off">
        </div>
    </div>
</div>
<!-- Password input -->
<div class="form-group">
    <label class="col-md-4 control-label">Password</label>
    <div class="col-md-4 inputGroupContainer">
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input type="password" name="password" placeholder="Password" class="form-control" value="<?php echo ($edit) ? '' : 'required'; ?>" autocomplete="off">
        </div>
    </div>
</div>
<!-- Desigation input -->
<div class="form-group">
    <label class="col-md-4 control-label" for="designation">Designation</label>
    <div class="col-md-4 inputGroupContainer">
        <label>
            <select name="designation" required class="form-control">
                <option value=''>-----SELECT-----</option>
                <option value="Business Development Officer" <?php echo ($edit && $admin_account['designation'] =='Business Development Officer') ? "selected": "" ; ?>>Business Development Officer</option>
                <option value="Business Development Intern" <?php echo ($edit && $admin_account['designation'] =='Business Development Intern') ? "selected": "" ; ?>>Business Development Intern</option>
                <option value="Software engineer" <?php echo ($edit && $admin_account['designation'] =='Software engineer') ? "selected": "" ; ?>>Software engineer</option>
                <option value="Technician" <?php echo ($edit && $admin_account['designation'] =='Technician') ? "selected": "" ; ?>>Technician</option>
            </select> 
        </label>
    </div>
</div>
<!-- Radio checks -->
<div class="form-group">
    <label class="col-md-4 control-label">User type</label>
    <div class="col-md-4 inputGroupContainer">
        <div class="radio">
            <label>
                <?php //echo $admin_account['admin_type'] ?>
                <input type="radio" name="admin_type" value="super" required="" <?php echo ($edit && $admin_account['admin_type'] =='super') ? "checked": "" ; ?>/> Super admin
            </label>
        </div>
        <div class="radio">
            <label>
                <input type="radio" name="admin_type" value="admin" required="" <?php echo ($edit && $admin_account['admin_type'] =='admin') ? "checked": "" ; ?>/> Admin
            </label>
        </div>
        <div class="radio">
            <label>
                <input type="radio" name="admin_type" value="user" required="" <?php echo ($edit && $admin_account['admin_type'] =='admin') ? "checked": "" ; ?>/> User
            </label>
        </div>
    </div>
</div>

<!-- Image input -->
<div class="form-group">
    
    <label class="col-md-4 control-label" for="user_img">Image</label>
    <div class="col-md-4 inputGroupContainer">
        <img id="output" class="row" style="max-width:50%;"  <?php echo ($edit) ? 'src="'.$admin_account['path'].'"' : ''; ?>/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-camera"></i></span>
            <input type="file" name="user_img" accept="image/*" class="form-control" <?php echo ($edit) ? '' : 'required'; ?> onchange="loadFile(event)">
            <script>
                var loadFile = function(event) {
                    var output = document.getElementById('output');
                    output.src = URL.createObjectURL(event.target.files[0]);
                    output.onload = function() {
                    URL.revokeObjectURL(output.src) // free memory
                    }
                };
            </script>
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
