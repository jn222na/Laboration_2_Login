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
              
              if($this->view->didUserPressLogin()){
                if($username != "" && $password != ""){
                  if($this->model->checkLogin($username, $password)){
                      $msg = "Successful login";
                      if($this->view->checkedCredBox()){
                          $this->view->saveCredentials();
                          $msg = "Login successful and credentials saved";
                      }
                      
                  }
                  else{
                      $msg ="Trouble logging in (Username/Password)";
                  }
               }
              }
              if($this->view->didUserPressLogout()){
                  $this->model->destroySession();
                  $this->view->removeCookies();
                  $msg =  "User logged out";
              }

              
              return $this->view->echoHTML($msg);
          }
        } 