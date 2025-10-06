<?php
session_start();
require_once 'config/config.php';
// require_once BASE_PATH . '/includes/auth_validate.php';

// if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == TRUE){ 
// $user_id = $_SESSION['user_id'];
// }
// Costumers class
require_once BASE_PATH . '/lib/Jobs/Jobs.php';
$jobs = new Jobs();

// Get Input data from query string
$search_string = filter_input(INPUT_GET, 'search_string');
$filter_col = filter_input(INPUT_GET, 'filter_col');
$order_by = filter_input(INPUT_GET, 'order_by');

// Per page limit for pagination.
$pagelimit = 8;

// Get current page.
$page = filter_input(INPUT_GET, 'page');
if (!$page) {
	$page = 1;
}

// If filter types are not selected we show latest added data first
if (!$filter_col) {
	$filter_col = 'deadline';
}
if (!$order_by) {
	$order_by = 'Desc';
}

//Get DB instance. i.e instance of MYSQLiDB Library
$db = getDbInstance();
$select = array('id', "email", "job_title", "loc", "job_region", "job_type", "job_desc", 'company_name', 'website', 'fb_link', 'twitter_link', 'linkedin_link', 'approval', 'f_image', 'job_resp', 'job_benefit', 'gender', 'quali', 'exper', 'vacancy', 'deadline', 'salary', 'phone', 'publish_date', 'job_cat','author_id');

//Start building query according to input parameters.
// If search string
if ($search_string) {
	$db->where('job_title', '%' . $search_string . '%', 'like');
    $db->orwhere('job_type', '%' . $search_string . '%', 'like');
    $db->orwhere('loc', '%' . $search_string . '%', 'like');
    $db->orwhere('company_name', '%' . $search_string . '%', 'like');
    $db->orwhere('gender', '%' . $search_string . '%', 'like');
    $db->orwhere('quali', '%' . $search_string . '%', 'like');
    $db->orwhere('exper', '%' . $search_string . '%', 'like');
    $db->orwhere('job_cat', '%' . $search_string . '%', 'like');
}

//If order by option selected
if ($order_by) {
	$db->orderBy($filter_col, $order_by);
}

// Set pagination limit
$db->pageLimit = $pagelimit;

// Get result of the query.
$rows = $db->arraybuilder()->paginate('post', $page, $select);
$total_pages = $db->totalPages;

$numJobs = $db->getValue ("post", "count(*)");

$categories    = $db->get('job_categories');
$states        = $db->get('states');
$cities        = $db->get('cities');
$job_types     = $db->get('job_types');

include BASE_PATH . '/includes/header.php';
?>

<div class="bradcam_area hero">
   <div class="container">
      <div class="row">
         <div class="col-xl-12">
            <div class="bradcam_text">
               <h3><?php echo $numJobs;?>+ Jobs Available</h3>
            </div>
         </div>
      </div>
   </div>
</div>

<?php 
   include_once('includes/flash_messages.php');
?>

<div class="job_listing_area plus_padding">
   <div class="container">
      <div class="row">
         <div class="col-lg-3">
            <div class="job_filter white-bg">
               <div class="form_inner white-bg">
                  <h3>Filter</h3>
                  <form action="" id="filter_form" >
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="single_field form-group">
                                <input type="text" class="form-control-sm Job" id="input_search" name="search_string" value="<?php echo xss_clean($search_string); ?>" placeholder="Search keywords">
                           </div>
                        </div>
                        <div class="col-lg-12">
                           <div class="single_field form-group">
                           <label>Location</label>
                           <select name="job_region" id="loc-filter" class="form-control" required>
                              
                              <option value="all" selected >All</option>
                                <?php
                                    foreach($rows as $job) { ?>
                                       <option value="<?= $job['loc'] ?>"><?= $job['loc'] ?></option>
                                    <?php }
                                ?>
                            </select>
                           </div>
                        </div>
                        <div class="col-lg-12">
                           <div class="single_field form-group">
                           <label>Category</label>
                           <select name="job_cat" id="cat-filter" class="form-control  Job" required>
                           <option value="all" selected>All</option>
                                <?php
                                    foreach($categories as $cat) { ?>
                                       <option value="<?= $cat['cat_name'] ?>"><?= $cat['cat_name'] ?></option>
                                    <?php }
                                ?>
                            </select>
                           </div>
                        </div>
                        <div class="col-lg-12">
                           <div class="single_field form-group">
                           <label>Job Type</label>
                           <select name="job_type" id="type-filter" class="form-control  Job" required>
                           <option value="all" selected>All</option>
                                <?php
                                    foreach($job_types as $job_type) { ?>
                                       <option value="<?= $job_type['job_type'] ?>"><?= $job_type['job_type'] ?></option>
                                    <?php }
                                ?>
                            </select>
                           </div>
                        </div>
                        <div class="col-lg-12">
                           <div class="single_field form-group">
                           <label>Qualification</label>
                           <?php $quali_arr = array("BSCS", "BSIT", "BSSE", "BBA", "MBA", "BCOM", "BA", "BS Mathematics", "Linguistics", "Economics"); 
                           ?>
                            <select name="quali" id="quali-filter" class="form-control  Job" required>
                            <option value="all" selected>All</option>
                                <?php
                                    foreach($quali_arr as $quali) { ?>
                                       <option value="<?= $quali ?>"><?= $quali ?></option>
                                    <?php }
                                ?>
                            </select>
                           </div>
                        </div>
                        <div class="col-lg-12">
                           <div class="single_field form-group">
                           <label>Gender</label>
                           <?php $gender_arr = array("Male", "Female", "Both"); 
                           ?>
                           <select name="gender" id="gender-filter" class="form-control selectpicker Job" required>
                              <option value="all" selected>All</option>
                                <?php
                                    foreach($gender_arr as $gender) { ?>
                                       <option value="<?= $gender ?>"><?= $gender ?></option>
                                    <?php }
                                ?>
                            </select>
                           </div>
                        </div>
                         
                     </div>
                     <div class="reset_btn form-group mt-4">
                           <button id="reset-jobs" class="btn btn-block boxed-btn3 w-100" type="reset">Reset</button>
                        </div>
                  </form>
               </div>
               
               
            </div>
         </div>
         <div class="col-lg-9">
            <div class="recent_joblist_wrap">
               <div class="recent_joblist white-bg ">
                  <div class="row align-items-center">
                     <div class="col-md-6">
                        <h4>Job Listing</h4>
                     </div>
                     <div class="col-md-6">
                        <div class="serch_cat d-flex justify-content-end form-group">
                            <form class="form form-inline" action="">
                                <select name="filter_col" class="form-control wide mx-2"><i class="fa fa-"></i>
                                    <?php
                                        foreach ($jobs->setOrderingValues() as $opt_value => $opt_name):
                                            ($order_by === $opt_value) ? $selected = 'selected' : $selected = '';
                                            echo ' <option value="' . $opt_value . '" ' . $selected . '>' . $opt_name . '</option>';
                                        endforeach;
                                        ?>
                                </select>
                                <select name="order_by" class="form-control wide" id="input_order">
                                    <option value="Asc" <?php
                                        if ($order_by == 'Asc') {
                                            echo 'selected';
                                        }
                                        ?> >Asc</option>
                                                        <option value="Desc" <?php
                                        if ($order_by == 'Desc') {
                                            echo 'selected';
                                        }
                                        ?>>Desc
                                    </option>
                                </select>
                                <input type="submit" value="Go" class="btn boxed-btn3 m-3 pt-2">
                            </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="job_lists m-0">
               <div class="row">
                <?php foreach ($rows as $row): ?>
                  <?php if ($row['approval'] == 1): ?> 
                     <div class="col-lg-12 col-md-12">
                        <?php 
                           $db->join("post p", "p.author_id=c.reg_no", "LEFT");
                           // $db->where('c.reg_no', $row['author_id']);
                           // $db->where('p.id', $row['id']);
                           $company_logo = $db->getOne("employers c", null, "c.img, c.reg_no, p.author_id");
                           // print_r($company_logo);die(); 
                        ?>
                        <div data-loc="<?= $row['loc'] ?>" id="job-<?= $row['id'] ?>" class="job">
                           <div class="single_jobs white-bg d-flex justify-content-between">
                              <div class="jobs_left d-flex align-items-center">
                                 <div class="img-fluid">
                                    <img src="<?php echo xss_clean($company_logo['img']); ?>" style="width: 90px; height:80px;" alt="" class="icon" alt="">
                                 </div>
                                 <div class="jobs_conetent ml-3">
                                    <a href="detail_job.php?post_id=<?php echo xss_clean($row['id']); ?>">
                                       <h4><?php echo xss_clean($row['job_title']); ?></h4>
                                    </a>
                                    <div class="links_locat d-flex align-items-center">
                                       <div class="location">
                                          <p> <i class="fa fa-map-marker"></i> <?php echo xss_clean($row['job_region'] . ' ' . $row['loc']); ?></p>
                                       </div>
                                       <div class="location">
                                          <p> <i class="far fa-clock"></i> <?php echo xss_clean($row['job_type']); ?></p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="jobs_right">
                                 <div class="apply_now">
                                    <?php
                                       // $db = getDbInstance();
                                       // $db->where('post_id', $row['id']);
                                       // $db->where('user_id', $_SESSION['user_id']);
                                       // $db->getOne('applied_jobs');
                                       // if($db->count >=1):
                                    ?>
                                    <a href="detail_job.php?post_id=<?php echo xss_clean($row['id']); ?>" class="boxed-btn3 btn btn-peimary">Apply Now</a>
                                 </div>
                                 <div class="date">
                                    <p>Date line: <?php echo xss_clean($row['deadline']); ?></p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <?php endif;?>
                  <?php endforeach;?>
               </div>
               <div class="row">
                  <div class="col-lg-12 d-flex justify-content-center">
                     <div class="pagination pagination_wrap">
                        <?php echo paginationLinks($page, $total_pages, 'browse-job.php'); ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>


<!-- <script src="assets/js/app.js"></script> -->

<?php include_once('includes/footer.php'); ?>