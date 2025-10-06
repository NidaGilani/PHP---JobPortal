
<?php
session_start();
require_once './config/config.php';
?>
<?php include_once('includes/header.php'); ?>
    <div id="layoutError">
        <div id="layoutError_content">
            <main>
                <div class="container my-5">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 mt-5">
                            <div class="text-center mt-4">
                                <h1 class="display-1">401</h1>
                                <p class="lead">Unauthorized</p>
                                <p>Access to this resource is restricted.</p>
                                <a href="index.php">
                                    <i class="fas fa-arrow-left mr-1"></i>
                                    Return to Home 
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
<?php include_once('includes/footer.php'); ?>