<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

// Costumers class
require_once BASE_PATH . '/lib/Costumers/Employers.php';
$employers = new Employers();

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
	$filter_col = 'reg_no';
}
if (!$order_by) {
	$order_by = 'Desc';
}

//Get DB instance. i.e instance of MYSQLiDB Library
$db = getDbInstance();

//Start building query according to input parameters.
// If search string
if ($search_string) {
	$db->where('company_name', '%' . $search_string . '%', 'like');
	$db->orwhere('user_name', '%' . $search_string . '%', 'like');
}

//If order by option selected
if ($order_by) {
	$db->orderBy($filter_col, $order_by);
}

// Set pagination limit
$db->pageLimit = $pagelimit;

$db->join("register_user u", "e.reg_no=u.reg_no", "LEFT");
$rows = $db->arraybuilder()->paginate ("employers e", $page, "u.user_name, u.email, u.password, e.id, e.img, e.address, e.company_name, e.cReg_no, e.phone, e.tagline, e.website, e.fb_link, e.reg_no, e.twitter_link, e.linkedin_link, e.company_description");

// Get result of the query.
// $rows = $db->arraybuilder()->paginate('employers', $page, $select);
$total_pages = $db->totalPages;

include BASE_PATH . '/includes/header.php';
?>
<!-- Main container -->
<div class="container-fluid">
        <h1 class="mt-4">Employers</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item active">Employers</li>
        </ol>
        <?php include BASE_PATH . '/includes/flash_messages.php';?>
    
        <div class="mx-auto text-center filter-form d-flex justify-content-center">
        <!-- Filters -->
            <form class="form form-inline" action="">
                <label for="input_search">Search</label>
                <input type="text" class="form-control m-3" id="input_search" name="search_string" value="<?php echo xss_clean($search_string); ?>">
                <label for="input_order">Order By</label>
                <select name="filter_col" class="form-control m-3">
                    <?php
                        foreach ($employers->setOrderingValues() as $opt_value => $opt_name):
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
                <input type="submit" value="Go" class="btn btn-primary px-3 m-3">
            </form>
        
        <!-- //Filters -->
        </div>
        <hr>
    
    <div class="row mt-2 mb-3">
        <div class="col-6">
            <div id="export-section " class="text-left">
                <a href="export_employers.php"><button class="btn btn-sm btn-primary py-2">Export to CSV <i class="glyphicon glyphicon-export"></i></button></a>
            </div>
        </div>
        <div class="col-6">
            <div class="text-right">
                <a href="add_employer.php?operation=create" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Add new</a>
            </div>
        </div>
    </div>
    <div class="row mt-3 mx-auto">
        <!-- Table -->
        <table class="table table-striped table-bordered table-condensed">
            <thead>
                <tr>
                    <th width="5%">Reg. No</th>
                    <th width="45%">Company Name</th>
                    <th width="10%">Email</th>
                    <th width="20%">Phone</th>
                    <th width="20%">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row): ?>
                <tr>
                    <td><?php echo $row['cReg_no']; ?></td>
                    <td><?php echo xss_clean($row['company_name']); ?></td>
                    <td><?php echo xss_clean($row['email']); ?></td>
                    <td><?php echo xss_clean($row['phone']); ?></td>
                    <td>
                        <a href="edit_employer.php?employer_id=<?php echo $row['reg_no']; ?>&operation=edit" class="btn btn-primary"><i class="fa fa-edit fa-fw"></i></a>
                        <a href="#" class="btn btn-danger delete_btn" data-toggle="modal" data-target="#confirm-delete-<?php echo $row['reg_no']; ?>"><i class="fa fa-trash-alt"></i></a>
                    </td>
                </tr>
                <!-- Delete Confirmation Modal -->
                <div class="modal fade" id="confirm-delete-<?php echo $row['reg_no']; ?>" role="dialog">
                    <div class="modal-dialog">
                        <form action="delete_employer.php" method="POST">
                            <!-- Modal content -->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Confirm</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="del_id" id="del_id" value="<?php echo $row['reg_no']; ?>">
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
                <?php endforeach;?>
            </tbody>
        </table>
        <!-- //Table -->

        <!-- Pagination -->
        <div class="text-center">
            <?php echo paginationLinks($page, $total_pages, 'employers.php'); ?>
        </div>
        <!-- //Pagination -->
    </div>
</div>
<!-- //Main container -->
<?php include BASE_PATH . '/includes/footer.php';?>
