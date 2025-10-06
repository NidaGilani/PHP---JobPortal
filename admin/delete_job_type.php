<?php 
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
echo $del_id = filter_input(INPUT_POST, 'del_id');
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST') 
{

	if($_SESSION['admin_type']!='super'){
		$_SESSION['failure'] = "You don't have permission to perform this action";
    	header('location: website_settings.php');
        exit;

	}
    $j_type_id = $del_id;

    $db = getDbInstance();
    $db->where('id', $j_type_id);
    $status = $db->delete('job_types');
    
    if ($status) 
    {
        $_SESSION['info'] = "Job Type deleted successfully!";
        header('location: website_settings.php');
        exit;
    }
    else
    {
    	$_SESSION['failure'] = "Unable to delete Job Type";
    	header('location: website_settings.php');
        exit;

    }
    
}