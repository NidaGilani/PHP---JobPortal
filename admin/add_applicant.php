<?php
session_start();
require_once './config/config.php';
require_once './includes/auth_validate.php';


//serve POST method, After successful insert, redirect to customers.php page.
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $db = getDbInstance();
    //Check whether the user name already exists ; 
    $db->where('user_name',$_POST['user_name']);
    $db->get('register_user');
    
    if($db->count >=1){
        $_SESSION['failure'] = "User_name already exists";
        header('location: add_applicant.php');
        exit();
    }

    //Get input data
    $data_to_store['f_name'] = $_POST['f_name'];
    $data_to_store['l_name'] = $_POST['l_name'];
    $data_to_store['field'] = $_POST['field'];
    $data_to_store['address'] = $_POST['address'];
    $data_to_store['phone'] = $_POST['phone'];
    $data_to_store['gender'] = $_POST['gender'];
    $data_to_store['date_of_birth'] = $_POST['date_of_birth'];
    $data_to_store['reg_no'] = $_POST['user_name'].date('Ymd_His');
    // print_r($data_to_store); die();

    // upload image
    $target_dir = "assets/images/";
    $fimage = $target_dir . basename($_FILES["img"]["name"]);
    $fimage_arr = array("jpg","png","jpeg","gif");
    $fimageFileType = strtolower(pathinfo($fimage,PATHINFO_EXTENSION));
    move_uploaded_file($_FILES['img']['tmp_name'],  $fimage);
    $data_to_store['img'] = $fimage;
    
    $data['email'] = $_POST['email'];
    $data['user_type'] = 'Applicant';
    $data['reg_no'] = $data_to_store['reg_no'];
    $data['user_name'] = $_POST['user_name'];
    $data['password'] = password_hash($_POST['password'],PASSWORD_DEFAULT);;
    $data['created_at'] = date('Y-m-d H:i:s');

    $db = getDbInstance();

    $stat1 = $db->insert('register_user', $data);
    $stat2 = $db->insert('applicants', $data_to_store);

    if($stat1 && $stat2)
    {
        $_SESSION['success'] = "User added successfully!";
        //Redirect to the listing page,
        header('location: applicants.php');
        //Important! Don't execute the rest put the exit/die. 
        exit();
    }
}

//We are using same form for adding and editing. This is a create form so declare $edit = false.
$edit = false;

require_once 'includes/header.php'; 
?>
<div class="container-fluid">
    <h1 class="my-4 ml-4">Add Applicant</h1>
    <div class="container">
        <?php 
        include_once('includes/flash_messages.php');
        ?>
        <form class="form" action="" method="post"  id="applicant_form" enctype="multipart/form-data">
        <?php  include_once('./forms/applicant_form.php'); ?>
        </form>
    </div>
</div>


<script type="text/javascript">
$(document).ready(function(){
   $("#applicant_form").validate({
       rules: {
            f_name: {
                required: true,
                minlength: 3
            },
            l_name: {
                required: true,
                minlength: 3
            },   
        }
    });
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