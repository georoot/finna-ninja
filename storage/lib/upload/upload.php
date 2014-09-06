<?php
    class upload{
        function save($name,$filename,$param){
            //no need to check because in no case will they be executed :p
            move_uploaded_file($_FILES[$name]["tmp_name"],$GLOBALS['path_uploads'].$filename);
        }
    }

