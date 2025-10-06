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
$user_id = $_SESSION['user_id'];

$db = getDbInstance();

$db->join("register_user u", "a.reg_no=u.reg_no", "LEFT");
$db->Where("a.reg_no", $user_id);
$user = $db->getOne ("applicants a", null, "u.user_name, u.email, u.password, u.reg_no, a.f_name, a.l_name, a.field, a.img, a.gender, a.address, a.city, a.state, a.phone, a.date_of_birth");

// $fvrts = $db->getOne("fvrt_jobs");
// $jobs = $db->getOne("post");
// print_r($user); die();

include BASE_PATH . '/includes/header.php';
?>

<div class="bradcam_area bradcam_bg_1 hero">
   <div class="container">
      <div class="row">
         <div class="col-xl-12">
            <div class="bradcam_text">
               <h3>User Profile</h3>
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
<div class="w-80 mx-5  my-4">
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
                                    <span style="color: rgb(166, 168, 170); font: bold 8pt Arial;"><img width="140px" height="140px" src="<?php echo xss_clean($user['img']); ?>" alt="image" class="img-fluid"></span>
                                 </div>
                              </div>
                           </div>
                           <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                              <div class="text-center text-sm-left mb-2 mb-sm-0">
                                 <h3 class="pt-sm-2 pb-1 mb-0 text-nowrap"><?php echo xss_clean($user['f_name'] . ' ' . $user['l_name']); ?></h3>
                                 <p class="mb-0"><?php echo xss_clean($user['user_name']); ?></p>
                                 <p class="mb-0"><?php echo xss_clean($user['email']); ?></p>
                              </div>
                           </div>
                           <div class="container">
                              <div class="p-3 d-flex bg-light heading">
                                 <div class="col-md-6">
                                    <h2>Profile</h2>
                                 </div>
                                 
                                 <div class="col-md-6 text-right">
                                    <a href="edit_applicant.php?user_id=<?php echo $user['reg_no']; ?>&operation=edit" class="btn btn-primary mx-1"><i class="fa fa-edit fa-fw"></i> Edit Profile</a>
                                    <a href="" class="btn btn-danger mx-1"  data-toggle="modal" data-target="#confirm-delete-<?php echo $user['reg_no']; ?>"><i class="fa fa-trash-alt"></i> Delete Profile</a>
                                 </div>
                              </div>
                              
                            </div>
                          </div>
                           <!-- Delete Confirmation Modal -->
                           <div class="modal fade" id="confirm-delete-<?php echo $user['reg_no']; ?>" role="dialog">
                              <div class="modal-dialog">
                                 <form action="delete_applicant.php" method="POST">
                                    <!-- Modal content -->
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <h4 class="modal-title">Confirm</h4>
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                       </div>
                                       <div class="modal-body">
                                          <input type="hidden" name="del_id" id="del_id" value="<?php echo $user['reg_no']; ?>">
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
                              <?php include_once './forms/user_profile_form.php'; ?>
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
                           $db->join('post p', 'p.id=f.post_id', 'INNER');
                           $db->where('f.user_id',$user_id);
                           
                           // Get result of the query.
                           $fvrts = $db->get('fvrt_jobs f', null, "p.job_title, p.id, p.approval, f.fvrt_job_id, f.user_id, f.post_id");
                        
                           // print_r($posts); die();
                           
                        ?>
                        <div class="card-body w-100 overflow-auto">
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
                           <div>
                              <hr>
                           </div>
                           <?php 
                           //Get DB instance. i.e instance of MYSQLiDB Library
                           $db = getDbInstance();
                           $db->join('post p', 'p.id=a.post_id', 'INNER');
                           $db->where('a.applicant_id',$user_id);
                           
                           // Get result of the query.
                           $applied = $db->get('applied_jobs a', null, "p.job_title, p.approval, a.id, a.applicant_id, a.post_id");
                        
                           // print_r($posts); die();
                           
                           ?>
                           <h6 class="card-title font-weight-bold">Applied Jobs</h6>
                           <?php foreach ($applied as $apply): ?>
                              <?php if ($apply['approval'] == 1): ?>
                                 <form action="delete_applied_job.php" method="post"></form>
                                    <div class="row">
                                       <div class="col-md-8">
                                          <a href="detail_job.php?post_id=<?php echo xss_clean($apply['post_id']); ?>" class="pt-2 card-text d-block ol"><?php echo xss_clean($apply['job_title']); ?></a>
                                       </div>
                                       <div class="col-md-4">
                                       <input type="hidden" name="del_id" id="del_id" value="<?php echo $apply['id']; ?>">

                                       <button type="submit" class="btn btn-sm pt-2"><i class="fas fa-minus-circle"></i></button>

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
</div>

<?php include_once('includes/footer.php'); ?>