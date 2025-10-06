<?php
session_start();
require_once './config/config.php';
require_once './includes/auth_validate.php';

if (isset($_POST['add_city'])) 
{

    //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
    $data_to_store = array_filter($_POST);


    //Insert timestamp
    $db = getDbInstance();

    //Check whether the city already exists ;
    $db->where('city_name',$data_to_store['city_name']);
    $db->get('cities');
    
    if($db->count >=1){
        $_SESSION['failure'] = "City already exists";
        header('location: website_settings.php');
        exit();
    }
    
    $stat = $db->insert('cities', $data_to_store);

    if($stat)
    {
    	$_SESSION['success'] = "City added successfully!";
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

