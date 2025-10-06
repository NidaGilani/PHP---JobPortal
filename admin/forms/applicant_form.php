<fieldset>
    <div class="form-group">
        <label for="f_name">User_name *</label>
          <input type="text" name="user_name" value="<?php echo htmlspecialchars($edit ? $applicant['user_name'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="User Name" class="form-control" required="required" id = "user_name" >
    </div>

    <div class="form-group">
        <label for="f_name">Password *</label>
          <input type="text" name="password" value="<?php echo htmlspecialchars($edit ? $applicant['password'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Password" class="form-control" required="required" id = "password" >
    </div>

    <div class="form-group">
        <label for="f_name">First Name *</label>
          <input type="text" name="f_name" value="<?php echo htmlspecialchars($edit ? $applicant['f_name'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="First Name" class="form-control" required="required" id = "f_name" >
    </div> 

    <div class="form-group">
        <label for="l_name">Last name *</label>
        <input type="text" name="l_name" value="<?php echo htmlspecialchars($edit ? $applicant['l_name'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Last Name" class="form-control" required="required" id="l_name">
    </div> 

    <div class="form-group">
        <label>Gender * </label>
        <label class="radio-inline">
            <input type="radio" name="gender" value="Male" <?php echo ($edit && $applicant['gender'] =='Male') ? "checked": "" ; ?> required="required"/> Male
        </label>
        <label class="radio-inline">
            <input type="radio" name="gender" value="Female" <?php echo ($edit && $applicant['gender'] =='Female')? "checked": "" ; ?> required="required" id="Female"/> Female
        </label>
        <label class="radio-inline">
            <input type="radio" name="gender" value="Other" <?php echo ($edit && $applicant['gender'] =='Other')? "checked": "" ; ?> required="required" id="Other"/> Other
        </label>
    </div>

    <div class="form-group">
        <label for="address">Address</label>
          <textarea name="address" placeholder="Address" class="form-control" id="address"><?php echo htmlspecialchars(($edit) ? $applicant['address'] : '', ENT_QUOTES, 'UTF-8'); ?></textarea>
    </div> 
    

    <div class="form-group">
        <label>Field </label>
           <?php $opt_arr = array("Designer", "Software Developer", "Manager", "Marketing Expert", "Teacher", "Engineer", "Student", "Freelancer"); 
                            ?>
            <select name="field" class="form-control selectpicker" required>
                <option value=" " >Please select your Field</option>
                <?php
                foreach ($opt_arr as $opt) {
                    if ($edit && $opt == $applicant['field']) {
                        $sel = "selected";
                    } else {
                        $sel = "";
                    }
                    echo '<option value="'.$opt.'"' . $sel . '>' . $opt . '</option>';
                }

                ?>
            </select>
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input  type="email" name="email" value="<?php echo htmlspecialchars($edit ? $applicant['email'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="E-Mail Address" class="form-control" id="email">
    </div>

    <div class="form-group">
        <label for="phone">Phone</label>
        <input name="phone" value="<?php echo htmlspecialchars($edit ? $applicant['phone'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="987654321" class="form-control"  type="text" id="phone">
    </div> 

    <div class="form-group">
        <label for="phone">Image</label>
        <input name="img" value="<?php echo htmlspecialchars($edit ? $applicant['img'] : '', ENT_QUOTES, 'UTF-8'); ?>"  class="form-control"  type="file" id="img">
    </div>

    <div class="form-group">
        <label>Date of birth</label>
        <input name="date_of_birth" value="<?php echo htmlspecialchars($edit ? $applicant['date_of_birth'] : '', ENT_QUOTES, 'UTF-8'); ?>"  placeholder="Birth date" class="form-control"  type="date">
    </div>

    <div class="form-group text-center">
        <label></label>
        <button type="submit" class="btn btn-dark" >Save <span class="glyphicon glyphicon-send"></span></button>
    </div>            
</fieldset>
