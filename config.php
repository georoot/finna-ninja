<?php

/*Variable to help shift in production*/
$GLOBALS['app_deploy'] = True;
$GLOBALS['app_name'] = "Framework app";
/*Variable to help shift in production ends here*/

/*Database Configuration comes here*/
$GLOBALS['db_name'] = "seedsa";
$GLOBALS['db_host'] = "localhost";
$GLOBALS['db_username'] = "root";
$GLOBALS['db_password'] = "toor";
/*Database Configuration ends here*/

/*Directory Structure Comes here*/
$GLOBALS['path_lib'] = "../storage/lib/";
$GLOBALS['path_uploads'] = "../storage/uploads/";
$GLOBALS['path_components'] = "../components/";
// $GLOBALS['path_static'] = "../static/";
$GLOBALS['path_interface'] = "../interface.php";
$GLOBALS['path_cache'] = "../storage/cache/";
$GLOBALS['path_lib_var'] = "../lib_var/";
// $GLOBALS['path_bin'] = "../bin/";
$GLOBALS['path_log'] = "../storage/log/";
/*Directory Structure Ends here*/

/*Components or page structure comes here*/
$GLOBALS['page_header'] = $GLOBALS['path_components']."header.php";
$GLOBALS['page_footer'] = $GLOBALS['path_components']."footer.php";
$GLOBALS['page_404'] = $GLOBALS['path_components']."404.php";
/*Components or page structure ends here*/

/*SESSION details come here*/
$GLOBALS['session_name'] = "FRAMEWORK_";
/*SESSION details ends here*/