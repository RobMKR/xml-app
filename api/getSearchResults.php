<?php 
include('../classes/Router.php');
include('../classes/DB.php');



// Return false if empty key
if(empty($_REQUEST['type'])){
	Router::sendResponse(false, 'Nothing passed to search!');
}
$type = $_REQUEST['type'];

// Creating DB Object if Not exist
$DB = DB::Instance();
switch($type){
	case 1:
		// Start Search Functional
		$searchable = $_REQUEST['key'];
		$limit = $_REQUEST['limit'];
		
		$result = $DB->select()->from('adresses')->where("`adress` LIKE '%$searchable%'")->order('`adress` ASC')->limit($limit)->prepare()->run();
		Router::sendResponse(true, 'success', $result);
		break;
	case 2:
		// Start Search Functional
		$id = $_REQUEST['id'];
		$limit = $_REQUEST['limit'];

		$result = $DB->select()->from('adresses')->where("`id` != $id")->order('`adress` ASC')->limit($limit)->prepare()->run();
		Router::sendResponse(true, 'success', $result);
		break;
	default:
		Router::sendResponse(false, 'Nothing passed to search!');
}


