<fieldset>

    <div class="my-4">

        <div class="form-group">
            <label for="company_name">Company Name</label>
            <input class="form-control " value="<?php echo htmlspecialchars($edit ? $employer['company_name'] : '', ENT_QUOTES, 'UTF-8'); ?>" type="text" name="company_name" id="company_name" placeholder="company Name" required>
        </div>

        <div class="form-group">
            <label for="cReg_no">Registration No</label>
            <input class="form-control " value="<?php echo htmlspecialchars($edit ? $employer['cReg_no'] : '', ENT_QUOTES, 'UTF-8'); ?>" type="text" name="cReg_no" id="cReg_no" required>
        </div>
        
        <div class="form-group">
            <label for="tagline">Tagline (Optional)</label>
            <input class="form-control " id="tagline" value="<?php echo htmlspecialchars($edit ? $employer['tagline'] : '', ENT_QUOTES, 'UTF-8'); ?>" type="text" name="tagline" placeholder="Tag line">
        </div>
        
        <div class="form-group">
            <label for="company_description">Comapny Description (Optional)</label>
            <textarea class="form-control" id="company_description" cols="30" rows="10" name="company_description" placeholder="Comapny Description"><?php echo htmlspecialchars($edit ? $employer['company_description'] : '', ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input class="form-control " value="<?php echo htmlspecialchars($edit ? $employer['email'] : '', ENT_QUOTES, 'UTF-8'); ?>" type="email" name="email" id="email" placeholder="Email" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input class="form-control " readonly value="<?php echo htmlspecialchars($edit ? $employer['password'] : '', ENT_QUOTES, 'UTF-8'); ?>" type="password" name="password" id="password" required>
        </div>

        <div class="form-group">
            <label for="user_name">User Name</label>
            <input class="form-control " value="<?php echo htmlspecialchars($edit ? $employer['user_name'] : '', ENT_QUOTES, 'UTF-8'); ?>" type="text" name="user_name" id="user_name" readonly>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input class="form-control " value="<?php echo htmlspecialchars($edit ? $employer['address'] : '', ENT_QUOTES, 'UTF-8'); ?>" type="text" name="address" id="address" >
        </div>
        
        <div class="form-group">
            <label for="website">Website (Optional)</label>
            <input class="form-control " id="website" type="text" name="website" value="<?php echo htmlspecialchars($edit ? $employer['website'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="http://">
        </div>
        
        <div class="form-group">
            <label for="fb_link">Facebook Link (Optional)</label>
            <input class="form-control " id="fb_link" type="text" name="fb_link" value="<?php echo htmlspecialchars($edit ? $employer['fb_link'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="companyname">
        </div>
        
        <div class="form-group">
            <label for="twitter_link">Twitter Link (Optional)</label>
            <input class="form-control " id="twitter_link" type="text" name="twitter_link" value="<?php echo htmlspecialchars($edit ? $employer['twitter_link'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="@companyname">
        </div>
        
        <div class="form-group">
            <label for="linkedin_link">Linkedin Link (Optional)</label>
            <input class="form-control " id="linkedin_link" type="text" name="linkedin_link" value="<?php echo htmlspecialchars($edit ? $employer['linkedin_link'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="linkedin_link">
        </div>
        
        <div class="form-group">
            <label for="phone">Phone (Optional)</label>
            <input class="form-control " type="phone" id="phone" name="phone" value="<?php echo htmlspecialchars($edit ? $employer['phone'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Phone Number">
        </div>
        
        <div class="form-group">
            <h6>Upload Logo</h6>
            <input type="file" name="img" id="logo_val" value="<?php echo htmlspecialchars($edit ? $employer['img'] : '', ENT_QUOTES, 'UTF-8'); ?>" class="logo_val form-control" >
            <span id="logo_val"></span>
        </div>

    </div>
</fieldset>