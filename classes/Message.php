<?php 
class Message {
	public static function setErrorMessage($msg){
		$_SESSION['error_msg'] = $msg;
	}

	public static function setSuccessMessage($msg){
		$_SESSION['success_msg'] = $msg;
	}

	public static function getErrorMessage(){
		if(isset($_SESSION['error_msg'])){
			$msg = $_SESSION['error_msg'];
			unset($_SESSION['error_msg']);
			return $msg;
		}else{
			return '';
		}
	}

	public static function getSuccessMessage(){
		if(isset($_SESSION['success_msg'])){
			$msg = $_SESSION['success_msg'];
			unset($_SESSION['success_msg']);
			return $msg;
		}else{
			return '';
		}
	}
}