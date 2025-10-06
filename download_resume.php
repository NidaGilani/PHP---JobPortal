<?php
session_start();
require_once './config/config.php';
// echo $_SESSION['user_type']; die();
// require_once 'includes/auth_validate.php';
// echo $_GET['file']; die();
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == TRUE) 
{
    if ($_SESSION['user_type'] === 'Applicant') {
        if (!empty($_GET['file'])) {

            $filename = basename($_GET['file']);
            $filepath = 'assets/uploads/' . $filename;
            
            if (!empty($filename) && file_exists($filepath)) {
                
                header("Cache-Control: public");
                header("Content-Description: FILE Transfer");
                header("Content-Disposition: attachment; filename= $filename");
                header("Content-Type: application/pdf, application/msword");
                header("Content-Transfer-Encoding: binary");

                readfile($filepath);
                exit;
            }
            else {
                $_SESSION['info'] = "File does not exist.!";
                header('location: index.php');
                exit();
            }
        
        }
    }
    else {
        header("location: 401.php");
    }
}
else {
   header("location: login.php?page_url=");
}


include_once('includes/header.php');
?>



<?php include_once('includes/footer.php'); ?>