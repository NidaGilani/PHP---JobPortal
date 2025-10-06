<?php 
session_start();
require_once 'config/config.php';

if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == TRUE){ 
    
    $user_id = $_SESSION['user_id'];
    $db = getDbInstance();
    $db->where('id',$user_id);
    $row = $db->getOne("users");
    if($db->count > 0){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            $rend = mt_rand(1,5000);
            $data = array_filter($_POST);
            $data['email'] = $_POST['email'];
            $data['id'] = $user_id;
            $to = $_POST['email'];
            $subject="login confirmation";
            $text="<div><a href = 'https://workmania.000webhostapp.com/confirm.php?code=$rend'>Click me</a></div>";
            $headers="From: anayashah.64@gmail.com" . "\r\n" . "CC:anayashah.64@gmail.com";
            $headers .= "MIME-Version: 1.0"."\r\n";
            $headers .= "Content-type:text/html;charsat=UTF-8"."\r\n";
 
            $stat = mail($to,$subject,$text,$headers);
            if($stat)
            {
            // 	$_SESSION['success'] = "Mail sent successfully!";
            	echo "Success".$rend;
            // 	exit();
            }
            else
            {
                echo 'Sending failed: ';
                exit();
            }
        }
        
    }
    else {
        $_SESSION['faliure'] = "Subscription Failed!";
    }
}
else {
    // $current_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    // header("Location: login.php?redirect=".$current_url);
    header('location: login.php');
}


?>