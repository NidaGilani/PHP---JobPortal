<fieldset>
    <div class="form-group">
        <label for="user_name">User Name *</label>
        <input type="text" name="user_name" value="<?php echo htmlspecialchars($edit ? $employer['user_name'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="User Name" class="form-control" required="required" id = "user_name" >
    </div> 

    <div class="form-group">
        <label for="password">Password *</label>
        <input type="text" name="password" value="<?php echo htmlspecialchars($edit ? $employer['password'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Password" class="form-control" required="required" id = "password" >
    </div>  

    <div class="form-group">
        <label for="address">Address</label>
        <textarea name="address" placeholder="Address" class="form-control" id="address"><?php echo htmlspecialchars(($edit) ? $employer['address'] : '', ENT_QUOTES, 'UTF-8'); ?></textarea>
    </div>

    <div class="form-group">
        <label for="company">Company*</label>
        <input  type="text" name="company_name" value="<?php echo htmlspecialchars($edit ? $employer['company_name'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Company Name" class="form-control" id="company_name">
    </div>

    <div class="form-group">
        <label for="cReg_no">Company Registration no*</label>
        <input  type="text" name="cReg_no" value="<?php echo htmlspecialchars($edit ? $employer['cReg_no'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Company Registration no" class="form-control" id="cReg_no">
    </div> 
    
    <div class="form-group">
        <label>Tagline </label>
        <input  type="text" name="tagline" value="<?php echo htmlspecialchars($edit ? $employer['tagline'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Tagline" class="form-control" id="tagline">
    </div> 

    <div class="form-group">
        <label>Compant Description </label>
        <textarea name="company_description" placeholder="Description" class="form-control" id="company_description"><?php echo htmlspecialchars(($edit) ? $employer['company_description'] : '', ENT_QUOTES, 'UTF-8'); ?></textarea>

    </div>

    <div class="form-group">
        <label for="img">Company Logo</label>
        <input  type="file" name="img" value="<?php echo htmlspecialchars($edit ? $employer['img'] : '', ENT_QUOTES, 'UTF-8'); ?>" class="form-control" id="img">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input  type="email" name="email" value="<?php echo htmlspecialchars($edit ? $employer['email'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="E-Mail Address" class="form-control" id="email">
    </div>

    <div class="form-group">
        <label for="phone">Phone</label>
        <input name="phone" value="<?php echo htmlspecialchars($edit ? $employer['phone'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="987654321" class="form-control"  type="text" id="phone">
    </div> 

    <div class="form-group">
        <label for="website">Website (Opetional) </label>
        <input name="website" value="<?php echo htmlspecialchars($edit ? $employer['website'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="https://" class="form-control"  type="text" id="website">
    </div>

    <div class="form-group">
        <label for="fb_link">Facebook Link (Opetional) </label>
        <input name="fb_link" value="<?php echo htmlspecialchars($edit ? $employer['fb_link'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Company" class="form-control"  type="text" id="fb_link">
    </div>

    <div class="form-group">
        <label for="twitter_link">Twitter Link (Opetional) </label>
        <input name="twitter_link" value="<?php echo htmlspecialchars($edit ? $employer['twitter_link'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="@Company" class="form-control"  type="text" id="twitter_link">
    </div>

    <div class="form-group">
        <label for="linkedin_link">Linkedin Link (Opetional) </label>
        <input name="linkedin_link" value="<?php echo htmlspecialchars($edit ? $employer['linkedin_link'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="CompanyName" class="form-control"  type="text" id="linkedin_link">
    </div>

    <div class="form-group text-center">
        <label></label>
        <button type="submit" class="btn btn-dark" >Save <span class="glyphicon glyphicon-send"></span></button>
    </div>            
</fieldset>
