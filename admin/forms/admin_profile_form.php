<fieldset class="p-2 m-2">
    <div class="row">
    
        <!-- Text input-->
        <div class="col-md-6 form-group">
            <label class="col-md-4 control-label">First name</label>
            <div class="col-md-8 inputGroupContainer">
                <div class="input-group mb-2">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input  type="text" name="f_name" autocomplete="off" placeholder="First name" class="form-control" value="<?php echo htmlspecialchars($edit ? $admin_account['f_name'] : '', ENT_QUOTES, 'UTF-8'); ?>" autocomplete="off">
                </div>
            </div>
        </div>
        <!-- Text input-->

        <!-- Text input-->
        <div class="col-md-6 form-group">
            <label class="col-md-4 control-label">Last name</label>
            <div class="col-md-8 inputGroupContainer">
                <div class="input-group mb-2">
                    <input  type="text" name="l_name" autocomplete="off" placeholder="Last name" class="form-control" value="<?php echo ($edit) ? $admin_account['l_name'] : ''; ?>" autocomplete="off">
                </div>
            </div>
        </div>
        <!-- Text input-->
    
    </div>
    
    <div class="row">
    
        <!-- Text input-->
        <div class="col-md-6 form-group">
            <label class="col-md-4 control-label">User name</label>
            <div class="col-md-8 inputGroupContainer">
                <div class="input-group mb-2">
                    <input  type="text" name="user_name" autocomplete="off" placeholder="user name" class="form-control" value="<?php echo $admin_account['user_name']; ?>" autocomplete="off" readonly>
                </div>
            </div>
        </div>
        
        <!-- Text input-->

        <div class="col-md-6 form-group">
            <label class="col-md-4 control-label" >Password</label>
            <div class="col-md-8 inputGroupContainer">
                <div class="input-group">
                    <input type="text" name="password" value="<?php echo ($edit) ? $admin_account['password'] : ''; ?>" autocomplete="off" placeholder="Password " class="form-control" autocomplete="off">
                </div>
            </div>
        </div>
    
    </div>

   <div class="row">
   
        <!-- radio checks -->
        <div class="col-md-6 form-group">
            <label class="col-md-4 control-label">Gender</label>
            <div class="col-md-8 mt-3">
                <div class="radio">
                    <label>
                        <?php //echo $admin_account['admin_type'] ?>
                        <input type="radio" name="gender" value="Male" required="" <?php echo ($edit && $admin_account['gender'] =='Male') ? "checked": "" ; ?>/> Male
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="gender" value="Female" required="" <?php echo ($edit && $admin_account['gender'] =='Female') ? "checked": "" ; ?>/> Female
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="gender" value="Other" required="" <?php echo ($edit && $admin_account['gender'] =='Other') ? "checked": "" ; ?>/> Other
                    </label>
                </div>
            </div>
        </div>
        <!-- radio checks -->

        <!-- phone -->
        <div class="col-md-6 form-group">
            <label class="col-md-4 control-label">Phone Number</label>
            <div class="col-md-8 inputGroupContainer">
                <input type="text" class="form-control" name="phone" value="<?php echo ($edit) ? $admin_account['phone'] : ''; ?>" />
            </div>
              
        </div>
        <!-- phone -->
   
   </div>
    
    <!-- Button -->
    <div class="row form-group text-right">
        <label class="control-label"></label>
        <div class="col-md-9 mx-4">
            <button type="reset" class="btn btn-default px-4" > Cancel </button>
            <button type="submit" class="btn btn-dark px-4" > Save </button>
        </div>
    </div>
</fieldset>