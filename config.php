<?php
/**
* @version 0.1
* @author Rahul Bhola
* @link https://www.facebook.com/g30r00t
*/


/*Variable to help shift in production*/
$GLOBALS['app_name'] = "finna";
$GLOBALS['app_deploy'] = False;	//set to true to avoid error messages from framework
$GLOBALS['base_url'] = ""; // url of the application
$GLOBALS['drop_unsecure'] = False;
/*Variable to help shift in production ends here*/

/*Database Configuration comes here*/
$GLOBALS['db_name'] = "finnadb";	//database name
$GLOBALS['db_host'] = "";	//database host : localhost if on same system
//$GLOBALS['db_username'] = "";	//database username /*uncomment if username and password to dbs exists*/
//$GLOBALS['db_password'] = "";	//database password
$GLOBALS['db_persistant'] = true;	//set to true if persistant connections are required (persistant recommended)
/*Database Configuration ends here*/

/*Directory Structure Comes here*/
$GLOBALS['path_lib'] = "./storage/lib/";
$GLOBALS['path_uploads'] = "./storage/uploads/";
$GLOBALS['path_pages'] = "./view/";
$GLOBALS['path_components'] = "./components/";
$GLOBALS['path_interface'] = "./interface.php";
$GLOBALS['path_log'] = "./storage/log/";
$GLOBALS['path_static'] = "./static";
$GLOBALS['path_mime'] = "mime.php";
$GLOBALS['path_init'] = "init.php";
$GLOBALS['log_file_name'] = "finna.log";
/*Directory Structure Ends here*/


/*SESSION details come here*/
$GLOBALS['session_name'] = "finna-ninja_";	// the name that should be displayed on the session cookie
/*SESSION details ends here*/

/*error pages comes here*/
$GLOBALS['404'] = "404";
/*error pages ends here*/

/*this is for url routing*/
$GLOBALS['url_routing'] = array('/^\/$/' => "test",
			'/^\/home$/' => "home",
			"/^\/documentation$/" => "docs",
			"/^\/developers$/" => "devs");
/*url routing var ends here*/
