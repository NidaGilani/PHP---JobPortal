<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH.'/includes/auth_validate.php';

// Users class
require_once BASE_PATH.'/lib/Users/Users.php';
$users = new Users();

// Only super admin is allowed to access this page
if ($_SESSION['admin_type'] !== 'super')
{
    // Show permission denied message
    header('Location:401.php');
    // exit();
}

// Get Input data from query string
$search_string = filter_input(INPUT_GET, 'search_string');
$filter_col = filter_input(INPUT_GET, 'filter_col');
$order_by = filter_input(INPUT_GET, 'order_by');
$del_id = filter_input(INPUT_GET, 'del_id');

// Per page limit for pagination.
$pagelimit = 20;

// Get current page.
$page = filter_input(INPUT_GET, 'page');
if (!$page)
{
    $page = 1;
}

// If filter types are not selected we show latest added data first
if (!$filter_col)
{
    $filter_col = 'id';
}
if (!$order_by)
{
    $order_by = 'Desc';
}

//Get DB instance. i.e instance of MYSQLiDB Library
$db = getDbInstance();
$select = array('id', 'user_name', 'admin_type');

//Start building query according to input parameters.
// If search string
if ($search_string)
{
    $db->where('user_name', '%' . $search_string . '%', 'like');
}


//If order by option selected
if ($order_by)
{
    $db->orderBy($filter_col, $order_by);
}

// Set pagination limit
$db->pageLimit = $pagelimit;

// Get result of the query.
$rows = $db->arraybuilder()->paginate('admin_accounts', $page, $select);
$total_pages = $db->totalPages;

include BASE_PATH.'/includes/header.php';
?>
<!-- Main container -->
<div class="container-fluid">
    <h1 class="mt-4">Admin users</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">Dashboard</li>
        <li class="breadcrumb-item active">Admin users</li>
    </ol>
    <?php include BASE_PATH.'/includes/flash_messages.php'; ?>

    <?php
    if (isset($del_stat) && $del_stat == 1)
    {
        echo '<div class="alert alert-info">Successfully deleted</div>';
    }
    ?>
    <!-- Filters -->
    <div class="well text-center filter-form">
        <form class="form form-inline" action="">
            <label for="input_search">Search</label>
            <input type="text" class="form-control m-2" id="input_search" name="search_string" value="<?php echo htmlspecialchars($search_string, ENT_QUOTES, 'UTF-8'); ?>">
            <label for="input_order">Order By</label>
            <select name="filter_col" class="form-control m-2">
                <?php
                foreach ($users->setOrderingValues() as $opt_value => $opt_name):
                    ($order_by === $opt_value) ? $selected = 'selected' : $selected = '';
                    echo ' <option value="'.$opt_value.'" '.$selected.'>'.$opt_name.'</option>';
                endforeach;
                ?>
            </select>
            <select name="order_by" class="form-control m-2" id="input_order">
                <option value="Asc" <?php
                if ($order_by == 'Asc') {
                    echo 'selected';
                }
                ?> >Asc</option>
                <option value="Desc" <?php
                if ($order_by == 'Desc') {
                    echo 'selected';
                }
                ?>>Desc</option>
            </select>
            <input type="submit" value="Go" class="btn btn-primary px-3 m-2">
        </form>
    </div>
    <hr>
    <!-- //Filters -->
    
    <div class="row mt-2 mb-3">
        <div class="col-12 ml-auto text-right">
            <a href="add_admin.php" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Add new</a>
        </div>
    </div>

    <div class="row mt-3 mx-auto">
    <!-- Table -->
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="45%">Name</th>
                <th width="30%">Admin type</th>
                <th width="20%">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                <td><?php echo htmlspecialchars($row['admin_type']); ?></td>
                <td>
                    <a href="edit_admin.php?admin_user_id=<?php echo $row['id']; ?>&operation=edit" class="btn btn-primary"><i class="fa fa-edit"></i></i></a>
                    <a href="#" class="btn btn-danger delete_btn" data-toggle="modal" data-target="#confirm-delete-<?php echo $row['id']; ?>"><i class="fa fa-trash-alt"></i></a>
                </td>
            </tr>
            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="confirm-delete-<?php echo $row['id']; ?>" role="dialog">
                <div class="modal-dialog">
                    <form action="delete_admin.php" method="POST">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                            <h4 class="modal-title">Confirm</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
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
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- //Table -->

    <!-- Pagination -->
    <div class="text-center">
        <?php
        if (!empty($_GET)) {
            // We must unset $_GET[page] if previously built by http_build_query function
            unset($_GET['page']);
            // To keep the query sting parameters intact while navigating to next/prev page,
            $http_query = "?" . http_build_query($_GET);
        } else {
            $http_query = "?";
        }
        // Show pagination links
        if ($total_pages > 1) {
            echo '<ul class="pagination text-center">';
            for ($i = 1; $i <= $total_pages; $i++) {
                ($page == $i) ? $li_class = ' class="active"' : $li_class = '';
                echo '<li' . $li_class . '><a href="admin_users.php' . $http_query . '&page=' . $i . '">' . $i . '</a></li>';
            }
            echo '</ul>';
        }
        ?>
    </div>
    <!-- //Pagination -->
    </div>
</div>
<!-- //Main container -->
<?php include BASE_PATH.'/includes/footer.php'; ?>
