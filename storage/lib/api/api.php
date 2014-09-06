<?php
/*Dependency: db auth*/
/*api for now is only used to fetch the user information and nothing else*/
    class api{
        public function __construct(){
        }

        public function registerApp(){
            //generate a public and private key
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
