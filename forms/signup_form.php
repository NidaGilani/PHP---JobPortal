<fieldset>

    <label for="user_name">User Type</label>
    <?php $opt_arr = array("Applicant", "Employer"); 
            ?>
    <select name="user_type" id="user_type" class="form-control" required>
        <option value="" class="text-secondary">Please select user type</option>
        <?php
        foreach ($opt_arr as $opt) {
            if ($edit && $opt == $user['user_type']) {
                $sel = "selected";
            } else {
                $sel = "";
            }
            echo '<option value="'.$opt.'"' . $sel . '>' . $opt . '</option>';
        }

        ?>
    </select>

    <label for="user_name">User Name</label>
    <input class="form-control" name="user_name" type="text" id="user_name" value="<?php echo htmlspecialchars(($edit) ? $user['user_name'] : '', ENT_QUOTES, 'UTF-8'); ?>">

    <label for="Email">Email Address</label>
    <input class="form-control" name="email" type="text" id="email" value="<?php echo htmlspecialchars(($edit) ? $user['email'] : '', ENT_QUOTES, 'UTF-8'); ?>">

    <label for="password">Password</label>
    <input class="form-control" name="password" type="text" id="password" value="<?php echo htmlspecialchars(($edit) ? $user['password'] : '', ENT_QUOTES, 'UTF-8'); ?>">

</fieldset>