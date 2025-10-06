<?php
session_start();
require_once 'config/config.php';
// require_once BASE_PATH . '/includes/auth_validate.php';

// Costumers class
require_once BASE_PATH . '/lib/Costumers/Costumers.php';
$candidates = new Costumers();

// Get Input data from query string
$search_string = filter_input(INPUT_GET, 'search_string');
$filter_col = filter_input(INPUT_GET, 'filter_col');
$order_by = filter_input(INPUT_GET, 'order_by');

// Per page limit for pagination.
$pagelimit = 10;

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
$select = array('user_name', 'user_type', 'email', 'password', 'reg_no', 'created_at', 'updated_at');

//Start building query according to input parameters.
// If search string
if ($search_string) {
	$db->where('email', '%' . $search_string . '%', 'like');
	$db->orwhere('reg_no', '%' . $search_string . '%', 'like');
    $db->orwhere('user_name', '%' . $search_string . '%', 'like');
}

//If order by option selected
if ($order_by) {
	$db->orderBy($filter_col, $order_by);
}

// Set pagination limit
$db->pageLimit = $pagelimit;

// Get result of the query.

$rows= $db->arraybuilder()->paginate('register_user', $page, $select);
$total_pages = $db->totalPages;


$numUsers = $db->getValue ("register_user", "count(*)");

include BASE_PATH . '/includes/header.php';
?>

<div class="bradcam_area hero">
   <div class="container">
      <div class="row">
         <div class="col-xl-12">
            <div class="bradcam_text">
               <h3><?php echo $numUsers;?>+ Members</h3>
            </div>
         </div>
      </div>
   </div>
</div>
    
<div class="featured_candidates_area candidate_page_padding">
    <div class="container text-center">
        <div class="d-flex justify-content-center filter-form">
            <!-- Filters -->
                <form class="form form-inline  mx-auto" action="">
                    <label for="input_search">Search</label>
                    <input type="text" class="form-control m-3" id="input_search" name="search_string" value="<?php echo xss_clean($search_string); ?>">
                    <label for="input_order">Order By</label>
                    <select name="filter_col" class="form-control m-3">
                        <?php
                            foreach ($candidates->setOrderingValues() as $opt_value => $opt_name):
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
        </div> <hr>
    </div>
   <div class="container">
      <div class="row">
        <?php foreach ($rows as $row): ?>
            <?php if ($row['user_type'] == 'Applicant'):
                $db->join("register_user u", "a.reg_no=u.reg_no", "LEFT");
                $db->Where("a.reg_no", $row['reg_no']);
                $row = $db->getOne("applicants a", null, "a.f_name, a.l_name, a.field, a.img, u.user_name, u.email");
            ?>
            <div class="col-md-6 col-lg-3">
                <div class="single_candidates text-center">
                <div class="">
                    <img class="" height="165px" width="165px" src="<?php echo xss_clean($row['img']); ?>" alt="Image">
                </div>
                <a href="#">
                    <h4><?php echo xss_clean($row['f_name'] . ' ' . $row['l_name']); ?></h4>
                </a>
                <p><?php echo xss_clean($row['user_type']); ?></p>
                <p><?php echo xss_clean($row['field']); ?></p>
                <p style="overflow:hidden"><?php echo xss_clean($row['email']); ?></p>
                </div>
            </div>
            
            <?php
                elseif ($row['user_type'] == 'Employer'):
                    $db->join("register_user u", "e.reg_no=u.reg_no", "LEFT");
                    $db->Where("e.reg_no", $row['reg_no']);
                    $row = $db->getOne ("employers e", null, "e.company_name, e.phone, e.img, u.user_name, u.email ");
                ?>
                <div class="col-md-6 col-lg-3">
            <div class="single_candidates text-center">
               <div class="">
                  <img class="" height="165px" width="165px" src="<?php echo xss_clean($row['img']); ?>" alt="Image">
               </div>
               <a href="#">
                  <h4><?php echo xss_clean($row['company_name']); ?></h4>
               </a>
               <p><?php echo xss_clean($row['user_type']); ?></p>
               <p><?php echo xss_clean($row['phone']); ?></p>
               <p><?php echo xss_clean($row['email']); ?></p>
            </div>
         </div>
                <?php endif;

                    
            ?>
         
        <?php endforeach;?>
      </div>
      <!-- Pagination -->
      <div class="row">
            <div class="col-lg-12 d-flex justify-content-center">
                <div class="pagination pagination_wrap">
                    <?php echo paginationLinks($page, $total_pages, 'candidates.php'); ?>
                </div>
            </div>
        </div>
        <!-- //Pagination -->
   </div>
</div>
<?php include_once('includes/footer.php'); ?>

    