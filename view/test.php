<?php
$m = new blog();
$c = $m -> get(array("title" => "something"));
print_r($c);
