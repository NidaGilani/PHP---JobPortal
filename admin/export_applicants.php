<?php

session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

$db = getDbInstance();
$select = array('user_name', 'email', 'password', 'reg_no', 'f_name', 'l_name', 'field', 'img', 'gender', 'address', 'phone', 'date_of_birth', 'id');


$chunk_size = 100;
$offset = 0;

$data = $db->withTotalCount()->get('applicants');
$total_count = $db->totalCount;

$handle = fopen('php://memory', 'w');

fputcsv($handle,$select);
$filename = 'export_applicants.csv';


$num_queries = ($total_count/$chunk_size) + 1;

//Prevent memory leak for large number of rows by using limit and offset :
for ($i=0; $i<$num_queries; $i++){

    $db->join("register_user u", "a.reg_no=u.reg_no", "LEFT");
    
    $rows = $db->get("applicants a",Array($offset,$chunk_size), "u.user_name, u.email, u.password, u.reg_no, a.f_name, a.l_name, a.field, a.img, a.gender, a.address, a.phone, a.date_of_birth, a.id");
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

