<?php 
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
$del_id = filter_input(INPUT_POST, 'del_id');
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST') 
{

	if($_SESSION['admin_type']!='super'){
		$_SESSION['failure'] = "You don't have permission to perform this action";
    	header('location: website_settings.php');
        exit;

	}
    $cat_id = $del_id;

    $db = getDbInstance();
    $db->where('id', $cat_id);
    $status = $db->delete('job_categories');
    
    if ($status) 
    {
        $_SESSION['info'] = "Category deleted successfully!";
        header('location: website_settings.php');
        exit;
    }
    else
    {
    	$_SESSION['failure'] = "Unable to delete Category";
    	header('location: website_settings.php');
        exit;

    }
    
}