<?php
session_start();
require_once './config/config.php';
// require_once './includes/auth_validate.php';

if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == TRUE)
{
    if ($_SESSION['user_type'] === 'Employer') {
        //serve POST method, After successful insert, redirect to customers.php page.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
            $data_to_store = array_filter($_POST);

            $db = getDbInstance();

            //author id
            $author_id  = $_SESSION['user_id'];
            // $db->join('register_user u', 'e.reg_no=u.reg_no', 'LEFT');
            $db->where('reg_no', $author_id );
            $company    = $db->getOne('employers');
            // print_r($company); die();
            $data_to_store['company_name'] = $company['company_name'];
            $data_to_store['email'] = $_SESSION['email'];
            $data_to_store['phone'] = $company['phone'];
            $data_to_store['website'] = $company['website'];
            $data_to_store['fb_link'] = $company['fb_link'];
            $data_to_store['twitter_link'] = $company['twitter_link'];
            $data_to_store['linkedin_link'] = $company['linkedin_link'];

            // Upload image
            $target_dir = "assets/images/";
            $fimage = $target_dir . basename($_FILES["f_image"]["name"]);
            $fimage_arr = array("jpg","png","jpeg","gif", "svg");
            $fimageFileType = strtolower(pathinfo($fimage,PATHINFO_EXTENSION));
            move_uploaded_file($_FILES['f_image']['tmp_name'],  $fimage);
            
            $data_to_store['f_image'] = $fimage;

            //Insert timestamp
            $data_to_store['publish_date'] = date('Y-m-d H:i:s');

            echo "<pre>";
            // print_r($data_to_store); die();
            
            $status = $db->insert('post', $data_to_store);

            if($status)
            {
                $_SESSION['success'] = "Job Post added successfully! Wait for Admin to approve!";
                header('location: browse-job.php');
                exit();
            }
            else
            {
                echo 'insert failed: ' . $db->getLastError();
                exit();
            }
        }
    }
    else {
        header("location: 401.php");
        exit;
    }
}
else {
    header("location: login.php?page_url=post-job.php");  
}

$db = getDbInstance();
$categories    = $db->get('job_categories');
$states        = $db->get('states');
$cities        = $db->get('cities');
$job_types     = $db->get('job_types');


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
               <h3>Add new Job Post</h3>
            </div>
         </div>
      </div>
   </div>
</div>

<?php 
    include_once('includes/flash_messages.php');
    ?>
    <div class="container bg-light">
        <form class="job-form form mx-auto mt-4" action="" method="post"  enctype="multipart/form-data" id="job_post_form">
            
            <?php include_once './forms/post_job_form.php'; ?>
            
            <div class="post-button-end text-right p-3">
                <button type="reset"  class="btn btn-secondary m-2">Reset Post</button>
                <button type="submit"  class="btn m-2 btn-primary px-3">Post Job </button>
            </div>
        </form>
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