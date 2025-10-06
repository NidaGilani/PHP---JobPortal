<div class="single_jobs white-bg d-flex justify-content-between">
    <div class="jobs_left d-flex align-items-center">
        <div class="img-fluid">
            <img src="<?php echo xss_clean($fvrt['f_image']); ?>" style="width: 90px; height:80px;" alt="" class="icon" alt="">
        </div>
        <div class="jobs_conetent ml-3">
            <a href="detail_job.php?post_id=<?php echo xss_clean($fvrt['id']); ?>">
            <h4><?php echo xss_clean($fvrt['job_title']); ?></h4>
            </a>
            <div class="links_locat d-flex align-items-center">
            <div class="location">
                <p> <i class="fa fa-map-marker"></i> <?php echo xss_clean($fvrt['job_region'] . ' ' . $fvrt['loc']); ?></p>
            </div>
            <div class="location">
                <p> <i class="far fa-clock"></i> <?php echo xss_clean($fvrt['job_type']); ?></p>
            </div>
            </div>
        </div>
    </div>
    <div class="jobs_right">
        <div class="apply_now">
            <a class="heart_mark bg-light mx-3" href="fvrt_job.php?post_id=<?php echo xss_clean($fvrt['id']); ?>&user_id=<?php echo $_SESSION['user_id'];?>"> <i class="fa fa-heart"></i> </a>
            <a href="detail_job.php?post_id=<?php echo xss_clean($fvrt['id']); ?>&user_id=<?php echo $_SESSION['user_id'];?>" class="boxed-btn3 btn btn-peimary">Apply Now</a>
        </div>
        <div class="date">
            <p>Date line: <?php echo xss_clean($fvrt['deadline']); ?></p>
        </div>
    </div>
</div>
