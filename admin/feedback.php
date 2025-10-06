<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

//Get DB instance. i.e instance of MYSQLiDB Library
$db = getDbInstance();
$feedback_list = $db->get('feedback');
include BASE_PATH . '/includes/header.php';
?>


<!-- Main container -->
<div class="container-fluid">
        <h1 class="mt-4">Feedback</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">Administration</li>
            <li class="breadcrumb-item active">Feedback</li>
        </ol>
        <?php include BASE_PATH . '/includes/flash_messages.php';?>
    <?php if($db->count >=1):?>
        <div class="container mt-3 mx-auto">
            <?php foreach($feedback_list as $feedback): ?>
                <form action="delete_feedback.php" method="post">
                    <div class="row mt-3 mx-auto mb-5 bg-light">
                        <div class="col-md-3 mt-3">
                            <h5 class=""><?php echo $feedback['user_name']; ?></h5>
                            <p><span><?php echo $feedback['reg_no']; ?></span></p>
                            <p><span><?php echo $feedback['date_time']; ?></span></p>
                        </div>
                        <div class="col-md-8 mt-3">
                            <h6 class=""><?php echo $feedback['subject']; ?></h6>
                            <p><?php echo $feedback['message']; ?></p>
                        </div>
                        <input type="hidden" name="del_id" value="<?php echo $feedback['id']; ?>">
                        <div class="col-md-1 mt-3">
                            <button class="btn" type="submit"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                </form>
            <?php endforeach; ?>
        </div>
    <?php else:?>
    <div class="container mt-5">
        <div style="height: 200px" class="container text-center bg-light pt-4">
            <h4 class="py-5">No feedback yet!</h4>
        </div>
    </div>
    <?php endif; ?>
</div>
<!-- //Main container -->
<?php include BASE_PATH . '/includes/footer.php';?>
