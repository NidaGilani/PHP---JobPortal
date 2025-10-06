<?php
require_once './config/config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$user_name = filter_input(INPUT_POST, 'user_name');
	$password = filter_input(INPUT_POST, 'password');
	$remember = filter_input(INPUT_POST, 'remember');
	$redirect_link = filter_input(INPUT_POST, 'redirect_link');

	//echo password_verify('admin', '$2y$10$RnDwpen5c8.gtZLaxHEHDOKWY77t/20A4RRkWBsjlPuu7Wmy0HyBu'); exit;

	//Get DB instance.
	$db = getDbInstance();

	$db->where("user_name", $user_name);

	$row = $db->get('register_user');

	if ($db->count >= 1) {
		
		$db_password = $row[0]['password'];
		$user_id = $row[0]['reg_no'];
		$user_type = $row[0]['user_type'];
		$user_name = $row[0]['user_name'];
		$email = $row[0]['email'];

		if (password_verify($password, $db_password)) {
			// print_r("verified"); die();
			$_SESSION['user_logged_in'] = TRUE;
			$_SESSION['user_id'] = $row[0]['reg_no'];
			$_SESSION['user_type'] = $row[0]['user_type'];
			$_SESSION['user_name'] = $row[0]['user_name'];
			$_SESSION['email'] = $row[0]['email'];

			if ($remember) {

				$series_id = randomString(16);
				$remember_token = getSecureRandomToken(20);
				$encryted_remember_token = password_hash($remember_token,PASSWORD_DEFAULT);
				

				$expiry_time = date('Y-m-d H:i:s', strtotime(' + 30 days'));

				$expires = strtotime($expiry_time);
				
				setcookie('series_id', $series_id, $expires, "/");
				setcookie('remember_token', $remember_token, $expires, "/");

				$db = getDbInstance();
				$db->where ('reg_no',$user_id);

				$update_remember = array(
					'series_id'=> $series_id,
					'remember_token' => $encryted_remember_token,
					'expires' =>$expiry_time
				);
				$db->update("register_user", $update_remember);
			}
			//Authentication successfull redirect user

			// $redirect_link=$_REQUEST['page_url'];
			if($redirect_link=="")
			{
				header("location: index.php");
			}
			else
			{
				header("location: ".$redirect_link);   
			}
			
			// header('Location:'.$_GET['redirect']);

		} else {
		
			$_SESSION['failure'] = "Invalid Password";
			header('Location:login.php?page_url=');
		}

		exit;
	} else {
		$_SESSION['failure'] = "Invalid user name or password";
		header('Location:login.php?page_url=');
		exit;
	}

}
else {
	die('Method Not allowed');
}