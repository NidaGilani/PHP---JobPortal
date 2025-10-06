<?php
session_start();
require_once 'config/config.php';
$user_id = $_SESSION['user_id'];
// Sanitize if you want
// echo $post_id = filter_input(INPUT_GET, 'post_id', FILTER_VALIDATE_INT); die();
$post_id = $_POST['post_id'];
// Get Input data from query string
$db = getDbInstance();
$db->where('id',$post_id);
$row = $db->getOne("post");

//serve POST method, After successful insert, redirect to customers.php page.
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == TRUE)
{

    if ($_SESSION['user_type'] === 'Applicant') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
        //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
        $data = array_filter($_POST);

        
        $name = $data['name'];
        $message = $data['message'];
        // $password = $data['password'];
        $from = $data['sender_email'];
        $to = $_POST['post_email'];
        $subject = "Applied for Job";

        // $to = AddAddress($data['post_email']);

        // Attachments
        $target_dir = "assets/uploads/";
        $fimage = $target_dir . basename($_FILES["file"]["name"]);
        $fimage_arr = array('pdf', 'doc', 'docx');
        $fimageFileType = strtolower(pathinfo($fimage,PATHINFO_EXTENSION));
        move_uploaded_file($_FILES['file']['tmp_name'],  $fimage);
        $data['file'] = $fimage;
        // print_r($data['file']); die();
        // resume
        $db = getDbInstance();
                    
        $db->where('reg_no', $user_id);
        $user_resume = $db->get('upload_resume', 'resume');
        // print_r($db->get('upload_resume')); die();
        if($db->count >=1){

            $data['resume'] = $user_resume['resume'];

            }
            else {

                $data['resume'] = 'CV is not uploaded by applicant!';
            
            }


            // $text= '<div> Hi, I am '.$data["name"].'
            //             <p>'.$data["message"].'</p>
            //             <div>
            //                     <a style="type:button;" download href="'.$data["file"].'">Cover-letter</a>
            //             </div>
            //             <div>
            //                     <a style="type:button;" href="'.$data["resume"].'">CV-file</a>
            //             </div>
            //             </div>';
            // $headers="From: $from" . "\r\n" . "CC:anayashah.64@gmail.com";
            // $headers .= "MIME-Version: 1.0"."\r\n";
            // $headers .= "Content-type:text/html;charsat=UTF-8"."\r\n";

            // $stat = mail($to,$subject,$text,$headers);

            // if($stat) {
            //     echo "";
            //     $_SESSION['failure'] = "PHP Mailer Error. Message could not be sent.";
            //     header('location: detail_job.php?post_id='.$post_id);
            //     exit();
            // } else {
            //     $_SESSION['success'] = "Job applied successfully!";
            //     header('location: detail_job.php?post_id='.$post_id);
            //     exit();
            // }
            $db = getDbInstance();
            $data_to_upload['post_id'] = $post_id;
            $data_to_upload['applicant_id'] = $user_id;

            $db->where('applicant_id', $user_id);
            $db->where('post_id', $post_id);
            $db->get('applied_jobs');
            // print_r($db->get('upload_resume')); die();
            if($db->count >=1){

                $_SESSION['info'] = "Yor already applied for this job!";
                header('location: detail_job.php?post_id='.$post_id);
                exit();

                }
                else {
                    $stat = $db->insert('applied_jobs', $data_to_upload);
                    $_SESSION['success'] = "Job have applied successfully!";
                header('location: detail_job.php?post_id='.$post_id);
                exit();
                
                }


            
        }
    }
    else {
        header("location: 401.php");
        exit;
    }
}
else {
    header('Location:login.php?page_url=detail_job.php?post_id='.$post_id);
}
include BASE_PATH . '/includes/header.php';
?>

<script>
    $(document).ready(function(){
            
      $(".file_val").focusin(function(){
        $("#file_validate").text("");
      });
      $(".file_val").change(function () {
        var fileExtension = ['pdf', 'doc', 'docx'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            $("#file_validate").text("Only pdf and Word documents are allowed");
            $(this).val("")
        }
    });
    });
</script>
<?php include_once('includes/footer.php'); ?>