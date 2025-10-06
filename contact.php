<?php
session_start();
require_once './config/config.php';
// require_once 'includes/auth_validate.php';
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == TRUE) 
{
   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
      $data = array_filter($_POST);
      $data['reg_no'] = $_SESSION['user_id'];
      $data['date_time'] = date('Y-m-d H:i:s');
      
      $db = getDbInstance();

      $stat = $db->insert('feedback', $data);

      if($stat)
      {
         $_SESSION['success'] = "Feedback sent successfully!";
         header('location: contact.php');
         exit();
      }
      else
      {
         echo 'Sending failed: ';
         exit();
      }
   }
}
else {
   header("location: login.php?page_url=");
}


include_once('includes/header.php');
?>
<div class="bradcam_area bradcam_bg_1 hero">
   <div class="container">
      <div class="row">
         <div class="col-xl-12">
            <div class="bradcam_text">
               <h3>Contact Us!</h3>
            </div>
         </div>
      </div>
   </div>
</div>
<?php 
   include_once('includes/flash_messages.php');
?>
<section class="contact-section section_padding">
   <div class="container">
      <div class="d-none d-sm-block mb-5 pb-4 mt-0">
         <div class="d-flex w-100 justify-content-center">
         <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d22625.369041226222!2d74.08586658744991!3d32.54533884847161!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xc3c6207b6ae1bd52!2sNational%20College%20of%20Business%20Administration%20%26%20Economics!5e0!3m2!1sen!2s!4v1609066032024!5m2!1sen!2s" width="100%" height="400" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
         </div>
      </div>
      <div class="row">
         <div class="col-12">
            <h2 class="contact-title">Get in Touch</h2>
         </div>
         <div class="col-lg-8">
            <form class="form-contact contact_form" action="" method="post" id="contactForm" novalidate="novalidate">
               <?php include_once './forms/contact_form.php'; ?>
            </form>
         </div>
      </div>
   </div>
</section>

<?php include_once('includes/footer.php'); ?>