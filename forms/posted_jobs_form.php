<div class="single_jobs white-bg d-flex justify-content-between">
    <div class="jobs_left d-flex align-items-center">
        <div class="img-fluid">
            <img src="<?php echo xss_clean($job['f_image']); ?>" style="width: 90px; height:80px;" alt="" class="icon" alt="">
        </div>
        <div class="jobs_conetent">
            <a href="detail_job.php?post_id=<?php echo xss_clean($job['id']); ?>">
            <h4><?php echo xss_clean($job['job_title']); ?></h4>
            </a>
        </div>
    </div>
    <div class="jobs_right">
        <div class="apply_now">
            <a class="btn btn-primary" href="edit_job.php?post_id=<?php echo xss_clean($job['id']); ?>&operation=edit"> <i class="fa fa-edit fa-fw"></i></i> </a>
            <a href="delete_job.php?post_id=<?php echo xss_clean($job['id']); ?>" class="btn btn-danger"><i class="fa fa-trash-alt"></i></a>
        </div>
    </div>
</div>