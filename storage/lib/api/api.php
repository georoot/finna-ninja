<?php
/*Dependency: db auth*/
/*api for now is only used to fetch the user information and nothing else*/
    class api{
        public function __construct(){
        }

        public function registerApp($information){
            //generate a public and private key
            $public = uniqid($GLOBALS['app_name']);
            $private = openssl_random_pseudo_bytes(400);
            print $public."<br>Private<br>".$private;
        }

        public function generateAuthorizationCode($publicKey){
            //generate a token for the user
        }

        public function generateSecurityToken($authorizationToken,$privateKey){
            //generate an access Token to access user information
        }

        public function serveRequest($securityToken,$privateToken){
            //serve the user information as required
        }
    }
