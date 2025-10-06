<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />

        <title>Dashboard - WorkMania</title>
        <!-- bootstrap -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
        <!-- MetisMenu CSS -->
        <link href="assets/js/metisMenu/metisMenu.min.css" rel="stylesheet">
        <!-- custom -->
        <link href="assets/css/style.css" rel="stylesheet" />
        <!-- font-awsome -->
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>

    <body class="sb-nav-fixed">

    <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true): ?>
        <!-- navigation -->
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">Work Mania</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        
                        <a class="dropdown-item" href="admin_profile.php"><i class="fa fa-user fa-fw"></i> Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out-alt fa-fw"></i> Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- sidebar -->
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Activity</div>
                                <a class="nav-link" href="index.php">
                                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                    Dashboard
                                </a>
                            <div class="sb-sidenav-menu-heading">Registered Members</div>
                             <!-- Employer -->
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEmployer" aria-expanded="false" aria-controls="collapseLayouts">
                                    <div class="sb-nav-link-icon"><i class="fa fa-building fa-fw"></i></div>
                                    Employer
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="collapseEmployer" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                    <ul class="sb-sidenav-menu-nested nav">
                                        <li <?php echo (CURRENT_PAGE == "employers.php" || CURRENT_PAGE == "add_employer.php") ? 'class="active"' : ''; ?>>
                                                <ul class="nav">
                                                    <li>
                                                        <a class="nav-link" href="employers.php"><i class="fa fa-list fa-fw"></i>List all</a>
                                                    </li>
                                                    <li>
                                                        <a class="nav-link" href="add_employer.php"><i class="fa fa-plus fa-fw"></i>Add New</a>
                                                    </li>
                                                </ul>
                                        </li> 
                                    </ul>
                                </div>
                            <!-- /Employer --> 

                            <!-- Applicants -->
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseApplicant" aria-expanded="false" aria-controls="collapseApplicant">
                                    <div class="sb-nav-link-icon"><i class="fa fa-user-circle fa-fw"></i></div>
                                    Applicants
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="collapseApplicant" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                    <ul class="sb-sidenav-menu-nested nav">
                                        <li <?php echo (CURRENT_PAGE == "applicants.php" || CURRENT_PAGE == "add_applicant.php") ? 'class="active"' : ''; ?>>
                                                <ul class="nav">
                                                    <li>
                                                        <a class="nav-link" href="applicants.php"><i class="fa fa-list fa-fw"></i>List all</a>
                                                    </li>
                                                    <li>
                                                        <a class="nav-link" href="add_applicant.php"><i class="fa fa-plus fa-fw"></i>Add New</a>
                                                    </li>
                                                </ul>
                                        </li> 
                                    </ul>
                                </div>
                            <!-- /Applicants --> 

                            <!-- Jobs -->
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseJobs" aria-expanded="false" aria-controls="collapseLayouts">
                                    <div class="sb-nav-link-icon"><i class="fa fa-tasks fa-fw"></i></div>
                                    Jobs
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="collapseJobs" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                    <ul class="sb-sidenav-menu-nested nav">
                                        <li <?php echo (CURRENT_PAGE == "jobs.php" || CURRENT_PAGE == "spam_job.php") ? 'class="active"' : ''; ?>>
                                            <ul class="nav">
                                                <li>
                                                    <a class="nav-link" href="jobs.php"><i class="fa fa-list fa-fw"></i>List all</a>
                                                </li>
                                                <li>
                                                    <a class="nav-link" href="spam_job.php"><i class="fa fa-bug fa-fw"></i>Repoted</a>
                                                </li>
                                            </ul>
                                        </li> 
                                    </ul>
                                </div>
                            <!-- /Jobs -->

                            <div class="sb-sidenav-menu-heading">Administration</div>

                            <!-- Team -->
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTeam" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fa fa-users fa-fw"></i></div>
                                Team
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseTeam" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                                <ul class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <li>
                                        <a class="nav-link collapsed" href="admin_users.php" ><i class="fa fa-list fa-fw"></i> List all
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link collapsed" href="add_admin.php" ><i class="fa fa-plus fa-fw"></i> Add New
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- /Team -->

                            <!-- settings -->
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSettings" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fa fa-cog fa-fw"></i></div>
                                Settings
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseSettings" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                                <ul class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <li>
                                        <a class="nav-link collapsed" href="website_settings.php" > <i class="fa fa-sliders-h fa-fw"></i> Website Settings
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link collapsed" href="feedback.php" > <i class="fa fa-comment fa-fw"></i> Feedback
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- /settings -->
                            
                        </div>
                    </div>
                    
                </nav>
            </div>
            <?php endif;?>
            <div id="layoutSidenav_content">