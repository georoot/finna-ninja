<?php
    class upload{
        function save($name,$filename,$param){
            //no need to check because in no case will they be executed :p
            $user = new auth();
            for($i=0;$i<sizeof($param);$i++){
                $data[$param[$i]] = $user -> get($param[$i]);
            }
            $data["location"] = $filename;
            $data["ip"] = $_SERVER['REMOTE_ADDR'];
            db::dbs($GLOBALS['db_name']) -> collection("class_upload") -> insert($data);
            move_uploaded_file($_FILES[$name]["tmp_name"],$GLOBALS['path_uploads'].$filename);
        }
    }

