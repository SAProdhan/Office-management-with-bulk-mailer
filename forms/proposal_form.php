<fieldset>
    <?php if($suser){?>
    <div class="form-group col-md-6">
        <label for="user_name" class="col-md-3 text-right">User</label>
        <label class="col-md-9">
        <select name="user_name" id="user_name" class="form-control selectpicker" required>
            <option value="" disable>Please select a user</option>
            <?php foreach ($opt_arr as $opt) {?>
                <option value="<?php echo $opt['user_name'];?>" > <?php echo $opt['user_name'];?></option>
            <?php }?>
        </select>
        </label>
    </div>
    <?php }else{ echo '<input type="hidden" id="user_name" name="user_name" value="'.$admin_data["user_name"].'">';}?>
    <div class="form-group col-md-6">
        <label for="email" class="col-md-3 text-right">Email</label>
        <label class="col-md-9"><input type="email" name="email" placeholder="Client Email" class="form-control" required="required" id = "email"></label>
    </div> 
    <div class="form-group col-md-6">
        <label for="sub" class="col-md-3 text-right">Subject</label>
        <label class="col-md-9">
            <input type="text" name="sub" placeholder="Email Subject" class="form-control" required="required" id="sub">
        </label>
    </div>
    <div class="form-group col-md-6">
        <label for="acc" class="col-md-3 text-right">ACC</label>
        <label class="col-md-9">
            <input type="text" name="acc" placeholder="Add CC here..." class="form-control" id="acc">
        </label>
    </div>  
    <div class="form-group col-md-6">
        <label for="reference" class="col-md-3 text-right">Referance</label>
        <label class="col-md-9">
            <input type="text" name="reference" value="<?php echo htmlspecialchars($edit ? $proposal['reference '] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Add Referance here..." class="form-control" required="required" id="reference">
        </label>
    </div>
    <div class="form-group col-md-6">
        <label for="user_name" class="col-md-3 text-right">Sender</label>
        <label class="col-md-9">
        <select name="Sender" id="Sender" class="form-control selectpicker" required>
            <?php foreach ($mails as $mail) {?>
                <option value="<?php echo $mail;?>" > <?php echo $mail;?></option>
            <?php }?>
        </select>
        </label>
    </div>  
    <input type="hidden" name="mail_body" id="mail_body">  
    <input type="hidden" name="signature" id="signature_field">  
    <div class="form-group text-center" >
        <table id="file_table" width="100%" class="text-center">
            <thead>
                <tr class="text-center">
                    <th colspan="3" class="text-center" style="height:50px;">Attached File</th>
                </tr>
            </thead>
            <tbody>
                <tr class="add_row">
                    <td id="no" width="5%">Proposal:</td>
                    <td width="75%"><input type="file" class="file" name="files[]" multiple /></td>
                    <td width="20%"></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">
                        <button class="btn btn-success btn-sm" type="button" id="add" title='Add another file'>Add another file</button>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="form-group">
        <label class="col-md-12 text-center">Mail body</label>
        <textarea  id="txtEditor"></textarea>
    </div>
    <div class="form-group col-md-6">
        <label for="reference" class="col-md-3 text-right">Signature:</label>
        <div class="col-md-9" id="signature">
        </div>
    </div>
    <div class="form-group text-center col-md-12">
        <label></label>
        <button type="button" class="btn btn-warning submit" >Save and Send <i class="glyphicon glyphicon-send"></i></button>
    </div>
</fieldset>
