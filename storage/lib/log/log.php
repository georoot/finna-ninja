<?php
class log{
    function log($data){
        $date = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'];
        $error = $date."|".$ip."|".$data;
        $path = $GLOBALS['path_log']."finna.log";
        $fileContents = file_get_contents($path);
        file_put_contents($file, $error . $fileContents);
    }

    function read(){
        return file_get_contents($GLOBALS['path_log']."finna.log");
    }
}

