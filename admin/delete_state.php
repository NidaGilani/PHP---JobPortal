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
    $state_id = $del_id;

    $db = getDbInstance();
    $db->where('st_id', $state_id);
    $status_1 = $db->delete('cities');
    $db->where('id', $state_id);
    $status_2 = $db->delete('states');
    
    if ($status_1 && $status_2) 
    {
        $_SESSION['info'] = "State deleted successfully!";
        header('location: website_settings.php');
        exit;
    }
    else
    {
    	$_SESSION['failure'] = "Unable to delete State";
    	header('location: website_settings.php');
        exit;

    }
    
}