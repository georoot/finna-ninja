<?php

/**
* @version 0.1
* @author Rahul Bhola
* @link https://www.facebook.com/g30r00t
*/

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
// print $url;

$url = str_replace($GLOBALS['base_url'], "", $url);
$key = array_keys($GLOBALS['url_routing']);

for ($i=0; $i < sizeof($key); $i++) { 
	if (preg_match($key[$i], $url)) {
		$page_name = $GLOBALS['url_routing'][$key[$i]];
		include $GLOBALS['path_pages'].$page_name.".php";
		die();
	}
}

$i = new interfacex();
$methods = get_class_methods($i);
	if (in_array($url[$baseIndex], $methods)) {
			//time to create a reflection and invoke the method i guess
		$reflexion = new ReflectionMethod("interfacex",$url[$baseIndex]);
		$param_number = count($reflexion -> getParameters());
		print $i -> $url[$baseIndex]($url,$baseIndex);
		die();
	}