<?php
class log{
    function logger($data){
        $date = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'];
        $error = $date."|".$ip."|".$data."\n";
        $path = $GLOBALS['path_log'].$GLOBALS['log_file_name'];
        $fileContents = file_get_contents($path);
        file_put_contents(realpath($path), $error . $fileContents);
    }

    function read(){
        return file_get_contents($GLOBALS['path_log'].$GLOBALS['log_file_name']);
    }
}

