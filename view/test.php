<?php
$m = db::dbs($GLOBALS['db_name']) -> collection("class_auth") -> drop(array("username" => "rahul"));
print_r($m);
