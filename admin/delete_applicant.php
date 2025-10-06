<?php 
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
$del_id = filter_input(INPUT_POST, 'del_id');
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST') 
{

	if($_SESSION['admin_type']!='super'){
		$_SESSION['failure'] = "You don't have permission to perform this action";
    	header('location: applicants.php');
        exit;

	}
    $applicant_id = $del_id;

    $db = getDbInstance();
    $db->where('reg_no', $applicant_id);
    $status = $db->delete('register_user');
    
    if ($status) 
    {
        $_SESSION['info'] = "Applicant deleted successfully!";
        header('location: applicants.php');
        exit;
    }
    else
    {
    	$_SESSION['failure'] = "Unable to delete Applicant";
    	header('location: applicants.php');
        exit;

    }
    
}