<?php
/*Dependency: db auth*/
    class follow{
        var $logged = false;
        var $auth;
        public function __construct(){
            $this -> auth = new auth();
            if($this -> auth -> is_logged()){
                $this -> logged = true;
            }
        }

        public function startFollowing($username){
            if($this -> logged){
                //time to start following the username
                db::dbs($GLOBALS['db_name']) -> collection("class_follow") -> insert(array("follower" => $this -> auth -> get("username"),"following" => $username));
            }
        }

        public function getFollowers($username){
            $data = db::dbs($GLOBALS['db_name']) -> collection("class_follow") -> find(array("following" => $username));
        }

        public function getFollowing($username){
            $data = db::dbs($GLOBALS['db_name']) -> collection("class_follow") -> find(array("follower" => $username));
        }
        public function stopFollowing($username){
        }
    }

