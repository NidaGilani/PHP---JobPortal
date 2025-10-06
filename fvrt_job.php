<?php
session_start();
require_once './config/config.php';
$post_id = $_GET['post_id'];
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == TRUE)
{
    if (isset($_GET['check']) == '1') {

        $post_id = isset($_GET['post_id']) ? $_GET['post_id'] : die('Invalid Request.');
        // echo $post_id;
        //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
        
        $data_to_store['post_id'] = $post_id;

        $data_to_store['user_id'] = $_SESSION['user_id'];
        // print_r($data_to_store); die();
        $db = getDbInstance();

        $db->where('post_id', $post_id);
        $db->where('user_id', $_SESSION['user_id']);
        $db->getOne('fvrt_jobs');
        if($db->count >=1){

            $db->where('post_id', $post_id);
            $db->where('user_id', $_SESSION['user_id']);
            $db->delete('fvrt_jobs'); 
            $_SESSION['info'] = "Deleted saved Post!";
            header('location:detail_job.php?post_id='.$post_id);
            exit();
        }
        else {

            $status = $db->insert('fvrt_jobs', $data_to_store);
        }

        

        if($status)
        {
            $_SESSION['success'] = "Post Saved successfully!";
            header('location:detail_job.php?post_id='.$post_id);
            exit();
        }
        else
        {
            echo 'insert failed: ' . $db->getLastError();
            exit();
        }
        
    }
    else {
        $_SESSION['success'] = "Already Added to Saved!";
        header('location:detail_job.php?post_id='.$post_id);
        exit();
    }
    
    
}else {
    header('Location:login.php?page_url=detail_job.php?post_id='.$post_id);
}


?>
