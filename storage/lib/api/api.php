<?php
/*Dependency: db auth*/
/*api for now is only used to fetch the user information and nothing else*/
    class api{
        public function __construct(){
        }

        public function registerApp($information){
            //generate a public and private key
            $public = uniqid($GLOBALS['app_name']);
            $private = openssl_random_pseudo_bytes(20);
            $information["public_key"] = $public;
            $information["private_key"] = $private;
            db::dbs($GLOBALS['db_name']) -> collection("class_api") -> insert($information);
            return array("public" => $public,"private" => $private);
        }

        public function generateAuthorizationCode($publicKey){
            //generate a token for the user
            //remember this is public and for one time use only
            //have to store this token temporary for future delete when used to generate security token
            $auth = new auth();
            if($auth -> is_logged()){
                $token = uniqid(uniqid());
                $login = true
            }else{
                $token = null;
                $login = false;
            }
            return array("login" => $login,"token" => $token);
        }

        public function generateSecurityToken($authorizationToken,$privateKey){
            //generate an access Token to access user information
            $secToken = openssl_random_pseudo_bytes(200);
            return $secToken;
        }

        public function serveRequest($securityToken,$privateToken){
            //serve the user information as required
            //not sure on what should be going here making this program linked to an interface for the cloud
        }

        private function validRequest($securityToken,$privateToken){
            //just to check if the req is valid or not
        }
    }
