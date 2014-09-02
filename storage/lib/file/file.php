<?php
/*bug: check that it can read file only in upload folder and nothing else*/
    class file{
        var $name;

        public function __construct($name){
            $this -> name = $name;
        }

        public function read(){
            return file_get_contents($this -> name);
        }

        public function write($data){
            file_put_contents($this -> name,$data);
        }
    }
