<?php 
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
$del_id = filter_input(INPUT_POST, 'del_id');
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST') 
{

	if($_SESSION['admin_type']!='super'){
		$_SESSION['failure'] = "You don't have permission to perform this action";
    	header('location: employers.php');
        exit;

	}
    $emp_id = $del_id;

    $db = getDbInstance();
    $db->where('reg_no', $emp_id);
    $status = $db->delete('register_user');
    
    if ($status) 
    {
        $_SESSION['info'] = "Employer deleted successfully!";
        header('location: employers.php');
        exit;
    }
    else
    {
    	$_SESSION['failure'] = "Unable to delete Employer";
    	header('location: employers.php');
        exit;

    }
    
}