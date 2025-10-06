<div class="tab-pane active" id="profile">
    <form class="form" novalidate="">
        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                        <label>User Name:</label>
                        <p class="form-control"  name="user_name"><?php echo xss_clean($employer['user_name']); ?></p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                        <label>Company Name:</label>
                        <p class="form-control"  name="company_name"><?php echo xss_clean($employer['company_name']); ?></p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                        <label>Registration No:</label>
                        <p class="form-control"  name="cReg_no"><?php echo xss_clean($employer['cReg_no']); ?></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    
                    <div class="col">
                        <div class="form-group">
                        <label>Description </label>
                        <p style = "overflow: auto" class="form-control"  name="company_description"><?php echo xss_clean($employer['company_description']); ?></p>
                        </div>
                    </div>
                    
                </div>
                
                <div class="row">

                    <div class="col">
                        <div class="form-group">
                        <label>Website</label>
                        <p style = "overflow: auto" class="form-control"  name="website"><?php echo xss_clean($employer['website']); ?></p>
                        </div>
                    </div>
                    <div class="col mb-3">
                        <div class="form-group">
                        <label>Address</label>
                        <p style = "overflow: auto" class="form-control"  name="address"><?php echo xss_clean($employer['address']); ?></p>
                        </div>
                    </div>
                    
                    <div class="col">
                        <div class="form-group">
                        <label>Email:</label>
                        <p class="form-control"  name="email"><?php echo xss_clean($employer['email']); ?></p>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col">
                        <div class="form-group">
                        <label>Facebook</label>
                        <p style = "overflow: auto" class="form-control"  name="fb_link"><?php echo xss_clean($employer['fb_link']); ?></p>
                        </div>
                    </div>
                    <div class="col mb-3">
                        <div class="form-group">
                        <label>Twitter</label>
                        <p style = "overflow: auto" class="form-control"  name="twitter_link"><?php echo xss_clean($employer['twitter_link']); ?></p>
                        </div>
                    </div>
                    
                    <div class="col">
                        <div class="form-group">
                        <label>Linked in:</label>
                        <p style = "overflow: auto" class="form-control"  name="linkedin_link"><?php echo xss_clean($employer['linkedin_link']); ?></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                        <label>Contact:</label>
                        <p class="form-control"  name="phone"><?php echo xss_clean($employer['phone']); ?></p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                        <label>Account Created At:</label>
                        <p class="form-control"  name="created_at"><?php echo xss_clean($employer['created_at']); ?></p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                        <label>Account Last Updated At:</label>
                        <p class="form-control"  name="updated_at"><?php echo xss_clean($employer['updated_at']); ?></p>
                        </div>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </form>
</div>