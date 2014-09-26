<?php

setlocale(LC_ALL, "sv_SE", "swedish");
require_once 'modelLogin.php';
class viewHTML {
	private $username = '';
	private $usrValue = '';
	private $password = '';
	private $msg = '';
    private $model;

//TODO: FIXA
    public	function __construct(modelLogin $model) {
        $this->model = $model;
	}


public function echoHTML($msg){
    $ret="";
    		//Clock function
		/*
		 * nl2br allows \n within variable
		 * strftime let us print date from our locale time
		 */
    $dat = nl2br(ucwords(strftime("%Aen den %d %B.\n " . "År" . " %Y.\n Klockan " . "Är" . " %X.")));
    //Om inloggningen lyckades
    if($this->model->loginStatus()){
        $ret ="
			<h1>
				Laboration_2
			</h1>
			<h2>
				Admin Inloggad!
			</h2>
			$msg
			$this->msg
			<form  method='post'> 
		    	<input type='submit'  name='logOut' value='Logga ut'/>
			</form>
			" . $dat . "
        ";
    }
    //Om inloggningen misslyckades
    else{
        $ret = "
        <h1>
			Laboration_2
		</h1>
		<h2>
				Ej inloggad
		</h2>
	<h3>$msg</h3>
    <h3>$this->msg</h3> 
       <form id='login'   method='post'>
    		<label for='username'>Username:</label>
    			<br>
    		<input type='text'  name='username' value='$this->usrValue' id='username'>
    			<br>
    		<label for='password'>Password:</label>
    			<br>
    		<input type='password'   name='password' id='password'>
    			<br>
    		<input type='checkbox' name='checkSave' value='remember'>Remember me
    			<br>
    		<input type='submit'  name='submit'  value='Submit'/>
	    </form>  
		 <div>
		 <p>$dat <br> </p>
		 
		
		 </div>";
        
    }
    return $ret;
}

//Om användaren klickar login och det är korrekt 
public function didUserPressLogin(){
	    $username = $_POST['username'];
	    $password = $_POST['password'];
	    
	    if (isset($_POST['submit'])) {
	        
			if($username == ""){
		    $this->usrValue = $username;
		    $this->msg = "Username is missing.";
		}
		
		if($password == "" && $username != ""){
		    $this->msg = "Password is empty.";
		    $this->usrValue = $username;
		}
		
		if($username != "" && $password != "Password"){
		    $this->usrValue = $username;
		    
		}
		return TRUE;
		}
		
		return FALSE;
	    
	}
	//Get funktioner
	public function getUsername(){
	    if(isset($_POST['username'])){
	        return  $_POST['username'];
	    }
	}
	public function getPassword(){
	    if(isset($_POST['password'])){
	        return  $_POST['password'];
	    }
	}
	
	public function getCookieUsername(){
		return $_COOKIE['cookieUsername'];
	}
	
	public function getCookiePassword(){
		return $_COOKIE['cookiePassword'];
	}
	public function checkedRememberBox(){
	    if(isset($_POST['checkSave'])){
	        return TRUE;
	    }
	    else{
	        return FALSE;
	    }
	}
	//Sätter kakor och krypterar lösenord
	public function rememberUser(){
	              setcookie('cookieUsername', $_POST['username'], time()+60*60*24*30);
				  setcookie('cookiePassword', md5($_POST['password']), time()+60*60*24*30);
				  
        		$cookieTime = time()+60*60*24*30;
        		file_put_contents('cookieTime.txt', $cookieTime);
				 $this->message ="Login successfull and you will be remembered.";
	}
	//Kollar om kakorna är satta
	public function checkCookie(){
	    if(isset($_COOKIE['cookieUsername']) && isset($_COOKIE['cookiePassword'])){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function removeCookies() {
	    setcookie ('cookieUsername', "", time() - 3600);
		setcookie ('cookiePassword', "", time() - 3600);
	}
	
	public function didUserPressLogout(){
	    if(isset($_POST['logOut'])){
	        return TRUE;
	    }else{
	        return FALSE;
	    }
	}




	
	
//	public function nameCheck($username, $password) {
		
		
		//Inte satt / tom
/*		if (isset($username) == FALSE) {
			$exception = new CustomException();
		}
		//Om satt skicka vidare och trimma strängen (Trim tar bort mellanslag i början och i slutet)
		else {
			$this -> trimName($username);
			return TRUE;
		}
		// header("refresh:0");		
	}

	public function trimName($input) {
		$nameTemp = trim($input);
		return $nameTemp;
	}



	
        public function assignCookieValue(){
             $this->usrValue =  $_COOKIE['cookieUsername'];
        }
        */

}


//To handle undefined index notice when $_GET isn't set, I usually do this somewhere at the top of scripts $lastname = isset($_GET['lastname'])?$_GET['lastname']:'';