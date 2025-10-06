
<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';

// Per page limit for pagination.
$pagelimit = 10;

// Get current page.
$page = filter_input(INPUT_GET, 'page');
if (!$page) {
	$page = 1;
}

//Get DB instance. function is defined in config.php
$db = getDbInstance();

 //Get DB instance. i.e instance of MYSQLiDB Library
 $select = array('job_title', 'job_type', 'job_cat', 'company_name', 'salary', 'publish_date','approval');

// Set pagination limit
$db->pageLimit = $pagelimit;

// Get result of the query.
$rows = $db->arraybuilder()->paginate('post', $page, $select);
$total_pages = $db->totalPages;

//Get Dashboard information
$numApplicant = $db->getValue ("applicants", "count(*)");
$numEmployers = $db->getValue ("employers", "count(*)");
$numJobs = $db->getValue ("post", "count(*)");

include_once('includes/header.php');
?>


<main>
    <!-- dashboard  -->
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="row d-flex justify-content-around ">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body row">
                        <div class="col-xs-3 mt-3">
                            <i class="fa fa-user fa-5x"></i>
                        </div>
                        <div class="col-xs-9 ml-auto mr-3 text-right">
                            <div class="display-4"><?php echo $numApplicant; ?></div>
                            <div class="lead">Applicants</div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="applicants.php">
                        <span class="pull-left">View Details</span>
                        </a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                <div class="card-body row">
                        <div class="col-xs-3 mt-3">
                            <i class="fa fa-building fa-5x"></i>
                        </div>
                        <div class="col-xs-9 ml-auto mr-3 text-right">
                            <div class="display-4"><?php echo $numEmployers; ?></div>
                            <div class="lead">Employers</div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="employers.php">
                        <span class="pull-left">View Details</span>
                        </a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                <div class="card-body row">
                        <div class="col-xs-3 mt-3">
                            <i class="fa fa-tasks fa-5x"></i>
                        </div>
                        <div class="col-xs-9 ml-auto mr-3 text-right">
                            <div class="display-4"><?php echo $numJobs; ?></div>
                            <div class="lead">Jobs</div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="jobs.php">
                        <span class="pull-left">View Details</span>
                        </a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            
        </div>
        <!-- /dashboard -->
        <!-- chats -->
        <!-- <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-area mr-1"></i>
                        Area Chart Example
                    </div>
                    <div class="card-body" id="chart-container"><canvas id="graphCanvas" width="100%" height="40"></canvas></div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar mr-1"></i>
                        Bar Chart Example
                    </div>
                    <div class="card-body" id="chart-container"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                </div>
            </div>
        </div> -->
        <!-- /chats -->
        <!-- data table -->
        <div class="card mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <i class="fas fa-table mr-1"></i>
                        All Jobs
                    </div>
                    <div class="col-6">
                        <div id="export-section" class="text-right">
                            <a href="export_jobs.php"><button class="btn btn-sm btn-primary py-2">Export to CSV <i class="fa fa-download"></i></button></a>
                        </div>
                    </div>
                </div>   
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Job Title</th>
                                <th>Job Category</th>
                                <th>Company Name</th>
                                <th>Job Type</th>
                                <th>Start date</th>
                                <th>Salary</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Job Title</th>
                                <th>Job Category</th>
                                <th>Company Name</th>
                                <th>Job Type</th>
                                <th>Start date</th>
                                <th>Salary</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        <?php foreach ($rows as $row): ?>
                            <?php if ($row['approval'] == 1){  ?>
                            <tr>
                                <td><?php echo xss_clean($row['job_title']); ?></td>
                                <td><?php echo xss_clean($row['job_cat']); ?></td>
                                <td><?php echo xss_clean($row['company_name']); ?></td>
                                <td><?php echo xss_clean($row['job_type']); ?></td>
                                <td><?php echo xss_clean($row['publish_date']); ?></td>
                                <td><?php echo xss_clean($row['salary']); ?></td>
                            </tr>
                            <?php }?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /data table -->
</main>
<?php include_once('includes/footer.php'); ?>
