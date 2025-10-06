<?php
session_start();
require_once './config/config.php';
require_once './includes/auth_validate.php';

if (isset($_POST['cat_submit'])) 
{

    //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
    $data_to_store = array_filter($_POST);

    // for icon
    $target_dir = "assets/images/";
    $cat_icon = $target_dir . basename($_POST["cat_icon"]);
    $cat_icon_arr = array("jpg","png","jpeg","gif","svg");
    $iconFileType = strtolower(pathinfo($cat_icon,PATHINFO_EXTENSION));
    move_uploaded_file($_POST["cat_icon"],  $cat_icon);

    $data_to_store['cat_icon'] = $cat_icon;

    //Insert timestamp
    $db = getDbInstance();
    
    $stat = $db->insert('job_categories', $data_to_store);

    if($stat)
    {
    	$_SESSION['success'] = "Category added successfully!";
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

