<?php
session_start();
require_once './config/config.php';
require_once './includes/auth_validate.php';


//fetch Data
$db = getDbInstance();

$cat_list = $db->get('job_categories');
$states = $db->get('states');
$cities = $db->get('cities');
$j_types = $db->get('job_types');

//We are using same form for adding and editing. This is a create form so declare $edit = false.
$edit = false;

require_once 'includes/header.php'; 
?>

<div class="container-fluid">
        <h1 class="mt-4">Website Setting</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">Administration</li>
            <li class="breadcrumb-item active">Website Setting</li>
        </ol>

        <?php include BASE_PATH . '/includes/flash_messages.php';?>

        <!-- categories -->
        <div class="bg-light mt-4">
            <div class="container mx-2 pt-2">
                <h4 class="h3">Job Categories</h4>
            </div>
            
            <div class="row m-1">
                <!-- left -->
                <div class="col-md-4 border bg-white rounded-lg p-3 mx-3 mb-3">
                    <div class="form-group ">
                        <label for="" class="mb-3">
                            <b>Job Categories</b>
                        </label>
                        <div style="height: 200px; overflow: auto" class="flux-column px-3 ">
                        <?php foreach ($cat_list as $cat_item):?> 
                           <form action="delete_cat.php" method="post">
                                <div class="row mb-2">
                                        <div class="col-md-4">
                                            <span class="px-1 pt-1"><img height="50px" width="50px" class="img-fluid" src="<?php echo $cat_item['cat_icon']; ?>" alt=""></span>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="pt-2"><?php echo $cat_item['cat_name']; ?></h6>
                                        </div>
                                        <input type="hidden" name="del_id" id="del_id" value="<?php echo $cat_item['id']; ?>">

                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-sm pt-2"><i class="fas fa-minus-circle"></i></button>
                                        </div>                                        
                                    </div>
                            </form>
                        <?php endforeach;?>        
                        </div>
                        
                    </div>
                </div>
                <!-- right -->
                
                <div class="col-md-7 ml-5">
                    <form action="add_category.php" id="cat_add_form" method="post" class="form">
                        <h6 class="text-center h6">Add New Category</h6>
                        <div class="form-group">
                            <label for="" class="">Category Name</label>
                            <input name="cat_name" id="cat_name" class="form-control file_val" />
                        </div>
                        <div class="form-group">
                            <label for="" class="">Category Icon</label>
                            <div class="form-control">
                                <input type="file" name="cat_icon" id="cat_icon" />
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-center">
                            <button type="reset" class="btn btn-light m-2">Cancel</button>
                            <button type="submit" name="cat_submit" id="cat_submit" class="btn btn-dark m-2">Add</button>
                        </div>
                    </form>
                </div>
                
            </div>  
            
        </div>
        <!-- /categories -->

        <!-- States -->
        <div class="bg-light mt-4">
            <div class="container mx-2 pt-2">
                <h4 class="h3">States</h4>
            </div>
            
            <div class="row m-1 py-4 px-2">
                <!-- left -->
                <div class="col-md-4 border bg-white rounded-lg p-3">
                    <div class="form-group ">
                        <label for="" class="">
                            <b>States</b>
                        </label>
                        <?php foreach ($states as $state):?>
                            <form action="delete_state.php" method="post">
                                <div class="row mt-2">
                                    <div class="col-md-10">
                                        <h6><?php echo $state['state_name']; ?></h6>
                                    </div>
                                    <input type="hidden" name="del_id" value="<?php echo $state['id']; ?>">
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-sm"><i class="fas fa-minus-circle"></i></button>
                                    </div>
                                </div>
                            </form>
                        <?php endforeach;?>
                    </div>
                </div>
                <!-- right -->
                
                <div class="col-md-7 ml-5">
                    <form action="add_state.php" method="post" class="form">
                        <h6 class="text-center h6">Add New State</h6>
                        <div class="form-group">
                            <label for="" class="">State Name</label>
                            <input name="state_name" id="" class="form-control" />
                        </div>
                        <div class="form-group d-flex justify-content-center">
                            <button type="reset" class="btn btn-light m-2">Cancel</button>
                            <button type="submit" name="add_state" class="btn btn-dark m-2">Add</button>
                        </div>
                    </form>
                </div>
            </div>
                
        </div>
        <!-- /States -->

        <!-- Cities -->
        <div class="bg-light mt-4">
            <div class="container mx-2 pt-2">
                <h4 class="h3">Cities</h4>
            </div>
            
            <div class="row m-1 py-4 px-2">
                <!-- left -->
                <div class="col-md-4 border bg-white rounded-lg p-3">
                    <div class="form-group ">
                        <label for="" class="">
                            <b>Cities</b>
                        </label>

                        <div style="overflow: auto; height: 250px" class="">
                        <?php foreach ($cities as $city):?>
                            
                            <form action="delete_city.php" method="post">
                                <div class="row">
                                    <div class="col-md-10">
                                        <h6><?php echo $city['city_name']; ?></h6>
                                    </div>
                                    <input type="hidden" name="del_id" value="<?php echo $city['id']; ?>">
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-sm"><i class="fas fa-minus-circle"></i></button>
                                    </div>
                                </div>
                            </form>
                            
                            <?php endforeach;?>
                        </div>

                    </div>
                </div>
                <!-- right -->
                <div class="col-md-7 ml-5"> 
                    <form action="add_city.php" method="post" class="form ">
                        <h6 class="text-center h6">Add New City</h6>
                        <div class="form-group">
                            <label for="" class="">Select State</label>
                            <select name="st_id" id="" class="form-control" >
                                <option value="">Please Select a state</option>
                                <?php foreach ($states as $state):?>
                                <option value="<?php echo $state['id']; ?>"><?php echo $state['state_name']; ?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="form-group">
                        <label for="">City Name</label>
                            <input type="text" name="city_name" id="" class="form-control" placeholder="Enter City name">
                        </div>
                        <div class="form-group d-flex justify-content-center">
                            <button type="reset" class="btn btn-light m-2">Cancel</button>
                            <button name="add_city" class="btn btn-dark m-2">Add</button>
                        </div>
                    </form>
                </div>
            </div>
                
        </div>
        <!-- /Cities -->

        <!-- Job Type -->
        <div class="bg-light mt-4">
            <div class="container mx-2 pt-2">
                <h4 class="h3">Job Types</h4>
            </div>
            
            <div class="row m-1 py-4 px-2">
                <!-- left -->
                <div class="col-md-4 border bg-white rounded-lg p-3">
                    <div class="form-group ">
                        <label for="" class="">
                            <b>Job Types</b>
                        </label>
                        <?php foreach ($j_types as $j_type):?>
                            <form action="delete_job_type.php" method="post">
                                <div class="row">
                                    <div class="col-md-10">
                                        <h6><?php echo $j_type['job_type']; ?></h6>
                                    </div>
                                    <input type="hidden" name="del_id" value="<?php echo $j_type['id']; ?>">
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-sm"><i class="fas fa-minus-circle"></i></button>
                                    </div>
                                    </div>
                            </form>
                        <?php endforeach;?>

                    </div>
                </div>
                <!-- right -->
                <div class="col-md-7 ml-5">
                    <form action="add_job_type.php" method="post" class="form ">
                        <h6 class="text-center h6">Add New Job Type</h6>
                        <div class="form-group">
                            <label for="" class="">Job Type</label>
                            <input name="job_type" id="" class="form-control" placeholder="Add Job Type" />
                        </div>
                        <div class="form-group d-flex justify-content-center">
                            <button type="reset" class="btn btn-light m-2">Cancel</button>
                            <button name="add_job_type" class="btn btn-dark m-2">Add</button>
                        </div>
                    </form>
                </div>
                
            </div>
                
            
        </div>
        <!-- /Job Type -->


</div>

<script>
    $(document).ready(function(){
      $(".file_val").focusin(function(){
        $("#cat_name").text("");
      });
      $(".file_val").change(function () {
        var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'svg'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            $("#cat_name").text("Only images are allowed");
            $(this).val("")
        }
        });
    });
</script>

<?php include_once 'includes/footer.php'; ?>