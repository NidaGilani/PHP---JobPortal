<?php

session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

$db = getDbInstance();
$select = array('user_name', 'email', 'password', 'img', 'address', 'company_name', 'cReg_no', 'phone', 'tagline', 'website', 'fb_link', 'reg_no', 'twitter_link', 'linkedin_link', 'company_description');


$chunk_size = 100;
$offset = 0;

$data = $db->withTotalCount()->get('employers');
$total_count = $db->totalCount;

$handle = fopen('php://memory', 'w');

fputcsv($handle,$select);
$filename = 'export_employers.csv';


$num_queries = ($total_count/$chunk_size) + 1;

//Prevent memory leak for large number of rows by using limit and offset :
for ($i=0; $i<$num_queries; $i++){

    $db->join("register_user u", "e.reg_no=u.reg_no", "LEFT");
    // $db->joinWhere("employers e", "e.reg_no", $employer_id);
    // $employer = $db->getOne ("employers e", null, "u.user_name, u.email, u.password, e.img, e.address, e.company_name, e.cReg_no, e.phone, e.tagline, e.website, e.fb_link, e.reg_no, e.twitter_link, e.linkedin_link, e.company_description");

    $rows = $db->get('employers e',Array($offset,$chunk_size), "u.user_name, u.email, u.password, e.img, e.address, e.company_name, e.cReg_no, e.phone, e.tagline, e.website, e.fb_link, e.reg_no, e.twitter_link, e.linkedin_link, e.company_description");
    $offset = $offset + $chunk_size;
    foreach ($rows as $row) {

        fputcsv($handle,array_values($row));
    }
}

// reset the file pointer to the start of the file
fseek($handle, 0);
// tell the browser it's going to be a csv file
header('Content-Type: application/csv');
// Save instead of displaying csv string
header('Content-Disposition: attachment; filename="'.$filename.'";');
//Send the generated csv lines directly to browser
fpassthru($handle);

