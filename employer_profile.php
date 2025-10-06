<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';

// Per page limit for pagination.
$pagelimit = 5;

// Get current page.
$page = filter_input(INPUT_GET, 'page');
if (!$page) {
	$page = 1;
}

// Sanitize if you want
$employer_id = $_SESSION['user_id'];

$db = getDbInstance();

$db->join("register_user u", "e.reg_no=u.reg_no", "LEFT");
$db->Where("e.reg_no", $employer_id);
$employer = $db->getOne ("employers e", null, "u.user_name, u.email, u.password, e.img, e.address, e.company_name, e.cReg_no, e.phone, e.tagline, e.website, e.fb_link, e.reg_no, e.twitter_link, e.linkedin_link, e.company_description");
//We are using same form for adding and editing. This is a create form so declare $edit = false.
$edit = false;

require_once 'includes/header.php'; 
?>

<main>
    <div class="bradcam_area hero">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="bradcam_text">
                <h3>Company Profile</h3>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="mt-3">
    <?php 
        include_once('includes/flash_messages.php');
    ?>
    </div>
    <div class="mx-5 mt-4">
    <div class="row flex-lg-nowrap">
        <div class="col">
            <div class="row">
                <div class="col-md-8 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="e-profile">
                                <div class="row">
                                    <div class="col-12 col-sm-auto mb-3">
                                        <div class="mx-auto" style="width: 140px;">
                                            <div class="d-flex justify-content-center align-items-center rounded" style="height: 140px; background-color: rgb(233, 236, 239);">
                                                <span style="color: rgb(166, 168, 170); font: bold 8pt Arial;"><img src="<?php echo xss_clean($employer['img']); ?>" alt="image" class="img-fluid"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                                        <div class="text-center text-sm-left mb-2 mb-sm-0">
                                            <h3 class="pt-sm-2 pb-1 mb-0 text-nowrap"><?php echo xss_clean($employer['company_name']); ?></h3>
                                            <p class="mb-0"><?php echo xss_clean($employer['user_name']); ?></p>
                                            <p class="mb-0"><?php echo xss_clean($employer['tagline']); ?></p>
                                        </div>
                                    </div>
                                    <div class="container">
                                        <div class="p-3 d-flex bg-light heading">
                                            <div class="col-md-6">
                                                <h2>Profile</h2>
                                            </div>
                                            
                                            <div class="col-md-6 text-right">
                                                <a href="edit_employer.php?user_id=<?php echo $employer['reg_no']; ?>&operation=edit" class="btn btn-primary mx-1"><i class="fa fa-edit fa-fw"></i> Edit Profile</a>
                                                <a href="" class="btn btn-danger mx-1"  data-toggle="modal" data-target="#confirm-delete-<?php echo $employer['reg_no']; ?>"><i class="fa fa-trash-alt"></i> Delete Profile</a>
                                            </div>
                                        </div>
                                        
                                        </div>
                                    </div>
                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="confirm-delete-<?php echo $employer['reg_no']; ?>" role="dialog">
                                    <div class="modal-dialog">
                                        <form action="delete_employer.php" method="POST">
                                            <!-- Modal content -->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h4 class="modal-title">Confirm</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                <input type="hidden" name="del_id" id="del_id" value="<?php echo $employer['reg_no']; ?>">
                                                <p>Are you sure you want to delete this row?</p>
                                                </div>
                                                <div class="modal-footer">
                                                <button type="submit" class="btn btn-default pull-left">Yes</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- //Delete Confirmation Modal -->
                                <div class="tab-content pt-3">
                                <!-- Profile Form -->
                                    <?php include_once './forms/employer_profile_form.php'; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <?php 
                            //Get DB instance. i.e instance of MYSQLiDB Library
                            $db = getDbInstance();
                            $db->where('author_id',$employer_id);
                            
                            // Get result of the query.
                            $posts = $db->get('post');
                        
                            // print_r($posts); die();
                            
                            ?>
                        <div class="card-body w-100 overflow-auto">
                            
                            <h6 class="card-title font-weight-bold">Jobs Posted</h6>
                            <?php foreach ($posts as $post): ?>
                                <?php if ($post['approval'] == 1): ?>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <a href="detail_job.php?post_id=<?php echo xss_clean($post['id']); ?>" class="pt-2 card-text d-block ol"><?php echo xss_clean($post['job_title']); ?></a>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="edit_post.php?post_id=<?php echo $post['id']; ?>&operation=edit" class="btn btn-primary"><i class="fa fa-edit fa-fw"></i></a>

                                            <a href="#" class="btn btn-danger delete_btn" data-toggle="modal" data-target="#confirm-delete-<?php echo $post['id']; ?>"><i class="fa fa-trash-alt"></i></a>
                                        </div>
                                    </div>
                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="confirm-delete-<?php echo $post['id']; ?>" role="dialog">
                                        <div class="modal-dialog">
                                            <form action="delete_post.php" method="POST">
                                                <!-- Modal content -->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h4 class="modal-title">Confirm</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="del_id" id="del_id" value="<?php echo $post['id']; ?>">
                                                        <p>Are you sure you want to delete this row?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-default pull-left">Yes</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- //Delete Confirmation Modal -->
                                <?php endif;?>
                            <?php endforeach;?>
                            <div>
                                <hr>
                            </div>
                            <h6 class="card-title font-weight-bold">Pending</h6>
                            <?php foreach ($posts as $post): ?>
                                <?php if ($post['approval'] != 1): ?>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <a href="detail_job.php?post_id=<?php echo xss_clean($post['id']); ?>" class="pt-2 card-text d-block ol"><?php echo xss_clean($post['job_title']); ?></a>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="edit_post.php?post_id=<?php echo $post['id']; ?>&operation=edit" class="btn btn-primary"><i class="fa fa-edit fa-fw"></i></a>

                                            <a href="#" class="btn btn-danger delete_btn" data-toggle="modal" data-target="#confirm-delete-<?php echo $post['id']; ?>"><i class="fa fa-trash-alt"></i></a>
                                        </div>
                                    </div>
                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="confirm-delete-<?php echo $post['id']; ?>" role="dialog">
                                        <div class="modal-dialog">
                                            <form action="delete_post.php" method="POST">
                                                <!-- Modal content -->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h4 class="modal-title">Confirm</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="del_id" id="del_id" value="<?php echo $post['id']; ?>">
                                                        <p>Are you sure you want to delete this row?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-default pull-left">Yes</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- //Delete Confirmation Modal -->
                                <?php endif;?>
                            <?php endforeach;?>
                            <div>
                                <hr>
                            </div>
                            <?php 
                                //Get DB instance. i.e instance of MYSQLiDB Library
                                $db = getDbInstance();
                                $db->join('post p', 'p.id=f.post_id', 'INNER');
                                $db->where('f.user_id',$employer_id);
                                
                                // Get result of the query.
                                $fvrts = $db->get('fvrt_jobs f', null, "p.job_title, p.id, p.approval, f.fvrt_job_id, f.user_id, f.post_id");
                                
                                // print_r($posts); die();
                           
                            ?>
                           <h6 class="card-title font-weight-bold">Favourite Jobs</h6>
                           <?php foreach ($fvrts as $fvrt): ?>
                              <?php if ($fvrt['approval'] == 1): ?>
                                 <form action="delete_fvrt.php" method="post"></form>
                                    <div class="row">
                                       <div class="col-md-8">
                                          <a href="detail_job.php?post_id=<?php echo xss_clean($fvrt['post_id']); ?>" class="pt-2 card-text d-block ol"><?php echo xss_clean($fvrt['job_title']); ?></a>
                                       </div>
                                       <div class="col-md-4">
                                          <input type="hidden" name="del_id" id="del_id" value="<?php echo $fvrt['fvrt_job_id']; ?>">

                                          <!-- <button type="submit" class="btn btn-sm pt-2"><i class="fas fa-minus-circle"></i></button> -->
                                       </div>
                                    </div>
                                 </form>
                              <?php endif;?>
                           <?php endforeach;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</main>
<script>
    $(document).ready(function(){
            $(".ggg").focusout(function(){
            $(this).css("background-color", "#FFFFFF");
            });

      $(".file_val").focusin(function(){
        $("#img_validate").text("");
      });
      $(".file_val").change(function () {
        var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'svg'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            $("#img_validate").text("Only images are allowed");
            $(this).val("")
        }
    });
    $(".logo_val").focusin(function(){
        $("#logo_val").text("");
      });
      $(".logo_val").change(function () {
        var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'svg'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            $("#logo_val").text("Only images are allowed");
            $(this).val("")
        }
    });
    });
</script>

<script>
    $(document).ready(function(){
    $(".btn1").click(function(){
        $("p").fadeOut(2000);
    });
    $(".btn2").click(function(){
        $("p").fadeIn();
    });
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
    $("#job_post_form").validate({
        rules: {
                company_name: {
                    required: true,
                    minlength: 3
                },
                job_title: {
                    required: true,
                    minlength: 3
                },   
            }
        });
    });
</script>

<?php include_once 'includes/footer.php'; ?>