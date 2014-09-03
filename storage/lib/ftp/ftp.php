<?php
	class ftp {
		var $uname;
		var $pwd;
		var $host;
		var $con = null;
		var $port = 21;
		var $ssl = false;
		var $timeout = 90;
		
		    function __construct($uname,$pwd,$host,$port=21,$timeout=90) {
		            $this->uname = $uname;
	                    $this->pwd = $pwd;
	                    $this->host = $host;
	                    $this->port = $port;
	                    $this->timeout = $timeout;
	                    }       

    		    function connect() {
    		            if ((isset($this->uname, $this->pwd, $this->host, $this->port)) and $ssl == false ) {
    			        $this->con = ftp_connect($this->host, $this->port);
    			    if ((isset($this->uname, $this->pwd, $this->host, $this->port, $this->timeout)) and $ssl == true ) {
    			        $this->con = ftp_ssl_connect($this->host [, $this->port [, $this->timeout ]]);   			    
    		            if (!$this->con) {        die("Connection Failed");            }
		            if (!ftp_login($this->con, $this->uname, $this->pwd)) { die("Login Failed");  }
		            ftp_pasv ($this->con, true);
		            return true;
		                    }
		                 }   
		            }
		       
		    function logout() {
		            if (isset($this->con)) {
		                        ftp_close($this->con);
		                                   }
		                      }
		      
		    function upload($file, $path, $mode = FTP_ASCII) {
		            if (isset($file, $path)) {
		                if (file_exists($file)) {
		                    $upload = ftp_put($this->con, $path, $file, FTP_ASCII);
		                    return $upload;
			                 }
			         } die("Upload Failed");
			    }     

		    function download($file, $path, $mode = FTP_BINARY) {
		            if (isset($file)) {
		                        if (ftp_get($this->con, $path, $file, FTP_BINARY)) {
		                             return true;
		                         }
		           	 } die("Download Failed");
		            }
		       		    
		    function mkdir($dirname) {
		            if (isset($dirname)) {
		                return ftp_mkdir($this->con, $dirname);
		                                 }
		                             }
		    
		    function rmdir($dirname) {
		    	    if (isset($dirname)) {
		    	        return ftp_rmdir($this->con, $dirname);
		    	        		 }
		    	          	     }  
		    
		    function chdir($path) {
		    	    if (isset($path)) {
		    	    	return ftp_chdir($this->con, $path);
		    	    		      }
		    	    		  }	          	                            

		    function ls($dir = '.') {
		            if (isset($this->con)) {  
		              $ls = ftp_nlist($this->con, $dir);
		              return $ls;
		                      }
		                }
		    
		    function rename($old,$new) {
		            if(isset($old,$new)) {
		            	return ftp_rename($this->con,$old,$new);
		            			 }
		            		       }
		    
		    function delete($file) {
		           if (isset($file)) {
		                return ftp_delete($this->con, $file);
		                             }
		                           }

		    function chmod($file, $perm = 0644) {
		            if (isset($file)) {
		                        if (ftp_chmod($this->con, $perm, $file) !== false) {
		                                        return true;
		                         } else { die("Mode not changed");   }
		                 }
		            }
		    
		    function systype() {
		    	if( isset($this->con)) { return ftp_systype($this->con);}
		    			}        
		                           
		    function __destruct() {
		            $this->logout();
		                }	            
		                
		  }

		


