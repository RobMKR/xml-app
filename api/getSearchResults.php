<?php 
include('../classes/Router.php');
include('../classes/DB.php');

// Return false if empty key
if(empty($_REQUEST['key'])){
	Router::sendResponse(false, 'Nothing passed to search!');
}

// Start Search Functional
$searchable = $_REQUEST['key'];
$limit = $_REQUEST['limit'];

// Creating DB Object
$DB = DB::Instance();

$result = $DB->select()->from('test_table')->where("`to` LIKE '%$searchable%'")->order('`to` ASC')->limit($limit)->prepare()->run();
Router::sendResponse(true, 'success', $result);
