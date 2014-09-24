<?php


    class modelLogin{
    
    private $username = "Admin";
    private $password = "Password";
    
    	public function checkLogin($username, $password) {
	
	       if($this->username == $username && $this->password == $password){
	           $_SESSION['login'] = $username;
	           return TRUE;
	       } 
	       else{
	       return FALSE;
	       }
	}
        public function sessionStatus(){
            if(isset($_SESSION['login'])){
                return TRUE;
            }
            else{
                return FALSE;
            }
        }
        public function destroySession(){
            //kolla
            session_unset();
            session_destroy();
        }
    }