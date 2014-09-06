<?php
class db{

	function dbs($name){
		return new table($name);
	}
}

class table{
	var $client;
	var $collection;
    var $logged;

	public function __construct($database){
		$this -> client = new MongoClient();
        if(isset($GLOBALS['db_username']) and isset($GLOBALS['db_password'])){
            //authenticate the database
            $this -> logged = true;
            $this -> client -> authenticate($GLOBALS['db_username'],$GLOBALS['db_password']);
        }
        $this -> client = $this -> client -> selectDB($database);
	}

    public function __destruct(){
        if($this -> logged){
            $this -> client ->command(array("logout" => 1));
        }
    }


	public function collection($name){
		$this -> collection = new MongoCollection($this -> client,$name);
		return $this;
	}

	public function count($param){
		$res = $this -> collection -> count($param);
		return $res;
	}

	public function update($old,$new){
		$this -> collection -> update($old,$new);
		return $this;
	}

	public function insert($data){
		$this -> collection -> insert($data);
		return $this;
	}

	public function find($data){
		$cursor = $this -> collection -> find($data);
		return iterator_to_array($cursor);
	}

}
