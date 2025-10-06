<?php
session_start();
require_once './config/config.php';
require_once './includes/auth_validate.php';

if (isset($_POST['add_job_type'])) 
{

    //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
    $data_to_store = array_filter($_POST);

    //Insert timestamp
    $db = getDbInstance();

    //Check whether the city already exists ;
    $db->where('job_type',$data_to_store['job_type']);
    $db->get('job_types');
    
    if($db->count >=1){
        $_SESSION['failure'] = "Job Type already exists";
        header('location: website_settings.php');
        exit();
    }
    
    $stat = $db->insert('job_types', $data_to_store);

    if($stat)
    {
    	$_SESSION['success'] = "Job Type added successfully!";
    	header('location: website_settings.php');
    	exit();
    }
    else
    {
        echo 'insert failed: ' . $db->getLastError();
        exit();
    }
}
else {
    $_SESSION['failur'] = "Submit Error";
    	header('location: website_settings.php');
    	exit();
}

