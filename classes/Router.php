<?php 
class Router {

	public $title = '';
	public $tamplate = '';
	public $js = [];
	public $css = [];
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

	public function setTitle($title){
		$this->title = $title;
		return $this;
	}

	public static function redirect($to){
		header("Location: $to");
	}

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

	private function setTitleIfEmpty($title){
		if(empty($this->title)){
			$this->title = $title;
		}
		return $this;
	}
}