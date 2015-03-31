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

if($GLOBALS['drop_unsecure']){
	//drop all unsecure connections here
	if(!(isset($_SERVER['HTTPS']) and ($_SERVER['HTTPS'] == "on"))){
		die("unsecure connection");
	}
}

function errorh($errno, $errstr, $errfile, $errline){
	print "some error detected";
}
set_error_handler("errorh");

header_remove("Server");
header_remove("X-Powered-By");

include $GLOBALS['path_interface'];
/*Essential imports ends here*/

/*Class autoloaded*/
function __autoload($class_name) {
    include $GLOBALS['path_lib']."$class_name/".$class_name . '.php';
}
/*Class autoloader ends here*/
include $GLOBALS['path_init'];
$url = $_SERVER["REQUEST_URI"];
// print $url;

$i = new interfacex();
$methods = get_class_methods($i);
	$urlx = explode("/", $url);
	if (in_array($urlx[1], $methods)) {
		$reflexion = new ReflectionMethod("interfacex",$urlx[1]);
		$param_number = count($reflexion -> getParameters());
		print $i -> $urlx[1]($urlx);
		die();
	}


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

/*check if the file is present in the static folder or not*/
$basepath = $GLOBALS['path_static'];
$realBase = realpath($basepath);
$userpath = $basepath.$url;
$a = explode("?",$userpath);
$userpath = $a[0];
$realUserPath = realpath($userpath);
$realBase = $realBase."/";
//print $realBase."<br>".$realUserPath."<br>";
$res = substr($realUserPath,0,strlen($realBase));
if(strcmp($realBase,$res) == 0){
	$filex = $realUserPath;
	$filex = explode(".",$filex);
	$extention = $filex[sizeof($filex)-1];
	include $GLOBALS['path_mime'];
	header('Content-type: '.$mime[$extention]);
	readfile($realUserPath);
	die();
}

include $GLOBALS['path_pages'].$GLOBALS['404'].".php";
die();

//TODO: invoke 404 if the pages are not found and at the same time no interfacex function mapping this is found
