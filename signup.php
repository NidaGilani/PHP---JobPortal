<?php
session_start();
require_once './config/config.php';
// require_once './includes/auth_validate.php';


//serve POST method, After successful insert, redirect to customers.php page.
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
    $data_to_store = array_filter($_POST);
    $db = getDbInstance();
    //Check whether the user name already exists ; 
    $db->where('user_name',$data_to_store['user_name']);
    $check = $db->get('register_user');
    if($db->count >=1){
        $_SESSION['failure'] = "User name already exists";
        header('location: signup.php');
        exit();
    }


    //Insert timestamp
    $data_to_store['created_at'] = date('Y-m-d H:i:s');
    $data_to_store['reg_no'] = $_POST['user_name'].date('Ymd_His');

    // encript password
    $data_to_store['password'] = password_hash($data_to_store['password'],PASSWORD_DEFAULT);
    $db = getDbInstance();
    
    if ($data_to_store['user_type'] === 'Applicant') {

        $stat1 = $db->insert('register_user', $data_to_store);
        $data['reg_no'] = $data_to_store['reg_no'];
        $stat2 = $db->insert('applicants', $data);
    }
    else if ($data_to_store['user_type'] === 'Employer') {

        $stat1 = $db->insert('register_user', $data_to_store);
        $data['reg_no'] = $data_to_store['reg_no'];
        $stat2 = $db->insert('employers', $data);
    }
    else {
        echo 'insert failed: ' . $db->getLastError();
        exit();
    }
    

    if($stat1 && $stat2)
    {
    	$_SESSION['success'] = "User added successfully! Login please.";
    	header('location: login.php?page_url=""');
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


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Registration</title>
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<link rel="stylesheet" href="assets/css/signup.css">
</head>
<body>
    <div class="container mb-4 d-flex justify-content-center h-100">
        <div class="container my-4 mx-auto">
            <?php 
                include_once('includes/flash_messages.php');
            ?>
            <div class="row my-5">
                <div class="logo-section col-md-6">
                    <div class="logo-head">
                    <a href="index.html"><img class="logo img-fluid" src="assets/images/logo.png" alt=""></a>
                    <p>Login using social media to get quick access</p>
                    <div class="social-links">
                    <a href="#"> <img src="assets/images/Facebook.svg" alt=""> </a>
                    <a href="#"> <img src="assets/images/Google-icon.svg" alt=""> </a>
                    <a href="#"> <img src="assets/images/twitter-icon.svg" alt=""> </a>
                </div>
        </div>
            </div>
            <div class="form-section col-md-6">
                <div class="heading text-center container-fluid">
                <h3>Sign Up</h3>
            </div>
            <form id="emp_signup" class="form-group text-left" action="" method="post"  enctype="multipart/form-data">
                <?php  include_once('./forms/signup_form.php'); ?>
                 <button type="submit" class="btn btn-primary signup-btn form-control">Sign Up</button>
                <a href='login.php?page_url=' class="btn btn-success account-btn form-control text-center pt-3">I already have account</a>
            </form>
            
            </div>
            </div>
        </div>
    </div>

</body>
</html>