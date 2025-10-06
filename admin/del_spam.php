<?php 
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
$del_id = filter_input(INPUT_POST, 'del_id');
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST') 
{

	if($_SESSION['admin_type']!='super'){
		$_SESSION['failure'] = "You don't have permission to perform this action";
    	header('location: spam_job.php');
        exit;

	}
    $report_id = $del_id;

    $db = getDbInstance();
    $db->where('report_id', $report_id);
    $status = $db->delete('spam');
    
    if ($status) 
    {
        $_SESSION['info'] = "Report deleted successfully!";
        header('location: spam_job.php');
        exit;
    }
    else
    {
    	$_SESSION['failure'] = "Unable to delete report";
    	header('location: spam_job.php');
        exit;

    }
    
}