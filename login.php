<?php
session_start();
require_once 'config/config.php';
$token = bin2hex(openssl_random_pseudo_bytes(16));

// If User has already logged in, redirect to dashboard page.
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === TRUE)
{
	$redirect_link=$_REQUEST['page_url'];
	if($redirect_link=="")
	{
		header("location: index.php");
	}
	else
	{
		header("location: ".$redirect_link);   
	}
}

// If user has previously selected "remember me option": 
if (isset($_COOKIE['series_id']) && isset($_COOKIE['remember_token']))
{
	// Get user credentials from cookies.
	$series_id = filter_var($_COOKIE['series_id']);
	$remember_token = filter_var($_COOKIE['remember_token']);
	$db = getDbInstance();
	// Get user By series ID: 
	$db->where('series_id', $series_id);
	$row = $db->getOne('register_user');

	if ($db->count >= 1)
	{
		// User found. verify remember token
		if (password_verify($remember_token, $row['remember_token']))
        	{
			// Verify if expiry time is modified. 
			$expires = strtotime($row['expires']);

			if (strtotime(date()) > $expires)
			{
				// Remember Cookie has expired. 
				clearAuthCookie();
				header('Location:login.php?page_url=');
				exit;
			}
			$_SESSION['user_logged_in'] = TRUE;
			$_SESSION['user_type'] = $row['user_type'];
			$_SESSION['user_id'] = $row['id'];
			$_SESSION['user_name'] = $row['user_name'];
			$_SESSION['email'] = $row['email'];
			header('Location:index.php');
			exit;
			
			
		}
		else
		{
			clearAuthCookie();
			header('Location:login.php?page_url=');
			exit;
		}
	}
	else
	{
		clearAuthCookie();
		header('Location:login.php?page_url=');
		exit;
	}
	
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to WorkMania</title>
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
<div class="main-section container">
	<div class="container login-page ">
		<div class="text-center">
			<a href="index.php" class="text-center"><img src="assets/images/logo.svg" alt=""></a>
		</div>
		<div class="top">
			<?php 
                include_once('includes/flash_messages.php');
            ?>
            <div class="login-form container ">
                <h3 class="text-center">
                    Sign In
                </h3>
				<?php $redirect_link=$_REQUEST['page_url'];?>
                <form method="POST" class="form-group text-left" action="authenticate.php">
				
					<?php include_once './forms/login_form.php'; ?>

					<input type="hidden" name="redirect_link" value="<?php echo $redirect_link;?>">
					<button class="btn btn-primary signin-btn form-control loginField" type="submit">Sign in</button>
					<hr>
				</form>
			</div>
			<div class="login-links container text-center">
				<a href="#"><img src="assets/images/Google-icon.svg" alt=""></a>
				<a href="#"><img src="assets/images/Facebook.svg" alt=""></a>
				<a href="#"><img src="assets/images/twitter-icon.svg" alt=""></a>
				<span class="text-white m-3"> 
				<a href="signup.php" class="text-white pl-2">New to work mania? Create an account </a>
				<hr>
				<p>
					By signing in to your account, you agree to Workmania Terms of Service and consent to our Cookie Policy
					and Privacy Policy.
					This site is protected by reCAPTCHA and the Google Privacy Policy and Google Terms of Service apply
				</p>
			</div>
			<div class="text-center">
				<li><a href="#">Forget Password</a></li>
				<li><a href="#"> Help Center </a></li>
			</div>
		</div>
	</div>
</div>				

</body>
</html>
