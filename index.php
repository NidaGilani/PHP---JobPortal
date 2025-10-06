<?php
session_start();
require_once './config/config.php';
// require_once 'includes/auth_validate.php';
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
// $select = array('id', "job_title", "loc", "job_region", "job_type", 'company_name', 'approval','company_logo', 'f_image',  'gender', 'quali', 'exper', 'publish_date', 'job_cat');

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
$db->join("job_categories c", "c.cat_name=p.job_cat", "LEFT");
$rows = $db->arraybuilder()->paginate("post p", $page, "c.cat_name, c.id, c.cat_icon, p.id, p.job_cat, p.approval, p.job_title, p.loc, p.job_region, p.job_type,  p.gender, p.quali, p.exper, p.publish_date, p.deadline");
$total_pages = $db->totalPages;


//Get DB instance. function is defined in config.php

$numJobs = $db->getValue ("post", "count(*)");



$categories = $db->get('job_categories');
$cities = $db->get('cities');
// print_r($cities); die();
include_once('includes/header.php');
?>
<!-- index  -->
<main id="top">

    <!-- header -->
    <div class="slider_area mt-0">
        <div class="single_slider  d-flex align-items-center hero">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7 col-md-6">
                        <div class="slider_text">
                            <h5 class="wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".2s"><?php echo $numJobs;?>+ Jobs listed</h5>
                            <h3 class="wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".3s">Find your Dream Job</h3>
                            <p class="wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".4s">We aim to deliver a smooth and pleasant job seeking experience and to help improve the recruitment process for both jobseekers and recruiters.</p>
                            <div class="sldier_btn wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".5s">
                                <?php 
                                    // user registration number
                                    if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == TRUE) 
                                    {
                                        $user_id = $_SESSION['user_id']; 
                                        $db = getDbInstance();
                                        $db->where('reg_no', $user_id);
                                        $db->getOne('upload_resume');
                                        if($db->count >=1){

                                            $db->where('reg_no', $user_id);
                                            $resume = $db->getOne('upload_resume', 'resume');
                                            echo '<a href="download_resume.php?file='.$resume["resume"].'" class="btn btn-lg btn-light">Download your Resume</a>';
                                        }
                                        else {
                                            echo '<a href="upload_resume.php" class="btn btn-lg btn-light">Upload your Resume</a>';
                                        }
                                    }
                                    else {
                                        echo '<a href="upload_resume.php" class="btn btn-lg btn-light">Upload your Resume</a>';
                                    }
                                    ?>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ilstration_img wow fadeInRight d-none d-lg-block text-right" data-wow-duration="1s" data-wow-delay=".2s">
            <img src="assets/images/flat.svg" class="img-fluid" alt="">
        </div>
    </div>
    <!-- header -->

    <!-- search -->
    <div class="container search-section">
        <form action="" class="form-inline">
            <div class="container d-flex justify-content-center">
                <div class="form-group">
                    <input type="text" id="input_search" name="search_string" value="<?php echo xss_clean($search_string); ?>" style = "width: 225px; height: 45px; border: 1px solid #D1D1D1; border-radius: 6px;" class="text-left search-field form-control" placeholder="Search Keywords">
                    
                    <select style = "width: 225px; height: 45px; border: 1px solid #D1D1D1; border-radius: 6px;" name="filter_col" class="form-control search-field mx-2">
                        
                        <?php
                            foreach ($jobs->setOrderingValues() as $opt_value => $opt_name):
                                ($order_by === $opt_value) ? $selected = 'selected' : $selected = '';
                                echo ' <option value="' . $opt_value . '" ' . $selected . '>' . $opt_name . '</option>';
                            endforeach;
                        ?>
                    </select>
                    <select name="order_by" style = "width: 225px; height: 45px; border: 1px solid #D1D1D1; border-radius: 6px;" class="form-control search-field mx-2">
                        <option value="Asc" <?php
                            if ($order_by == 'Asc') {
                                echo 'selected';
                            }
                            ?> >Assending</option>
                                            <option value="Desc" <?php
                            if ($order_by == 'Desc') {
                                echo 'selected';
                            }
                            ?>>Descending
                        </option>
                    </select>
                    <a href="#show-result"><input type="submit" value="Find Jobs" class="btn py-2 px-4 mx-2" style="background-color: #3750B5; color: white; font-size: 18px" /></a>
                </div>
                

            </div>
        </form>
        <div class="search-tags d-flex justify-content-center mb-5 pb-4">
            <ul class="search-links">Popular Search :
                <li class="list-inline"> <a href="#"> Creative & Design </a> </li>
                <li class="list-inline"> <a href="#"> Marketing </a> </li>
                <li class="list-inline"> <a href="#"> Administration</a> </li>
                <li class="list-inline"> <a href="#"> Teaching & Education </a> </li>
                <li class="list-inline"> <a href="#"> Engineering </a> </li>
                <li class="list-inline"> <a href="#"> Software & web </a> </li>
            </ul>
        </div>
    </div>

    <!-- search -->

    <!-- manage -->
    <Section class="container-fluid h-auto manage my-5">
        <div class="container my-3 py-5">
            <div class="row my-auto text-center">
                <div class="col-lg-3 col-md-6 col-sm-12 my-3"> <img src="assets/images/resume.svg" alt="" class="img-fluid">
                    <h6 class="h6">Search million of jobs</h6>
                    <p>A small river named Duden flows
                        by their place and supplies</p>
                        <button class="lead btn btn-default text-white"  data-toggle="modal" data-target="#blog1">Read more</button>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="blog1" tabindex="-1"  aria-labelledby = "exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Search million of jobs</h5>
                              <button type="button" class="btn btn-default btn-close" data-dismiss="modal" aria-label="Close">Close</button>
                           </div>
                            <div class="modal-body">
                                <p class="text-dark">Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                                Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                                Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.

                                Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                                Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                                Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.

                                Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                                Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                                Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.

                                Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                                Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                                Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.

                                Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                                Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                                Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.

                                Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                                Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                                Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.
                                </p>
                            </div>
                            <div class="modal-footer">
                            </div>
                        </div>
                     </div>
                  </div>
                <div class="col-lg-3 col-md-6 col-sm-12 my-3"> <img src="assets/images/collaboration.svg" alt="" class="img-fluid">
                    <h6 class="h6">Easy to Manage jobs</h6>
                    <p>A small river named Duden flows
                        by their place and supplies</p>
                        <button class="lead btn btn-default text-white"  data-toggle="modal" data-target="#blog2">Read more</button>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="blog2" tabindex="-1"  aria-labelledby = "exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Search million of jobs</h5>
                              <button type="button" class="btn btn-default btn-close" data-dismiss="modal" aria-label="Close">Close</button>
                           </div>
                            <div class="modal-body">
                                <p class="text-dark">Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                                Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                                Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.

                                Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                                Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                                Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.

                                Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                                Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                                Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.

                                Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                                Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                                Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.

                                Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                                Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                                Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.

                                Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                                Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                                Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.
                                </p>
                            </div>
                            <div class="modal-footer">
                            </div>
                        </div>
                     </div>
                  </div>
                <div class="col-lg-3 col-md-6 col-sm-12 my-3"> <img src="assets/images/career-promotion.svg" alt="" class="img-fluid">
                    <h6 class="h6">Top Careers</h6>
                    <p>A small river named Duden flows
                        by their place and supplies</p>
                        <button class="lead btn btn-default text-white"  data-toggle="modal" data-target="#blog3">Read more</button>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="blog3" tabindex="-1"  aria-labelledby = "exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Search million of jobs</h5>
                              <button type="button" class="lead btn btn-default btn-close" data-dismiss="modal" aria-label="Close">Close</button>
                           </div>
                            <div class="modal-body">
                                <p class="text-dark">Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                                Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                                Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.

                                Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                                Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                                Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.

                                Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                                Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                                Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.

                                Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                                Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                                Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.

                                Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                                Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                                Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.

                                Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                                Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                                Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.
                                </p>
                            </div>
                            <div class="modal-footer">
                            </div>
                        </div>
                     </div>
                  </div>
                <div class="col-lg-3 col-md-6 col-sm-12 my-3"> <img src="assets/images/employee (1).svg" alt="" class="img-fluid">
                    <h6 class="h6">Search Expert Candidates</h6>
                    <p>A small river named Duden flows
                        by their place and supplies</p>
                        <button class="lead btn btn-default text-white"  data-toggle="modal" data-target="#blog4">Read more</button>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="blog4" tabindex="-1"  aria-labelledby = "exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Search million of jobs</h5>
                              <button type="button" class="btn btn-default btn-close" data-dismiss="modal" aria-label="Close">Close</button>
                           </div>
                            <div class="modal-body">
                                <p class="text-dark">Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                                Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                                Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.

                                Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                                Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                                Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.

                                Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                                Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                                Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.

                                Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                                Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                                Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.

                                Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                                Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                                Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.

                                Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                                Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                                Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.
                                </p>
                            </div>
                            <div class="modal-footer">
                            </div>
                        </div>
                     </div>
                  </div>
            </div>
        </div>

    </Section>
    <!-- manage -->

    <!-- category -->
    <div class="container-fluid category" id="show-result">
        <div class="container mx-auto mb-5">
            <h1 class="h1 text-center">Find Jobs By Category</h1>
            <p class="lead text-center">Open lesser winged midst wherein may morning</p>
        </div>

        <div class="container popular_catagory_area">
            <div class="row">
                <?php foreach ($rows as $row): ?> 
                    <?php if ($row['approval'] == 1): ?>  
                    <div class="col-lg-4 col-xl-3 col-md-6">
                        <div class="single_catagory text-center">
                        <img src="<?php echo xss_clean($row['cat_icon']); ?>"  class="img-fluid" alt="">
                        <a href="browse-job.php">
                            <h4><?php echo xss_clean($row['cat_name']); ?></h4>
                        </a>
                        </div>
                    </div>
                    <?php endif;?>
                <?php endforeach;?>
            </div>
            <div class="row">
                <div class="col-lg-12 d-flex justify-content-center">
                    <div class="pagination pagination_wrap">
                        <?php echo paginationLinks($page, $total_pages, 'index.php'); ?>
                    </div>
                </div>
            </div>
        </div>    
    </div>
    <!-- category -->

    <!-- looking for job -->
    <div class="container-fluid row looking-section h-auto my-4 mx-0">
        <div class="container my-auto col-lg-6 col-md-6 col-sm-12 pl-5">
            <img src="assets/images/g10.svg" alt="" class="img-fluid">
        </div>
        <div class="container text-white my-auto ml-auto p-5 col-lg-6 col-md-6 col-sm-12">
            <h1 class="h1 text-white">Looking For A Job?</h1>
            <p class="lead text-white">We provide online instant cash loans with quick approval</p>
            <a href="browse-job.php" type="button" class="btn text-center browse-btn btn-light mb-2">Browse A Job</a>

        </div>
    </div>
    <!-- looking for job -->

    <!-- testimonial -->
    <div class="container mx-auto my-5">
        <h1 class="h1 text-center mb-4">Testimonials</h1>
        <div class="container testimonial-section text-center">
            <div class="testimonial-paragraph my-auto ml-5">
                <p class="lead text-center mt-2">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Blanditiis nulla optio delectus totam
                    eligendi
                    laborum in maxime animi aperiam? Neque aperiam quam voluptates corrupti omnis non! Similique
                    consequuntur ut sapiente.
                </p>
            </div>

            <div class="testimonial-image img-fluid my-auto">
                <img src="assets/images/businessman-black-suit-makes-thumb-up-sign.png" alt="testimonials">
            </div>
        </div>
    </div>
    <!-- testimonial --> 

</main>
<!-- /index -->
<?php include_once('includes/footer.php'); ?>
