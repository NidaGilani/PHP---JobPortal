<?php 
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
$del_id = filter_input(INPUT_POST, 'del_id');
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST') 
{

    $applied_id = $del_id;

    $db = getDbInstance();
    $db->where('id', $applied_id);
    $status = $db->delete('applied_jobs');
    
    if ($status) 
    {
        $_SESSION['info'] = "Removed successfully!";
        header('location: applicant_profile.php');
        exit;
    }
    else
    {
    	$_SESSION['failure'] = "Unable to delete Category";
    	header('location: applicant_profile.php');
        exit;

    }
    
}