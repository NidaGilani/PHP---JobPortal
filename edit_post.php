<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';


// Sanitize if you want
$post_id = filter_input(INPUT_GET, 'post_id', FILTER_VALIDATE_INT);
$operation = filter_input(INPUT_GET, 'operation',FILTER_SANITIZE_STRING); 
($operation == 'edit') ? $edit = true : $edit = false;
 $db = getDbInstance();

//Handle update request. As the form's action attribute is set to the same script, but 'POST' method, 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    //Get employer id form query string parameter.
    $post_id = filter_input(INPUT_GET, 'post_id', FILTER_SANITIZE_STRING);

    //Get input data
    // $dat\a_to_update = filter_input_array(INPUT_POST);

    // Upload image
        $target_dir = "assets/images/";
        $fimage = $target_dir . basename($_FILES["f_image"]["name"]);

    if (empty( basename($_FILES["f_image"]["name"]))) {
        
        $data_to_update['f_image'] = $_POST['prev_img'];
    }
    else{
        
        $fimage_arr = array("jpg","png","jpeg","gif","svg");
        $fimageFileType = strtolower(pathinfo($fimage,PATHINFO_EXTENSION));
        move_uploaded_file($_FILES['f_image']['tmp_name'],  $fimage);

        $data_to_update['f_image'] = $fimage;
    }

    $data_to_update['job_title'] = $_POST['job_title'];
    $data_to_update['loc'] = $_POST['loc'];
    $data_to_update['job_region'] = $_POST['job_region'];
    $data_to_update['job_type'] = $_POST['job_type'];
    $data_to_update['job_desc'] = $_POST['job_desc'];
    $data_to_update['job_cat'] = $_POST['job_cat'];
    $data_to_update['job_resp'] = $_POST['job_resp'];
    $data_to_update['job_benefit'] = $_POST['job_benefit'];
    $data_to_update['gender'] = $_POST['gender'];
    $data_to_update['quali'] = $_POST['quali'];
    $data_to_update['exper'] = $_POST['exper'];
    $data_to_update['vacancy'] = $_POST['vacancy'];
    $data_to_update['deadline'] = $_POST['deadline'];
    $data_to_update['salary'] = $_POST['salary'];

    $data_to_update['updated_at'] = date('Y-m-d H:i:s');

    $db = getDbInstance();
    $db->where('id',$post_id);
    $stat = $db->update('post', $data_to_update);

    if($stat)
    {
        $_SESSION['success'] = "Post updated successfully!";
        //Redirect to the listing page,
        header('location: employer_profile.php');
        //Important! Don't execute the rest put the exit/die. 
        exit();
    }
}


//If edit variable is set, we are performing the update operation.
if($edit)
{
    $db->where('id', $post_id);
    //Get data to pre-populate the form.

    $post          = $db->getOne("post");
    $categories    = $db->get('job_categories');
    $states        = $db->get('states');
    $cities        = $db->get('cities');
    $job_types     = $db->get('job_types');
}
?>


<?php
    include_once 'includes/header.php';
?>

<div class="bradcam_area bradcam_bg_1 hero">
   <div class="container">
      <div class="row">
         <div class="col-xl-12">
            <div class="bradcam_text">
               <h3>Update Job Details</h3>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="container-fluid">
    <!-- Flash messages -->
    <?php
        include('./includes/flash_messages.php')
    ?>
    <form class="form" action="" method="post" enctype="multipart/form-data" id="job_edit_form"> 
        <?php
            //Include the common form for add and edit  
            require_once('./forms/post_job_form.php'); 
        ?>
        <input type="hidden" name="prev_img" value=<?php echo $post['f_image']; ?>>
            <div class="post-button-end text-right p-3">
                <button type="submit"  class="btn m-2 btn-primary px-3">Post Job </button>
            </div>
    </form>
</div>

<script>
    $(document).ready(function(){
        
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


<?php include_once 'includes/footer.php'; ?>