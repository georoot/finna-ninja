<?php
/**
* @version 0.1
* @author Rahul Bhola
* @link https://www.facebook.com/g30r00t
*/


error_reporting(0);
$m = array(0 => "logger");

$documentation = "";
$documentation = $documentation."Documentor V 0.1";

for ($i=0;$i<sizeof($m);$i++){
	include_once("storage/lib/".$m[$i]."/".$m[$i].".php");
	$buffer = new $m[$i]();
	//print $m[$i]."\n";
	$documentation = $documentation."\n\n\n\nClass ".($i+1).":".$m[$i]."\n";
	$methods = get_class_methods($m[$i]);
	$methods_number = sizeof($methods);
	for($j=1;$j<$methods_number;$j++){
		$a = new ReflectionMethod($m[$i],$methods[$j]);
		$param = $a -> getParameters();
		// print_r($param);
		$param_no = sizeof($param);
		$documentation = $documentation."\n\tMethod ".$j.":".$methods[$j]."\n";
			for ($q=0; $q < $param_no; $q++) { 
				$documentation = $documentation."\t\t Param ".$q.":".$param[$q]."\n";
			}
	}
}
print $documentation;
