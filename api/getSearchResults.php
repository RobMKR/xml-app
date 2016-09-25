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
		$ltd = $_REQUEST['ltd'];
		$lng = $_REQUEST['lng'];
		$limit = $_REQUEST['limit'];

		/* MySql FUNCTION
		*
		* CREATE FUNCTION DISTANCE_BETWEEN (lat1 DOUBLE, lon1 DOUBLE, lat2 DOUBLE, lon2 DOUBLE)
		* RETURNS DOUBLE DETERMINISTIC
		* RETURN ACOS( SIN(lat1*PI()/180)*SIN(lat2*PI()/180) + COS(lat1*PI()/180)*COS(lat2*PI()/180)*COS(lon2*PI()/180-lon1*PI()/180) ) * 6371
		*
		*/

		$result = $DB
		->select("DISTANCE_BETWEEN($ltd , $lng , `adresses`.`latitude`, `adresses`.`longitude`) AS `distance`", "`adresses`.`adress`")
		->from('adresses')
		->where("`id` != $id")
		->order('`distance` ASC')
		->having("distance<15")
		->limit($limit)
		->prepare()
		->run();


		Router::sendResponse(true, 'success', $result);
		break;
	default:
		Router::sendResponse(false, 'Nothing passed to search!');
}


