<fieldset>
    <div class="row">
        <div class="col-md-12">
        <div class="input_field">
            <input type="text" name="name" placeholder="Your name">
        </div>
        </div>
        <div class="col-md-6">
        <div class="input_field">
            <input type="text" name="sender_email" placeholder="Email">
        </div>
        </div>
        <div class="col-md-6">
        <div class="input_field">
            <input type="password" name="password" placeholder="Password">
        </div>
        </div>
        <div class="col-md-12">
        <div class="input_field">
            <input type="text" name="website" placeholder="Website/Portfolio link">
        </div>
        </div>
        <div class="col-md-12">
        <div class="input-group">
            <div class="input-group-prepend">
                <button type="button" id="inputGroupFileAddon03"><i class="fa fa-upload" aria-hidden="true"></i>
                </button>
            </div>
            <div class="custom-file">
                <label class="custom-file-label" for="file">Upload Cover Letter</label>
                <input type="file" name="file" class="custom-file-input" id="file" aria-describedby="inputGroupFileAddon03">
                
            </div>
        </div>
        </div>
        <div class="col-md-12">
        <div class="input_field">
            <textarea name="message" id="" cols="30" rows="10" placeholder="Message"></textarea>
        </div>
        </div>
        <?php $current_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>
        <div class="col-md-12">
        <div class="submit_btn">
            <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == TRUE): ?>
                <button class="boxed-btn3 w-100" type="submit">Apply Now</button>
            <?php else: ?>
                <a class="boxed-btn3 w-100" href="login.php?redirect=<?php echo $current_url;?>">Apply Now</a>
            <?php endif;?>
        </div>
        </div>
    </div>
</fieldset>
