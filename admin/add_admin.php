<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';

//Only super admin is allowed to access this page
if ($_SESSION['admin_type'] !== 'super') {
    // show permission denied message
    header('location: 401.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
	$data_to_store = filter_input_array(INPUT_POST);
    $db = getDbInstance();
    //Check whether the user name already exists ; 
    $db->where('user_name',$data_to_store['user_name']);
    $db->get('admin_accounts');
    
    if($db->count >=1){
        $_SESSION['failure'] = "User name already exists";
        header('location: add_admin.php');
        exit();
    }

    //Encrypt password
    $data_to_store['password'] = password_hash($data_to_store['password'],PASSWORD_DEFAULT);
    //reset db instance
    $db = getDbInstance();
    $last_id = $db->insert ('admin_accounts', $data_to_store);
    if($last_id)
    {

    	$_SESSION['success'] = "Admin user added successfully!";
    	header('location: admin_users.php');
    	exit();
    }  
    
}

$edit = false;


require_once 'includes/header.php';
?>
<div id="container-fluid">
	<div class="row mx-auto mb-3">
		<div class="col-12">
            <h1 class="mt-4 px-4">Add admin</h1>
		</div>
	</div>
	<?php 
        include_once('includes/flash_messages.php');
    ?>
	<div class="row mx-auto my-2">
        <div class="col-md-8 mx-auto bg-light mt-2">
            <form class="" action="" method="post"  id="contact_form" enctype="multipart/form-data">
                <?php include_once './forms/add_admin_form.php'; ?>
            </form>
        </div>
    </div>
</div>




<?php include_once 'includes/footer.php'; ?>