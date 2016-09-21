<?php 
class Files {
	public function validate($file){
		try {
		  	if(empty($file['fileToUpload'])){
		  		throw new Exception("File Not Found!");
		  	}elseif(empty($file['fileToUpload']['tmp_name'])){
		  		throw new Exception("Select File to Upload!");
		  	}elseif($this->getExtension($file['fileToUpload']) !== 'xml'){
		  		throw new Exception("Only XML format supported!");
		  	}
		}
		catch(Exception $e) {
			$return['message'] = $e->getMessage();
			$return['status'] = false;
			$return['file'] = '';
	    	return $return;
		}
		return array('status' => true, 'message' => '', 'file' => $file['fileToUpload']['tmp_name']);
	}

	private function getExtension($file){
		if(!empty($file)){
			return pathinfo($file['name'], PATHINFO_EXTENSION);
		}else{
			return false;
		}
	}
}