<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

// Per page limit for pagination.
$pagelimit = 10;

// Get current page.
$page = filter_input(INPUT_GET, 'page');
if (!$page) {
	$page = 1;
}


//Get DB instance. i.e instance of MYSQLiDB Library
$db = getDbInstance();
$select = array('report_id', 'post_id', 'author_id', 'message', 'reported_at');


// Set pagination limit
$db->pageLimit = $pagelimit;

// Get result of the query.
$rows = $db->arraybuilder()->paginate('spam', $page, $select);
$total_pages = $db->totalPages;

include BASE_PATH . '/includes/header.php';
?>
<!-- Main container -->
<div class="container-fluid">
        <h1 class="mt-4">Spam</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item active">Jobs</li>
        </ol>
        <?php include BASE_PATH . '/includes/flash_messages.php';?>
    
        
        <hr>
    <!-- all jobs -->
    
    <div class="row my-2">
        <div class="col-12">
            <div id="export-section" class="text-right">
                <a href="export_spams.php"><button class="btn btn-sm btn-primary py-2">Export to CSV <i class="fa fa-download"></i></button></a>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <!-- Table -->
        <table class="table table-striped table-bordered table-condensed">
            <thead>
                <tr class="bg-light">
                    <td colspan="7"><h3 class="text-center">List All</h3></td>
                </tr>
                <tr>
                    <th width="5%">ID</th>
                    <th width="10%">Post ID</th>
                    <th width="15%">Author ID</th>
                    <th width="30%">Message</th>
                    <th width="10%">Date</th>
                    <th width="30%">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($rows as $row): ?>
                <tr>
                    <td><?php echo $row['report_id']; ?></td>
                    <td><?php echo xss_clean($row['post_id']); ?></td>
                    <td><?php echo xss_clean($row['author_id']); ?></td>
                    <td><?php echo xss_clean($row['message']); ?></td>
                    <td><?php echo xss_clean($row['reported_at']); ?></td>
                    <td>
                        <a href="confirm_delete.php?report_id=<?php echo $row['report_id']; ?>&operation=approve" class="btn btn-success">Remove Post</a>
                        <a href="#" class="btn btn-danger delete_btn" data-toggle="modal" data-target="#confirm-delete-<?php echo $row['report_id']; ?>">Delete Report</i></a>
                    </td>
                </tr>
                <!-- Delete Confirmation Modal -->
                <div class="modal fade" id="confirm-delete-<?php echo $row['report_id']; ?>" role="dialog">
                    <div class="modal-dialog">
                        <form action="del_spam.php" method="POST">
                            <!-- Modal content -->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Confirm</h4>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="del_id" id="del_id" value="<?php echo $row['report_id']; ?>">
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
