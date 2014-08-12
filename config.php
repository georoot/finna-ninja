<?php
/**
* @version 0.1
* @author Rahul Bhola
* @link https://www.facebook.com/g30r00t
*/


/*Variable to help shift in production*/
$GLOBALS['app_deploy'] = False;	//set to true to avoid error messages from framework
$GLOBALS['base_url'] = "/finna-ninja/www/"; // url of the application
/*Variable to help shift in production ends here*/

/*Database Configuration comes here*/
$GLOBALS['db_name'] = "";	//database name
$GLOBALS['db_host'] = "";	//database host : localhost if on same system
$GLOBALS['db_username'] = "";	//database username
$GLOBALS['db_password'] = "";	//database password
$GLOBALS['db_persistant'] = false;	//set to true if persistant connections are required
/*Database Configuration ends here*/

/*Directory Structure Comes here*/
$GLOBALS['path_lib'] = "../storage/lib/";
$GLOBALS['path_uploads'] = "../storage/uploads/";
$GLOBALS['path_pages'] = "../pages/";
$GLOBALS['path_components'] = "../components/";
$GLOBALS['path_interface'] = "../interface.php";
$GLOBALS['path_log'] = "../storage/log/";
/*Directory Structure Ends here*/


/*SESSION details come here*/
$GLOBALS['session_name'] = "finna-ninja_";	// the name that should be displayed on the session cookie
/*SESSION details ends here*/

/*this is for url routing*/
$GLOBALS['url_routing'] = array('/^def/' => "helloworld");
/*url routing var ends here*/