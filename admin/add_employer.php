<?php
session_start();
require_once './config/config.php';
require_once './includes/auth_validate.php';


//serve POST method, After successful insert, redirect to customers.php page.
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
    // $data = array_filter($_POST);
    
    $db = getDbInstance();
    //Check whether the user name already exists ; 
    $db->where('user_name',$_POST['user_name']);
    $db->get('register_user');
    
    if($db->count >=1){
        $_SESSION['failure'] = "User_name already exists";
        header('location: add_employer.php');
        exit();
    }

    

    //Insert timestamp
    $data_to_store['created_at'] = date('Y-m-d H:i:s');
    $data_to_store['user_type'] = "Employer";
    $data_to_store['user_name'] = $_POST['user_name'];
    $data_to_store['email'] = $_POST['email'];
    $data_to_store['reg_no'] = $_POST['user_name'].date('Ymd_His');
    //Encrypt password
    $data_to_store['password'] = password_hash($_POST['password'],PASSWORD_DEFAULT);
    
    $target_dir = "assets/images/";
    $fimage = $target_dir . basename($_FILES["img"]["name"]);
    $fimage_arr = array("jpg","png","jpeg","gif", "svg");
    $fimageFileType = strtolower(pathinfo($fimage,PATHINFO_EXTENSION));
    move_uploaded_file($_FILES['img']['tmp_name'],  $fimage);
    $data['img'] = $fimage;

    $data['company_name']           = $_POST['company_name'];
    $data['tagline']                = $_POST['tagline'];
    $data['cReg_no']                = $_POST['cReg_no'];
    $data['reg_no']                 = $data_to_store['reg_no'];
    $data['company_description']    = $_POST['company_description'];
    $data['phone']                  = $_POST['phone'];
    $data['address']                = $_POST['address'];

    // wensite input
    if (in_array("website", $_POST)) {

        $data['website']            = $_POST['website'];
    }
    else {
        $data['website']            = '';
    }

    // facebook input
    if (in_array("fb_link", $_POST)) {

        $data['fb_link']                = $_POST['fb_link'];
    }
    else {
        $_POST['fb_link']            = '';
    }

    // Twitter input
    if (in_array("twitter_link", $_POST)) {

        $data['twitter_link']           = $_POST['twitter_link'];
    }
    else {
        $data['twitter_link']            = '';
    }

    // Linked in input
    if (in_array("linkedin_link", $_POST)) {

        $data['linkedin_link']          = $_POST['linkedin_link'];
    }
    else {
        $data['linkedin_link']            = '';
    }
    
    // print_r($data); die();

    $stat_1 = $db->insert('register_user', $data_to_store);
    $stat_2 = $db->insert('employers', $data);


    if($stat_1 && $stat_2)
    {
    	$_SESSION['success'] = "Employer added successfully!";
    	header('location: employers.php');
    	exit();
    }
    else
    {
        echo 'insert failed: ' . $db->getLastError();
        exit();
    }
}

//We are using same form for adding and editing. This is a create form so declare $edit = false.
$edit = false;

require_once 'includes/header.php'; 
?>
<div class="container-fluid">
    <h1 class="my-4 ml-4">Add Employer</h1>
    <div class="container">
        <?php 
        include_once('includes/flash_messages.php');
        ?>
        <form class="form" action="" method="post"  id="employer_form" enctype="multipart/form-data">
        <?php  include_once('./forms/employer_form.php'); ?>
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
    $(".logo_val").focusin(function(){
        $("#logo_val").text("");
      });
      $(".logo_val").change(function () {
        var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'svg'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            $("#logo_val").text("Only images are allowed");
            $(this).val("")
        }
    });
    });
</script>


<?php include_once 'includes/footer.php'; ?>