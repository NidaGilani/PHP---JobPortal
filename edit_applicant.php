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
    echo "<pre>";
    // print_r($_POST); die(); 

    //Get input data
    $data_to_update['f_name'] = $_POST['f_name'];
    $data_to_update['l_name'] = $_POST['l_name'];
    $data_to_update['field'] = $_POST['field'];
    $data_to_update['address'] = $_POST['address'];
    $data_to_update['phone'] = $_POST['phone'];
    $data_to_update['gender'] = $_POST['gender'];
    $data_to_update['date_of_birth'] = $_POST['date_of_birth'];
    // print_r($data_to_update); die();

    
    // upload image
    $target_dir = "assets/images/";
    $fimage = $target_dir . basename($_FILES["img"]["name"]);
    
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
    $stat2 = $db->update('applicants', $data_to_update);

    if($stat1 && $stat2)
    {
        $_SESSION['success'] = "User updated successfully!";
        //Redirect to the listing page,
        header('location: applicant_profile.php');
        //Important! Don't execute the rest put the exit/die. 
        exit();
    }
}


//If edit variable is set, we are performing the update operation.
if($edit)
{
    $db->join("register_user u", "a.reg_no=u.reg_no", "LEFT");
    $db->Where("a.reg_no", $user_id);
    $user = $db->getOne ("applicants a", null, "u.user_name, u.email, u.password, a.f_name, a.l_name, a.field, a.img, a.gender, a.address, a.phone, a.date_of_birth");
    
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
                //Include the common form for add and edit  
                require_once('./forms/user_form.php'); 
            ?>
            <input type="hidden" name="prev_img" value="<?php echo $user['img']; ?>">
            <input type="hidden" name="prev_pass" value="<?php echo $user['password']; ?>">

            <button type="submit" class="btn btn-primary signup-btn form-control mt-3">Update Profile</button>
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
        var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'svg'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            $("#img_validate").text("Only images are allowed");
            $(this).val("")
        }
    });
    });
</script>


<?php include_once 'includes/footer.php'; ?>