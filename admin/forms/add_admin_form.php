<fieldset class="pl-4 py-2 ml-4 my-2">

    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label h5">User name</label>
        <div class="col-md-8 inputGroupContainer">
            <div class="input-group mb-2">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input  type="text" name="user_name" autocomplete="off" placeholder="user name" class="form-control" value="<?php echo ($edit) ? $admin_account['user_name'] : ''; ?>" autocomplete="off">
            </div>
        </div>
    </div>
    <!-- Text input-->

    <div class="form-group">
        <label class="col-md-4 control-label h5">Password</label>
        <div class="col-md-8 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input type="password" name="password" autocomplete="off" placeholder="Password " class="form-control" required="" autocomplete="off">
            </div>
        </div>
    </div>

    <!-- radio checks -->
    <div class="form-group">
        <label class="col-md-4 control-label h5">User type</label>
        <div class="col-md-8 mt-1">
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
        </div>
    </div>
    <!-- radio checks -->


    <!-- Button -->
    <div class="form-group">
        <label class="col-md-4 control-label"></label>
        <div class="col-md-8 text-right">
            <button type="reset" class="btn btn-default" > Cancel </button>
            <button type="submit" class="btn btn-dark" > Save </button>
        </div>
    </div>
</fieldset>