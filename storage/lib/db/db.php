<?php
class db{

	function dbs($name){
		return new table($name);
	}
}

class table{
	var $client;
	var $collection;
	var $result;

	public function __construct($database){
		$this -> client = new MongoClient();
		$this -> client = $this -> client -> selectDB($database);
	}

	public function collection($name){
		$this -> collection = new MongoCollection($this -> client,$name);
		return $this;
	}

	public function insert($data){
		$this -> collection -> insert($data);
		return $this;
	}

	public function find($data){
		$cursor = $this -> collection -> find($data);
		$result[sizeof($result)] = iterator_to_array($cursor);
		return $this;
	}

	public function result(){
		return $this -> result;
	}
}
