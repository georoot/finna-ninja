<?php
    class file{
        var $name;
        var $valid = false;

        public function __construct($name){
            $basepath = $GLOBALS['path_uploads'];
            $realBase = realpath($basepath);
            $userpath = $basepath.$name;
            $realUserPath = realpath($userpath);
            $realBase = $realBase."/";
            $res = substr($realUserPath,0,strlen($realBase));
            if(strcmp($realBase,$res) == 0){
                $this -> valid = true;
            }
            $this -> name = $realUserPath;
        }

        public function read(){
            if(!$this -> valid){
                die("Finna: Woops!!! looks like you are reading a file you are not authorised to");
            }
            return file_get_contents($this -> name);
        }

        public function write($data){
            if(!$this -> valid){
                die("Finna: Woops!!! you are writing to a file you dont have permission to");
            }
            file_put_contents($this -> name,$data);
        }

        public function __toString(){
            if(!$this -> valid){
                die("Finna: Woops!!! looks like you are reading a file you are not authorised to");
            }
            readfile($this -> name);
        }
    }
