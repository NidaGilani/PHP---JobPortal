<?php 
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';


// Sanitize if you want
$post_id = filter_input(INPUT_GET, 'post_id', FILTER_VALIDATE_INT);
$operation = filter_input(INPUT_GET, 'operation',FILTER_SANITIZE_STRING); 
($operation == 'approve') ? $approve = true : $approve = false;
 $db = getDbInstance();

//Handle update request. As the form's action attribute is set to the same script, but 'POST' method, 
if ($_SERVER['REQUEST_METHOD'] == 'GET') 
{
    if($_SESSION['admin_type']!='super'){
		$_SESSION['failure'] = "You don't have permission to perform this action";
    	header('location: jobs.php');
        exit;
    }
    //Get employer id form query string parameter.
    $post_id = filter_input(INPUT_GET, 'post_id', FILTER_SANITIZE_STRING);

    //Get input data
    $data_to_update = filter_input_array(INPUT_POST);
    
    $data_to_update['updated_at'] = date('Y-m-d H:i:s');
    $data_to_update['approval'] = 1;

    $db = getDbInstance();
    $db->where('id',$post_id);
    $stat = $db->update('post', $data_to_update);
    
    if ($stat) 
    {
        $_SESSION['success'] = "Job approved successfully!";
        header('location: jobs.php');
        exit;
    }
    else
    {
    	$_SESSION['failure'] = "Unable to approve job";
    	header('location: jobs.php');
        exit;

    }
    
}


