<?php
/*Dependency: db*/
/*add some more functions to accomodate api calls to this system*/
class auth{
	public function __construct(){
		session_name($GLOBALS['session_name']);
		session_start();
	}

	public function signup($data){
		if (isset($data["username"]) and isset($data["password"])) {
			$data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);
			db::dbs($GLOBALS['db_name']) -> collection("class_auth") -> insert($data);
			return true;
		}
		return false;
	}

	public function login($username,$password){
		$data = db::dbs($GLOBALS['db_name']) -> collection("class_auth") -> findOne(array("username" => $username));
		if (password_verify($password, $data["password"])) {
			$key = array_keys($data);
			for ($i=0; $i < sizeof($key); $i++) {
				//all data buffered to session
				$_SESSION[$key[$i]] = $data[$key[$i]];
			}
			$_SESSION["logged"] = true;
			return true;
		}
		return false;
	}

	public function logout(){
		$_SESSION["logged"] = false;
		session_destroy();
	}

	public function get($key){
		if (isset($_SESSION[$key])) {
			return $_SESSION[$key];
		}
		return null;
	}

	public function is_logged(){
		if (isset($_SESSION['logged']) and $_SESSION["logged"] == true) {
			return true;
		}
		return false;
	}
}
?>
