<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';

//User ID for which we are performing operation
$admin_user_id = $_SESSION['admin_user_id']; 

$operation = filter_input(INPUT_GET, 'operation', FILTER_SANITIZE_STRING);
($operation == 'edit') ? $edit = true : $edit = false;
// print_r($operation); die();
//Serve POST request.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	// Sanitize input post if we want
	$data_to_update = filter_input_array(INPUT_POST);
    $data_to_update['admin_type'] = $_SESSION['admin_type'];

	//Encrypting the password
	$data_to_update['password'] = password_hash($data_to_update['password'], PASSWORD_DEFAULT);

	$db = getDbInstance();
	$db->where('id', $admin_user_id);
	$stat = $db->update('admin_accounts', $data_to_update);

	if ($stat) {
		$_SESSION['success'] = "Profile has been updated successfully";
	} else {
		$_SESSION['failure'] = "Failed to update Admin Profile : " . $db->getLastError();
	}

	header('location: admin_profile.php');
	exit;

}

//Select where clause
$db = getDbInstance();
$db->where('id', $admin_user_id);
$admin_account = $db->getOne("admin_accounts");
$edit = true;
// import header
require_once 'includes/header.php';
?>
<div class="container-fluid">
        <h1 class="mt-4">Admin Profile</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item active">Admin Profile</li>
        </ol>
    <!-- Flash messages -->
    <?php
        include('./includes/flash_messages.php')
    ?>
        <div class="row mt-4">

            <div class="col-md-12">
                <form class="" action="" method="post" enctype="multipart/form-data" id="contact_form">
                    <?php include_once './forms/admin_profile_form.php';?>
                </form>
            </div>

        </div> 

</div>


<?php include_once('includes/footer.php'); ?>
