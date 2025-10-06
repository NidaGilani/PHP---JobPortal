<?php
require_once './config/config.php';
session_start();
session_destroy();


if(isset($_COOKIE['series_id']) && isset($_COOKIE['remember_token'])){
	clearAuthCookie();
}
$redirect_link=$_REQUEST['page_url'];
if($redirect_link=="")
{
	header("location: index.php");
}
else if(basename($_REQUEST['page_url'])=="applicant_profile.php")
{
	header("location: login.php?page_url="); 
}
else if(basename($_REQUEST['page_url'])=="employer_profile.php")
{
	header("location: login.php?page_url="); 
}
else
{
	header("location: ".$redirect_link);   
}

exit;

 ?>