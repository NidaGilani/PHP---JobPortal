<?php
session_start();
require_once './config/config.php';
// echo $_SESSION['user_type']; die();
// require_once 'includes/auth_validate.php';
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == TRUE) 
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_SESSION['user_type'] === 'Applicant') {
            //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
            $data = array_filter($_POST);

            // upload file

            

            $target_dir = "assets/uploads/";
            $fimage = $target_dir . basename($_FILES["resume"]["name"]);
            $fimage_arr = array('pdf', 'doc', 'docx');
            $fimageFileType = strtolower(pathinfo($fimage,PATHINFO_EXTENSION));
            move_uploaded_file($_FILES['resume']['tmp_name'],  $fimage);
            $data['resume'] = $fimage;


            $data['reg_no'] = $_SESSION['user_id'];
            $data['date'] = date('Y-m-d H:i:s');
            
            // print_r($data); die();
            
            $db = getDbInstance();
            
            $db->where('reg_no', $data['reg_no']);
            $db->get('upload_resume');
            // print_r($db->get('upload_resume')); die();
            if($db->count >=1){

                $db->where('reg_no', $data['reg_no']);
                $stat = $db->update('upload_resume', $data);
            }
            else {

                $stat = $db->insert('upload_resume', $data);
                
            }
            
    
            if($stat)
            {
                $_SESSION['success'] = "Resume uploaded successfully!";
                header('location: upload_resume.php');
                exit();
            }
            else
            {
                echo 'Sending failed: ';
                exit();
            }
        }
        else {
            header("location: 401.php");
        }
    }
    
}
else {
   header("location: login.php?page_url=");
}


include_once('includes/header.php');
?>

<div class="d-flex justify-content-center my-2">
    <?php 
    include_once('includes/flash_messages.php');
    ?>
</div>
<div class="container bg-light w-50 h-70 d-flex justify-content-center my-5">
    <form action="" method="post" enctype="multipart/form-data">
        <h3 class="text-center my-5">Upload Resume</h3>
        <div class="form-group">
        <input type="file" class="form-control file_val" name="resume" id="resume" accept="application/pdf,application/msword" />
        <span id="file_validate"></span>
        <button class="btn btn-block btn-primary my-5">Upload</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function(){
        
      $(".file_val").focusin(function(){
        $("#file_validate").text("");
      });
      $(".file_val").change(function () {
        var fileExtension = ['pdf', 'doc', 'docx'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            $("#file_validate").text("Only PDF and Word documents are allowed");
            $(this).val("")
        }
    });
    });
</script>



<?php include_once('includes/footer.php'); ?>