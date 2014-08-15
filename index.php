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
include './config.php';
include $GLOBALS['path_interface'];
/*Essential imports ends here*/

/*Class autoloaded*/
function __autoload($class_name) {
    include $GLOBALS['path_lib']."$class_name/".$class_name . '.php';
}
/*Class autoloader ends here*/

$url = $_SERVER["REQUEST_URI"];
//print $url;
print $GLOBALS['db_name'];
$url = str_replace($GLOBALS['base_url'], "", $url);
//print $url;
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
	$url = explode("/", $url);
	if (in_array($url[0], $methods)) {
		$reflexion = new ReflectionMethod("interfacex",$url[0]);
		$param_number = count($reflexion -> getParameters());
		print $i -> $url[0]($url);
		die();
	}

//TODO: invoke 404 if the pages are not found and at the same time no interfacex function mapping this is found