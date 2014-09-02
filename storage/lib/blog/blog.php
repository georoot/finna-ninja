<?php
    /*Dependency: auth,db*/
    class blog{
        function insert($data,$param){
            $user = new auth();
            for($i=0;$i<sizeof($param);$i++){
                $data[$param[$i]] = $user -> get($param[$i]);
            }
            db::dbs($GLOBALS['db_name']) -> collection("class_blog") -> insert($data);
        }

        function get($condition){
            //the search is equavalent to the normal search of mongodb for now
            $data = db::dbs($GLOBALS['db_name']) -> collection("class_blog") -> find($condition);
            return $data;
        }
    }
