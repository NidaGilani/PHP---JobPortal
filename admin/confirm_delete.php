<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

$report_id = isset($_GET['report_id']) ? $_GET['report_id'] : die('Invalid Request.');

$db = getDbInstance();

$report = $db->where('report_id', $report_id)->getOne('spam', 'post_id', 1);

// Delete Report By Id:
   $status = $db->where('report_id', $report_id)->delete('spam');

// Delete Post
    $f_status = $db->where('id', $report['post_id'])->delete('post');

    if ($status) 
    {
        if ($f_status) 
        {
            $_SESSION['info'] = "Post deleted successfully!";
            header('location: spam_job.php');
            exit;
        }
        else
        {
            $_SESSION['failure'] = "Unable to delete Post";
            header('location: spam_job.php');
            exit;
    
        }
    }
    else
    {
    	$_SESSION['failure'] = "Unable to delete Post";
    	header('location: spam_job.php');
        exit;

    }