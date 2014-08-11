<?php
/*Contains all the routing information for the project*/
/*First routing stage is through pages*/
/*Second routing stage is through interface components*/

date_default_timezone_set('UTC');
/*Essential imports*/
include '../config.php';
include $GLOBALS['path_interface'];
/*Essential imports ends here*/

/*Class autoloaded*/
function __autoload($class_name) {
    include $GLOBALS['path_lib']."$class_name/".$class_name . '.php';
}
/*Class autoloader ends here*/

$url = $_SERVER["REQUEST_URI"];

$url = explode("/",$url);
// print_r($url);
$baseIndex = 3;

if($url[$baseIndex] == ""){
	//this is the home
	include $GLOBALS['path_components']."header.php";
	include $GLOBALS['path_components']."home.php";
	include $GLOBALS['path_components']."footer.php";
}


else{
	$i = new interfacex();
	$methods = get_class_methods($i);
	if (in_array($url[$baseIndex], $methods)) {
			//time to create a reflection and invoke the method i guess
		$reflexion = new ReflectionMethod("interfacex",$url[$baseIndex]);
		$param_number = count($reflexion -> getParameters());
		print $i -> $url[$baseIndex]($url,$baseIndex);
	}
	
	die();
}
