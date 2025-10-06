<?php
session_start();
require_once './config/config.php';
// require_once 'includes/auth_validate.php';


// Sanitize if you want
$user_id = filter_input(INPUT_GET, 'user_id', FILTER_SANITIZE_STRING); 
$operation = filter_input(INPUT_GET, 'operation',FILTER_SANITIZE_STRING); 
($operation == 'edit') ? $edit = true : $edit = false;
 $db = getDbInstance();

//Handle update request. As the form's action attribute is set to the same script, but 'POST' method, 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    //Get employer id form query string parameter.
    $user_id = filter_input(INPUT_GET, 'user_id', FILTER_SANITIZE_STRING);
    // print_r($_POST); die();

    // upload image
    $target_dir = "assets/images/";
    $fimage = $target_dir . basename($_FILES["img"]["name"]);

    //Get input data
    $data_to_update['company_name'] = $_POST['company_name'];
    $data_to_update['cReg_no'] = $_POST['cReg_no'];
    $data_to_update['address'] = $_POST['address'];
    $data_to_update['phone'] = $_POST['phone'];
    $data_to_update['website'] = $_POST['website'];
    $data_to_update['fb_link'] = $_POST['fb_link'];
    $data_to_update['twitter_link'] = $_POST['twitter_link'];
    $data_to_update['linkedin_link'] = $_POST['linkedin_link'];
    $data_to_update['tagline'] = $_POST['tagline'];
    $data_to_update['company_description'] = $_POST['company_description'];
    // print_r($_POST['prev_img']); die();
        
    if (empty( basename($_FILES["img"]["name"]))) {
        
        $data_to_update['img'] = $_POST['prev_img'];
    }
    else{
        
        $fimage_arr = array("jpg","png","jpeg","gif", "svg");
        $fimageFileType = strtolower(pathinfo($fimage,PATHINFO_EXTENSION));
        move_uploaded_file($_FILES['img']['tmp_name'],  $fimage);
        $data_to_update['img'] = $fimage;
    }
    
    
    $data['email'] = $_POST['email'];
    $data['user_name'] = $_POST['user_name'];
    // if (password_verify($_POST['password'], $_POST['prev_pass'])) {
    //     $data['password'] = $_POST['prev_pass'];
    // }
    // else {
    //     $data['password'] = password_hash($_POST['password'],PASSWORD_DEFAULT);
    // }
    
    $data['updated_at'] = date('Y-m-d H:i:s');

    $db = getDbInstance();
    $db->where('reg_no',$user_id);
    $stat1 = $db->update('register_user', $data);

    $db->where('reg_no',$user_id);
    $stat2 = $db->update('employers', $data_to_update);

    if($stat1 && $stat2)
    {
        $_SESSION['success'] = "Profile updated successfully!";
        //Redirect to the listing page,
        header('location: employer_profile.php');
        //Important! Don't execute the rest put the exit/die. 
        exit();
    }
}


//If edit variable is set, we are performing the update operation.
if($edit)
{
    $db->join("register_user u", "e.reg_no=u.reg_no", "LEFT");
    $db->Where("e.reg_no", $user_id);
    $employer = $db->getOne ("employers e", null, "u.user_name, u.email, u.password, e.img, e.address, e.company_name, e.cReg_no, e.phone, e.tagline, e.website, e.fb_link, e.reg_no, e.twitter_link, e.linkedin_link, e.company_description");
    
}


include_once 'includes/header.php';
?>


<div class="bradcam_area bradcam_bg_1 hero">
   <div class="container">
      <div class="row">
         <div class="col-xl-12">
            <div class="bradcam_text">
               <h3>Update Profile</h3>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="container ">
    
    <!-- Flash messages -->
    <?php
        include('./includes/flash_messages.php')
    ?>
    <div class="container w-75 my-5">
        <form class="form" action="" method="post" enctype="multipart/form-data" id="user_edit_form"> 
            <?php
            // $prev_img = $employer['img'];
                //Include the common form for add and edit  
                require_once('./forms/employer_form.php'); 
            ?>
            <input type="hidden" name="prev_pass" value="<?php echo $employer['password']; ?>">
            <input type="hidden" name="prev_img" value="<?php echo $employer['img']; ?>">
            <div class="post-button-end text-right p-3">
                <button type="reset"  class="btn btn-secondary m-2"> Reset Details </button>
                <button type="submit"  class="btn m-2 btn-primary"> Update Profile </button>
            </div>
        </form>
    </div>
    
</div>

<script>
    $(document).ready(function(){
            $(".ggg").focusout(function(){
            $(this).css("background-color", "#FFFFFF");
            });

      $(".file_val").focusin(function(){
        $("#img_validate").text("");
      });
      $(".file_val").change(function () {
        var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            $("#img_validate").text("Only images are allowed");
            $(this).val("")
        }
    });
    });
</script>


<?php include_once 'includes/footer.php'; ?>