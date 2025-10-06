<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

// Costumers class
require_once BASE_PATH . '/lib/Jobs/Jobs.php';
$posts = new Jobs();

// Get Input data from query string
$search_string = filter_input(INPUT_GET, 'search_string');
$filter_col = filter_input(INPUT_GET, 'filter_col');
$order_by = filter_input(INPUT_GET, 'order_by');

// Per page limit for pagination.
$pagelimit = 15;

// Get current page.
$page = filter_input(INPUT_GET, 'page');
if (!$page) {
	$page = 1;
}

// If filter types are not selected we show latest added data first
if (!$filter_col) {
	$filter_col = 'id';
}
if (!$order_by) {
	$order_by = 'Desc';
}

//Get DB instance. i.e instance of MYSQLiDB Library
$db = getDbInstance();
$select = array('id', 'job_title', 'job_type', 'company_name', 'author_id', 'approval', 'publish_date', 'updated_at');

//Start building query according to input parameters.
// If search string
if ($search_string) {
	$db->where('job_title', '%' . $search_string . '%', 'like');
	$db->orwhere('job_type', '%' . $search_string . '%', 'like');
}


//If order by option selected
if ($order_by) {
	$db->orderBy($filter_col, $order_by);
}

// Set pagination limit
$db->pageLimit = $pagelimit;

// Get result of the query.
$rows = $db->arraybuilder()->paginate('post', $page, $select);
$total_pages = $db->totalPages;

include BASE_PATH . '/includes/header.php';
?>
<!-- Main container -->
<div class="container-fluid">
        <h1 class="mt-4">Jobs</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item active">Jobs</li>
        </ol>
        <?php include BASE_PATH . '/includes/flash_messages.php';?>
    
        <div class="mx-auto filter-form">
            <!-- Filters -->
                <form class="form form-inline" action="">
                    <label for="input_search">Search</label>
                    <input type="text" class="form-control m-3" id="input_search" name="search_string" value="<?php echo xss_clean($search_string); ?>">
                    <label for="input_order">Order By</label>
                    <select name="filter_col" class="form-control m-3">
                        <?php
                            foreach ($posts->setOrderingValues() as $opt_value => $opt_name):
                                ($order_by === $opt_value) ? $selected = 'selected' : $selected = '';
                                echo ' <option value="' . $opt_value . '" ' . $selected . '>' . $opt_name . '</option>';
                            endforeach;
                            ?>
                    </select>
                    <select name="order_by" class="form-control m-3" id="input_order">
                        <option value="Asc" <?php
                            if ($order_by == 'Asc') {
                                echo 'selected';
                            }
                            ?> >Asc</option>
                                            <option value="Desc" <?php
                            if ($order_by == 'Desc') {
                                echo 'selected';
                            }
                            ?>>Desc
                        </option>
                    </select>
                    <input type="submit" value="Go" class="btn btn-primary m-3 px-3">
                </form>
            <!-- //Filters -->
        </div>
        <hr>
    <!-- job approval -->
    
    <div class="row mt-3">
        <!-- Table -->
        <table class="table table-striped table-bordered table-condensed">
            <thead>
            <tr class="bg-light">
                    <td colspan="7"><h3 class="text-center">Job Approvals</h3></td>
                </tr>
                <tr>
                <tr>
                    <th width="5%">ID</th>
                    <th width="25%">Job Title</th>
                    <th width="15%">Job Type</th>
                    <th width="20%">Company Name</th>
                    <th width="10%">Author ID</th>
                    <th width="10%">Published at</th>
                    <th width="15%">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row): ?>
                    <?php if ($row['approval'] == 0){ ?> 
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo xss_clean($row['job_title']); ?></td>
                    <td><?php echo xss_clean($row['job_type']); ?></td>
                    <td><?php echo xss_clean($row['company_name']); ?></td>
                    <td><?php echo xss_clean($row['author_id']); ?></td>
                    <td><?php echo xss_clean($row['publish_date']); ?></td>
                    <td>
                        <a href="approve_post.php?post_id=<?php echo $row['id']; ?>&operation=approve" class="btn btn-success"><i class="fa fa-check"></i></a>
                        <a href="#" class="btn btn-danger delete_btn" data-toggle="modal" data-target="#confirm-delete-<?php echo $row['id']; ?>"><i class="fa fa-times"></i></a>
                    </td>
                </tr>
                <!-- Delete Confirmation Modal -->
                <div class="modal fade" id="confirm-delete-<?php echo $row['id']; ?>" role="dialog">
                    <div class="modal-dialog">
                        <form action="delete_post.php" method="POST">
                            <!-- Modal content -->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Confirm</h4>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="del_id" id="del_id" value="<?php echo $row['id']; ?>">
                                    <p>Are you sure you want to delete this row?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-default pull-left">Yes</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- //Delete Confirmation Modal -->
                <?php }?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- //Table -->

        <!-- Pagination -->
        <div class="text-center">
        <?php echo paginationLinks($page, $total_pages, 'jobs.php'); ?>
        </div>
        <!-- //Pagination -->
    </div>
    <!-- job approval -->

    <!-- all jobs -->
    
    <div class="row my-2">
        <div class="col-12">
            <div id="export-section" class="text-right">
                <a href="export_jobs.php"><button class="btn btn-sm btn-primary py-2">Export to CSV <i class="fa fa-download"></i></button></a>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <!-- Table -->
        <table class="table table-striped table-bordered table-condensed">
            <thead>
                <tr class="bg-light">
                    <td colspan="7"><h3 class="text-center">All Jobs</h3></td>
                </tr>
                <tr>
                    <th width="5%">ID</th>
                    <th width="25%">Job Title</th>
                    <th width="15%">Job Type</th>
                    <th width="20%">Company Name</th>
                    <th width="10%">Author ID</th>
                    <th width="15%">Published at</th>
                    <th width="20%">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($rows as $row): ?>
                    <?php if ($row['approval'] == 1){ ?> 
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo xss_clean($row['job_title']); ?></td>
                    <td><?php echo xss_clean($row['job_type']); ?></td>
                    <td><?php echo xss_clean($row['company_name']); ?></td>
                    <td><?php echo xss_clean($row['author_id']); ?></td>
                    <td><?php echo xss_clean($row['publish_date']); ?></td>
                    <td>
                        <a href="approve_post.php?post_id=<?php echo $row['id']; ?>&operation=approve" class="btn btn-success"><i class="fa fa-check"></i></a>
                        <a href="#" class="btn btn-danger delete_btn" data-toggle="modal" data-target="#confirm-delete-<?php echo $row['id']; ?>"><i class="fa fa-times"></i></a>
                    </td>
                </tr>
                <!-- Delete Confirmation Modal -->
                <div class="modal fade" id="confirm-delete-<?php echo $row['id']; ?>" role="dialog">
                    <div class="modal-dialog">
                        <form action="delete_post.php" method="POST">
                            <!-- Modal content -->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Confirm</h4>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="del_id" id="del_id" value="<?php echo $row['id']; ?>">
                                    <p>Are you sure you want to delete this row?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-default pull-left">Yes</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- //Delete Confirmation Modal -->
                <?php }?>
                <?php endforeach; ?>
            </tbody>  
            </tbody>
        </table>
        <!-- //Table -->

        <!-- Pagination -->
        <div class="text-center">
        <?php echo paginationLinks($page, $total_pages, 'jobs.php'); ?>
        </div>
        <!-- //Pagination -->
    </div>
    <!-- /all jobs -->

</div>
<!-- //Main container -->
<?php include BASE_PATH . '/includes/footer.php';?>
