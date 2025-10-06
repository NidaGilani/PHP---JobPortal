<!-- Redirect url -->

<?php
$protocol=$_SERVER['SERVER_PROTOCOL'];

if(strpos($protocol, "HTTPS"))
{
    $protocol="HTTPS://";
}
else
{
    $protocol="HTTP://";   
}
$redirect_link_var=$protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
?>

<!-- redirect url end  -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Mania</title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap.bundle.min.css"> -->
    
    <!-- MetisMenu CSS -->
    <link href="assets/js/metisMenu/metisMenu.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">


    <!-- css -->
    <link rel="stylesheet" href="assets/css/test.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/detail.css">
    
    
</head>

<body>
    
    <header>
        <div class="container-fluid hero h-auto">
            <nav class="navbar navbar-expand-lg navbar-light sticky-top">
                <a class="navbar-brand" href="index.php"><img src="assets/images/logo.png" class="img-fluid" alt="logo"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav nav-left mx-auto">
                        <li class="nav-item active">
                            <a href="index.php" class="nav-link text-white">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="browse-job.php" class="nav-link text-white">Browse Job</a>
                        </li>
                        <li class="nav-item">
                            <a href="candidates.php" class="nav-link text-white">Members</a>
                        </li>
                        <li class="nav-item">
                            <a href="contact.php" class="nav-link text-white">Contact Us</a>
                        </li>
                    </ul>

                    <ul class="navbar-nav ml-auto mt-2">
                        
                        <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == TRUE){ ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <?php if ($_SESSION['user_type'] === 'Employer') {
                                    echo '<a class="dropdown-item" href="employer_profile.php">User Profile</a>';
                                }
                                    else {
                                        echo '<a class="dropdown-item" href="applicant_profile.php">User Profile</a>';
                                    }
                                ?>
                                <!-- <a class="dropdown-item" href="profile.php">User Profile</a> -->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php?page_url=<?php echo $redirect_link_var;?>">Log Out</a>
                                </div>
                            </li>
                        <?php 
                        }else{?>
                            <li class="nav-item">
                                
                                <a href="login.php?page_url=<?php echo $redirect_link_var;?>" class="nav-link text-white">Log in</a>
                            </li>
                        <?php } ?>
                        <a href="post-job.php" class="btn btn-light"> Post A Job </a>
                    </ul>
                </div>
            </nav>
        </div> 
    </header> 

    
    
        