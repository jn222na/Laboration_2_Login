<?php

require_once 'viewHTML.php';
require_once 'modelLogin.php';

        class  controller{
          private $view;
          private $model;
          public function __construct() {
              $this->model = new modelLogin();
              $this->view = new viewHTML($this->model);
              
          }
          
          public function login(){
              $username = $this->view->getUsername();
              $password = $this->view->getPassword();
              $msg = "";
              
    //Om sessionen inte �r satt 
            if($this->model->loginStatus() == FALSE){
    // kolla om cookies �r satta
		   	if($this->view->checkCookie()){
	  //�r dom det skicka kaknamn och kakl�sen vidare 
				if($this->model->checkLoginCookie($this->view->getCookieUsername(), $this->view->getCookiePassword())){
					$msg = "Login with cookies successfull";
				}else{
    //annars ta bort
					$this->view->removeCookies();
					$msg = "Cookie contains wrong information";
				}
			}
		}
    //Om anv�ndaren vill logga in          
              if($this->view->didUserPressLogin()){
                if($username != "" && $password != ""){
    //Om han kryssat i "remember me"                
                  if($this->model->checkLogin($username, $password)){
                      $msg = "Successful login";
                      if($this->view->checkedRememberBox()){
                          $this->view->rememberUser();
                          $msg = "Login successful you will be remembered";
                      }
                      
                  }
                  else{
                      $msg ="Trouble logging in (Username/Password)";
                  }
               }
              }
    //Om anv�ndaren klickar logout
              if($this->view->didUserPressLogout()){
                  $this->view->removeCookies();
                  $this->model->destroySession();
                  $msg =  "User logged out";
              }
    //Skickar med meddelandet till echoHTML
              return $this->view->echoHTML($msg);
          }
        } 