<?php 
class XML {
	public function getXmlObject($file_path){
		return simplexml_load_file($file_path); 
	}

	public function toArray($xml_object){
		$return = [];
		// Creating Xml String
		foreach($xml_object as $_k => $_tag){
			$tmp = [];
			$tmp['to'] = $_tag->to->__toString();
			$tmp['from'] = $_tag->from->__toString();
			$tmp['heading'] = $_tag->heading->__toString();
			$tmp['body'] = $_tag->body->__toString();
			$return[] = $tmp;
		}
		return $return;
	}
}