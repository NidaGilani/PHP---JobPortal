<?php
session_start();
require_once './config/config.php';
require_once './includes/auth_validate.php';


//serve POST method, After successful insert, redirect to customers.php page.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['user_logged_in'] === TRUE) 
{
    //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
    $data_to_store = array_filter($_POST);
    
    //author id

    $data_to_store['author_id'] = $_SESSION['user_id'];
    $data_to_store['post_id'] = $_POST['post_id'];
    $data_to_store['message'] = $_POST['message'];

    //Insert timestamp
    $data_to_store['reported_at'] = date('Y-m-d H:i:s');
    $db = getDbInstance();
    // print_r($data_to_store); die();
    $db->where('post_id', $_POST['post_id']);
    $db->where('author_id', $_SESSION['user_id']);
    $db->getOne('spam');
    if($db->count >=1){
        $_SESSION['info'] = "Already reported!";
        header('location:detail_job.php?post_id='.$_POST['post_id']);
        exit();
    }
    else {

        $stat = $db->insert('spam', $data_to_store);
        
    }
    

    if($stat)
    {
    	$_SESSION['success'] = "Job Repoted successfully!";
    	header('location:detail_job.php?post_id='.$_POST['post_id']);
        exit();
    }
    else
    {
        echo 'insert failed: ' . $db->getLastError();
        exit();
    }
}
 
?>