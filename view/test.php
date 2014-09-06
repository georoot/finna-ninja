<?php
$auth = new auth();
$auth -> signup(array("username" => "rahul","password" =>"sahil"));
if($auth -> login("rahul","sahil")){
    print "123";
}print "123";
