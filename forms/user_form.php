<fieldset class="form-group">

    <label class="my-2" for="user">First Name</label>
    <input class="form-control" name="f_name" type="text" id="f_name" value="<?php echo htmlspecialchars(($edit) ? $user['f_name'] : '', ENT_QUOTES, 'UTF-8'); ?>"> 

    <label class="my-2" for="user">Last Name</label>
    <input class="form-control" name="l_name" type="text" id="l_name" value="<?php echo htmlspecialchars(($edit) ? $user['l_name'] : '', ENT_QUOTES, 'UTF-8'); ?>">

    <label class="my-2" for="user_name">UserName</label>
    <input class="form-control" name="user_name" type="text" id="user_name" readonly value="<?php echo htmlspecialchars(($edit) ? $user['user_name'] : '', ENT_QUOTES, 'UTF-8'); ?>">

    <label class="my-2">Field </label>
    <?php $opt_arr = array("Designer", "Software Developer", "Manager", "Marketing Expert", "Teacher", "Engineer", "Student", "Freelancer");
        ?>
    <select name="field" class="form-control selectpicker" required>
        <option value=" " >Please select your Field</option>
        <?php
        foreach ($opt_arr as $opt) {
            if ($edit && $opt == $user['field']) {
                $sel = "selected";
            } else {
                $sel = "";
            }
            echo '<option value="'.$opt.'"' . $sel . '>' . $opt . '</option>';
        }

        ?>
    </select>

    <div>
        <label class="my-2" for="img">Image</label>
        <input class="form-control file_val" name="img" type="file" id="img_validate" value="<?php echo htmlspecialchars(($edit) ? $user['img'] : '', ENT_QUOTES, 'UTF-8'); ?>">
        <span id="img_validate"></span>
    </div>

    <label class="my-2" for="gender">Gender</label>
    <?php $opt_arr = array("Male", "Female", "Other"); 
            ?>
    <select name="gender" class="form-control selectpicker" required>
        <option value=" " >Please select your Gender</option>
        <?php
        foreach ($opt_arr as $opt) {
            if ($edit && $opt == $user['gender']) {
                $sel = "selected";
            } else {
                $sel = "";
            }
            echo '<option value="'.$opt.'"' . $sel . '>' . $opt . '</option>';
        }

        ?>
    </select>

    <label class="my-2" for="Address">Address</label>
    <input class="form-control" name="address" type="text" id="address" value="<?php echo htmlspecialchars(($edit) ? $user['address'] : '', ENT_QUOTES, 'UTF-8'); ?>"> 

    <label class="my-2" for="phone">Phone Number</label>
    <input class="form-control" name="phone" type="text" id="phone" value="<?php echo htmlspecialchars(($edit) ? $user['phone'] : '', ENT_QUOTES, 'UTF-8'); ?>">

    <label class="my-2" for="Email">Email Address</label>
    <input class="form-control" name="email" type="text" id="email" value="<?php echo htmlspecialchars(($edit) ? $user['email'] : '', ENT_QUOTES, 'UTF-8'); ?>">

    <label class="my-2" for="password">Password</label>
    <input class="form-control" readonly name="password" type="password" id="password" value="<?php echo htmlspecialchars(($edit) ? $user['password'] : '', ENT_QUOTES, 'UTF-8'); ?>">

    <label class="my-2">Date of birth</label>
    <input name="date_of_birth" value="<?php echo htmlspecialchars($edit ? $user['date_of_birth'] : '', ENT_QUOTES, 'UTF-8'); ?>"  placeholder="Birth date" class="form-control"  type="date">

</fieldset>