<?php


    class modelLogin{
    
    private $username = "Admin";
    private $password = "Password";
    
    public function __construct(){
        
    }
    //Lyckad inloggning s�tt sessionen till webbl�saren anv�ndaren loggade in i
    	public function checkLogin($username, $password) {
	       if($this->username == $username && $this->password == $password){
	           $_SESSION['login'] = $username;
	           $_SESSION["checkBrowser"] = $_SERVER['HTTP_USER_AGENT'];
	           return TRUE;
	       } 
	       else{
	       return FALSE;
	       }
	}
       
        public function destroySession(){
            session_unset();
            session_destroy();
        }
        //kollar om sessionen �r satt och att den �r samma webbl�sare som vid inloggning
        public function loginStatus(){
                 if(isset($_SESSION['checkBrowser']) && $_SESSION["checkBrowser"] === $_SERVER['HTTP_USER_AGENT']){
                     if(isset($_SESSION['login'])){
                         return TRUE;
                     }
                 }
                else{
                    return FALSE;
                }
            
        }
        
        public function checkLoginCookie($username,$password){
            $getCookieTime = file_get_contents('cookieTime.txt');
            if ($username == $this->username && $password == md5($this->password) && $getCookieTime > time()){
				$_SESSION["login"] = $username;
				$_SESSION["checkBrowser"] = $_SERVER['HTTP_USER_AGENT'];
    			return TRUE;
			}
			else{
				return FALSE;
			}
        }
        
    }