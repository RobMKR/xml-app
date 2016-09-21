<?php 
class Router {

	// Title
	public $title = '';

	// Tamplate file url
	public $tamplate = '';

	// Js to include in header
	public $js = [];

	// Css to include in header
	public $css = [];

	// Getting Tamplate using page name from $_GET global variable
	public function getTamplate($page_name){
		switch($page_name){
			case '':
				$this->setTitleIfEmpty('Home');
			    $this->tamplate = 'tamplates/index.html';
			    break;
		  	case 'addXmlFile':
			  	$this->setTitleIfEmpty('Add Xml');
			    $this->tamplate = 'tamplates/addXmlFile.php';
			    break;
		  	case 'searchRecords':
		  		$this->setTitleIfEmpty('Search Records');
		  		$this->js[] = '<script type="text/javascript" src="js/jquery-latest.js"></script>';
				$this->js[] = '<script type="text/javascript" src="js/jquery.tablesorter.js"></script>';
			    $this->tamplate = 'tamplates/searchRecords.php';
			    break;
		  	default:
		  		$this->css[] = '<link rel="stylesheet" href="css/404.css">';
			  	$this->title = 'Page Not Found';
			  	$this->tamplate = 'tamplates/404.html';
		}
		return $this;
	}

	// Setting title (not used)
	public function setTitle($title){
		$this->title = $title;
		return $this;
	}

	// Simple redirect method
	public static function redirect($to){
		header("Location: $to");
	}

	// Sending AJAX response in json format
	public static function sendResponse($status, $message, $params = []){
		$arr['status'] = $status;
		$arr['message'] = $message;
		$arr['params'] = [];
		if(!empty($params)){
			$arr['params'] = $params;
		}
		echo json_encode($arr);
		die;
	}

	// If not setted Page title, use defaults
	private function setTitleIfEmpty($title){
		if(empty($this->title)){
			$this->title = $title;
		}
		return $this;
	}
}