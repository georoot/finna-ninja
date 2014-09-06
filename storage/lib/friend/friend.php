<?php
    /*Dependency: auth,db*/
    class friend{
        var $auth;
        public function __construct(){
            $this -> auth = new auth();
        }

        public function request($username){
            if($this -> auth ->is_logged()){
                //send request and return true
            }
            //not logged return false
        }

        public function fetchRequest(){
            if($this -> auth ->is_logged()){
                //fetch friend req associated with this account
            }
        }

        public function confirm($username){
            if($this -> auth ->is_logged()){
                //confirm the friend request of whosoever is sending it
            }
        }

        public function delete($username){
            if($this -> auth ->is_logged()){
                //Delete the friend request
            }
        }

        public function fetchFriends(){
            if($this -> auth ->is_logged()){
                //fetch all friends associated with this account
            }
        }
    }
