<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';


// Sanitize if you want
$employer_id = filter_input(INPUT_GET, 'employer_id', FILTER_SANITIZE_STRING);
$operation = filter_input(INPUT_GET, 'operation',FILTER_SANITIZE_STRING); 
($operation == 'edit') ? $edit = true : $edit = false;
 $db = getDbInstance();

//Handle update request. As the form's action attribute is set to the same script, but 'POST' method, 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    //Get employer id form query string parameter.
    $employer_id = filter_input(INPUT_GET, 'employer_id', FILTER_SANITIZE_STRING);

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
        
    if (empty($_POST['img'])) {
        
        $data_to_update['img'] = $_POST['prev_img'];
    }
    else{
        // upload image
        $target_dir = "assets/images/";
        $fimage = $target_dir . basename($_FILES["img"]["name"]);
        $fimage_arr = array("jpg","png","jpeg","gif", "svg");
        $fimageFileType = strtolower(pathinfo($fimage,PATHINFO_EXTENSION));
        move_uploaded_file($_FILES['img']['tmp_name'],  $fimage);
        $data_to_update['img'] = $fimage;
    }
    
    
    $data['email'] = $_POST['email'];
    $data['user_name'] = $_POST['prev_user_name'];
    // $data['password'] = password_hash($_POST['password'],PASSWORD_DEFAULT);
    $data['updated_at'] = date('Y-m-d H:i:s');

    $db = getDbInstance();
    $db->where('reg_no',$employer_id);
    $stat1 = $db->update('register_user', $data);

    $db->where('reg_no',$employer_id);
    $stat2 = $db->update('employers', $data_to_update);

    if($stat1 && $stat2)
    {
        $_SESSION['success'] = "Profile updated successfully!";
        //Redirect to the listing page,
        header('location: employers.php');
        //Important! Don't execute the rest put the exit/die. 
        exit();
    }
}


//If edit variable is set, we are performing the update operation.
if($edit)
{
    $db->join("register_user u", "e.reg_no=u.reg_no", "LEFT");
    $db->Where("e.reg_no", $employer_id);
    $employer = $db->getOne ("employers e", null, "u.user_name, u.email, u.password, e.img, e.address, e.company_name, e.cReg_no, e.phone, e.tagline, e.website, e.fb_link, e.reg_no, e.twitter_link, e.linkedin_link, e.company_description");
    
}
?>


<?php
    include_once 'includes/header.php';
?>
<div class="container-fluid">
    <div class="row mx-auto">
        <h2 class="mt-4">Update Employer</h2>
    </div>
    
    <!-- Flash messages -->
    <?php
        include('./includes/flash_messages.php')
    ?>
    <form class="form" action="" method="post" enctype="multipart/form-data" id="emp_edit_form"> 
        <?php
            //Include the common form for add and edit  
            require_once('./forms/employer_form.php'); 
        ?>
        <input type="hidden" name="prev_user_name" value="<?php echo $employer['user_name']; ?>">
        <input type="hidden" name="prev_img" value="<?php echo $employer['img']; ?>">
    </form>
</div>




<?php include_once 'includes/footer.php'; ?>