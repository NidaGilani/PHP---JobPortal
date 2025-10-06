<?php 
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
$del_id = filter_input(INPUT_POST, 'del_id');
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST') 
{
    

    $fvrt_id = $del_id;

    $db = getDbInstance();
    $db->where('fvrt_job_id', $fvrt_id);
    $status = $db->delete('fvrt_jobs');
    
    if ($status) 
    {
        if ($_SESSION['user_type'] === 'Applicant') {

            $_SESSION['info'] = "Removed successfully!";
            header('location: applicant_profile.php');
        exit;
        }
        elseif ($_SESSION['user_type'] === 'Applicant') {

            $_SESSION['info'] = "Removed successfully!";
            header('location: employer_profile.php');
            exit;
        }
        
    }
    else
    {
        if ($_SESSION['user_type'] === 'Applicant') {

            $_SESSION['failure'] = "Can not remove this row!";
            header('location: applicant_profile.php');
            exit;
        }
        elseif ($_SESSION['user_type'] === 'Applicant') {

            $_SESSION['failure'] = "Can not remove this row!";
            header('location: employer_profile.php');
            exit;
        }

    }
    
}