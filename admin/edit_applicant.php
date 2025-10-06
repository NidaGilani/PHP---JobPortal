<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';


// Sanitize if you want
$applicant_id = filter_input(INPUT_GET, 'applicant_id', FILTER_SANITIZE_STRING);
$operation = filter_input(INPUT_GET, 'operation',FILTER_SANITIZE_STRING); 
($operation == 'edit') ? $edit = true : $edit = false;
 $db = getDbInstance();

//Handle update request. As the form's action attribute is set to the same script, but 'POST' method, 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    //Get user id form query string parameter.
    $applicant_id = filter_input(INPUT_GET, 'applicant_id', FILTER_SANITIZE_STRING);

    //Get input data
    $data_to_update['f_name'] = $_POST['f_name'];
    $data_to_update['l_name'] = $_POST['l_name'];
    $data_to_update['field'] = $_POST['field'];
    $data_to_update['address'] = $_POST['address'];
    $data_to_update['phone'] = $_POST['phone'];
    $data_to_update['gender'] = $_POST['gender'];
    $data_to_update['date_of_birth'] = $_POST['date_of_birth'];
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
    $db->where('reg_no',$applicant_id);
    $stat1 = $db->update('register_user', $data);

    $db->where('reg_no',$applicant_id);
    $stat2 = $db->update('applicants', $data_to_update);

    if($stat1 && $stat2)
    {
        $_SESSION['success'] = "User updated successfully!";
        //Redirect to the listing page,
        header('location: applicants.php');
        //Important! Don't execute the rest put the exit/die. 
        exit();
    }
}


//If edit variable is set, we are performing the update operation.
if($edit)
{
    $db->join("register_user u", "a.reg_no=u.reg_no", "LEFT");
    $db->Where("a.reg_no", $applicant_id);
    $applicant = $db->getOne ("applicants a", null, "u.user_name, u.email, u.password, a.f_name, a.l_name, a.field, a.img, a.gender, a.address, a.phone, a.date_of_birth");
}

?>


<?php
    include_once 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row mx-auto">
        <h2 class="mt-4">Update Applicant</h2>
    </div>
    <!-- Flash messages -->
    <?php
        include('./includes/flash_messages.php')
    ?>

    <form class="" action="" method="post" enctype="multipart/form-data" id="applicant_form">
        
        <?php
            //Include the common form for add and edit  
            require_once('./forms/applicant_form.php'); 
        ?>
        <input type="hidden" name="prev_user_name" value="<?php echo $applicant['user_name']; ?>">
        <input type="hidden" name="prev_img" value="<?php echo $applicant['img']; ?>">
    </form>
</div>

<?php include_once 'includes/footer.php'; ?>