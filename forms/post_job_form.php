<fieldset>
    <!-- Form Name -->
    <div class="job-desc-section text-left d-flex row">
        <div class="job-detail container form-group col-lg-8 col-md-10 col-sm-12">       
            <h3 class="text-center h2 mt-3">Job Details</h3>

            <div class="form-group">
                <label for="job-title">Job Title</label>
                <input class="form-control " type="text" id="job_title" name="job_title" placeholder="Job Title" value="<?php echo htmlspecialchars($edit ? $post['job_title'] : '', ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <div class="form-group">
                <label for="loc">State</label>
                <select name="loc" id="loc" class="form-control selectpicker" required>
                    <option value=""  >Please select your state</option>
                    <?php
                    foreach ($states as $state) {
                        if ($edit && $state['state_name'] == $post['loc']) {
                            $sel = "selected";
                        } else {
                            $sel = "";
                        }
                        echo '<option value="'.$state['state_name'].'"' . $sel . '>' . $state['state_name'] . '</option>';
                    }

                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="job_region">Job Region</label>
                <select name="job_region" id="job_region" class="form-control selectpicker" required>
                    <option value=""  selected >Please select your City</option>
                    <?php
                    foreach ($cities as $city) {
                        if ($edit && $city['city_name'] == $post['job_region']) {
                            $sel = "selected";
                        } else {
                            $sel = "";
                        }
                        echo '<option value="'.$city['city_name'].'"' . $sel . '>' . $city['city_name'] . '</option>';
                    }

                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="job_type">Job Type</label>
                <select class="dropdown form-control" name="job_type" id="job_type" required>
                    <option class="dropdown-item" value=""  selected >Select Type</option>
                    <?php
                        foreach ($job_types as $job_type) {
                        if ($edit && $job_type['job_type'] == $post['job_type']) {
                            $sel = "selected";
                        } else {
                            $sel = "";
                        }
                        echo '<option value="'.$job_type['job_type'].'"' . $sel . '>' . $job_type['job_type'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="job_desc">Job Description</label>
                <textarea class="form-control" id="job_desc" cols="30" rows="5" placeholder="Job Description"  name="job_desc" required>
                    <?php echo trim(htmlspecialchars($edit ? $post['job_desc'] : '', ENT_QUOTES, 'UTF-8')); ?>
                </textarea>
            </div>

            <div class="form-group">
                <h6>
                    <label for="f_image">Upload Featured Image</label>
                    <input type="file" name="f_image" id="f_image" value="<?php echo htmlspecialchars($edit ? $post['f_image'] : '', ENT_QUOTES, 'UTF-8'); ?>" class="file_val form-control">  
                </h6>
                <span id="img_validate"></span>
            </div>
            
            <div class="form-group">
                <label for="job_cat">Job Category</label>
                <select class="dropdown form-control" name="job_cat" id="job_cat" required>
                    <option class="dropdown-item" value=""  selected >Select category</option>
                    <?php
                        foreach ($categories as $cat) {
                        if ($edit && $cat['cat_name'] == $post['job_cat']) {
                            $sel = "selected";
                        } else {
                            $sel = "";
                        }
                        echo '<option value="'.$cat['cat_name'].'"' . $sel . '>' . $cat['cat_name'] . '</option>';
                        }
                    ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="job_resp">Responsibitities</label>
                <textarea class="form-control" id="job_resp" cols="30" rows="5" placeholder="Responsibitities"  name="job_resp" required>
                    <?php echo trim(htmlspecialchars($edit ? $post['job_resp'] : '', ENT_QUOTES, 'UTF-8') ); ?>
            </textarea>
            </div>
                
            <div class="form-group">
                <label for="job_benefit">Job Benefits</label>
                <textarea class="form-control" cols="30" rows="5" id="job_benefit" placeholder="Job Benefits" name="job_benefit" required>
                    <?php echo trim(htmlspecialchars($edit ? $post['job_benefit'] : '', ENT_QUOTES, 'UTF-8')); ?>
                </textarea>
            </div>
            
            <div class="form-group">
                <label>Gender</label>
                <label class="radio-inline">
                    <input type="radio" name="gender" value="male" <?php echo ($edit && $post['gender'] =='male') ? "checked": "" ; ?> required="required"/> Male
                </label>
                <label class="radio-inline">
                    <input type="radio" name="gender" value="female" <?php echo ($edit && $post['gender'] =='female')? "checked": "" ; ?> required="required" id="female"/> Female
                </label>
                <label class="radio-inline">
                    <input type="radio" name="gender" value="both" <?php echo ($edit && $post['gender'] =='both')? "checked": "" ; ?> required="required" id="female"/> Both Male & Female
                </label>
            </div>
            
            <div class="form-group">
                <label for="quali">Qualification</label>
                <?php $opt_arr = array("BSCS", "BSIT", "BSSE", "BBA", "MBA", "BCOM", "BA", "BS Mathematics", "Linguistics", "Economics"); 
                ?>
                <select name="quali" id="quali" class="form-control selectpicker" required>
                    <option value=" " >Select Subject</option>
                    <?php
                    foreach ($opt_arr as $opt) {
                        if ($edit && $opt == $post['quali']) {
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
                <label for="exper">Experience</label>
                <?php $opt_arr = array("None", "Less than 6 months", "6 m - 1 y", "1 y - 2 y", "2 y - 5 y", "more than 5 years"); 
                ?>
                <select name="exper" id="exper" class="form-control selectpicker" required>
                    <option value=" " >Choose Experience period</option>
                    <?php
                    foreach ($opt_arr as $opt) {
                        if ($edit && $opt == $post['exper']) {
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
                <label for="vacancy">Vacancies</label>
                <input class="form-control " min="1" placeholder="Vacancies" name="vacancy" id="vacancy" type="number" value="<?php echo htmlspecialchars($edit ? $post['vacancy'] : '', ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="deadline">Deadline</label>
                <input class="form-control "  type="date" name="deadline" id="deadline" placeholder="Deadline" value="<?php echo htmlspecialchars($edit ? $post['deadline'] : '', ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="salary">Salary Range</label>
                <input type="text" class="form-control " name="salary" id="salary" placeholder="Salary Range" value="<?php echo htmlspecialchars($edit ? $post['salary'] : '', ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
        </div>   
    </div>       
</fieldset>