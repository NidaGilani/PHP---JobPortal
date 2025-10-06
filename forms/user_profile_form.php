<div class="tab-pane active" id="profile">
    <form class="form" novalidate="">
        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                        <label>User Name:</label>
                        <p class="form-control"  name="user_name"><?php echo xss_clean($user['user_name']); ?></p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                        <label>First Name:</label>
                        <p class="form-control"  name="f_name"><?php echo xss_clean($user['f_name']); ?></p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                        <label>Last Name:</label>
                        <p class="form-control"  name="l_name"><?php echo xss_clean($user['l_name']); ?></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                        <label>Gender</label>
                        <p class="form-control"  name="gender"><?php echo xss_clean($user['gender']); ?></p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                        <label>Field </label>
                        <p class="form-control"  name="field"><?php echo xss_clean($user['field']); ?></p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                        <label>Contact:</label>
                        <p class="form-control"  name="phone"><?php echo xss_clean($user['phone']); ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col mb-3">
                        <div class="form-group">
                        <label>Address</label>
                        <p class="form-control"  name="address"><?php echo xss_clean($user['address']); ?></p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                        <label>Email:</label>
                        <p class="form-control" style="overflow:auto" name="email"><?php echo xss_clean($user['email']); ?></p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                        <label>Date of birth:</label>
                        <p class="form-control"  name="date_of_birth"><?php echo xss_clean($user['date_of_birth']); ?></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                        <label>Account Created At:</label>
                        <p class="form-control"  name="created_at"><?php echo xss_clean($user['created_at']); ?></p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                        <label>Account Last Updated At:</label>
                        <p class="form-control"  name="updated_at"><?php echo xss_clean($user['updated_at']); ?></p>
                        </div>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </form>
</div>