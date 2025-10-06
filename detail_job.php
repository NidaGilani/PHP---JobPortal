<?php
session_start();
require_once 'config/config.php';

// Sanitize if you want
$post_id = filter_input(INPUT_GET, 'post_id', FILTER_VALIDATE_INT);

// Get Input data from query string
$db = getDbInstance();
$db->where('id',$post_id);
$row = $db->getOne("post");

//serve POST method, After successful insert, redirect to customers.php page.

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
   //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
   $data = array_filter($_POST);

   $name = $data['name'];
   $message = $data['message'];
   // $password = $data['password'];
   $from = $data['sender_email'];
   $to = 'anayashah.64@gmail.com';
   $subject = "Applied for Job";

   // $to = AddAddress($data['post_email']);

   // Attachments
   // $file_name = $data['file']; 
   // $target_dir = "assets/uploads/";
   // echo $path = $target_dir . basename($_FILES["file"]["name"]); 
   // move_uploaded_file($_FILES["file"]["name"],  $path);

   $text= '<div> Hi, I am '.$data['name'].'
               <p>'.$data['message'].'</p>
            </div>';
   $headers="From: $from" . "\r\n" . "CC:anayashah.64@gmail";
   $headers .= "MIME-Version: 1.0"."\r\n";
   $headers .= "Content-type:text/html;charsat=UTF-8"."\r\n";

   $stat = mail($to,$subject,$text,$headers);

   if($stat) {
      echo "Message could not be sent. Mailer Error";
      exit();
   } else {
      $_SESSION['success'] = "Job applied successfully!";
      header('location: browse-job.php');
      exit();
   }
      
}

include BASE_PATH . '/includes/header.php';
?>
<div class="bradcam_area bradcam_bg_1 hero">
   <div class="container">
      <div class="row">
         <div class="col-xl-12">
            <div class="bradcam_text">
               <h3><?php echo $row['job_title'];?></h3>
            </div>
         </div>
      </div>
   </div>
</div>




<div class="job_details_area">
   <div class="container">
      <?php 
         include_once('includes/flash_messages.php');
      ?>
   </div>
   <div class="container">
      <div class="row">
         <div class="col-lg-8">
            <div class="job_details_header">
               <div class="single_jobs white-bg d-flex justify-content-between">
                  <div class="jobs_left d-flex align-items-center">
                     <div class="img-fluid">
                        <?php 
                        $db->join("post p", "c.cat_name=p.job_cat", "LEFT");
                        $db->where('c.cat_name', $row['job_cat']);
                        $cat_icon = $db->getOne("job_categories c", null, "c.cat_icon");
                        // print_r($cat_icon['cat_icon']); 
                        ?>
                        <img src="<?php echo $cat_icon['cat_icon'];?>"  style="width: 90px; height:80px;" alt="" class="icon">
                     </div>
                     <div class="jobs_conetent mx-4">
                        <a href="#">
                           <h4><?php echo $row['job_title']; ?></h4>
                        </a>
                        <div class="links_locat d-flex align-items-center">
                           <div class="location">
                              <p> <i class="fa fa-map-marker"></i> <?php echo $row['loc'].', '.$row['job_region']; ?></p>
                           </div>
                           <div class="location">
                              <p> <i class="far fa-clock"></i> <?php echo $row['job_type']; ?></p>
                           </div>
                           <div class="d-flex-justify-content-end location">
                              <p><button class="btn btn-default"  data-toggle="modal" data-target="#reportModal"><i class="fa fa-bug"></i> Report</button></p>
                           </div>
                        </div>
                     </div>
                  </div>

                  <!-- Modal -->
                  <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Report Content</h5>
                              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                           </div>
                           <form action="report.php?post_id=<?php echo $row['id']; ?>" method="POST">
                              <div class="modal-body">
                                 <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
                                 <textarea class="form-control" name="message" id="" cols="15" rows="5" placeholder="Message"></textarea>
                              </div>
                              <div class="modal-footer">
                                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                 <button type="submit" class="btn btn-primary">Report</button>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>

                  <div class="jobs_right my-auto"> 
                     <div class="apply_now"> 
                        <form action="fvrt_job.php" mathod="POST">
                           <input type="hidden" name="post_id" value="<?php echo $row['id'];?>">
                           <button class="btn btn-default" type="submit">
                           <a  class="heart_mark"><input class="" style="display:none" checked="checked" type="checkbox" name="check" value="1" id="flexCheckChecked"  />
                              <i class="far fa-heart"></i></a>  
                           </button>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            <div class="descript_wrap white-bg">
               <div class="container text-center mb-4">
                  <img src="<?php echo $row['f_image'];?>" alt="Job Poster"  class="img-fluid">
               </div>
               <div class="single_wrap">
                  <h4>Job description</h4>
                  <p><?php echo $row['job_desc']; ?></p>
               </div>
               <div class="single_wrap">
                  <h4>Responsibility</h4>
                  <p class="list-unstyled"><?php echo $row['job_resp']; ?></p>
               </div>
               <div class="single_wrap">
                  <h4>Qualifications</h4>
                  <p><?php echo $row['quali']; ?> </p>
               </div>
               <div class="single_wrap">
                  <h4>Benefits</h4>
                  <p class="list-unstyled"><?php echo $row['job_benefit']; ?></p>
               </div>
            </div>
            <div class="apply_job_form white-bg">
               <h4>Apply for the job</h4>
               <form action="apply_job.php" method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="post_email" value="<?php echo $row['email']; ?>" />
                  <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>" />
                  <?php include_once './forms/apply_job_form.php'; ?>
               </form>
            </div>
         </div>
         <div class="col-lg-4">
            <div class="job_sumary">
               <div class="summery_header">
                  <?php 
                     $db->join("post p", "c.reg_no=p.author_id", "LEFT");
                     // $db->where('c.reg_no', $row['author_id']);
                     $company_logo = $db->getOne("employers c", null, "c.img, c.reg_no, p.author_id");
                     // print_r($company_logo['img']); 
                  ?>
                  <h3><img src="<?php echo $company_logo['img'];?>"  style="width: 70px; height:60px;" alt="<?php echo $company_logo['img'];?>" class=""/> <?php echo $row['company_name']; ?></h3>
               </div>
               
               <div class="job_content">
                  <h3 class="text-left pb-3">Job Summery</h3>
                  <table class="table table-borderless">
                     <ul class="list px-5">
                        <tr>
                           <td><li>Publish on:</li></td>
                           <td><?php echo $row['publish_date']; ?></td>
                        </tr>
                        <tr>
                           <td><li>Vacancy:</li></td>
                           <td><?php echo $row['vacancy']; ?></td>
                        </tr>
                        <tr>
                           <td><li>Salary: <span></span></li></td>
                           <td><?php echo $row['salary']; ?></td>
                        </tr>
                        <tr>
                           <td><li>Location: <span></span></li></td>
                           <td><?php echo $row['loc'].', '.$row['job_region']; ?></td>
                        </tr>
                        <tr>
                           <td><li>Job Nature: <span> </span></li></td>
                           <td><?php echo $row['job_type']; ?></td>
                        </tr>
                        <tr>
                           <td><li>Gender: <span> </span></li></td>
                           <td><?php echo $row['gender']; ?></td>
                        </tr>
                        <tr>
                           <td><li>Phone: <span> </span></li></td>
                           <td><?php echo $row['phone']; ?></td>
                        </tr>
                        <tr>
                           <td><li>Email: <span> </span></li></td>
                           <td><?php echo $row['email']; ?></td>
                        </tr>
                        <tr>
                           <td><li>Experience: <span> </span></li></td>
                           <td><?php echo $row['exper']; ?></td>
                        </tr>
                     </ul>
                  </table>
               </div>
            </div>
            <div class="share_wrap d-flex">
               <span>Share at:</span>
               <ul>
                  <li><a href="<?php echo $row['fb_link']; ?>"> <i class="fab fa-facebook-f"></i></a> </li>
                  <li><a href="<?php echo $row['linkedin_link']; ?>"> <i class="fab fa-linkedin-in"></i></a> </li>
                  <li><a href="<?php echo $row['twitter_link']; ?>"> <i class="fab fa-twitter"></i></a> </li>
                  <li><a href="<?php echo $row['website']; ?>"> <i class="fa fa-envelope"></i></a> </li>
               </ul>
            </div>
            <div class="job_location_wrap">
               <div class="job_lok_inner">
                  <div id="map" style="height: 200px;"></div>
                  <script>
                     function initMap() {
                     var uluru = {lat: -25.363, lng: 131.044};
                     var grayStyles = [
                         {
                         featureType: "all",
                         stylers: [
                             { saturation: -90 },
                             { lightness: 50 }
                         ]
                         },
                         {elementType: 'labels.text.fill', stylers: [{color: '#ccdee9'}]}
                     ];
                     var map = new google.maps.Map(document.getElementById('map'), {
                         center: {lat: -31.197, lng: 150.744},
                         zoom: 9,
                         styles: grayStyles,
                         scrollwheel:  false
                     });
                     }
                     
                  </script>
                  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpfS1oRGreGSBU5HHjMmQ3o5NLw7VdJ6I&callback=initMap"></script>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
   function initMap() {
   var myModal = document.getElementById('myModal')
   var myInput = document.getElementById('myInput')

   myModal.addEventListener('shown.bs.modal', function () {
   myInput.focus()
});
}
</script>

<?php include_once('includes/footer.php'); ?>