<?php 
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
$del_id = filter_input(INPUT_POST, 'del_id');
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST') 
{

    $post_id = $del_id;

    $db = getDbInstance();
    $db->where('id', $post_id);
    $row = $db->getOne('post', 'f_image');
    unlink("images/".$row['f_image']);
    
    $db->where('id', $post_id);
    $status = $db->delete('post');
    
    if ($status) 
    {
        $_SESSION['info'] = "Job Post deleted successfully!";
        header('location: browse-job.php');
        exit;
    }
    else
    {
    	$_SESSION['failure'] = "Unable to delete Job Post";
    	header('location: browse-job.php');
        exit;

    }
    
}