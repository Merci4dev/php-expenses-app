
<?php

    # Signin class. Handle the login process. Here we just authenticate the user. This is extend from the sessionController
    # ====================================================
    class Login extends SessionController{

        function __construct(){
            parent::__construct();
        }

        # Render the view we want to display
        # ====================================================
        function render(){
            error_log(" ? '/'Controller Login::render -> Login started '/'");

            $actual_link = trim("$_SERVER[REQUEST_URI]");
            $url = explode('/', $actual_link);
            $this->view->errorMessage = '';
            $this->view->render('login/index');
        }

        # User Authentication. This validate if the user and password exists. if exists we implement the login process
        # ====================================================
        function authenticate(){
            if( $this->existPOST(['username', 'password']) ){
                $username = $this->getPost('username');
                $password = $this->getPost('password');

                # validate the data from the login form
                if($username == '' || empty($username) || $password == '' || empty($password)){
                   
                    error_log(" ? '/'Controller Login::authenticate -> Empty '/'");

                    $this->redirect('', ['error' => ErrorsMsg::ERROR_LOGIN_AUTHENTICATE_EMPTY]);
                    return;
                }
                
                # If the login is successful return the the user id 
                $user = $this->model->login($username, $password);

                if($user != NULL){
                    # Inicialize the sesseion proccess
                    error_log(" ? '/'Controller Login::authenticate -> passed '/'");

                    $this->initialize($user);
                }else{
                    # error to signin, try again
                    error_log(" ? '/'Controller Login::authenticate -> Username and/or Password wrong '/'");
                    $this->redirect('', ['error' => ErrorsMsg::ERROR_LOGIN_AUTHENTICATE_DATA]);
                    return;
                }
            }else{
                # error, load the  view with error
                error_log(" ? '/'Controller Login::authenticate ->  Error with Params '/'");
                $this->redirect('', ['error' => ErrorsMsg::ERROR_LOGIN_AUTHENTICATE]);
            }
        }

    }

?>