<?php 
session_start();
include('../classes/DB.php');
include('../classes/Files.php');
include('../classes/Router.php');
include('../classes/XML.php');
include('../classes/Message.php');

$File = new Files();

// Validating File
$check = $File->validate($_FILES);

if(!$check['status']){
	// Redirect to previous page
	Message::setErrorMessage($check['message']);
	Router::redirect('../index.php?page=addXmlFile');
	die;
}

// Creating DB object (which automatically opens MySQL connection)
$DB = DB::Instance();

// Directly Save XML to table (which is the fastest way to add Rows Many rows to database)
if($DB->directSaveXml($check['file'])){
	// Redirect to home page with success message
	Message::setSuccessMessage('Xml File Succesfullty uploaded to database');
	Router::redirect('../index.php');
}