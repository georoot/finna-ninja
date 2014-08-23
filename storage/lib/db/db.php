<?php
class db{
	var $name;

	function dbs($name){
		$this -> name = $name;
	}
}

class table{
	var $table;
	public function collection($name){
		$this -> table = $name;
	}

	public function insert(){

	}

	public function find(){

	}
}
