<?php
// show error reporting
error_reporting(0);


date_default_timezone_set('Europe/Budapest');
session_start();
// home page url
$home_url="http://192.168.0.18/ecommerce/";
$page_title="http://192.168.0.18/ecommerce/";


// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// set number of records per page
$records_per_page = 12;

// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;
?>
