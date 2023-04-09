
<?php

    # Controller to signup the users
    # ====================================================
    require_once "models/usermodel.php";

    class Signup extends SessionController{

        function __construct(){
            parent::__construct();
        }

        # Displays the view we deside whe the use access to this controller (signup form)
        # ====================================================
        function render(){
            $this->view->errorMessage = '';
            $this->view->render('login/signup');
        }

        # Function handle a request to signup a new user. Take the use data. validate if the user eist or not. if the user do not exist, create a new user.
        # ====================================================
        function newUser(){
            if($this->existPOST(['username', 'password'])){
                
                $username = $this->getPost('username');
                $password = $this->getPost('password');
                
                # Here we validate the date which come from the signup form
                if($username == '' || empty($username) || $password == '' || empty($password)){
                    # error when we validare the data
                    $this->redirect('signup', ['error' => ErrorsMsg::ERROR_SIGNUP_NEWUSER_EMPTY]);
                    return;
                }

                $user = new UserModel();
                $user->setUsername($username);
                $user->setPassword($password);
                $user->setRole("user");
                
                if($user->exists($username)){
                    
                    $this->redirect('signup', ['error' => ErrorsMsg::ERROR_SIGNUP_NEWUSER_EXISTS]);
                    //return;
                }else if($user->save()){
                    
                    $this->redirect('', ['success' => Success::SUCCESS_SIGNUP_NEWUSER]);
                }else{
                    
                    $this->redirect('signup', ['error' => ErrorsMsg::ERROR_SIGNUP_NEWUSER]);
                }
            }else{
                # error, load the view thit erros
                $this->redirect('signup', ['error' => ErrorsMsg::ERROR_SIGNUP_NEWUSER_EXISTS]);
            }
        }
    }

?>