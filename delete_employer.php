<?php 
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
$del_id = filter_input(INPUT_POST, 'del_id');
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $employer_id = $del_id;

    $db = getDbInstance();
    $db->where('reg_no', $employer_id);
    $row = $db->getOne('employers', 'img');
    unlink("assets/images/".$row['img']);

    $db->where('reg_no', $employer_id);
    $status = $db->delete('register_user');
    
    if ($status) 
    {
        $_SESSION['info'] = "User deleted successfully!";
        header('location: signup.php');
        exit;
    }
    else
    {
    	$_SESSION['failure'] = "Unable to delete User";
    	header('location: employer_profile.php');
        exit;

    }
    
}