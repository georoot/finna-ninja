<?php

/**
* Logger, a simple class for logging scripts execution
*
* @author Rocco Filippo Zanni <rocco[DOT]zanni{AT}gmail[DOT]com>
* @version 0.2
*/ 

  define("LOG_ERROR",100);
  define("LOG_WARNING",200);
  define("LOG_INFO",300);
  define("LOG_DEBUG",400);

  class logger {
  
    private $logfile;
    private $loglevel;
    private $date_format;
    
    public function __construct($logfile){
      $this->logfile = $GLOBALS['path_log'].$logfile;
      $this->loglevel = constant("LOG_INFO");
      $this->date_format = "d-m-Y H:m:s";
    }
    
    public function setLogLevel($level){
    
      $this->loglevel = $level;
    }

    public function setDateFormat($date_format){
    
      $this->date_format = $date_format;
    }
    
    public function append($level, $msg){
      
      if ($level<=$this->loglevel)
        error_log(date($this->date_format).' --> '.$msg."\n",3,$this->logfile);
    }
    
    public function error($msg){    
      if ($this->loglevel>=constant("LOG_ERROR"))
        error_log(date($this->date_format).' --> '.$msg."\n",3,$this->logfile);
    }    
    
    public function warning($msg){    
      if ($this->loglevel>=constant("LOG_WARNING"))
        error_log(date($this->date_format).' --> '.$msg."\n",3,$this->logfile);
    }  

    public function info($msg){    
      if ($this->loglevel>=constant("LOG_INFO"))
        error_log(date($this->date_format).' --> '.$msg."\n",3,$this->logfile);
    }  
    
    public function debug($msg){    
      if ($this->loglevel>=constant("LOG_DEBUG"))
        error_log(date($this->date_format).' --> '.$msg."\n",$this->log_type,$this->logfile);
    }      
    
    
    
  }
?>